<?php

class ContactModel
{

    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    //function to submit contact form to database
    public function submitContact($data)
    {
        try {

            $stmt = $this->db->prepare("insert into contact (user_id, firstname, lastname, gmail, mobile_number, message) values (:user_id, :firstname, :lastname, :gmail, :mobile_number, :message)");
            $stmt->bindParam(':user_id', $data['user_id']);
            $stmt->bindParam(':firstname', $data['firstname']);
            $stmt->bindParam(':lastname', $data['lastname']);
            $stmt->bindParam(':gmail', $data['gmail']);
            $stmt->bindParam(':mobile_number', $data['phone']);
            $stmt->bindParam(':message', $data['message']);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            return false;
        }
    }
}
