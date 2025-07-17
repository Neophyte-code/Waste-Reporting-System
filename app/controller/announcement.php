<?php

class Announcement extends Controller
{

    private $announcementModel;

    public function __construct()
    {

        //check if user is logged in, redirect to auth if not
        if (!isset($_SESSION['user'])) {
            header('Location: ' . URL_ROOT . '/auth');
            exit;
        }

        //i instantiate ang model para sa announcement
        $this->announcementModel = $this->model('announcementModel');
    }

    public function index()
    {
        //Pass user data to the view
        $userData = $_SESSION['user'];
        $barangay_id = $userData['barangay_id'];

        $announcements = $this->announcementModel->getAnnouncement($barangay_id);

        //i pasa ang annuncement ug user data padung sa UI/view
        $this->view("announcement/index", [
            'user' => $userData,
            'announcements' => $announcements ? $announcements : []
        ]);
    }

    public function getAnnouncement()
    {

        //Ajax request para pag fetch sa announcements
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_SESSION['user']['barangay_id'])) {
            $barangay_id = $_SESSION['user']['barangay_id'];
            $announcements = $this->announcementModel->getAnnouncement($barangay_id);

            //i return ang response in JSON
            header('Content-Type: application/json');
            echo json_encode([
                'success' => $announcements !== false,
                'data' => $announcements ? $announcements : [],
                'message' => $announcements === false ? 'Failed to fetch announcements' : ''
            ]);
            exit;
        } else {

            //invalid ang request or walay barangay id nga gi pasa
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'data' => [],
                'message' => 'Invalid request or user not authorized'
            ]);
            exit;
        }
    }
}
