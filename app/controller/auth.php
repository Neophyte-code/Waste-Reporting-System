<?php

require_once __DIR__ . '/../Mailer/Emailer.php';

class Auth extends Controller
{
    public function __construct() {}

    public function index()
    {
        $this->view("auth/index", []);
    }

    // function for user registration
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

            // basic validation
            if (empty($data['firstname']) || empty($data['lastname']) || empty($data['barangay']) || empty($data['email']) || empty($data['password']) || empty($data['confirm_password'])) {
                $this->view('auth/index', ['error' => 'All fields are required', 'form' => 'signup']);
                return;
            }
            if ($data['password'] !== $data['confirm_password']) {
                $this->view('auth/index', ['error' => 'Passwords do not match', 'form' => 'signup']);
                return;
            }

            // Model instance
            $userModel = $this->model('UserModel');
            $barangay_id = $userModel->getBarangayIdByName($data['barangay']);
            if (!$barangay_id) {
                $this->view('auth/index', ['error' => 'Invalid barangay selected', 'form' => 'signup']);
                return;
            }

            // Check existing user
            $existingUser = $userModel->getUserByEmail($data['email']);
            if ($existingUser) {
                $this->view("auth/index", [
                    'error' => 'This email is already registered.',
                    'form' => 'signup'
                ]);
                return;
            }

            // Handle file uploads
            $uploadDir = __DIR__ . '/../../public/images/ids/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            $maxSize = 5 * 1024 * 1024;

            $uploadedFiles = $_FILES['files'] ?? null;
            if (!$uploadedFiles || count($uploadedFiles['name']) < 2) {
                $this->view("auth/index", ['error' => 'Please upload both front and back ID images.', 'form' => 'signup']);
                return;
            }

            $idFront = null;
            $idBack = null;

            for ($i = 0; $i < count($uploadedFiles['name']); $i++) {
                if ($uploadedFiles['error'][$i] === UPLOAD_ERR_OK) {
                    $tmpName = $uploadedFiles['tmp_name'][$i];
                    $fileType = mime_content_type($tmpName);
                    $fileSize = $uploadedFiles['size'][$i];

                    if (!in_array($fileType, $allowedTypes)) {
                        $this->view("auth/index", ['error' => 'Only JPG or PNG files are allowed.', 'form' => 'signup']);
                        return;
                    }
                    if ($fileSize > $maxSize) {
                        $this->view("auth/index", ['error' => 'Each file must be less than 5MB.', 'form' => 'signup']);
                        return;
                    }

                    // Generate safe filename
                    $ext = pathinfo($uploadedFiles['name'][$i], PATHINFO_EXTENSION);
                    $newName = uniqid('id_', true) . '.' . $ext;
                    $targetPath = $uploadDir . $newName;

                    if (move_uploaded_file($tmpName, $targetPath)) {
                        if ($i == 0) $idFront = 'images/ids/' . $newName;
                        else $idBack = 'images/ids/' . $newName;
                    } else {
                        $this->view("auth/index", ['error' => 'Failed to upload files.', 'form' => 'signup']);
                        return;
                    }
                } else {
                    $this->view("auth/index", ['error' => 'Error uploading ID images.', 'form' => 'signup']);
                    return;
                }
            }

            // store user 
            $data['barangay_id'] = $barangay_id;
            $data['id_front'] = $idFront;
            $data['id_back'] = $idBack;

            $user_id = $userModel->register($data);

