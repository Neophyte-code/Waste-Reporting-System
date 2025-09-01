<?php

class announcementModel
{

    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    //function to get announcement and display to users
    public function getAnnouncement($barangay_id)
    {

        try {

            //i prepare ang query 
            $stmt = $this->db->prepare("select a.id, a.title, a.to_whom, a.date, a.time, a.location, a.message from announcements a where a.barangay_id = :barangay_id order by a.created_at desc");
            $stmt->bindParam(':barangay_id', $barangay_id, PDO::PARAM_INT);
            //i execute ang query
            $stmt->execute();
            //i return ang na fetch nga data gikan sa database
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Database Error: ' . $e->getMessage());
            return false;
        }
    }

    //function to create announcemnent (for admin)
    public function createAnnouncement($data)
    {
        try {
            $stmt = $this->db->prepare("
                insert into announcements (barangay_id, title, to_whom, date, time, location, message)
                values (:barangay_id, :title, :to_whom, :date, :time, :location, :message)
            ");

            $stmt->bindParam(':barangay_id', $data['barangay_id']);
            $stmt->bindParam(':title', $data['title']);
            $stmt->bindParam(':to_whom', $data['to']);
            $stmt->bindParam(':date', $data['date']);
            $stmt->bindParam(':time', $data['time']);
            $stmt->bindParam(':location', $data['location']);
            $stmt->bindParam(':message', $data['message']);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }
}
