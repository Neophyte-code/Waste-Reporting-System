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

        //pass user data to the view
        $userData = $_SESSION['user'];

        $message = null;
        $messageType = null;

        if (!empty($_SESSION['failed'])) {
            $message = $_SESSION['failed'];
            $messageType = 'failed';
            unset($_SESSION['failed']);
        } elseif (!empty($_SESSION['success'])) {
            $message = $_SESSION['success'];
            $messageType = 'success';
            unset($_SESSION['success']);
        }

        // instanciate the model for getting the admins
        $userModel = $this->model('UserModel');
        $admin = $userModel->getAdmin();

        $this->view('superadmin/admin', [
            'user' => $userData,
            'message' => $message,
            'messageType' => $messageType,
            'admin' => $admin
        ]);
    }

    //function to add a admin account
    public function createAdmin()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = [
                'firstname' => htmlspecialchars(trim($_POST['firstname'])),
                'lastname' => htmlspecialchars(trim($_POST['lastname'])),
                'password' => htmlspecialchars(trim($_POST['password'])),
                'email' => htmlspecialchars(trim($_POST['email'])),
                'barangay' => htmlspecialchars(trim($_POST['barangay']))
            ];

            //get the user model
            $userModel = $this->model('UserModel');

            //field validation ensure that allfields have value
            if (empty($data['firstname']) || empty($data['lastname']) || empty($data['email']) || empty($data['barangay'])) {
                $_SESSION['failed'] = 'All fields are required!';
                header('Location: ' . URL_ROOT . '/superadmin');
                exit;
            }

            // Validate if email is already registered
            if ($userModel->emailExist($data['email'])) {
                $_SESSION['failed'] = 'Email already registered!';
                header('Location: ' . URL_ROOT . '/superadmin');
                exit;
            }

            // Validate the chosen barangay
            $barangay_id = $userModel->getBarangayIdByName($data['barangay']);
            if (!$barangay_id) {
                $_SESSION['failed'] = 'Invalid barangay selected';
                exit;
            }

            // assign the validated choosen barangay
            $data['barangay'] = $barangay_id;

            // pass the data to the model
            if ($userModel->createAdmin($data)) {
                $_SESSION['success'] = "Account created successfully";
            } else {
                $_SESSION['failed'] = "Failed to create account";
            }

            header('Location: ' . URL_ROOT . '/superadmin');
            exit;
        }
    }

    //function to edit an admin account
    public function editAdmin()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = [
                'id' => htmlspecialchars(trim($_POST['editId'])),
                'firstname' => htmlspecialchars(trim($_POST['editFirstname'])),
                'lastname' => htmlspecialchars(trim($_POST['editLastname'])),
                'password' => htmlspecialchars(trim($_POST['editPassword'])),
                'email' => htmlspecialchars(trim($_POST['editEmail'])),
                'barangay' => htmlspecialchars(trim($_POST['barangay']))
            ];

            //get the user model
            $userModel = $this->model('UserModel');

            //field validation ensure that allfields have value
            if (empty($data['id']) || empty($data['firstname']) || empty($data['lastname']) || empty($data['email']) || empty($data['barangay'])) {
                $_SESSION['failed'] = 'All fields are required!';
                header('Location: ' . URL_ROOT . '/superadmin');
                exit;
            }

            // Validate the chosen barangay
            $barangay_id = $userModel->getBarangayIdByName($data['barangay']);
            if (!$barangay_id) {
                $_SESSION['failed'] = 'Invalid barangay selected';
                exit;
            }

            // assign the validated choosen barangay
            $data['barangay'] = $barangay_id;

            // pass the data to the model
            if ($userModel->updateAdmin($data)) {
                $_SESSION['success'] = "Account updated successfully";
            } else {
                $_SESSION['failed'] = "Failed to update account";
            }

            header('Location: ' . URL_ROOT . '/superadmin');
            exit;
        }
    }

    //function to delete admin account
    public function deleteAdmin()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $id = (int)$_POST['id'];
            $userModel = $this->model('UserModel');

            $deleted = $userModel->deleteAdmin($id);

            header('Content-Type: application/json');
            echo json_encode([
                'success' => $deleted,
                'message' => $deleted ? 'Admin account deleted successfully!' : 'Failed to delete admin account.'
            ]);
            exit;
        }

        // Invalid request
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Invalid request.']);
        exit;
    }

    //function for displaying UI for managing admins
    public function user()
    {

        $userData = $_SESSION['user'];

        //instantiate  a  users  model
        $userModel = $this->model('UserModel');
        $users = $userModel->getUser();

        $message = null;
        $messageType = null;

        if (!empty($_SESSION['failed'])) {
            $message = $_SESSION['failed'];
            $messageType = 'failed';
            unset($_SESSION['failed']);
        } elseif (!empty($_SESSION['success'])) {
            $message = $_SESSION['success'];
            $messageType = 'success';
            unset($_SESSION['success']);
        }

        $this->view('superadmin/user', [
            'user' => $userData,
            'users' => $users,
            'message' => $message,
            'messageType' => $messageType,
        ]);
    }

    //function to edit users status
    public function updateStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['action'])) {

            $userModel = $this->model('UserModel');
            $status = ($_POST['action'] === 'ban') ? 'banned' : 'active';

            if ($userModel->updateStatus($_POST['id'], $status)) {
                $_SESSION['success'] = "Status updated successfully";
            } else {
                $_SESSION['failed'] = "Failed to update status";
            }

            header('Location: ' . URL_ROOT . '/superadmin/user');
            exit;
        }
    }
}
