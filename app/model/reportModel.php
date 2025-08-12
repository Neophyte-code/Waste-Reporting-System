<?php
class ReportModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    // Function to create a notification
    public function createNotification($user_id, $report_id, $type, $title, $message)
    {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO notifications (user_id, report_id, type, title, message, is_read) 
                VALUES (:user_id, :report_id, :type, :title, :message, 0)
            ");

            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':report_id', $report_id, PDO::PARAM_INT);
            $stmt->bindParam(':type', $type, PDO::PARAM_STR);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':message', $message, PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('Notification creation error: ' . $e->getMessage());
            return false;
        }
    }

    // Function to fetch notifications for a user
    public function getNotifications($user_id)
    {
        try {
            $stmt = $this->db->prepare("
                SELECT id, user_id, report_id, type, title, message, is_read, created_at
                FROM notifications
                WHERE user_id = :user_id
                ORDER BY created_at DESC
                LIMIT 10
            ");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error fetching notifications: ' . $e->getMessage());
            return [];
        }
    }

    // Function to mark a single notification as read
    public function markNotificationAsRead($notification_id, $user_id)
    {
        try {
            $stmt = $this->db->prepare("
                UPDATE notifications
                SET is_read = 1
                WHERE id = :id AND user_id = :user_id
            ");
            $stmt->bindParam(':id', $notification_id, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log('Error marking notification as read: ' . $e->getMessage());
            return false;
        }
    }

    // Function to mark all notifications as read for a user
    public function markAllNotificationsAsRead($user_id)
    {
        try {
            $stmt = $this->db->prepare("
                UPDATE notifications
                SET is_read = 1
                WHERE user_id = :user_id
            ");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log('Error marking all notifications as read: ' . $e->getMessage());
            return false;
        }
    }

    // Function for submitting waste Report
    public function submitWasteReport($data)
    {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO waste_reports (user_id, description, image_path, estimated_weight, latitude, longitude, status) 
                VALUES (:user_id, :description, :image_path, :estimated_weight, :latitude, :longitude, 'pending')
            ");

            $stmt->bindParam(':user_id', $data['user_id']);
            $stmt->bindParam(':description', $data['wasteType']);
            $stmt->bindParam(':image_path', $data['image']);
            $stmt->bindParam(':estimated_weight', $data['estimatedWeight']);
            $stmt->bindParam(':latitude', $data['latitude']);
            $stmt->bindParam(':longitude', $data['longitude']);

            $result = $stmt->execute();

            if ($result) {
                // Get the ID of the newly inserted report
                $report_id = $this->db->lastInsertId();

                // Create a notification for the user
                $this->createNotification(
                    $data['user_id'],
                    $report_id,
                    'report_status',
                    'Report Submitted Successfully',
                    'Your report has been submitted and is currently pending review. We will notify you once it has been processed.'
                );
            }

            return $result;
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            return false;
        }
    }


    // validate redemptions request (enough points and user id)
    public function validateRedemptionRequest($data)
    {
        try {
            // Check if user has enough points
            $stmt = $this->db->prepare("SELECT points FROM users WHERE id = :user_id");
            $stmt->bindParam(':user_id', $data['user_id'], PDO::PARAM_INT);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                return ['success' => false, 'message' => 'User not found'];
            }

            if ($user['points'] < $data['points_amount']) {
                return ['success' => false, 'message' => 'Insufficient points for redemption'];
            }

            return ['success' => true];
        } catch (PDOException $e) {
            error_log('Redemption validation error: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Database error occurred'];
        }
    }

    // Function to suubmit redemption request
    public function submitRedemptionRequest($data)
    {
        try {
            $this->db->beginTransaction();

            // Re-check points with FOR UPDATE lock
            $stmt = $this->db->prepare("SELECT points FROM users WHERE id = :user_id FOR UPDATE");
            $stmt->bindParam(':user_id', $data['user_id'], PDO::PARAM_INT);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                throw new Exception("User not found");
            }

            if ($user['points'] < $data['points_amount']) {
                throw new Exception("Insufficient points for redemption");
            }

            // Insert redemption request
            $stmt = $this->db->prepare("
            INSERT INTO redemption_requests 
            (user_id, points_amount, gcash_number, gcash_name, qr_code_path, status) 
            VALUES 
            (:user_id, :points_amount, :gcash_number, :gcash_name, :qr_code_path, 'pending')
        ");

            $stmt->bindParam(':user_id', $data['user_id']);
            $stmt->bindParam(':points_amount', $data['points_amount']);
            $stmt->bindParam(':gcash_number', $data['gcash_number']);
            $stmt->bindParam(':gcash_name', $data['gcash_name']);
            $stmt->bindParam(':qr_code_path', $data['qr_code_path']);

            $result = $stmt->execute();

            if ($result) {
                $redemption_id = $this->db->lastInsertId();

                // Deduct points from user
                $stmt = $this->db->prepare("
                UPDATE users 
                SET points = points - :points 
                WHERE id = :user_id
            ");
                $stmt->bindParam(':points', $data['points_amount']);
                $stmt->bindParam(':user_id', $data['user_id']);
                $stmt->execute();

                // Create history record
                $this->createHistory(
                    $data['user_id'],
                    $redemption_id,
                    'redemption_request',
                    'Redemption Request Submitted',
                    'Your redemption request has been submitted and is pending review.',
                    -$data['points_amount']
                );

                $this->db->commit();
                return ['success' => true];
            }

            $this->db->rollBack();
            return ['success' => false, 'message' => 'Failed to save redemption request'];
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log('Redemption request error: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Database error occurred'];
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log('Redemption validation error: ' . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    //function to create history
    public function createHistory($user_id, $redemption_id, $type, $title, $message, $points_change)
    {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO history 
                (user_id, redemption_id, type, title, message, points_change) 
                VALUES 
                (:user_id, :redemption_id, :type, :title, :message, :points_change)
            ");

            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':redemption_id', $redemption_id, PDO::PARAM_INT);
            $stmt->bindParam(':type', $type, PDO::PARAM_STR);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':message', $message, PDO::PARAM_STR);
            $stmt->bindParam(':points_change', $points_change);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('History creation error: ' . $e->getMessage());
            return false;
        }
    }

    //function to get history and display in the user UI
    public function getHistory($user_id)
    {
        try {
            $stmt = $this->db->prepare("
                SELECT id, user_id, redemption_id, type, title, message, points_change, created_at
                FROM history
                WHERE user_id = :user_id
                ORDER BY created_at DESC
                LIMIT 10
            ");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error fetching history: ' . $e->getMessage());
            return [];
        }
    }


    //function to display the redemption request (for admin)
    public function getRedemptionRequests($user_id)
    {
        try {
            $stmt = $this->db->prepare("
                SELECT * FROM redemption_requests 
                WHERE user_id = :user_id
                ORDER BY request_date DESC
            ");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error fetching redemption requests: ' . $e->getMessage());
            return [];
        }
    }

    //function for updating the report status(for admin)
    public function updateReportStatus($report_id, $status)
    {
        try {
            // Start transaction
            $this->db->beginTransaction();

            // Update the report status
            $stmt = $this->db->prepare("
            UPDATE waste_reports 
            SET status = :status 
            WHERE id = :report_id
        ");
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->bindParam(':report_id', $report_id, PDO::PARAM_INT);
            $stmt->execute();

            // Get the user_id from the report
            $stmt = $this->db->prepare("
            SELECT user_id FROM waste_reports WHERE id = :report_id
        ");
            $stmt->bindParam(':report_id', $report_id, PDO::PARAM_INT);
            $stmt->execute();
            $report = $stmt->fetch(PDO::FETCH_ASSOC);
            $user_id = $report['user_id'];

            // Create appropriate notification based on status
            if ($status === 'approved') {
                $title = 'Report Approved';
                $message = 'Your waste report has been approved! 10 points have been added to your account.';

                // Add points to user
                $stmt = $this->db->prepare("
                UPDATE users 
                SET points = points + 10 
                WHERE id = :user_id
            ");
                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmt->execute();
            } else {
                $title = 'Report Rejected';
                $message = 'Your waste report has been rejected. Please check the details and submit again if necessary.';
            }

            // Create notification
            $this->createNotification(
                $user_id,
                $report_id,
                'report_status',
                $title,
                $message
            );

            // Commit transaction
            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log('Error updating report status: ' . $e->getMessage());
            return false;
        }
    }

    //get all report from database(for admin)
    public function getAllReports()
    {
        try {
            $stmt = $this->db->prepare("
            SELECT * FROM waste_reports 
            ORDER BY report_date DESC
        ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error fetching reports: ' . $e->getMessage());
            return [];
        }
    }
}
