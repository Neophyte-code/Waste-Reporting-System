<?php
class ReportModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    // Function to create a notification
    public function createNotification($user_id, $report_id, $report_type, $type, $title, $message)
    {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO notifications 
                (user_id, report_id, report_type, type, title, message, is_read) 
            VALUES 
                (:user_id, :report_id, :report_type, :type, :title, :message, 0)
            ");

            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':report_id', $report_id, PDO::PARAM_INT);
            $stmt->bindParam(':report_type', $report_type, PDO::PARAM_STR);
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
                    'waste',
                    'report_status',
                    'Waste Report Submitted',
                    'Your waste report has been submitted and is currently pending review. We will notify you once it has been processed.'
                );
            }

            return $result;
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            return false;
        }
    }

    //function to submit litterer report
    public function submitLittererReport($data)
    {

        try {

            $stmt = $this->db->prepare("
                insert into litterer_reports (user_id, name, image_path, age, gender, features, latitude, longitude, status)
                values(:user_id, :name, :image_path, :age, :gender, :features, :latitude, :longitude, 'pending')
            ");

            $stmt->bindParam(':user_id', $data['user_id']);
            $stmt->bindParam(':name', $data['name']);
            $stmt->bindParam(':image_path', $data['image']);
            $stmt->bindParam(':age', $data['age']);
            $stmt->bindParam(':gender', $data['gender']);
            $stmt->bindParam(':features', $data['distinguishingFeature']);
            $stmt->bindParam(':latitude', $data['latitude']);
            $stmt->bindParam(':longitude', $data['longitude']);

            $result = $stmt->execute();

            if ($result) {

                //Get the ID og the newly inserted report
                $report_id = $this->db->lastInsertId();

                //create a notification for the user
                $this->createNotification(
                    $data['user_id'],
                    $report_id,
                    'litterer',
                    'report_status',
                    'Litterer Report Submitted',
                    'Your litterer report has been submitted and is currently pending review. We will notify you once it has been processed.'
                );
            }

            return $result;
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            return false;
        }
    }

    //function to get all pending reports
    public function getAllPendingReports($barangay_id)
    {
        try {
            $sqlWaste = '
            SELECT 
                wr.id, 
                u.firstname, 
                u.lastname, 
                u.email, 
                wr.report_date, 
                "waste" as report_type,
                wr.description as details,
                wr.image_path, 
                wr.status,
                wr.estimated_weight,
                NULL as name,
                NULL as age,
                NULL as gender,
                NULL as features,
                wr.latitude,
                wr.longitude
            FROM waste_reports wr
            JOIN users u ON wr.user_id = u.id
            WHERE wr.status = "pending"
        ';

            $sqlLitterer = '
            SELECT 
                lr.id, 
                u.firstname, 
                u.lastname, 
                u.email, 
                lr.report_date, 
                "litterer" as report_type,
                lr.features as details,
                lr.image_path, 
                lr.status,
                NULL as estimated_weight,
                lr.name,
                lr.age,
                lr.gender,
                lr.features,
                lr.latitude,
                lr.longitude
            FROM litterer_reports lr
            JOIN users u ON lr.user_id = u.id
            WHERE lr.status = "pending"
        ';

            // Add barangay filter if provided
            if ($barangay_id) {
                $sqlWaste .= ' AND u.barangay_id = :barangay_id';
                $sqlLitterer .= ' AND u.barangay_id = :barangay_id';
            }

            // Combine with UNION ALL
            $sql = $sqlWaste . ' UNION ALL ' . $sqlLitterer . ' ORDER BY report_date DESC';

            $stmt = $this->db->prepare($sql);

            if ($barangay_id) {
                $stmt->bindParam(':barangay_id', $barangay_id, PDO::PARAM_INT);
            }

            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        } catch (PDOException $e) {
            error_log('Database Error: ' . $e->getMessage());
            return [];
        }
    }

    //function to add points
    public function addPoints($userId, $points)
    {
        try {
            $stmt = $this->db->prepare("
                UPDATE users SET points = points + :points WHERE id = :user_id
            ");

            $stmt->bindParam(':points', $points);
            $stmt->bindParam(':user_id', $userId);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('Database Error: ' . $e->getMessage());
            return false;
        }
    }

    //function to trace which table is the report id that is going to be change status
    public function getReportById($reportId, $barangayId)
    {
        try {
            // Check waste reports with all needed fields
            $stmt = $this->db->prepare("
            SELECT wr.*, u.barangay_id, 'waste' as report_type
            FROM waste_reports wr
            JOIN users u ON wr.user_id = u.id
            WHERE wr.id = :id AND u.barangay_id = :barangay_id
        ");
            $stmt->bindParam(':id', $reportId);
            $stmt->bindParam(':barangay_id', $barangayId);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return $result;
            }

            // Check litterer reports if not found in waste reports
            $stmt = $this->db->prepare("
            SELECT lr.*, u.barangay_id, 'litterer' as report_type
            FROM litterer_reports lr
            JOIN users u ON lr.user_id = u.id
            WHERE lr.id = :id AND u.barangay_id = :barangay_id
        ");
            $stmt->bindParam(':id', $reportId);
            $stmt->bindParam(':barangay_id', $barangayId);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Database Error: ' . $e->getMessage());
            return false;
        }
    }

    //function model to change the status of the reports 
    public function updateReportStatus($reportId, $status, $barangayId)
    {
        try {
            // First determine which table the report is in
            $report = $this->getReportById($reportId, $barangayId);

            if (!$report) {
                return false;
            }

            $tableName = $report['report_type'] === 'waste' ? 'waste_reports' : 'litterer_reports';

            $stmt = $this->db->prepare("
            UPDATE $tableName 
            SET status = :status 
            WHERE id = :id
        ");

            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id', $reportId);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('Database Error: ' . $e->getMessage());
            return false;
        }
    }

    //Get user ID from a report
    public function getUserIdFromReport($reportId, $reportType)
    {
        try {
            $tableName = $reportType === 'waste' ? 'waste_reports' : 'litterer_reports';

            $stmt = $this->db->prepare("
            SELECT user_id FROM $tableName WHERE id = :id
        ");
            $stmt->bindParam(':id', $reportId);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['user_id'] : false;
        } catch (PDOException $e) {
            error_log('Database Error: ' . $e->getMessage());
            return false;
        }
    }

    //Get report details by ID for a specific barangay
    public function getReportDetails($reportId, $barangayId)
    {
        try {
            // Check waste reports
            $stmt = $this->db->prepare("
            SELECT wr.*, 'waste' as report_type
            FROM waste_reports wr
            JOIN users u ON wr.user_id = u.id
            WHERE wr.id = :id AND u.barangay_id = :barangay_id
        ");
            $stmt->bindParam(':id', $reportId);
            $stmt->bindParam(':barangay_id', $barangayId);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return $result;
            }

            // Check litterer reports if not found in waste reports
            $stmt = $this->db->prepare("
            SELECT lr.*, 'litterer' as report_type
            FROM litterer_reports lr
            JOIN users u ON lr.user_id = u.id
            WHERE lr.id = :id AND u.barangay_id = :barangay_id
        ");
            $stmt->bindParam(':id', $reportId);
            $stmt->bindParam(':barangay_id', $barangayId);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Database Error: ' . $e->getMessage());
            return false;
        }
    }

    //functon to get all the redemptions request from db (for admin)
    public function getRedemptions($barangay_id)
    {
        try {
            $stmt = $this->db->prepare("
            SELECT 
            rr.id,
            u.firstname, 
            u.lastname, 
            u.email, 
            rr.points_amount, 
            rr.gcash_number, 
            rr.gcash_name, 
            rr.qr_code_path, 
            rr.status, 
            rr.request_date
        FROM redemption_requests rr
        JOIN users u ON rr.user_id = u.id
        WHERE u.barangay_id = :barangay_id and status = 'pending'
        ORDER BY rr.request_date DESC

        ");

            $stmt->bindParam(':barangay_id', $barangay_id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }
}
