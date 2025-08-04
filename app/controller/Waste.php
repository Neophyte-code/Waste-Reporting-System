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
        //check if user is logged in, redirect to auth if not
        if (!isset($_SESSION['user'])) {
            header('Location: ' . URL_ROOT . '/auth');
            exit;
        }
    }

    public function index()
    {
        //pass the user data to the view
        $userData = $_SESSION['user'];

        $success = $_SESSION['report_success'] ?? '';
        $error = $_SESSION['report_error'] ?? '';

        unset($_SESSION['report_error']);
        unset($_SESSION['report_success']);

        $this->view("waste/index", [
            'user' => $userData,
            'success' => $success,
            'error' => $error
        ]);
    }

    //funtion to validate the image using AI
    public function process()
    {
        //load the api key - FIXED: Point to root directory where .env file is located
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

    //function for reporting waste
    public function submitWasteReport()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $_SESSION['user'];

            $data = [
                'user_id' => htmlspecialchars(trim($user['id'])),
                'image' => null,
                'wasteType' => htmlspecialchars(trim($_POST['wasteType'])),
                'estimatedWeight' => htmlspecialchars(trim($_POST['estimatedWeight'])),
                'latitude' => filter_var($_POST['latitude'] ?? '', FILTER_VALIDATE_FLOAT),
                'longitude' => filter_var($_POST['longitude'] ?? '', FILTER_VALIDATE_FLOAT)
            ];

            // FIRST: Check if image was uploaded
            if (!isset($_FILES['wasteImage']) || $_FILES['wasteImage']['error'] !== UPLOAD_ERR_OK) {
                $_SESSION['report_error'] = 'Please upload an image.';
                header('Location: ' . URL_ROOT . '/waste');
                exit;
            }

            // SECOND: Validate text fields
            if (empty($data['wasteType']) || empty($data['estimatedWeight']) || $data['latitude'] === false || $data['longitude'] === false) {
                $_SESSION['report_error'] = 'All fields are required.';
                header('Location: ' . URL_ROOT . '/waste');
                exit;
            }

            // THIRD: Handle file upload
            $uploadDir = __DIR__ . '/../../public/images/reportWaste/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Validate file type and size
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $maxSize = 5 * 1024 * 1024;
            $fileType = $_FILES['wasteImage']['type'];
            $fileSize = $_FILES['wasteImage']['size'];

            if (!in_array($fileType, $allowedTypes)) {
                $_SESSION['report_error'] = 'Invalid file type. Only JPEG, PNG, and GIF are allowed.';
                header('Location: ' . URL_ROOT . '/waste');
                exit;
            }

            if ($fileSize > $maxSize) {
                $_SESSION['report_error'] = 'File size too large. Maximum 5MB allowed.';
                header('Location: ' . URL_ROOT . '/waste');
                exit;
            }

            // Generate unique filename and upload
            $fileName = uniqid() . '-' . basename($_FILES['wasteImage']['name']);
            $uploadPath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['wasteImage']['tmp_name'], $uploadPath)) {
                $data['image'] = 'images/reportWaste/' . $fileName;
            } else {
                $_SESSION['report_error'] = 'Failed to upload file. Please try again later.';
                header('Location: ' . URL_ROOT . '/waste');
                exit;
            }

            // FOURTH: Submit to database
            $wasteReportModel = $this->model('ReportModel');

            if ($wasteReportModel->submitWasteReport($data)) {
                $_SESSION['report_success'] = 'Your report has been submitted successfully!';
            } else {
                $_SESSION['report_error'] = 'Failed to submit your report. Please try again.';
            }

            header('Location: ' . URL_ROOT . '/waste');
            exit;
        }
    }
}
