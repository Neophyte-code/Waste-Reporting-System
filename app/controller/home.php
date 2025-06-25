<?php

class Home extends Controller
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

        $this->view('home/index', [
            'user' => $userData,
            'welcome_message' => 'Welcome to your dashboard!'
        ]);
    }

    public function updateProfile()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = $this->model('User');

            // Initialize data array with form values
            $data = [
                'firstname' => htmlspecialchars(trim($_POST['firstname'] ?? '')),
                'lastname' => htmlspecialchars(trim($_POST['lastname'] ?? '')),
                'barangay' => htmlspecialchars(trim($_POST['barangay'] ?? '')),
                'email' => filter_var(trim(strtolower($_POST['email'] ?? '')), FILTER_SANITIZE_EMAIL),
                'old_email' => $_SESSION['user']['email'],
                'profile_picture' => $_SESSION['user']['profile_picture'] ?? 'images/profile.png'
            ];

            // Handle profile picture upload
            if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../public/images/uploads/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                // Validate file type and size
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                $maxSize = 5 * 1024 * 1024;
                $fileType = $_FILES['profile_picture']['type'];
                $fileSize = $_FILES['profile_picture']['size'];

                if (!in_array($fileType, $allowedTypes)) {
                    $_SESSION['profile_error'] = 'Invalid file type. Only JPEG, PNG, and GIF are allowed.';
                    header('Location: ' . URL_ROOT . '/home');
                    exit;
                }
                if ($fileSize > $maxSize) {
                    $_SESSION['profile_error'] = 'File size too large. Maximum 5MB allowed.';
                    header('Location: ' . URL_ROOT . '/home');
                    exit;
                }

                // Generate unique filename
                $fileName = uniqid() . '-' . basename($_FILES['profile_picture']['name']);
                $uploadPath = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $uploadPath)) {
                    $data['profile_picture'] = 'images/uploads/' . $fileName;
                } else {
                    $_SESSION['profile_error'] = 'Failed to upload file. Check directory permissions.';
                    header('Location: ' . URL_ROOT . '/home');
                    exit;
                }
            }

            // Validate inputs
            if (empty($data['firstname']) || empty($data['lastname']) || empty($data['barangay']) || empty($data['email'])) {
                $_SESSION['profile_error'] = 'All fields are required';
                header('Location: ' . URL_ROOT . '/home');
                exit;
            }

            // Validate barangay
            $barangay_id = $userModel->getBarangayIdByName($data['barangay']);
            if (!$barangay_id) {
                $_SESSION['profile_error'] = 'Invalid barangay selected';
                header('Location: ' . URL_ROOT . '/home');
                exit;
            }

            // Check if new email is already taken (if changed)
            if ($data['email'] !== $data['old_email'] && $userModel->emailExist($data['email'])) {
                $_SESSION['profile_error'] = 'Email already registered';
                header('Location: ' . URL_ROOT . '/home');
                exit;
            }

            $data['barangay_id'] = $barangay_id;
            if ($userModel->updateProfile($data)) {
                // Update session data
                $_SESSION['user'] = [
                    'email' => $data['email'],
                    'firstname' => $data['firstname'],
                    'lastname' => $data['lastname'],
                    'barangay' => $data['barangay'],
                    'profile_picture' => $data['profile_picture']
                ];
                $_SESSION['profile_success'] = 'Profile updated successfully';
            } else {
                $_SESSION['profile_error'] = 'Failed to update profile';
            }
            header('Location: ' . URL_ROOT . '/home');
            exit;
        }
    }
}
