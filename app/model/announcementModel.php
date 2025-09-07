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

    //function to get announcement for admin (for admin)
    public function getAnnouncementAdmin($barangay_id)
    {
        try {
            $stmt = $this->db->prepare("
        select id, title, to_whom, date, time, location, message from announcements where barangay_id = :barangay_id order by date ASC, time ASC
        ");

            $stmt->bindParam(':barangay_id', $barangay_id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    //function to update announcement (for admin)
    public function updateAnnouncement($data)
    {
        try {
            $stmt = $this->db->prepare("
            UPDATE announcements 
            SET title = :title, to_whom = :to_whom, date = :date, time = :time, location = :location, message = :message
            WHERE id = :id
        ");
            $stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);
            $stmt->bindParam(':title', $data['title']);
            $stmt->bindParam(':to_whom', $data['to']);
            $stmt->bindParam(':date', $data['date']);
            $stmt->bindParam(':time', $data['time']);
            $stmt->bindParam(':location', $data['location']);
            $stmt->bindParam(':message', $data['message']);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    //function to delete announcement (for admin)
    public function deleteAnnouncement($id)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM announcements WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
