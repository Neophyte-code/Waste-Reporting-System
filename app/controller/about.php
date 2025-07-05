<?php

class About extends Controller
{

    public function __construct()
    {
        session_start();

        // Check if user is logged in, redirect to auth if not
        if (!isset($_SESSION['user'])) {
            header('Location: ' . URL_ROOT . '/auth');
            exit;
        }
    }

    public function index()
    {
        // Pass user data to the view
        $userData = $_SESSION['user'];

        $this->view('about/index', [
            'user' => $userData,
            'welcome_message' => 'Welcome to your dashboard!'
        ]);
    }
}
