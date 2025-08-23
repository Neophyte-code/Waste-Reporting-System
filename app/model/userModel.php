<?php

class UserModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    // Function to register account
    public function register($data)
    {
        $stmt = $this->db->prepare("INSERT INTO users (firstname, lastname, barangay_id, email, password, profile_picture) VALUES (:firstname, :lastname, :barangay_id, :email, :password, :profile_picture)");
        $stmt->bindParam(':firstname', $data['firstname']);
        $stmt->bindParam(':lastname', $data['lastname']);
        $stmt->bindParam(':barangay_id', $data['barangay_id'], PDO::PARAM_INT);
        $stmt->bindParam(':email', $data['email']);
        $hashPassword = password_hash($data['password'], PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $hashPassword);
        $profilePicture = $data['profile_picture'] ?? null;
        $stmt->bindParam(':profile_picture', $profilePicture);
        return $stmt->execute();
    }

    // Function for user login
    public function login($email, $password)
    {
        $stmt = $this->db->prepare("SELECT u.*, b.name AS barangay_name FROM users u JOIN barangays b ON u.barangay_id = b.id WHERE LOWER(u.email) = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    // Function to check if the email is already used
    public function emailExist($email)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE LOWER(email) = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    // Function to fetch barangay ID by name
    public function getBarangayIdByName($barangay_name)
    {
        $stmt = $this->db->prepare("SELECT id FROM barangays WHERE name = :name");
        $stmt->bindParam(':name', $barangay_name);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['id'] : null;
    }

    // Function to update user profile
    public function updateProfile($data)
    {
        $query = "UPDATE users SET firstname = :firstname, lastname = :lastname, barangay_id = :barangay_id, email = :email";
        if (!empty($data['profile_picture'])) {
            $query .= ", profile_picture = :profile_picture";
        }
        $query .= " WHERE email = :old_email";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':firstname', $data['firstname']);
        $stmt->bindParam(':lastname', $data['lastname']);
        $stmt->bindParam(':barangay_id', $data['barangay_id'], PDO::PARAM_INT);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':old_email', $data['old_email']);
        if (!empty($data['profile_picture'])) {
            $stmt->bindParam(':profile_picture', $data['profile_picture']);
        }

        return $stmt->execute();
    }

    // Function to get user by email
    public function getUserByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT u.*, b.name AS barangay_name FROM users u JOIN barangays b ON u.barangay_id = b.id WHERE LOWER(u.email) = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //function to get user points
    public function getUserPoints($userID)
    {
        $stmt = $this->db->prepare("SELECT points FROM users WHERE id = :user_id");
        $stmt->bindParam(':user_id', $userID, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Corrected return statement with proper parentheses
        return ($result && isset($result['points'])) ? (float)$result['points'] : 0.00;
    }

    //function to get all users (for admin)
    public function getDashboardStats($barangay_id)
    {

        try {
            $stmt = $this->db->prepare(
                "Select
                    (select count(*) from users where barangay_id = :barangay_id and role not in ('admin', 'superadmin')) as total_users,
                    (select count(*) from waste_reports wr join users u on wr.user_id = u.id where u.barangay_id = :barangay_id) as total_waste_reports,
                    (select count(*) from litterer_reports lr join users u on lr.user_id = u.id where u.barangay_id = :barangay_id) as total_litterer_reports,
                    (select count(*) from waste_reports wr join users u on wr.user_id = u.id where u.barangay_id = :barangay_id and status = 'approved') as total_verified_waste_reports,
                    (select count(*) from litterer_reports lr join users u on lr.user_id = u.id where u.barangay_id = :barangay_id and status = 'approved') as total_verified_litterer_reports,
                    (select count(*) from waste_reports wr join users u on wr.user_id = u.id where u.barangay_id = :barangay_id and status = 'pending') as total_pending_waste_reports,
                    (select count(*) from litterer_reports lr join users u on lr.user_id = u.id where u.barangay_id = :barangay_id and status = 'pending') as total_pending_litterer_reports
                "
            );

            $stmt->bindParam(':barangay_id', $barangay_id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            return [
                'total_users' => 0,
                'total_waste_reports' => 0,
                'total_litterer_reports' => 0,
                'total_verified_waste_reports' => 0,
                'total_verified_litterer_reports' => 0,
                'total_pending_waste_reports' =>  0,
                'total_pending_litterer_reports' => 0
            ];
        }
    }
}
