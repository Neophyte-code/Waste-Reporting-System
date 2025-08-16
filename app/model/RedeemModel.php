<?php
class RedeemModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
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

            // Check if user has sufficient points (but don't deduct yet)
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

                // Create history record
                $this->createHistory(
                    $data['user_id'],
                    $redemption_id,
                    'redemption_request',
                    'Redemption Request Submitted',
                    'Your redemption request has been submitted and is pending review.',
                    0,
                    'pending'
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
    public function createHistory($user_id, $redemption_id, $type, $title, $message, $points_change, $status)
    {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO history 
                (user_id, redemption_id, type, title, message, points_change, status) 
                VALUES 
                (:user_id, :redemption_id, :type, :title, :message, :points_change, :status)
            ");

            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':redemption_id', $redemption_id, PDO::PARAM_INT);
            $stmt->bindParam(':type', $type, PDO::PARAM_STR);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':message', $message, PDO::PARAM_STR);
            $stmt->bindParam(':points_change', $points_change);
            $stmt->bindParam(':status', $status);

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
                SELECT id, user_id, redemption_id, type, title, message, points_change, status, created_at
                FROM history
                WHERE user_id = :user_id
                ORDER BY created_at DESC
                LIMIT 20
            ");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error fetching history: ' . $e->getMessage());
            return [];
        }
    }




    //function to get redemption request(for admin)
    public function getRedemptionRequest()
    {
        try {
            $stmt = $this->db->prepare("
                SELECT id, user_id, points_amount, gcash_number, gcash_name, qr_code_path, status, request_date
                FROM redemption_requests
                ORDER BY request_date DESC
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Database Error: ' . $e->getMessage());
            return false;
        }
    }
}
