<?php

class announcementModel
{

    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function getAnnouncement($barangay_id)
    {

        try {

            //i prepare ang query 
            $stmt = $this->db->prepare("select a.id, a.what, a.to_whom, a.date, a.time, a.location, a.message from announcements a where a.barangay_id = :barangay_id order by a.created_at desc");
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
}
