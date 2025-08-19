<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use GeminiAPI\Client;
use GeminiAPI\Resources\Parts\ImagePart;
use GeminiAPI\Resources\Parts\TextPart;
use GeminiAPI\Enums\MimeType;
use Dotenv\Dotenv;

class Waste extends Controller
{

    public function __construct()
    {
        // Check if user is logged in, redirect to auth if not
        if (!isset($_SESSION['user'])) {
            header('Location: ' . URL_ROOT . '/auth');
            exit;
        }
    }

    public function index()
    {
        // Pass the user data to the view
        $userData = $_SESSION['user'];

        //use to display points to the UI
        $userModel = $this->model('User');
        $userPoints = $userModel->getUserPoints($userData['id']);
        // Ensure points is a numeric value before formatting
        $userData['points'] = is_numeric($userPoints) ? number_format((float)$userPoints) : '0.00';

        $success = $_SESSION['report_success'] ?? '';
        $error = $_SESSION['report_error'] ?? '';
        $redeemSuccess = $_SESSION['redeem_success'] ?? '';
        $redeemError = $_SESSION['redeem_error'] ?? '';

        unset($_SESSION['report_error']);
        unset($_SESSION['report_success']);
        unset($_SESSION['redeem_error']);
        unset($_SESSION['redeem_success']);

        $this->view("waste/index", [
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
                header('Location: ' . URL_ROOT . '/waste');
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
                    header('Location: ' . URL_ROOT . '/waste');
                    exit;
                }
            } else {
                $_SESSION['report_error'] = 'Please upload a valid image.';
                header('Location: ' . URL_ROOT . '/waste');
                exit;
            }

            // Submit the report
            if ($reportModel->submitWasteReport($data)) {
                $_SESSION['report_success'] = 'Report submitted successfully!';
                header('Location: ' . URL_ROOT . '/waste');
                exit;
            } else {
                $_SESSION['report_error'] = 'Failed to submit report. Please try again.';
                header('Location: ' . URL_ROOT . '/waste');
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
                header('Location: ' . URL_ROOT . '/waste');
                exit;
            }

            // Sanitize and prepare data (without qr_code_path for now)
            $data = [
                'user_id' => $_SESSION['user']['id'],
                'points_amount' => filter_var($_POST['points'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                'gcash_number' => htmlspecialchars(trim($_POST['gcashNumber'])),
                'gcash_name' => htmlspecialchars(trim($_POST['gcashName'])),
            ];

            $redeemModel = $this->model('RedeemModel');

            // First validate the redemption (points, user existence, etc.) without file upload
            $validationResult = $redeemModel->validateRedemptionRequest($data);

            if (!($validationResult['success'] ?? false)) {
                $_SESSION['redeem_error'] = $validationResult['message'] ?? 'Validation failed.';
                header('Location: ' . URL_ROOT . '/waste');
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
                header('Location: ' . URL_ROOT . '/waste');
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

            header('Location: ' . URL_ROOT . '/waste');
            exit;
        }
    }

    //function to get the transaction history via AJAX
    public function getHistory()
    {
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
}
