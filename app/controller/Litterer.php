<?php

class Litterer extends Controller
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

        $success = $_SESSION['report_success'] ?? null;
        $error   = $_SESSION['report_error'] ?? null;

        unset($_SESSION['report_error'], $_SESSION['report_success']);


        //use to display points to the UI
        $userModel = $this->model('User');
        $userPoints = $userModel->getUserPoints($userData['id']);
        // Ensure points is a numeric value before formatting
        $userData['points'] = is_numeric($userPoints) ? number_format((float)$userPoints) : '0.00';

        $this->view("litterer/index", [
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
                header('Location: ' . URL_ROOT . '/litterer');
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
                    header('Location: ' . URL_ROOT . '/Litterer');
                    exit;
                }

                // Validate file type
                $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime = finfo_file($fileInfo, $file['tmp_name']);
                finfo_close($fileInfo);

                if (!in_array($mime, $allowedTypes)) {
                    $_SESSION['report_error'] = 'Only JPG, JPEG, and PNG files are allowed';
                    header('Location: ' . URL_ROOT . '/Litterer');
                    exit;
                }

                // Validate file size (10MB max)
                if ($file['size'] > 10 * 1024 * 1024) {
                    $_SESSION['report_error'] = 'File size exceeds 10MB limit';
                    header('Location: ' . URL_ROOT . '/Litterer');
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
                    header('Location: ' . URL_ROOT . '/Litterer');
                    exit;
                }
            } else {
                $_SESSION['report_error'] = 'No image file was submitted';
                header('Location: ' . URL_ROOT . '/Litterer');
                exit;
            }

            // Submit the report
            if ($reportModel->submitLittererReport($data)) {
                $_SESSION['report_success'] = 'Report submitted successfully';
                header('Location: ' . URL_ROOT . '/Litterer');
                exit;
            } else {
                $_SESSION['report_error'] = 'Failed to submit report. Please try again.';
                header('Location: ' . URL_ROOT . '/Litterer');
                exit;
            }
        }
    }
}
