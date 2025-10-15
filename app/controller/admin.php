<?php

require_once __DIR__ . '/../../vendor/autoload.php';

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
        $summary = $userModel->getDashboardSummary($userData['barangay_id']);

        // Get chart data for all timeframes
        $dailyChartData = $userModel->getChartData($userData['barangay_id'], 'daily');
        $weeklyChartData = $userModel->getChartData($userData['barangay_id'], 'weekly');
        $monthlyChartData = $userModel->getChartData($userData['barangay_id'], 'month');
        $yearlyChartData = $userModel->getChartData($userData['barangay_id'], 'year');

        $this->view('admin/dashboard', [
            'user' => $userData,
            'totalUsers' => $summary['totalUsers'],
            'totalReports' => $summary['totalReports'],
            'total_verified_reports' => $summary['total_verified_reports'],
            'total_pending_reports' => $summary['total_pending_reports'],
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

    //function to approve user (status)
    public function approveUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
            $userId = (int)$_POST['user_id'];
            $userModel = $this->model('UserModel');

            header('Content-Type: application/json');

            if ($userModel->approveUserById($userId)) {
                echo json_encode([
                    'success' => true,
                    'message' => 'User approved successfully!'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to approve user.'
                ]);
            }
            exit;
        }

        // If accessed directly (not POST)
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Invalid request.']);
        exit;
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

            //send the datas to model
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

        $this->view('admin/redemptions', [
            'user' => $userData,
            'redemption' => $redemption,
            'message' => $message,
            'messageType' => $messageType,
        ]);
    }

    // function to approve redemption request
    public function approveRedemption()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];

            $data = [
                'id' => (int)$id,
            ];

            $redemptionModel = $this->model('ReportModel');

            if ($redemptionModel->approveRequest($data)) {
                $_SESSION['success'] = "Redemption approved successfully!";
            } else {
                $_SESSION['failed'] = "Failed to approve redemption!";
            }

            header("Location: " . URL_ROOT . '/admin/redemptions');
            exit;
        }
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

    //function for downloading summary report
    public function downloadSummaryReport()
    {
        $userData = $_SESSION['user'];
        $barangay_id = $userData['barangay_id'];

        // Get filters from URL parameters
        $year = $_GET['year'] ?? null;
        $month = $_GET['month'] ?? null;
        $day = $_GET['day'] ?? null;

        // Convert empty strings to null
        $year = !empty($year) ? $year : null;
        $month = !empty($month) ? $month : null;
        $day = !empty($day) ? $day : null;

        // Get comprehensive data from model
        $summaryModel = $this->model('UserModel');
        $data = $summaryModel->getSummaryData($barangay_id, $year, $month, $day);
        $recentActivities = $summaryModel->getRecentActivities($barangay_id, 10);


        // Load FPDF
        $pdf = new FPDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetMargins(15, 15, 15);
        $pdf->SetAutoPageBreak(true, 25);

        // ===== HEADER SECTION =====
        $pdf->SetFillColor(34, 139, 34); // Forest Green
        $pdf->Rect(0, 0, 210, 55, 'F');

        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 22);
        $pdf->SetXY(15, 15);
        $pdf->Cell(180, 12, 'BARANGAY WASTE MANAGEMENT REPORT', 0, 1, 'C');

        $pdf->SetFont('Arial', '', 16);
        $pdf->SetX(15);
        $pdf->Cell(180, 10, strtoupper($data['barangay_info']['name']) . ' SUMMARY', 0, 1, 'C');

        // Reset position and color
        $pdf->SetXY(15, 65);
        $pdf->SetTextColor(0, 0, 0);

        // ===== REPORT PERIOD INFO =====
        $this->addReportPeriodSection($pdf, $year, $month, $day);

        // ===== OVERVIEW CARDS SECTION =====
        $this->addOverviewCards($pdf, $data);

        // ===== USER STATISTICS =====
        $this->addUserStatistics($pdf, $data['users']);

        // ===== WASTE MANAGEMENT SECTION =====
        $this->addWasteManagementSection($pdf, $data['waste_reports'], $data['litterer_reports'], $data['litterers']);

        // ===== COMMUNITY ENGAGEMENT =====
        $this->addCommunityEngagementSection($pdf, $data['announcements'], $data['redemptions']);

        // ===== RECENT ACTIVITIES =====
        if (!empty($recentActivities)) {
            $this->addRecentActivitiesSection($pdf, $recentActivities);
        }

        // ===== SUMMARY & INSIGHTS =====
        $this->addSummaryInsights($pdf, $data);

        // ===== OUTPUT =====
        $filename = 'Barangay_' . $data['barangay_info']['name'] . '_Summary_' . date('Y-m-d') . '.pdf';
        $pdf->Output('I', $filename);
        exit;
    }

    // Helper method for report period section
    private function addReportPeriodSection($pdf, $year, $month, $day)
    {
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->SetTextColor(46, 125, 50);
        $pdf->Cell(0, 10, 'REPORT PERIOD & INFORMATION', 0, 1, 'L');

        // Info box
        $pdf->SetFillColor(245, 245, 245);
        $pdf->Rect(15, $pdf->GetY(), 180, 25, 'F');

        $pdf->SetFont('Arial', '', 11);
        $pdf->SetTextColor(0, 0, 0);
        $currentY = $pdf->GetY() + 5;

        // Format period
        $period = 'All Time';
        if ($day && $month && $year) {
            $period = date('F j, Y', mktime(0, 0, 0, $month, $day, $year));
        } elseif ($month && $year) {
            $period = date('F Y', mktime(0, 0, 0, $month, 1, $year));
        } elseif ($year) {
            $period = $year;
        }

        $pdf->SetXY(25, $currentY);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(40, 6, 'Report Period:', 0, 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(60, 6, $period, 0, 0);

        $pdf->SetXY(120, $currentY);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(30, 6, 'Generated:', 0, 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(40, 6, date('M j, Y g:i A'), 0, 1);

        $pdf->Ln(15);
    }

    // Helper method for overview cards
    private function addOverviewCards($pdf, $data)
    {
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->SetTextColor(46, 125, 50);
        $pdf->Cell(0, 10, 'OVERVIEW', 0, 1, 'L');

        $currentY = $pdf->GetY();
        $cardWidth = 42;
        $cardHeight = 35;

        // Card 1: Total Users
        $this->createOverviewCard(
            $pdf,
            15,
            $currentY,
            $cardWidth,
            $cardHeight,
            'TOTAL USERS',
            $data['users']['total_users'] ?: '0',
            [52, 152, 219]
        );

        // Card 2: Waste Reports
        $this->createOverviewCard(
            $pdf,
            60,
            $currentY,
            $cardWidth,
            $cardHeight,
            'WASTE REPORTS',
            $data['waste_reports']['total_waste_reports'] ?: '0',
            [46, 204, 113]
        );

        // Card 3: Litterer Reports
        $this->createOverviewCard(
            $pdf,
            105,
            $currentY,
            $cardWidth,
            $cardHeight,
            'LITTERER REPORTS',
            $data['litterer_reports']['total_litterer_reports'] ?: '0',
            [231, 76, 60]
        );

        //Card 4: Verified Reports (Approved + Rejected)
        $totalVerifiedReports =
            ($data['waste_reports']['approved_reports'] ?: 0) +
            ($data['waste_reports']['rejected_reports'] ?: 0) +
            ($data['litterer_reports']['approved_reports'] ?: 0) +
            ($data['litterer_reports']['rejected_reports'] ?: 0);

        $this->createOverviewCard(
            $pdf,
            150,
            $currentY,
            $cardWidth,
            $cardHeight,
            'VERIFIED REPORTS',
            number_format($totalVerifiedReports),
            [155, 89, 182]
        );

        $pdf->SetY($currentY + $cardHeight + 10);
    }

    // Helper method to create overview cards
    private function createOverviewCard($pdf, $x, $y, $width, $height, $title, $value, $color)
    {
        $pdf->SetFillColor($color[0], $color[1], $color[2]);
        $pdf->Rect($x, $y, $width, $height, 'F');

        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetXY($x, $y + 5);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell($width, 6, $title, 0, 1, 'C');

        $pdf->SetX($x);
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell($width, 15, $value, 0, 1, 'C');

        $pdf->SetTextColor(0, 0, 0);
    }

    // Helper method for user statistics
    private function addUserStatistics($pdf, $users)
    {
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->SetTextColor(46, 125, 50);
        $pdf->Cell(0, 10, 'USER STATISTICS', 0, 1, 'L');

        $this->createDataTable($pdf, [
            'Total Registered Users' => number_format($users['total_users'] ?: 0),
            'Average Points Per User' => number_format($users['avg_points_per_user'] ?: 0, 1),
            'Admin Users' => number_format($users['admin_count'] ?: 0),
            'Users with Profile Picture' => number_format($users['users_with_profile'] ?: 0)
        ]);

        $pdf->Ln(5);
    }

    // Helper method for waste management section
    private function addWasteManagementSection($pdf, $waste, $litterer_reports, $litterers)
    {
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->SetTextColor(46, 125, 50);
        $pdf->Cell(0, 10, 'WASTE MANAGEMENT STATISTICS', 0, 1, 'L');

        // Waste Reports Table
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetTextColor(52, 73, 94);
        $pdf->Cell(0, 8, 'Waste Reports', 0, 1, 'L');

        $this->createDataTable($pdf, [
            'Total Waste Reports' => number_format($waste['total_waste_reports'] ?: 0),
            'Pending Reports' => number_format($waste['pending_reports'] ?: 0),
            'Approved Reports' => number_format($waste['approved_reports'] ?: 0),
            'Rejected Reports' => number_format($waste['rejected_reports'] ?: 0),
            'Unique Reporters' => number_format($waste['unique_reporters'] ?: 0)
        ]);

        $pdf->Ln(3);

        // Litterer Reports Table
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetTextColor(52, 73, 94);
        $pdf->Cell(0, 8, 'Litterer Reports & Offenders', 0, 1, 'L');

        $this->createDataTable($pdf, [
            'Total Litterer Reports' => number_format($litterer_reports['total_litterer_reports'] ?: 0),
            'Pending Reports' => number_format($litterer_reports['pending_reports'] ?: 0),
            'Approved Reports' => number_format($litterer_reports['approved_reports'] ?: 0),
            'Registered Offenders' => number_format($litterers['total_registered_litterers'] ?: 0),
            'Repeat Offenders (3+)' => number_format($litterers['repeat_offenders'] ?: 0),
            'Average Offender Age' => number_format($litterer_reports['avg_offender_age'] ?: 0, 1) . ' years'
        ]);

        $pdf->Ln(5);
    }

    // Helper method for community engagement
    private function addCommunityEngagementSection($pdf, $announcements, $redemptions)
    {
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->SetTextColor(46, 125, 50);
        $pdf->Cell(0, 10, 'COMMUNITY ENGAGEMENT', 0, 1, 'L');

        $this->createDataTable($pdf, [
            'Total Announcements' => number_format($announcements['total_announcements'] ?: 0),
            'Upcoming Events' => number_format($announcements['upcoming_events'] ?: 0),
            'Total Redemption Requests' => number_format($redemptions['total_redemption_requests'] ?: 0),
            'Points Redeemed' => number_format($redemptions['total_points_redeemed'] ?: 0),
            'Average Redemption Amount' => number_format($redemptions['avg_redemption_amount'] ?: 0, 1),
            'Approved Redemptions' => number_format($redemptions['approved_redemptions'] ?: 0)
        ]);

        $pdf->Ln(5);
    }

    // Helper method for recent activities
    private function addRecentActivitiesSection($pdf, $activities)
    {
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->SetTextColor(46, 125, 50);
        $pdf->Cell(0, 10, 'RECENT ACTIVITIES', 0, 1, 'L');

        // Table header
        $pdf->SetFillColor(46, 125, 50);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(50, 8, 'TYPE', 1, 0, 'C', true);
        $pdf->Cell(70, 8, 'USER', 1, 0, 'C', true);
        $pdf->Cell(60, 8, 'DATE', 1, 1, 'C', true);

        // Table body
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetTextColor(0, 0, 0);
        $fill = false;

        foreach (array_slice($activities, 0, 8) as $activity) {
            $pdf->SetFillColor($fill ? 245 : 255, $fill ? 245 : 255, $fill ? 245 : 255);
            $pdf->Cell(50, 7, $activity['type'], 1, 0, 'L', true);
            $pdf->Cell(70, 7, $activity['firstname'] . ' ' . $activity['lastname'], 1, 0, 'L', true);
            $pdf->Cell(60, 7, date('M j, Y g:i A', strtotime($activity['date'])), 1, 1, 'C', true);
            $fill = !$fill;
        }

        $pdf->Ln(5);
    }

    // Helper method to create data tables
    private function createDataTable($pdf, $data)
    {
        // Table header
        $pdf->SetFillColor(52, 152, 219);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(120, 10, 'METRIC', 1, 0, 'C', true);
        $pdf->Cell(60, 10, 'VALUE', 1, 1, 'C', true);

        // Table body
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0, 0, 0);
        $fill = false;

        foreach ($data as $key => $value) {
            $pdf->SetFillColor($fill ? 248 : 255, $fill ? 249 : 255, $fill ? 250 : 255);
            $pdf->Cell(120, 8, $key, 1, 0, 'L', true);
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetTextColor(46, 125, 50);
            $pdf->Cell(60, 8, $value, 1, 1, 'C', true);
            $pdf->SetFont('Arial', '', 10);
            $pdf->SetTextColor(0, 0, 0);
            $fill = !$fill;
        }
    }

    // Helper method for summary insights
    private function addSummaryInsights($pdf, $data)
    {
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->SetTextColor(46, 125, 50);
        $pdf->Cell(0, 10, 'SUMMARY & INSIGHTS', 0, 1, 'L');

        // Summary box
        $pdf->SetFillColor(240, 248, 255);
        $pdf->SetDrawColor(52, 152, 219);
        $pdf->Rect(15, $pdf->GetY(), 180, 40, 'FD');

        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(52, 73, 94);
        $pdf->Ln(5);

        // Calculate key insights
        $totalReports = ($data['waste_reports']['total_waste_reports'] ?: 0) + ($data['litterer_reports']['total_litterer_reports'] ?: 0);
        $approvalRate = $totalReports > 0 ?
            round((($data['waste_reports']['approved_reports'] ?: 0) + ($data['litterer_reports']['approved_reports'] ?: 0)) / $totalReports * 100, 1) : 0;
        $engagementScore = ($data['users']['total_users'] ?: 1) > 0 ?
            round($totalReports / ($data['users']['total_users'] ?: 1), 2) : 0;

        $insights = [
            "Total community reports: " . number_format($totalReports) . " reports submitted",
            "Report approval rate: " . $approvalRate . "% of reports were approved",
            "Community engagement: " . $engagementScore . " reports per registered user",
            "Points system impact: " . number_format($data['redemptions']['total_points_redeemed'] ?: 0) . " points redeemed by residents"
        ];

        foreach ($insights as $insight) {
            $pdf->Cell(0, 6, $insight, 0, 1, 'L');
        }

        $pdf->Ln(5);

        // ===== FOOTER =====
        $pdf->SetY(-25);

        // Footer line
        $pdf->SetDrawColor(46, 125, 50);
        $pdf->Line(15, $pdf->GetY() - 5, 195, $pdf->GetY() - 5);

        $pdf->SetFont('Arial', 'I', 9);
        $pdf->SetTextColor(107, 114, 128);

        // Left side of footer
        $pdf->Cell(90, 8, 'Generated by Barangay Waste Management System', 0, 0, 'L');

        // Right side of footer
        $pdf->Cell(90, 8, 'Page ' . $pdf->PageNo() . ' of {nb}', 0, 0, 'R');
    }
}
