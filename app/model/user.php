<?php

class User
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    // Function to register account
    public function register($data)
    {
        $stmt = $this->db->prepare("insert into users (firstname, lastname, barangay_id, email, password) values (:firstname, :lastname, :barangay_id, :email, :password)");
        $stmt->bindParam(':firstname', $data['firstname']);
        $stmt->bindParam(':lastname', $data['lastname']);
        $stmt->bindParam(':barangay_id', $data['barangay_id'], PDO::PARAM_INT);
        $stmt->bindParam(':email', $data['email']);
        $hashPassword = password_hash($data['password'], PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $hashPassword);

        return $stmt->execute();
    }

    // Function for user login
    public function login($email, $password)
    {
        $stmt = $this->db->prepare("select u.*, b.name as barangay_name from users u join barangays b on u.barangay_id = b.id where LOWER(u.email) = :email");
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
        $stmt = $this->db->prepare("select count(*) from users where LOWER(email) = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    // Function to fetch barangay ID by name
    public function getBarangayIdByName($barangay_name)
    {
        $stmt = $this->db->prepare("select id from barangays where name = :name");
        $stmt->bindParam(':name', $barangay_name);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['id'] : null;
    }
}
