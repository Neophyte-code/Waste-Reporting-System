<?php

class Announcement extends Controller
{

    public function __construct()
    {

        //check if user is logged in, redirect to auth if not
        if (!isset($_SESSION['user'])) {
            header('Location: ' . URL_ROOT . '/auth');
            exit;
        }
    }

    public function index()
    {
        //Pass user data to the view
        $userData = $_SESSION['user'];

        $this->view("announcement/index", [
            'user' => $userData
        ]);
    }
}
