<?php

class Admin extends Controller
{

    public function __construct()
    {
        //authorize the role to admin
        $this->authorize(['admin']);

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

        //initialize and get the dashboard stats from model
        $userModel = $this->model('UserModel');
        $stats = $userModel->getDashboardStats($userData['barangay_id']);

        // Get chart data for all timeframes
        $dailyChartData = $userModel->getChartData($userData['barangay_id'], 'daily');
        $weeklyChartData = $userModel->getChartData($userData['barangay_id'], 'weekly');
        $monthlyChartData = $userModel->getChartData($userData['barangay_id'], 'month');
        $yearlyChartData = $userModel->getChartData($userData['barangay_id'], 'year');

        $this->view('admin/dashboard', [
            'user' => $userData,
            'totalUsers' => $stats['total_users'],
            'totalReports' => $stats['total_waste_reports'] + $stats['total_litterer_reports'],
            'total_verified_reports' => $stats['total_verified_waste_reports'] + $stats['total_verified_litterer_reports'],
            'total_pending_reports' => $stats['total_pending_waste_reports'] + $stats['total_pending_litterer_reports'],
            'dailyChartData' => json_encode($dailyChartData),
            'weeklyChartData' => json_encode($weeklyChartData),
            'monthlyChartData' => json_encode($monthlyChartData),
            'yearlyChartData' => json_encode($yearlyChartData)
        ]);
    }

    //function to display the reports UI
    public function reports()
    {
        $userData = $_SESSION['user'];
        $reportModel = $this->model('ReportModel');

        // Get reports with debug info
        $pendingReports = $reportModel->getAllPendingReports($userData['barangay_id']);

        $this->view('admin/reports', [
            'user' => $userData,
            'reports' => $pendingReports,
        ]);
    }

    //function to approved report
    public function approveReport($reportId)
    {
        header('Content-Type: application/json; charset=utf-8');

        $userData = $_SESSION['user'];
        $reportModel = $this->model('ReportModel');

        $reportDetails = $reportModel->getReportDetails($reportId, $userData['barangay_id']);
        if (!$reportDetails) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Report not found']);
            return;
        }

