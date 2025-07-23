<?php

class Report extends Controller
{

    public function __construct()
    {
        //check if user is logged in, redirect to auth if not
        if (!isset($_SESSION['user'])) {
            header('Location: ' . URL_ROOT . '/auth');
            exit;
        }
    }

    public function waste()
    {
        //pass the user date to the view
        $userData = $_SESSION['user'];

        $this->view("report/waste", [
            'user' => $userData
        ]);
    }

    public function litterer()
    {
        $this->view("report/litterer", []);
    }
}
