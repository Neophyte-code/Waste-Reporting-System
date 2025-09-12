<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use GeminiAPI\Client;
use GeminiAPI\Resources\Parts\ImagePart;
use GeminiAPI\Resources\Parts\TextPart;
use GeminiAPI\Enums\MimeType;
use Dotenv\Dotenv;

class User extends Controller
{

    public function __construct()
    {
        //authorize the role to user
        $this->authorize(['user']);

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

        $this->view('user/dashboard', [
            'user' => $userData,
        ]);
    }

    //function for updating user details
    public function updateProfile()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = $this->model('UserModel');

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
                    header('Location: ' . URL_ROOT . '/user');
                    exit;
                }
                if ($fileSize > $maxSize) {
                    $_SESSION['profile_error'] = 'File size too large. Maximum 5MB allowed.';
                    header('Location: ' . URL_ROOT . '/user');
                    exit;
                }

                // Generate unique filename
                $fileName = uniqid() . '-' . basename($_FILES['profile_picture']['name']);
                $uploadPath = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $uploadPath)) {
                    $data['profile_picture'] = 'images/uploads/' . $fileName;
                } else {
                    $_SESSION['profile_error'] = 'Failed to upload file. Check directory permissions.';
                    header('Location: ' . URL_ROOT . '/user');
                    exit;
                }
            }

            // Validate inputs
            if (empty($data['firstname']) || empty($data['lastname']) || empty($data['barangay']) || empty($data['email'])) {
                $_SESSION['profile_error'] = 'All fields are required';
                header('Location: ' . URL_ROOT . '/user');
                exit;
            }

            // Validate barangay
            $barangay_id = $userModel->getBarangayIdByName($data['barangay']);
            if (!$barangay_id) {
                $_SESSION['profile_error'] = 'Invalid barangay selected';
                header('Location: ' . URL_ROOT . '/user');
                exit;
            }

            // Check if new email is already taken (if changed)
            if ($data['email'] !== $data['old_email'] && $userModel->emailExist($data['email'])) {
                $_SESSION['profile_error'] = 'Email already registered';
                header('Location: ' . URL_ROOT . '/user');
                exit;
            }

            $data['barangay_id'] = $barangay_id;
            if ($userModel->updateProfile($data)) {
                // Update session data
                $_SESSION['user'] = [
                    'id' => $_SESSION['user']['id'],
                    'role' => $_SESSION['user']['role'],
                    'email' => $data['email'],
                    'firstname' => $data['firstname'],
                    'lastname' => $data['lastname'],
                    'barangay_id' => $data['barangay'],
                    'profile_picture' => $data['profile_picture']
                ];
                $_SESSION['profile_success'] = 'Profile updated successfully';
            } else {
                $_SESSION['profile_error'] = 'Failed to update profile';
            }
            header('Location: ' . URL_ROOT . '/user');
            exit;
        }
    }

    //function to display about UI
    public function about()
    {
        // Pass user data to the view
        $userData = $_SESSION['user'];

        $this->view('user/about', [
            'user' => $userData
        ]);
    }

    //function to display contact UI
    public function contact()
    {
        // Pass user data to the view
        $userData = $_SESSION['user'];
        $barangay = $userData['barangay'] ?? 'Daanbantayan';

        //kuhaon ang barangay details gikan sa function nga getBarangayDetails()
        $barangayDetails  = $this->getBarangayDetails();
        $details = $barangayDetails[$barangay] ?? $barangayDetails['Daanbantayan'];

        //kuhaon ang value sa display message gikan sa contactForm() na function ug i assign sa variables
        $error = $_SESSION['contact_error'] ?? null;
        $success =  $_SESSION['contact_success'] ?? null;

        //i delete ang display message nga naa sa session
        unset($_SESSION['contact_error']);
        unset($_SESSION['contact_success']);

        $this->view('user/contact', [
            'user' => $userData,
            'barangayDetails' => $details,
            'error' => $error,
            'success' => $success
        ]);
    }

    //function for submitting contact form
    public function contactForm()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            //Gamiton ang session para makuha ang ID sa naka log in nga user
            $user = $_SESSION['user'];

            $data = [
                //sanitize the input
                'user_id' => htmlspecialchars(trim($user['id'])),
                'firstname' => htmlspecialchars(trim($_POST['firstname'])),
                'lastname' => htmlspecialchars(trim($_POST['lastname'])),
                'gmail' => filter_var(trim(strtolower($_POST['gmail'])), FILTER_SANITIZE_EMAIL),
                'phone' => htmlspecialchars(trim($_POST['phone'])),
                'message' => htmlspecialchars(trim($_POST['message']))
            ];

            //I validate ang form if naay value tanan input field
            if (empty($data['firstname']) || empty($data['lastname']) || empty($data['gmail'])  || empty($data['phone']) || empty($data['message'])) {
                $_SESSION['contact_error'] = 'All fields are required.';
                header('Location: ' . URL_ROOT . '/user/contact');
                exit;
            }

            //i validate ang email
            if (!filter_var($data['gmail'], FILTER_VALIDATE_EMAIL)) {
                $_SESSION['contact_error'] = 'Invalid email address';
                header('Location: ' . URL_ROOT . '/user/contact');
                exit;
            }

            //i validate ang phone number
            if (!preg_match('/^09[0-9]{9}$/', $data['phone'])) {
                $_SESSION['contact_error'] = 'Invalid phone number format. Must be 11 digits starting with 09.';
                header('Location: ' . URL_ROOT . '/user/contact');
                exit;
            }

            //pangitaon or i instantiate ang model para sendan sa data gikan sa input field
            $contactModel = $this->model('ContactModel');

            //i send and data sa input field padung sa model
            if ($contactModel->submitContact($data)) {
                $_SESSION['contact_success'] = 'Your message has been submitted successfully!';
            } else {
                $_SESSION['contact_error'] = 'Failed to submit your message. Please try again.';
            }

            header('Location: ' . URL_ROOT . '/user/contact');
            exit;
        }
    }

    //function that consist of barangay details of the three barangays
    private function  getBarangayDetails()
    {
        return [
            'Tapilon' => [
                'map' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15651.496957973563!2d124.0207196321978!3d11.270653816586503!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a877cdf2f92c03%3A0x5ebd702f1c7dd656!2sTapilon%20Barangay%20Hall!5e0!3m2!1sen!2sph!4v1752040121515!5m2!1sen!2sph',
                'phone' => '(032)437-3765',
                'gmail' => 'brgy.tapilonofcl@gmail.com',
                'facebook' => 'https://web.facebook.com/profile.php?id=61554347493287',
                'fbName' => 'Barangay Tapilon'
            ],
            'Maya' => [
                'map' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d500692.0165874774!2d123.24964129540528!3d11.359789817930817!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a877e775f573d1%3A0xb242f4fb38d59e!2sMaya%20Baranggay%20Hall!5e0!3m2!1sen!2sph!4v1752040254350!5m2!1sen!2sph',
                'phone' => '(032)340-18564',
                'gmail' => 'barangay_maya@yahoo.com',
                'facebook' => 'https://web.facebook.com/profile.php?id=61575813887580&rdid=DlYzM8MmGncDZ4a0&share_url=https%3A%2F%2Fweb.facebook.com%2Fshare%2F1FQXze85CH%2F%3F_rdc%3D1%26_rdr',
                'fbName' => 'Barangay Maya'
            ],
            'Poblacion' => [
                'map' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7812.656272161509!2d123.99805230634198!3d11.253821989236988!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a877a0a270c489%3A0xf3c04035945accc0!2sBrgy.%20Poblacion%20Hall!5e0!3m2!1sen!2sph!4v1752040497088!5m2!1sen!2sph',
                'phone' => '(032)231-4525',
                'gmail' => 'pob.dbantayansec@gmail.com',
                'facebook' => 'https://web.facebook.com/skdbpoblacion',
                'fbName' => 'Barangay Poblacion'
            ],
            'Daanbantayan' => [
                'map' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d125220.84096790677!2d123.85405714335937!3d11.25027970000002!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a8770b5b923b63%3A0xe2cd86d84135f9ba!2sDaanbantayan%20Municipal%20Hall!5e0!3m2!1sen!2sph!4v1752043258401!5m2!1sen!2sph',
                'phone' => 'None',
                'gmail' => 'daanbantayan@gmail.com',
                'facebook' => '',
                'fbName' => 'Municipalty of Daanbantayan'
            ]
        ];
    }

    //function to display announcemnet
    public function announcement()
    {
        // Pass user data to the view
        $userData = $_SESSION['user'];
        $barangay_id = $userData['barangay_id'];

        $announcementModel = $this->model('announcementModel');

        $announcements = $announcementModel->getAnnouncement($barangay_id);

        $this->view('user/announcement', [
            'user' => $userData,
            'announcements' => $announcements ? $announcements : []
        ]);
    }

    //get announcement from database
    public function getAnnouncement()
    {

        //i instantiate ang model para sa announcement
        $announcementModel = $this->model('announcementModel');

        //Ajax request para pag fetch sa announcements
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_SESSION['user']['barangay_id'])) {
            $barangay_id = $_SESSION['user']['barangay_id'];
            $announcements = $announcementModel->getAnnouncement($barangay_id);

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

    //function to diplay the report waste UI
    public function waste()
    {
        // Pass user data to the view
        $userData = $_SESSION['user'];
        //use to display points to the UI
        $userModel = $this->model('UserModel');
        $userPoints = $userModel->getUserPoints($userData['id']);
        // Ensure points is a numeric value before formatting
        $userData['points'] = is_numeric($userPoints) ? number_format((float)$userPoints) : '0.00';

        //display error/success message
        $success = $_SESSION['report_success'] ?? '';
        $error = $_SESSION['report_error'] ?? '';
        $redeemSuccess = $_SESSION['redeem_success'] ?? '';
        $redeemError = $_SESSION['redeem_error'] ?? '';

        //unset after view
        unset($_SESSION['report_error']);
        unset($_SESSION['report_success']);
        unset($_SESSION['redeem_error']);
        unset($_SESSION['redeem_success']);

        $this->view('user/waste', [
            'user' => $userData,
            'success' => $success,
            'error' => $error,
            'redeemSuccess' => $redeemSuccess,
            'redeemError' => $redeemError
        ]);
    }

    // Function to validate the image using AI
    public function process()
    {
        // Load the API key
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        $apiKey = $_ENV['GEMINI_API_KEY'] ?? null;
        if (!$apiKey) {
            echo json_encode(['error' => 'API key not found.']);
            exit;
        }

        // Initialize Gemini client
        $client = new Client($apiKey);

        // Handle the uploaded image
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['wasteImage'])) {
            $response = ['error' => ''];

            try {
                // Validate image
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                $maxSize = 5 * 1024 * 1024;
                $file = $_FILES['wasteImage'];

                if (!in_array($file['type'], $allowedTypes)) {
                    throw new Exception('Invalid image format. Only JPEG, PNG, or GIF allowed.');
                }
                if ($file['size'] > $maxSize) {
                    throw new Exception('Image size exceeds 5MB limit.');
                }
                if ($file['error'] !== UPLOAD_ERR_OK) {
                    throw new Exception('Image upload failed with error code: ' . $file['error']);
                }

                // Read and encode the image
                $imageData = file_get_contents($file['tmp_name']);
                if ($imageData === false) {
                    throw new Exception('Failed to read image file.');
                }
                $imageBase64 = base64_encode($imageData);

                // Map string MIME type to GeminiAPI\Enums\MimeType enum
                $mimeTypeMap = [
                    'image/jpeg' => MimeType::IMAGE_JPEG,
                    'image/png'  => MimeType::IMAGE_PNG,
                    'image/gif'  => MimeType::IMAGE_WEBP,
                ];
                $mimeType = $mimeTypeMap[$file['type']] ?? null;
                if (!$mimeType) {
                    throw new Exception('Unsupported MIME type: ' . $file['type']);
                }

                // Prepare prompt for Gemini API
                $prompt = new TextPart(
                    "Analyze this image of waste and identify the type of waste (e.g., plastic, glass, metal, organic). " .
                        "Also estimate the weight in kilograms based on visual characteristics. " .
                        "Return the response in the format: Waste Type: [type], Estimated Weight: [weight] kg"
                );
                $imagePart = new ImagePart($mimeType, $imageBase64);

                // Call Gemini API
                $response = $client->generativeModel('gemini-2.0-flash')->generateContent($prompt, $imagePart);
                $result = $response->text();

                // Parse the result
                preg_match('/Waste Type:\s*(.+?),\s*Estimated Weight:\s*([0-9.]+)\s*kg/i', $result, $matches);
                $wasteType = $matches[1] ?? 'Unknown';
                $wasteWeight = $matches[2] ?? 'Unknown';

                echo json_encode([
                    'wasteType' => $wasteType,
                    'wasteWeight' => $wasteWeight
                ]);
            } catch (Exception $e) {
                http_response_code(400);
                echo json_encode([
                    'error' => $e->getMessage(),
                    'status' => 'error'
                ]);
                exit;
            }
        } else {
            echo json_encode(['error' => 'No image uploaded or invalid request method']);
        }
    }

    //function to submit the waste report
    public function submitWasteReport()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Load the ReportModel
            $reportModel = $this->model('ReportModel');

            // Sanitize and prepare data
            $data = [
                'user_id' => $_SESSION['user']['id'],
                'wasteType' => filter_var($_POST['wasteType']),
                'estimatedWeight' => filter_var($_POST['estimatedWeight']),
                'latitude' => filter_var($_POST['latitude'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                'longitude' => filter_var($_POST['longitude'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                'image' => ''
            ];

            //validate the form if all fields have value
            if (empty($data['estimatedWeight']) || empty($data['wasteType']) || empty($data['latitude']) || empty($data['longitude'])) {
                $_SESSION['report_error'] = 'All fields are required';
                header('Location: ' . URL_ROOT . '/user/waste');
                exit;
            }

            // Handle file upload
            if (isset($_FILES['wasteImage']) && $_FILES['wasteImage']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = '../public/images/reportWaste/';
                $fileName = time() . '_' . basename($_FILES['wasteImage']['name']);
                $uploadPath = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['wasteImage']['tmp_name'], $uploadPath)) {
                    $data['image'] = 'images/reportWaste/' . $fileName;
                } else {
                    $_SESSION['report_error'] = 'Failed to upload image.';
                    header('Location: ' . URL_ROOT . '/user/waste');
                    exit;
                }
            } else {
                $_SESSION['report_error'] = 'Please upload a valid image.';
                header('Location: ' . URL_ROOT . '/user/waste');
                exit;
            }

            // Submit the report
            if ($reportModel->submitWasteReport($data)) {
                $_SESSION['report_success'] = 'Report submitted successfully!';
                header('Location: ' . URL_ROOT . '/user/waste');
                exit;
            } else {
                $_SESSION['report_error'] = 'Failed to submit report. Please try again.';
                header('Location: ' . URL_ROOT . '/user/waste');
                exit;
            }
        }
    }

    //function to get notification
    public function getNotifications()
    {
        $reportModel = $this->model('ReportModel');
        $user_id = $_SESSION['user']['id'];

        try {
            $notifications = $reportModel->getNotifications($user_id);

            header('Content-Type: application/json');
            echo json_encode($notifications);
        } catch (Exception $e) {
            error_log('Error fetching notifications: ' . $e->getMessage());
            header('Content-Type: application/json');
            echo json_encode([]);
        }
        exit;
    }

    //function to mark the notification as read
    public function markNotificationAsRead()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            $notification_id = filter_var($input['id'], FILTER_SANITIZE_NUMBER_INT);
            $user_id = $_SESSION['user']['id'];

            try {
                $reportModel = $this->model('ReportModel');
                $success = $reportModel->markNotificationAsRead($notification_id, $user_id);

                header('Content-Type: application/json');
                echo json_encode(['success' => $success]);
            } catch (Exception $e) {
                error_log('Error marking notification as read: ' . $e->getMessage());
                header('Content-Type: application/json');
                echo json_encode(['success' => false]);
            }
            exit;
        }
    }

    //function to mark all the notification as read
    public function markAllNotificationsAsRead()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user']['id'];

            try {
                $reportModel = $this->model('ReportModel');
                $success = $reportModel->markAllNotificationsAsRead($user_id);

                header('Content-Type: application/json');
                echo json_encode(['success' => $success]);
            } catch (Exception $e) {
                error_log('Error marking all notifications as read: ' . $e->getMessage());
                header('Content-Type: application/json');
                echo json_encode(['success' => false]);
            }
            exit;
        }
    }

    //function to redeem points
    public function redeemPoints()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate file upload first
            if (!isset($_FILES['gcashQR']) || $_FILES['gcashQR']['error'] !== UPLOAD_ERR_OK) {
                $_SESSION['redeem_error'] = 'Please upload a valid image.';
                header('Location: ' . URL_ROOT . '/user/waste');
                exit;
            }

            // Sanitize and prepare data
            $data = [
                'user_id' => $_SESSION['user']['id'],
                'points_amount' => filter_var($_POST['points'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                'gcash_number' => htmlspecialchars(trim($_POST['gcashNumber'])),
                'gcash_name' => htmlspecialchars(trim($_POST['gcashName'])),
            ];

            $redeemModel = $this->model('RedeemModel');

            // First validate the redemption (points, user existence, etc.)
            $validationResult = $redeemModel->validateRedemptionRequest($data);

            if (!($validationResult['success'] ?? false)) {
                $_SESSION['redeem_error'] = $validationResult['message'] ?? 'Validation failed.';
                header('Location: ' . URL_ROOT . '/user/waste');
                exit;
            }

            // Only upload file after validation passes
            $uploadDir = '../public/images/qrCode/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileName = time() . '_' . basename($_FILES['gcashQR']['name']);
            $uploadPath = $uploadDir . $fileName;

            if (!move_uploaded_file($_FILES['gcashQR']['tmp_name'], $uploadPath)) {
                $_SESSION['redeem_error'] = 'Failed to upload image.';
                header('Location: ' . URL_ROOT . '/user/waste');
                exit;
            }

            // Add the file path to data after successful upload
            $data['qr_code_path'] = 'images/qrCode/' . $fileName;

            // Submit the redemption with file path
            $result = $redeemModel->submitRedemptionRequest($data);

            if ($result['success'] ?? false) {
                $_SESSION['redeem_success'] = 'Redemption request submitted successfully!';
            } else {
                // If submission fails, clean up the uploaded file
                if (file_exists($uploadPath)) {
                    unlink($uploadPath);
                }
                $_SESSION['redeem_error'] = $result['message'] ?? 'Failed to submit redemption request. Please try again.';
            }

            header('Location: ' . URL_ROOT . '/user/waste');
            exit;
        }
    }

    //function to get the transaction history via AJAX
    public function getHistory()
    {
        // Turn off output buffering and clean any previous output
        if (ob_get_length()) ob_clean();

        // Ensure no previous output has been sent
        if (headers_sent()) {
            error_log('Headers already sent in ' . __FILE__ . ' at line ' . __LINE__);
        }

        // Check if user is authenticated
        if (!isset($_SESSION['user'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }

        try {
            $reportModel = $this->model('RedeemModel');
            $history = $reportModel->getHistory($_SESSION['user']['id']);

            // Set proper content type for JSON response
            header('Content-Type: application/json');
            echo json_encode($history);
            exit;
        } catch (Exception $e) {
            error_log('Error fetching history: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Internal server error']);
            exit;
        }
    }

    //funciton top display the litterer UI
    public function litterer()
    {
        // Pass user data to the view
        $userData = $_SESSION['user'];
        $userModel = $this->model('UserModel');
        $userPoints = $userModel->getUserPoints($userData['id']);
        // Ensure points is a numeric value before formatting
        $userData['points'] = is_numeric($userPoints) ? number_format((float)$userPoints) : '0.00';

        //display error/success message
        $success = $_SESSION['report_success'] ?? null;
        $error   = $_SESSION['report_error'] ?? null;

        //unset after viewing
        unset($_SESSION['report_error'], $_SESSION['report_success']);

        $this->view('user/litterer', [
            'user' => $userData,
            'success' => $success,
            'error' => $error
        ]);
    }

    //function to submit litterer report
    public function submitLittererReport()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $reportModel = $this->model('ReportModel');

            $data = [
                'user_id' => $_SESSION['user']['id'],
                'name' => filter_var($_POST['name']),
                'age' => filter_var($_POST['age']),
                'gender' => filter_var($_POST['gender']),
                'distinguishingFeature' => filter_var($_POST['features']),
                'longitude' => filter_var($_POST['longitude'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                'latitude' => filter_var($_POST['latitude'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                'image' => ''
            ];

            // Validate required fields
            if (
                empty($data['name']) || empty($data['age']) || empty($data['gender']) ||
                empty($data['distinguishingFeature']) || empty($data['longitude']) || empty($data['latitude'])
            ) {
                $_SESSION['report_error'] = 'All fields are required';
                header('Location: ' . URL_ROOT . '/user/litterer');
                exit;
            }

            // Handle file upload with more comprehensive checks
            if (isset($_FILES['littererImage'])) {
                $file = $_FILES['littererImage'];

                // Check for upload errors
                if ($file['error'] !== UPLOAD_ERR_OK) {
                    $errorMessages = [
                        UPLOAD_ERR_INI_SIZE => 'File is too large',
                        UPLOAD_ERR_FORM_SIZE => 'File is too large',
                        UPLOAD_ERR_PARTIAL => 'File was only partially uploaded',
                        UPLOAD_ERR_NO_FILE => 'No file was uploaded',
                        UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder',
                        UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
                        UPLOAD_ERR_EXTENSION => 'File upload stopped by extension',
                    ];

                    $_SESSION['report_error'] = $errorMessages[$file['error']] ?? 'Unknown upload error';
                    header('Location: ' . URL_ROOT . '/user/litterer');
                    exit;
                }

                // Validate file type
                $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime = finfo_file($fileInfo, $file['tmp_name']);
                finfo_close($fileInfo);

                if (!in_array($mime, $allowedTypes)) {
                    $_SESSION['report_error'] = 'Only JPG, JPEG, and PNG files are allowed';
                    header('Location: ' . URL_ROOT . '/user/litterer');
                    exit;
                }

                // Validate file size (10MB max)
                if ($file['size'] > 10 * 1024 * 1024) {
                    $_SESSION['report_error'] = 'File size exceeds 10MB limit';
                    header('Location: ' . URL_ROOT . '/user/litterer');
                    exit;
                }

                // Move uploaded file
                $uploadDir = '../public/images/reportLitterer/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9\.\-_]/', '', $file['name']);
                $uploadPath = $uploadDir . $filename;

                if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                    $data['image'] = 'images/reportLitterer/' . $filename;
                } else {
                    $_SESSION['report_error'] = 'Failed to upload image';
                    header('Location: ' . URL_ROOT . '/user/litterer');
                    exit;
                }
            } else {
                $_SESSION['report_error'] = 'No image file was submitted';
                header('Location: ' . URL_ROOT . '/user/litterer');
                exit;
            }

            // Submit the report
            if ($reportModel->submitLittererReport($data)) {
                $_SESSION['report_success'] = 'Report submitted successfully';
                header('Location: ' . URL_ROOT . '/user/litterer');
                exit;
            } else {
                $_SESSION['report_error'] = 'Failed to submit report. Please try again.';
                header('Location: ' . URL_ROOT . '/user/litterer');
                exit;
            }
        }
    }
}