        $success = $reportModel->updateReportStatus($reportId, 'approved', $userData['barangay_id']);
        if ($success) {
            $userId = $reportModel->getUserIdFromReport($reportId, $reportDetails['report_type']);

            if ($userId) {
                if ($reportDetails['report_type'] === 'waste') {

                    //add ten points to users
                    $userModel = $this->model('ReportModel');
                    $points = 10;
                    $userModel->addPoints($userId, $points);

                    //get updated points to display in the notif message
                    $userModel = $this->model('UserModel');
                    $updatedPoints = $userModel->getUserPoints($userId);

                    $reportModel->createNotification(
                        $userId,
                        $reportId,
                        'waste',
                        'report_approved',
                        'Waste Report Approved',
                        "Your waste report has been approved! You earned 10 points. Your total points: {$updatedPoints}. Thank you for helping keep our community clean!"
                    );
                } else {

                    //add ten points to users
                    $userModel = $this->model('ReportModel');
                    $points = 10;
                    $userModel->addPoints($userId, $points);

                    //get updated points to display in the notif message
                    $userModel = $this->model('UserModel');
                    $updatedPoints = $userModel->getUserPoints($userId);

                    $reportModel->createNotification(
                        $userId,
                        $reportId,
                        'litterer',
                        'report_approved',
                        'Litterer Report Approved',
                        "Your litterer report has been approved. You earned 10 points. Your total points: {$updatedPoints}. Thank you for helping keep our community clean!"
                    );
                }
            }

            echo json_encode(['success' => true, 'message' => 'Report approved successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to approve report']);
        }
    }

    //function to reject report
    public function rejectReport($reportId)
    {
        $userData = $_SESSION['user'];
        $reportModel = $this->model('ReportModel');

        // First get report details to determine type
        $reportDetails = $reportModel->getReportDetails($reportId, $userData['barangay_id']);

        if (!$reportDetails) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Report not found']);
            exit;
        }

        // Update report status to rejected
        $success = $reportModel->updateReportStatus($reportId, 'rejected', $userData['barangay_id']);

        if ($success) {
            // Notify the user who submitted the report using your existing method
            $userId = $reportModel->getUserIdFromReport($reportId, $reportDetails['report_type']);

            if ($userId) {
                $reportModel->createNotification(
                    $userId,
                    $reportId,
                    $reportDetails['report_type'],
                    'report_rejected',
                    'Report Rejected',
                    'Your ' . $reportDetails['report_type'] . ' report was rejected. Please ensure your reports contain clear evidence and accurate information.'
                );
            }

            echo json_encode(['success' => true, 'message' => 'Report rejected successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to reject report']);
        }
    }

    //function to display the user info UI
    public function user_info()
    {

        // Pass user data to the view
        $userData = $_SESSION['user'];
        $userModel = $this->model('UserModel');
        $users = $userModel->getUsers($userData['barangay_id']);

        $this->view('admin/users', [
            'user' => $userData,
            'users' => $users
        ]);
    }

    //function to delete user
    public function deleteUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userID = $_POST['user_id'] ?? null;
            $userModel = $this->model('UserModel');

            $message = "Invalid User ID.";
            if ($userID) {
                $deleted = $userModel->deleteUser($userID);
                $message = $deleted ? "User deleted successfully." : "Failed to delete user.";
            }

            // Reload user list with message
            $userData = $_SESSION['user'];
            $users = $userModel->getUsers($userData['barangay_id']);

            $this->view('admin/users', [
                'user' => $userData,
                'users' => $users,
                'message' => $message
            ]);
        }
    }

    //function to display the announcement UI
    public function announcement()
    {
        // Pass user data to the view
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

        //instantiate to get the announcement from model
        $announcementModel = $this->model('AnnouncementModel');
        $announcement = $announcementModel->getAnnouncementAdmin($userData['barangay_id']);

        $this->view('admin/announcement', [
            'user' => $userData,
            'message' => $message,
            'messageType' => $messageType,
            'announcement' => $announcement
        ]);
    }

    //function to create announcement
    public function createAnnouncement()
    {

        $userData = $_SESSION['user'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = [
                'barangay_id' => $userData['barangay_id'],
                'title' => htmlspecialchars(trim($_POST['title'])),
                'to' => htmlspecialchars(trim($_POST['to'])),
                'date' => htmlspecialchars(trim($_POST['date'])),
                'time' => htmlspecialchars(trim($_POST['time'])),
                'location' => htmlspecialchars(trim($_POST['location'])),
                'message' => htmlspecialchars(trim($_POST['message']))
            ];

            //check if all the field are provided with value
            if (empty($data['barangay_id']) || empty($data['title']) || empty($data['to']) || empty($data['date'])  || empty($data['time']) || empty($data['location'])  || empty($data['message'])) {
                $_SESSION['failed'] = 'All fields are required';
                header('Location: ' . URL_ROOT . '/admin/announcement');
                exit;
            }

            //instantiate the model for submitting the announcement to database
            $announementModel = $this->model('AnnouncementModel');

            //send the datas to database
            if ($announementModel->createAnnouncement($data)) {
                $_SESSION['success'] = "Announcement created successfully";
            } else {
                $_SESSION['failed'] = "Failed to create announcement";
            }

            header('Location: ' . URL_ROOT . '/admin/announcement');
            exit;
        }
    }

    // function to update announcement
    public function updateAnnouncement()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = [

                'id' => htmlspecialchars(trim($_POST['id'])),
                'title' => htmlspecialchars(trim($_POST['title'])),
                'to' => htmlspecialchars(trim($_POST['to'])),
                'date' => htmlspecialchars(trim($_POST['date'])),
                'time' => htmlspecialchars(trim($_POST['time'])),
                'location' => htmlspecialchars(trim($_POST['location'])),
                'message' => htmlspecialchars(trim($_POST['message'])),
            ];

            $announcementModel = $this->model('AnnouncementModel');

            if ($announcementModel->updateAnnouncement($data)) {
                $_SESSION['success'] = "Announcement updated successfully!";
            } else {
                $_SESSION['failed'] = "Failed to update announcement!";
            }

            header("Location: " . URL_ROOT . "/admin/announcement");
            exit;
        }
    }

    // fucntion to delete announcement
    public function deleteAnnouncement($id)
    {
        $announcementModel = $this->model('AnnouncementModel');

        if ($announcementModel->deleteAnnouncement($id)) {
            $_SESSION['success'] = "Announcement deleted successfully!";
        } else {
            $_SESSION['failed'] = "Failed to delete announcement!";
        }

        header("Location: " . URL_ROOT . "/admin/announcement");
        exit;
    }


    //function to display the litterer records UI
    public function litterer()
    {
        // Pass user data to the view
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

        $littererModel = $this->model('LittererModel');
        $litterer = $littererModel->getLittererRecords($userData['barangay_id']);

        $this->view('admin/litterer', [
            'user' => $userData,
            'message' => $message,
            'messageType' => $messageType,
            'litterer' => $litterer
        ]);
    }

    //function to create litterer records
    public function createLitterer()
    {

        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            //get data from user session
            $userData = $_SESSION['user'];

            $data = [
                'barangay_id' => htmlspecialchars(trim($userData['barangay_id'])),
                'name' => htmlspecialchars(trim($_POST['name'])),
                'number' => htmlspecialchars(trim($_POST['number'])),
                'address' => htmlspecialchars(trim($_POST['address'])),
                'offense' => htmlspecialchars(trim($_POST['offense']))
            ];


            //validate inputs
            if (empty($data['name']) || empty($data['number']) || empty($data['address']) || empty($data['offense'])) {
                $_SESSION['failed'] = "All fields are required!";
                header("Location: " . URL_ROOT . '/admin/litterer');
                exit;
            }

            //i validate ang phone number
            if (!preg_match('/^09[0-9]{9}$/', $data['number'])) {
                $_SESSION['failed'] = "Invalid number format!";
                header('Location: ' . URL_ROOT . '/admin/litterer');
                exit;
            }

            $littererModel = $this->model('LittererModel');

            if ($littererModel->createLittererRecord($data)) {
                $_SESSION['success'] = "Record created successfully!";
            } else {
                $_SESSION['failed'] = "Failed to create record!";
            }

            header("Location: " . URL_ROOT . '/admin/litterer');
            exit;
        }
    }

    //function to update litterer record
    public function updateLitterer()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $data = [
                'id' => $id,
                'name' => trim($_POST['name']),
                'number' => trim($_POST['number']),
                'address' => trim($_POST['address']),
                'offense' => (int)$_POST['offense'],
            ];

            $littererModel = $this->model('LittererModel');

            if ($littererModel->updateRecord($data)) {
                $_SESSION['success'] = "Record updated successfully!";
            } else {
                $_SESSION['failed'] = "Failed to update record!";
            }

            header("Location: " . URL_ROOT . '/admin/litterer');
            exit;
        }
    }


    //function to display the redemptions UI
    public function redemptions()
    {
        // Pass user data to the view
        $userData = $_SESSION['user'];

        $reportModel = $this->model('ReportModel');
        $redemption = $reportModel->getRedemptions($userData['barangay_id']);

        $this->view('admin/redemptions', [
            'user' => $userData,
            'redemption' => $redemption
        ]);
    }

    //function to display the settings UI
    public function settings()
    {
        // Pass user data to the view
        $userData = $_SESSION['user'];

        $this->view('admin/settings', [
            'user' => $userData
        ]);
    }
}
