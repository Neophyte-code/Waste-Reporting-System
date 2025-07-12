<?php

class AuthController extends Controller
{
    public function __construct() {}

    public function index()
    {
        $this->view("auth/index", []);
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'firstname' => htmlspecialchars(trim($_POST['firstname'] ?? '')),
                'lastname' => htmlspecialchars(trim($_POST['lastname'] ?? '')),
                'barangay' => htmlspecialchars(trim($_POST['barangay'] ?? '')),
                'email' => filter_var(trim(strtolower($_POST['email'] ?? '')), FILTER_SANITIZE_EMAIL),
                'password' => $_POST['password'] ?? '',
                'confirm_password' => $_POST['confirm_password'] ?? '',
                'form' => 'signup'
            ];

            // Input field validation
            if (empty($data['firstname']) || empty($data['lastname']) || empty($data['barangay']) || empty($data['email']) || empty($data['password']) || empty($data['confirm_password'])) {
                $this->view('auth/index', ['error' => 'All fields are required', 'form' => 'signup']);
                return;
            }

            // Confirm password
            if ($data['password'] !== $data['confirm_password']) {
                $this->view('auth/index', ['error' => 'Passwords do not match', 'form' => 'signup']);
                return;
            }

            // Validate the chosen barangay
            $userModel = $this->model('User');
            $barangay_id = $userModel->getBarangayIdByName($data['barangay']);
            if (!$barangay_id) {
                $this->view('auth/index', ['error' => 'Invalid barangay selected', 'form' => 'signup']);
                return;
            }

            // Validate if email is already registered
            if ($userModel->emailExist($data['email'])) {
                $this->view("auth/index", ['error' => 'Email already registered', 'form' => 'signup']);
                return;
            }

            // Register the user
            $data['barangay_id'] = $barangay_id;
            if ($userModel->register($data)) {
                $this->view("auth/index", ['success' => 'Registration successful!', 'form' => 'signup']);
            } else {
                $this->view("auth/index", ['error' => 'Registration failed', 'form' => 'signup']);
            }
        } else {
            $this->view("auth/index", ['form' => 'signup']);
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_var(trim(strtolower($_POST['email'] ?? '')), FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';

            // Validate empty fields
            if (empty($email) || empty($password)) {
                $this->view('auth/index', ['error' => 'All fields are required', 'form' => 'signin']);
                return;
            }

            // Instantiate the model class
            $userModel = $this->model('User');

            // Check if email is registered
            if (!$userModel->emailExist($email)) {
                $this->view('auth/index', ['error' => 'Email is not registered', 'form' => 'signin']);
                return;
            }

            // Validate password
            $user = $userModel->login($email, $password);
            if ($user) {
                $profilePicture = !empty($user['profile_picture'])
                    ? $user['profile_picture']
                    : 'images/profile.png';
                $profilePicture = ltrim($profilePicture, '/');

                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'email' => $user['email'],
                    'firstname' => $user['firstname'],
                    'lastname' => $user['lastname'],
                    'barangay' => $user['barangay_name'],
                    'profile_picture' => $profilePicture
                ];

                // Clear localStorage to reset modal state
                echo '<script>localStorage.removeItem("modalState"); localStorage.removeItem("activeForm");</script>';

                // Use URL_ROOT for consistent redirects
                header('Location: ' . URL_ROOT . '/home');
                exit;
            } else {
                //Handle incorrect password
                $this->view('auth/index', ['error' => 'Incorrect password', 'form' => 'signin']);
                return;
            }
        } else {
            $this->view("auth/index", ['form' => 'signin']);
        }
    }

    public function logout()
    {
        session_destroy();
        // Clear localStorage to reset modal state
        echo '<script>localStorage.removeItem("modalState"); localStorage.removeItem("activeForm");</script>';
        header('Location: ' . URL_ROOT . '/auth');
        exit;
    }
}
