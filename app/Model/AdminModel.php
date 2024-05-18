<?php

namespace PBW\login\system\Model;

class AdminModel {
    private $con;

    public function __construct() {
        define('DB_SERVER','localhost');
        define('DB_USER','root');
        define('DB_PASS' ,'');
        define('DB_NAME', 'loginsystem');
        $this->con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);

        // Check connection
        if (!$this->con) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    public function execute($query){
        return $this->con->query($query);
    }

    public function checkAdminLogin($adminusername, $password) {
        $pass = md5($password);
        $ret = mysqli_query($this->con, "SELECT * FROM admin WHERE username='$adminusername' and password='$pass'");
        $num = mysqli_fetch_array($ret);
        return $num;
    }

    public function getTotalUsers() {
        $query = mysqli_query($this->con, "SELECT id FROM users");
        $totalUsers = mysqli_num_rows($query);
        return $totalUsers;
    }

    public function getUsersRegisteredYesterday() {
        $query = mysqli_query($this->con, "SELECT id FROM users WHERE DATE(posting_date) = CURRENT_DATE() - INTERVAL 1 DAY");
        $yesterdayRegUsers = mysqli_num_rows($query);
        return $yesterdayRegUsers;
    }

    public function getUsersRegisteredLast7Days() {
        $query = mysqli_query($this->con, "SELECT id FROM users WHERE DATE(posting_date) >= NOW() - INTERVAL 7 DAY");
        $last7DaysRegUsers = mysqli_num_rows($query);
        return $last7DaysRegUsers;
    }

    public function getUsersRegisteredLast30Days() {
        $query = mysqli_query($this->con, "SELECT id FROM users WHERE DATE(posting_date) >= NOW() - INTERVAL 30 DAY");
        $last30DaysRegUsers = mysqli_num_rows($query);
        return $last30DaysRegUsers;
    }

    public function getUsers() {
        $query = mysqli_query($this->con, "SELECT * FROM users");
        $users = array();
        while($row = mysqli_fetch_array($query)) {
            $users[] = $row;
        }
        return $users;
    }

    public function getUsersLast7Days() {
        $query = mysqli_query($this->con, "SELECT * FROM users WHERE DATE(posting_date) >= NOW() - INTERVAL 7 DAY");
        $users = array();
        while($row = mysqli_fetch_array($query)) {
            $users[] = $row;
        }
        return $users;
    }

    public function getUsersYesterday() {
        $query = mysqli_query($this->con, "SELECT * FROM users WHERE DATE(posting_date) = CURRENT_DATE() - INTERVAL 1 DAY");
        $users = array();
        while($row = mysqli_fetch_array($query)) {
            $users[] = $row;
        }
        return $users;
    }

    public function getUsersLast30Days() {
        $query = mysqli_query($this->con, "SELECT * FROM users WHERE DATE(posting_date) >= NOW() - INTERVAL 30 DAY");
        $users = array();
        while($row = mysqli_fetch_array($query)) {
            $users[] = $row;
        }
        return $users;
    }

    public function searchUsers($searchkey) {
        $ret = mysqli_query($this->con, "SELECT * FROM users WHERE (fname LIKE '%$searchkey%' OR email LIKE '%$searchkey%' OR contactno LIKE '%$searchkey%')");
        $users = array();
        while ($row = mysqli_fetch_array($ret)) {
            $users[] = $row;
        }
        return $users;
    }

    public function getUserByID($userid) {
        $query = mysqli_query($this->con, "SELECT * FROM users WHERE id='$userid'");
        $userData = mysqli_fetch_array($query);
        return $userData;
    }

    public function deleteUserById($userid) {
        $msg = mysqli_query($this->con, "DELETE FROM users WHERE id='$userid'");
        return $msg;
    }

    public function getReportData($fdate, $tdate) {
        $reportData = array();

        // Query untuk mendapatkan data pengguna berdasarkan tanggal
        $query = "SELECT * FROM users WHERE date(posting_date) BETWEEN '$fdate' AND '$tdate'";
        $result = mysqli_query($this->con, $query);

        // Ambil data hasil query
        while($row = mysqli_fetch_array($result)) {
            $reportData[] = $row;
        }

        return $reportData;
    }

    public function getUserData($uid){
        $userid = $uid;
        $query = mysqli_query($this->con, "select * from users where id='$userid'");
        return mysqli_fetch_array($query);
    
    }

    public function updatePassword($oldPassword, $newPassword, $adminId) {
        $oldPassword = md5($oldPassword);
        $newPassword = md5($newPassword);

        $sql = mysqli_query($this->con, "SELECT password FROM admin WHERE password='$oldPassword'");
        $num = mysqli_fetch_array($sql);
        if($num > 0) {
            $ret = mysqli_query($this->con, "UPDATE admin SET password='$newPassword' WHERE id='$adminId'");
            return $ret;
        } else {
            return false;
        }
    }

    public function updateUserProfile($fname, $lname, $contact, $userid) {
        $msg = mysqli_query($this->con, "UPDATE users SET fname='$fname', lname='$lname', contactno='$contact' WHERE id='$userid'");
        return $msg;
    }
}

?>
