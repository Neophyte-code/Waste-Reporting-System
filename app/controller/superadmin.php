<?php

class Superadmin extends Controller
{

    public function __construct()
    {
        //authorize the role to superadmin
        $this->authorize(['superadmin']);

        //check if the user is logged in, redirect to auth if not
        if (!isset($_SESSION['user'])) {
            header('Location: ' . URL_ROOT . '/auth');
            exit;
        }
    }

    //Main intry point page for superadmin
    public function index()
    {

        $userData = $_SESSION['user'];

        $this->view('superadmin/admin', [
            'user' => $userData
        ]);
    }

    //function for displaying UI for managing admins
    public function user()
    {

        $userData = $_SESSION['user'];

        $this->view('superadmin/user', [
            'user' => $userData
        ]);
    }
}
