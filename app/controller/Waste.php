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

        $this->view("waste/index", [
            'user' => $userData
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
                http_response_code(400); // Set appropriate HTTP status code
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
}
