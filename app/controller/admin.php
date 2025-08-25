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

    //function to display the user info UI
    public function user_info()
    {

        // Pass user data to the view
        $userData = $_SESSION['user'];

        $this->view('admin/users', [
            'user' => $userData
        ]);
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
