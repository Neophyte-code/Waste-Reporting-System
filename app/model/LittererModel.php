<?php

class LittererModel
{

    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    //function to create litterer records
    public function createLittererRecord($data)
    {

        try {
            $stmt = $this->db->prepare("
            insert into litterers (name, number, address, offense, barangay_id) values (:name, :number, :address, :offense, :barangay_id)
        ");

            $stmt->bindParam(':name', $data['name']);
            $stmt->bindParam(':number', $data['number']);
            $stmt->bindParam(':address', $data['address']);
            $stmt->bindParam(':offense', $data['offense']);
            $stmt->bindParam(':barangay_id', $data['barangay_id']);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }
}
