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
}
