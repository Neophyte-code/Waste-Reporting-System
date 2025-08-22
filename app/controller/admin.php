<?php

class Admin extends Controller
{

    public function __construct()
    {
        //authorize the role to admin
        $this->authorize(['admin']);

        // Check if user is logged in, redirect to auth if not
        if (!isset($_SESSION['user'])) {
            header('Location: ' . URL_ROOT . '/auth');
            exit;
        }
    }

    //entry point function
    public function index()
    {
        // Pass user data to the view
        $userData = $_SESSION['user'];

        $this->view('admin/dashboard', [
            'user' => $userData,
        ]);
    }

    //function to diplay the reports UI
    public function reports()
    {
        // Pass user data to the view
        $userData = $_SESSION['user'];

        $this->view('admin/reports', [
            'user' => $userData
        ]);
    }

    //function to display the user info UI
    public function user_info()
    {

        // Pass user data to the view
        $userData = $_SESSION['user'];

        $this->view('admin/users', [
            'user' => $userData
        ]);
    }

    //function to display the announcement UI
    public function announcement()
    {
        // Pass user data to the view
        $userData = $_SESSION['user'];

        $this->view('admin/announcement', [
            'user' => $userData
        ]);
    }

    //function to display the litterer records UI
    public function litterer()
    {
        // Pass user data to the view
        $userData = $_SESSION['user'];

        $this->view('admin/litterer', [
            'user' => $userData
        ]);
    }

    //function to display the redemptions UI
    public function redemptions()
    {
        // Pass user data to the view
        $userData = $_SESSION['user'];

        $this->view('admin/redemptions', [
            'user' => $userData
        ]);
    }

    //function to display the settings UI
    public function settings()
    {
        // Pass user data to the view
        $userData = $_SESSION['user'];

        $this->view('admin/settings', [
            'user' => $userData
        ]);
    }
}