            if ($user_id) {
                // generate OTP (6 digits)
                $otp = str_pad((string)random_int(0, 999999), 6, '0', STR_PAD_LEFT);

                // hash OTP and set expiry (10 minutes)
                $otpHash = password_hash($otp, PASSWORD_DEFAULT);
                $expiresAt = (new DateTime('+10 minutes'))->format('Y-m-d H:i:s');

                // store OTP
                if (!$userModel->storeOtp($user_id, $otpHash, $expiresAt)) {
                    $this->view("auth/index", ['error' => 'Registration failed', 'form' => 'signup']);
                    return;
                }

                // send OTP using Emailer
                $emailer = new Emailer();
                if (!$emailer->sendVerificationOtp($data['email'], $otp)) {
                    $this->view("auth/index", ['error' => 'Registration failed. Please try again later.', 'form' => 'signup']);
                    return;
                }

                // redirect user to verification page
                header("Location: " . URL_ROOT . "/auth/verify?email=" . urlencode($data['email']));
                exit;
            } else {
                $this->view("auth/index", ['error' => 'Registration failed', 'form' => 'signup']);
            }
        } else {
            $this->view("auth/index", ['form' => 'signup']);
        }
    }


    // show verify page (OTP input)
    public function verify()
    {
        $email = $_GET['email'] ?? '';
        if (!$email) {
            $this->view("auth/index", ['error' => 'Invalid verification request', 'form' => 'signup']);
            return;
        }
        // show verify form
        $this->view("auth/verify", ['email' => htmlspecialchars($email)]);
    }

    // process OTP submission
    public function verifyOtp()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . URL_ROOT . "/auth/index");
            exit;
        }

        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
        $inputOtp = trim($_POST['otp'] ?? '');

        if (empty($email) || empty($inputOtp)) {
            $this->view("auth/verify", [
                'error' => 'Code and email are required.',
                'email' => htmlspecialchars($email)
            ]);
            return;
        }

        $userModel = $this->model('UserModel');
        $user = $userModel->findByEmail($email);

        if (!$user) {
            $this->view("auth/verify", [
                'error' => 'Invalid code or email.',
                'email' => htmlspecialchars($email)
            ]);
            return;
        }

        // Get latest OTP record
        $otpRecord = $userModel->getLatestOtpRecord($user['id']);
        if (!$otpRecord) {
            $this->view("auth/verify", [
                'error' => 'No verification code found. Please request a new one.',
                'email' => htmlspecialchars($email)
            ]);
            return;
        }

        // Check expiry
        $now = new DateTime();
        $expiresAt = new DateTime($otpRecord['expires_at']);
        if ($now > $expiresAt) {
            $this->view("auth/verify", [
                'error' => 'Code expired. Please request a new one.',
                'email' => htmlspecialchars($email)
            ]);
            return;
        }

        // Check attempts limit
        if ((int)$otpRecord['attempts'] >= 5) {
            $this->view("auth/verify", [
                'error' => 'Too many attempts. Please request a new code.',
                'email' => htmlspecialchars($email)
            ]);
            return;
        }

        // Verify OTP
        if (password_verify($inputOtp, $otpRecord['otp_hash'])) {
            $userModel->markEmailVerified($user['id']);
            $userModel->deleteOtp($otpRecord['id']);

            // Success message
            $this->view("auth/index", [
                'success' => 'Email verified! Your account is pending admin approval. You’ll be able to sign in once approved.',
                'form' => 'signin',
                'toast_only' => true
            ]);
            return;
        }

        // Wrong code (increment attempts)
        $userModel->incrementOtpAttempts($otpRecord['id']);
        $this->view("auth/verify", [
            'error' => 'Incorrect code. Please try again.',
            'email' => htmlspecialchars($email)
        ]);
    }


    // resend OTP
    public function resendOtp()
    {
        // Allow both GET (link click) and POST (form)
        $email = filter_var(trim($_GET['email'] ?? $_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);

        if (empty($email)) {
            $this->view("auth/verify", [
                'error' => 'Invalid request. Email missing.',
                'email' => ''
            ]);
            return;
        }

        $userModel = $this->model('UserModel');
        $user = $userModel->findByEmail($email);

        // Don't reveal user existence
        if (!$user) {
            $this->view("auth/verify", [
                'success' => 'If an account exists, a new code was sent.',
                'email' => htmlspecialchars($email)
            ]);
            return;
        }

        // Generate new OTP
        $otp = str_pad((string)random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $otpHash = password_hash($otp, PASSWORD_DEFAULT);
        $expiresAt = (new DateTime('+10 minutes'))->format('Y-m-d H:i:s');

        // Store new OTP
        if (!$userModel->storeOtp($user['id'], $otpHash, $expiresAt)) {
            $this->view("auth/verify", [
                'error' => 'Failed to create code. Please try again later.',
                'email' => htmlspecialchars($email)
            ]);
            return;
        }

        // Send via Emailer
        $emailer = new Emailer();
        if (!$emailer->sendVerificationOtp($email, $otp)) {
            $this->view("auth/verify", [
                'error' => 'Failed to send code. Please try again later.',
                'email' => htmlspecialchars($email)
            ]);
            return;
        }

        // Success
        $this->view("auth/verify", [
            'success' => "A new verification code was sent to $email. It will expire in 10 minutes.",
            'email' => htmlspecialchars($email)
        ]);
    }


    // function for logging in
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

            $userModel = $this->model('UserModel');

            // Check if email is registered
            if (!$userModel->emailExist($email)) {
                $this->view('auth/index', ['error' => 'Email is not registered', 'form' => 'signin']);
                return;
            }

            // Validate password
            $user = $userModel->login($email, $password);

            if ($user) {
                // Check if email verified
                if ($user['is_verified'] == 0) {
                    $this->view('auth/index', [
                        'error' => 'Your email is not verified. Register it to verify.',
                        'form' => 'signin',
                        'toast_only' => true
                    ]);
                    return;
                }

                // Check if still pending admin approval
                if ($user['status'] === 'pending') {
                    $this->view('auth/index', [
                        'success' => 'Your account is still awaiting admin approval. 
                                  You’ll be able to sign in once approved.',
                        'form' => 'signin',
                        'toast_only' => true
                    ]);
                    return;
                }

                //check account if user is banned
                if ($user['status'] === 'banned') {
                    $this->view('auth/index', [
                        'error' => 'Your account has been banned. Please contact support for assistance.',
                        'form' => 'signin',
                        'toast_only' => true
                    ]);
                    return;
                }

                // Proceed only if approved
                $profilePicture = !empty($user['profile_picture'])
                    ? $user['profile_picture']
                    : 'images/profile.png';
                $profilePicture = ltrim($profilePicture, '/');

                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'email' => $user['email'],
                    'firstname' => $user['firstname'],
                    'lastname' => $user['lastname'],
                    'barangay_id' => $user['barangay_id'],
                    'barangay' => $user['barangay_name'],
                    'profile_picture' => $profilePicture,
                    'role' => $user['role']
                ];

                // Clear modal state
                echo '<script>localStorage.removeItem("modalState"); localStorage.removeItem("activeForm");</script>';

                // Redirect based on roles
                if ($user['role'] === 'superadmin') {
                    header('Location: ' . URL_ROOT . '/superadmin');
                } elseif ($user['role'] === 'admin') {
                    header('Location: ' . URL_ROOT . '/admin');
                } else {
                    header('Location: ' . URL_ROOT . '/user');
                }
                exit;
            } else {
                $this->view('auth/index', ['error' => 'Incorrect password', 'form' => 'signin']);
                return;
            }
        } else {
            $this->view("auth/index", ['form' => 'signin']);
        }
    }



    // function for logging out
    public function logout()
    {
        session_destroy();
        // Clear localStorage to reset modal state
        echo '<script>localStorage.removeItem("modalState"); localStorage.removeItem("activeForm");</script>';
        header('Location: ' . URL_ROOT . '/auth');
        exit;
    }
}
