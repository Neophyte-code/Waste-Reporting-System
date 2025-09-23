<?php

class UserModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    // Function to register account
    public function register($data)
    {
        $stmt = $this->db->prepare("INSERT INTO users (firstname, lastname, barangay_id, email, password, profile_picture) VALUES (:firstname, :lastname, :barangay_id, :email, :password, :profile_picture)");
        $stmt->bindParam(':firstname', $data['firstname']);
        $stmt->bindParam(':lastname', $data['lastname']);
        $stmt->bindParam(':barangay_id', $data['barangay_id'], PDO::PARAM_INT);
        $stmt->bindParam(':email', $data['email']);
        $hashPassword = password_hash($data['password'], PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $hashPassword);
        $profilePicture = $data['profile_picture'] ?? null;
        $stmt->bindParam(':profile_picture', $profilePicture);
        return $stmt->execute();
    }

    // Function for user login
    public function login($email, $password)
    {
        $stmt = $this->db->prepare("SELECT u.*, b.name AS barangay_name FROM users u JOIN barangays b ON u.barangay_id = b.id WHERE LOWER(u.email) = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    // Function to check if the email is already used
    public function emailExist($email)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE LOWER(email) = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    // Function to fetch barangay ID by name
    public function getBarangayIdByName($barangay_name)
    {
        $stmt = $this->db->prepare("SELECT id FROM barangays WHERE name = :name");
        $stmt->bindParam(':name', $barangay_name);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['id'] : null;
    }

    // Function to update user profile
    public function updateProfile($data)
    {
        $query = "UPDATE users SET firstname = :firstname, lastname = :lastname, barangay_id = :barangay_id, email = :email";
        if (!empty($data['profile_picture'])) {
            $query .= ", profile_picture = :profile_picture";
        }
        $query .= " WHERE email = :old_email";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':firstname', $data['firstname']);
        $stmt->bindParam(':lastname', $data['lastname']);
        $stmt->bindParam(':barangay_id', $data['barangay_id'], PDO::PARAM_INT);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':old_email', $data['old_email']);
        if (!empty($data['profile_picture'])) {
            $stmt->bindParam(':profile_picture', $data['profile_picture']);
        }

        return $stmt->execute();
    }

    // Function to get user by email
    public function getUserByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT u.*, b.name AS barangay_name FROM users u JOIN barangays b ON u.barangay_id = b.id WHERE LOWER(u.email) = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //function to get user points
    public function getUserPoints($userID)
    {
        $stmt = $this->db->prepare("SELECT points FROM users WHERE id = :user_id");
        $stmt->bindParam(':user_id', $userID, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Corrected return statement with proper parentheses
        return ($result && isset($result['points'])) ? (float)$result['points'] : 0.00;
    }

    //function to get all users (for admin)
    public function getDashboardStats($barangay_id)
    {

        try {
            $stmt = $this->db->prepare(
                "Select
                    (select count(*) from users where barangay_id = :barangay_id and role not in ('admin', 'superadmin')) as total_users,
                    (select count(*) from waste_reports wr join users u on wr.user_id = u.id where u.barangay_id = :barangay_id) as total_waste_reports,
                    (select count(*) from litterer_reports lr join users u on lr.user_id = u.id where u.barangay_id = :barangay_id) as total_litterer_reports,
                    (select count(*) from waste_reports wr join users u on wr.user_id = u.id where u.barangay_id = :barangay_id and status = 'approved') as total_verified_waste_reports,
                    (select count(*) from litterer_reports lr join users u on lr.user_id = u.id where u.barangay_id = :barangay_id and status = 'approved') as total_verified_litterer_reports,
                    (select count(*) from waste_reports wr join users u on wr.user_id = u.id where u.barangay_id = :barangay_id and status = 'pending') as total_pending_waste_reports,
                    (select count(*) from litterer_reports lr join users u on lr.user_id = u.id where u.barangay_id = :barangay_id and status = 'pending') as total_pending_litterer_reports
                "
            );

            $stmt->bindParam(':barangay_id', $barangay_id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            return [
                'total_users' => 0,
                'total_waste_reports' => 0,
                'total_litterer_reports' => 0,
                'total_verified_waste_reports' => 0,
                'total_verified_litterer_reports' => 0,
                'total_pending_waste_reports' =>  0,
                'total_pending_litterer_reports' => 0
            ];
        }
    }

    //function to get data for chart (for admin)
    public function getChartData($barangay_id, $timeFrame = 'month')
    {
        try {
            if ($timeFrame === 'daily') {
                // Daily data - last 7 days
                $query = "
                SELECT 
                    DATE(report_date) as date,
                    DAYNAME(report_date) as day_name,
                    DAYOFWEEK(report_date) as day_order,
                    COUNT(CASE WHEN report_type = 'waste' THEN 1 END) as waste_count,
                    COUNT(CASE WHEN report_type = 'litterer' THEN 1 END) as litterer_count
                FROM (
                    SELECT 'waste' as report_type, report_date FROM waste_reports wr 
                    JOIN users u ON wr.user_id = u.id 
                    WHERE u.barangay_id = :barangay_id
                    UNION ALL
                    SELECT 'litterer' as report_type, report_date FROM litterer_reports lr 
                    JOIN users u ON lr.user_id = u.id 
                    WHERE u.barangay_id = :barangay_id
                ) combined_reports
                WHERE report_date >= DATE_SUB(NOW(), INTERVAL 7 DAY)
                GROUP BY DATE(report_date), DAYNAME(report_date), DAYOFWEEK(report_date)
                ORDER BY date
            ";
            } elseif ($timeFrame === 'weekly') {
                // Weekly data - last 8 weeks
                $query = "
                SELECT 
                    YEAR(report_date) as year,
                    WEEK(report_date) as week_number,
                    CONCAT('Week ', WEEK(report_date)) as week_label,
                    COUNT(CASE WHEN report_type = 'waste' THEN 1 END) as waste_count,
                    COUNT(CASE WHEN report_type = 'litterer' THEN 1 END) as litterer_count
                FROM (
                    SELECT 'waste' as report_type, report_date FROM waste_reports wr 
                    JOIN users u ON wr.user_id = u.id 
                    WHERE u.barangay_id = :barangay_id
                    UNION ALL
                    SELECT 'litterer' as report_type, report_date FROM litterer_reports lr 
                    JOIN users u ON lr.user_id = u.id 
                    WHERE u.barangay_id = :barangay_id
                ) combined_reports
                WHERE report_date >= DATE_SUB(NOW(), INTERVAL 8 WEEK)
                GROUP BY YEAR(report_date), WEEK(report_date)
                ORDER BY year, week_number
            ";
            } elseif ($timeFrame === 'month') {
                // Monthly data - last 12 months
                $query = "
                SELECT 
                    YEAR(report_date) as year,
                    MONTH(report_date) as month,
                    COUNT(CASE WHEN report_type = 'waste' THEN 1 END) as waste_count,
                    COUNT(CASE WHEN report_type = 'litterer' THEN 1 END) as litterer_count
                FROM (
                    SELECT 'waste' as report_type, report_date FROM waste_reports wr 
                    JOIN users u ON wr.user_id = u.id 
                    WHERE u.barangay_id = :barangay_id
                    UNION ALL
                    SELECT 'litterer' as report_type, report_date FROM litterer_reports lr 
                    JOIN users u ON lr.user_id = u.id 
                    WHERE u.barangay_id = :barangay_id
                ) combined_reports
                WHERE report_date >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
                GROUP BY YEAR(report_date), MONTH(report_date)
                ORDER BY year, month
            ";
            } else {
                // Yearly data - last 5 years
                $query = "
                SELECT 
                    YEAR(report_date) as year,
                    COUNT(CASE WHEN report_type = 'waste' THEN 1 END) as waste_count,
                    COUNT(CASE WHEN report_type = 'litterer' THEN 1 END) as litterer_count
                FROM (
                    SELECT 'waste' as report_type, report_date FROM waste_reports wr 
                    JOIN users u ON wr.user_id = u.id 
                    WHERE u.barangay_id = :barangay_id
                    UNION ALL
                    SELECT 'litterer' as report_type, report_date FROM litterer_reports lr 
                    JOIN users u ON lr.user_id = u.id 
                    WHERE u.barangay_id = :barangay_id
                ) combined_reports
                WHERE report_date >= DATE_SUB(NOW(), INTERVAL 5 YEAR)
                GROUP BY YEAR(report_date)
                ORDER BY year
            ";
            }

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':barangay_id', $barangay_id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            return [];
        }
    }

    //function to get all the users in each barangay (for admin)
    public function getUsers($barangay_id)
    {
        try {

            $stmt = $this->db->prepare("select id, firstname, lastname, email from users where barangay_id = :barangay_id and role not in ('admin', 'superadmin')");
            $stmt->bindParam(':barangay_id', $barangay_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return;
        }
    }

    //funciton to delete users(for admin)
    public function deleteUser($userID)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
            $stmt->bindParam(':id', $userID, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }


    //Get comprehensive summary data with date filtering (for admin)
    public function getSummaryData($barangay_id, $year = null, $month = null, $day = null)
    {
        return [
            'users' => $this->getUserStats($barangay_id, $year, $month, $day),
            'announcements' => $this->getAnnouncementStats($barangay_id, $year, $month, $day),
            'waste_reports' => $this->getWasteReportStats($barangay_id, $year, $month, $day),
            'litterer_reports' => $this->getLittererReportStats($barangay_id, $year, $month, $day),
            'litterers' => $this->getLittererStats($barangay_id, $year, $month, $day),
            'redemptions' => $this->getRedemptionStats($barangay_id, $year, $month, $day),
            'barangay_info' => $this->getBarangayInfo($barangay_id),
            'period_summary' => $this->getPeriodSummary($barangay_id, $year, $month, $day)
        ];
    }


    //Build date condition for specific date column (for admin)
    private function buildDateCondition($dateColumn, $year, $month, $day)
    {
        $conditions = [];

        if ($year && !empty($year)) {
            $conditions[] = "YEAR($dateColumn) = :year";
        }
        if ($month && !empty($month)) {
            $conditions[] = "MONTH($dateColumn) = :month";
        }
        if ($day && !empty($day)) {
            $conditions[] = "DAY($dateColumn) = :day";
        }

        return empty($conditions) ? '' : 'AND (' . implode(' AND ', $conditions) . ')';
    }

    //Bind date parameters to statement (for admin)
    private function bindDateParams($stmt, $year, $month, $day)
    {
        if ($year && !empty($year)) {
            $stmt->bindParam(':year', $year);
        }
        if ($month && !empty($month)) {
            $stmt->bindParam(':month', $month);
        }
        if ($day && !empty($day)) {
            $stmt->bindParam(':day', $day);
        }
    }

    //Get user statistics (for admin)
    private function getUserStats($barangay_id, $year, $month, $day)
    {
        $dateCondition = $this->buildDateCondition('created_at', $year, $month, $day);

        $sql = "SELECT 
                    COUNT(*) as total_users,
                    COALESCE(SUM(points), 0) as total_points,
                    COALESCE(AVG(points), 0) as avg_points_per_user,
                    COUNT(CASE WHEN role = 'admin' THEN 1 END) as admin_count,
                    COUNT(CASE WHEN profile_picture IS NOT NULL THEN 1 END) as users_with_profile
                FROM users 
                WHERE barangay_id = :barangay_id $dateCondition";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':barangay_id', $barangay_id);
        $this->bindDateParams($stmt, $year, $month, $day);

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //Get announcement statistics (for admin)
    private function getAnnouncementStats($barangay_id, $year, $month, $day)
    {
        $dateCondition = $this->buildDateCondition('created_at', $year, $month, $day);

        $sql = "SELECT 
                    COUNT(*) as total_announcements,
                    COUNT(CASE WHEN date >= CURDATE() THEN 1 END) as upcoming_events,
                    COUNT(CASE WHEN date < CURDATE() THEN 1 END) as past_events,
                    COUNT(DISTINCT what) as unique_event_types
                FROM announcements 
                WHERE barangay_id = :barangay_id $dateCondition";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':barangay_id', $barangay_id);
        $this->bindDateParams($stmt, $year, $month, $day);

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //Get waste report statistics (for admin)
    private function getWasteReportStats($barangay_id, $year, $month, $day)
    {
        $dateCondition = $this->buildDateCondition('wr.report_date', $year, $month, $day);

        $sql = "SELECT 
                    COUNT(*) as total_waste_reports,
                    COUNT(CASE WHEN wr.status = 'pending' THEN 1 END) as pending_reports,
                    COUNT(CASE WHEN wr.status = 'approved' THEN 1 END) as approved_reports,
                    COUNT(CASE WHEN wr.status = 'rejected' THEN 1 END) as rejected_reports,
                    COUNT(DISTINCT wr.user_id) as unique_reporters
                FROM waste_reports wr
                JOIN users u ON wr.user_id = u.id
                WHERE u.barangay_id = :barangay_id $dateCondition";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':barangay_id', $barangay_id);
        $this->bindDateParams($stmt, $year, $month, $day);

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //Get litterer report statistics (for admin)
    private function getLittererReportStats($barangay_id, $year, $month, $day)
    {
        $dateCondition = $this->buildDateCondition('lr.report_date', $year, $month, $day);

        $sql = "SELECT 
                    COUNT(*) as total_litterer_reports,
                    COUNT(CASE WHEN lr.status = 'pending' THEN 1 END) as pending_reports,
                    COUNT(CASE WHEN lr.status = 'approved' THEN 1 END) as approved_reports,
                    COUNT(CASE WHEN lr.status = 'rejected' THEN 1 END) as rejected_reports,
                    COUNT(CASE WHEN lr.gender = 'male' THEN 1 END) as male_offenders,
                    COUNT(CASE WHEN lr.gender = 'female' THEN 1 END) as female_offenders,
                    COALESCE(AVG(lr.age), 0) as avg_offender_age
                FROM litterer_reports lr
                JOIN users u ON lr.user_id = u.id
                WHERE u.barangay_id = :barangay_id $dateCondition";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':barangay_id', $barangay_id);
        $this->bindDateParams($stmt, $year, $month, $day);

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //Get registered litterer statistics (for admin)
    private function getLittererStats($barangay_id, $year, $month, $day)
    {
        $dateCondition = $this->buildDateCondition('created_at', $year, $month, $day);

        $sql = "SELECT 
                    COUNT(*) as total_registered_litterers,
                    COALESCE(AVG(offense), 0) as avg_offense_count,
                    COALESCE(MAX(offense), 0) as max_offense_count,
                    COUNT(CASE WHEN offense >= 3 THEN 1 END) as repeat_offenders
                FROM litterers 
                WHERE barangay_id = :barangay_id $dateCondition";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':barangay_id', $barangay_id);
        $this->bindDateParams($stmt, $year, $month, $day);

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //Get redemption statistics (for admin)
    private function getRedemptionStats($barangay_id, $year, $month, $day)
    {
        $dateCondition = $this->buildDateCondition('rr.request_date', $year, $month, $day);

        $sql = "SELECT 
                    COUNT(*) as total_redemption_requests,
                    COALESCE(SUM(rr.points_amount), 0) as total_points_redeemed,
                    COALESCE(AVG(rr.points_amount), 0) as avg_redemption_amount,
                    COUNT(CASE WHEN rr.status = 'pending' THEN 1 END) as pending_redemptions,
                    COUNT(CASE WHEN rr.status = 'approved' THEN 1 END) as approved_redemptions,
                    COUNT(CASE WHEN rr.status = 'rejected' THEN 1 END) as rejected_redemptions
                FROM redemption_requests rr
                JOIN users u ON rr.user_id = u.id
                WHERE u.barangay_id = :barangay_id $dateCondition";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':barangay_id', $barangay_id);
        $this->bindDateParams($stmt, $year, $month, $day);

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //Get barangay information (for admin)
    private function getBarangayInfo($barangay_id)
    {
        $sql = "SELECT name FROM barangays WHERE id = :barangay_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':barangay_id', $barangay_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //Get period summary with key insights (for admin)
    private function getPeriodSummary($barangay_id, $year, $month, $day)
    {
        // Build individual date conditions for each table
        $wasteCondition = $this->buildDateCondition('wr.report_date', $year, $month, $day);
        $littererCondition = $this->buildDateCondition('lr.report_date', $year, $month, $day);
        $redemptionCondition = $this->buildDateCondition('rr.request_date', $year, $month, $day);
        $userCondition = $this->buildDateCondition('u.created_at', $year, $month, $day);

        // Execute separate queries to avoid complex subqueries
        $result = [];

        // Get waste reports count
        $sql = "SELECT COUNT(*) as count FROM waste_reports wr 
                JOIN users u ON wr.user_id = u.id 
                WHERE u.barangay_id = :barangay_id $wasteCondition";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':barangay_id', $barangay_id);
        $this->bindDateParams($stmt, $year, $month, $day);
        $stmt->execute();
        $result['waste_reports'] = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

        // Get litterer reports count
        $sql = "SELECT COUNT(*) as count FROM litterer_reports lr 
                JOIN users u ON lr.user_id = u.id 
                WHERE u.barangay_id = :barangay_id $littererCondition";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':barangay_id', $barangay_id);
        $this->bindDateParams($stmt, $year, $month, $day);
        $stmt->execute();
        $result['litterer_reports'] = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

        // Get users count
        $sql = "SELECT COUNT(*) as count FROM users u WHERE u.barangay_id = :barangay_id $userCondition";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':barangay_id', $barangay_id);
        $this->bindDateParams($stmt, $year, $month, $day);
        $stmt->execute();
        $result['active_users'] = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

        // Get points distributed
        $sql = "SELECT COALESCE(SUM(rr.points_amount), 0) as total FROM redemption_requests rr 
                JOIN users u ON rr.user_id = u.id 
                WHERE u.barangay_id = :barangay_id AND rr.status = 'approved' $redemptionCondition";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':barangay_id', $barangay_id);
        $this->bindDateParams($stmt, $year, $month, $day);
        $stmt->execute();
        $result['points_distributed'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Calculate total activity
        $result['total_activity'] = $result['waste_reports'] + $result['litterer_reports'];

        return $result;
    }

    //Get recent activities for the summary (for admin)
    public function getRecentActivities($barangay_id, $limit = 10)
    {
        $sql = "
            (SELECT 'Waste Report' as type, wr.report_date as date, u.firstname, u.lastname
             FROM waste_reports wr 
             JOIN users u ON wr.user_id = u.id 
             WHERE u.barangay_id = :barangay_id 
             ORDER BY wr.report_date DESC LIMIT :limit)
            
            UNION ALL
            
            (SELECT 'Litterer Report' as type, lr.report_date as date, u.firstname, u.lastname
             FROM litterer_reports lr 
             JOIN users u ON lr.user_id = u.id 
             WHERE u.barangay_id = :barangay_id 
             ORDER BY lr.report_date DESC LIMIT :limit)
            
            ORDER BY date DESC LIMIT :limit
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':barangay_id', $barangay_id);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //function to create admin (for superadmin)
    public function createAdmin($data)
    {
        try {
            $stmt = $this->db->prepare("
                insert into users (firstname, lastname, barangay_id, email, password, role)
                values (:firstname, :lastname, :barangay, :email, :password, 'admin')
            ");

            // Hash password before saving
            $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);

            // Bind values
            $stmt->bindParam(':firstname', $data['firstname']);
            $stmt->bindParam(':lastname', $data['lastname']);
            $stmt->bindParam(':barangay', $data['barangay']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':password', $hashedPassword);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    //function to retrieve admin from db (for superadmin)
    public function getAdmin()
    {

        try {
            $stmt = $this->db->prepare("
            select u.id, u.firstname, u.lastname, b.name, u.email from users u join barangays b on  b.id = u.barangay_id where role = 'admin'
            ");

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    // function to edit admin account (for superadmin)
    public function updateAdmin($data)
    {
        try {
            $stmt = $this->db->prepare("
            update users 
            SET firstname = :firstname,
                lastname = :lastname,
                email = :email,
                barangay_id = :barangay,
                password = :password
            WHERE id = :id AND role = 'admin'
        ");

            $stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);
            $stmt->bindParam(':firstname', $data['firstname']);
            $stmt->bindParam(':lastname', $data['lastname']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':barangay', $data['barangay'], PDO::PARAM_INT);

            // hash the new password
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            $stmt->bindParam(':password', $hashedPassword);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    //funtion to delete delete admin account (for superadmin)
    public function deleteAdmin($id)
    {
        try {
            $stmt = $this->db->prepare("delete FROM users WHERE id = :id AND role = 'admin'");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    //function to retrieve users from db (for superadmin)
    public function getUser()
    {
        try {

            $stmt = $this->db->prepare("
            select u.id, u.firstname, u.lastname, u.email, u.points, b.name from users u join barangays b on u.barangay_id = b.id where role = 'user' 
            ");
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }
}
