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

        $this->view('admin/announcement', [
            'user' => $userData
        ]);
    }

    //function to display the litterer records UI
    public function litterer()
    {
        // Pass user data to the view
        $userData = $_SESSION['user'];

        $this->view('admin/litterer', [
            'user' => $userData
        ]);
    }

    //function to display the redemptions UI
    public function redemptions()
    {
        // Pass user data to the view
        $userData = $_SESSION['user'];

        $this->view('admin/redemptions', [
            'user' => $userData
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
