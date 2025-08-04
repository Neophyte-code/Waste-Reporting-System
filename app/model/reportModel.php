<?php

class ReportModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    //function for submitting waste Report
    public function submitWasteReport($data)
    {

        try {

            $stmt = $this->db->prepare("insert into waste_reports (user_id, description, image_path, estimated_weight, latitude, longitude, status) values(:user_id, :description, :image_path, :estimated_weight, :latitude, :longitude,  'pending')");
            $stmt->bindParam(':user_id', $data['user_id']);
            $stmt->bindParam(':description', $data['wasteType']);
            $stmt->bindParam(':image_path', $data['image']);
            $stmt->bindParam(':estimated_weight', $data['estimatedWeight']);
            $stmt->bindParam(':latitude', $data['latitude']);
            $stmt->bindParam(':longitude', $data['longitude']);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            return false;
        }
    }
}
