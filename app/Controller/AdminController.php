<?php

namespace PBW\login\system\Controller;


use PBW\login\system\Model\AdminModel;

class AdminController
{
    public $adminModel;

    public function __construct()
    {
        $this->adminModel = new adminModel();
    }

    public function index()
    {
        include_once __DIR__ . '/../View/Admin/index.php';
    } 

    public function login() {
        if(isset($_POST['login'])) {
            $adminusername = $_POST['username'];
            $password = $_POST['password'];

            $adminData = $this->adminModel->checkAdminLogin($adminusername, $password);

            if($adminData) {
                session_start();
                $_SESSION['login'] = $adminusername;
                $_SESSION['adminid'] = $adminData['id'];
                echo "<script>window.location.href='/dashboard'</script>";
                exit();
            } else {
                echo "<script>alert('Invalid username or password');</script>";
                echo "<script>window.location.href='/admin'</script>";
                exit();
            }
        }
    }

    public function dashboard()
    {
        session_start();
        // var_dump($_SESSION);
        // Periksa apakah ID ada di session
        if(isset($_SESSION['adminid'])) {
            $userid = $_SESSION['adminid'];
            // Gunakan ID untuk mendapatkan data pengguna
            $totalUsers = $this->adminModel->getTotalUsers();
            $yesterdayRegUsers = $this->adminModel->getUsersRegisteredYesterday();
            $last7DaysRegUsers = $this->adminModel->getUsersRegisteredLast7Days();
            $last30DaysRegUsers = $this->adminModel->getUsersRegisteredLast30Days();
            include_once __DIR__ . '/../View/Admin/dashboard.php';
        } 
        else {
            // Jika tidak ada ID di session, mungkin pengguna belum login, arahkan mereka ke halaman login
            header("location: /admin");
        }
        
    }
    
    public function manageUsers()
    {
        session_start();
        // var_dump($_SESSION);
        // Periksa apakah ID ada di session
        if(isset($_SESSION['adminid'])) {
            $userid = $_SESSION['adminid'];
            // Gunakan ID untuk mendapatkan data pengguna
            $users = $this->adminModel->getUsers();
            include_once __DIR__ . '/../View/Admin/manage-users.php';
        } 
        else {
            // Jika tidak ada ID di session, mungkin pengguna belum login, arahkan mereka ke halaman login
            header("location: /admin");
        }
        
    } 

    public function yesterdayUsers()
    {
        session_start();
        // var_dump($_SESSION);
        // Periksa apakah ID ada di session
        if(isset($_SESSION['adminid'])) {
            $userid = $_SESSION['adminid'];
            // Gunakan ID untuk mendapatkan data pengguna
            $users = $this->adminModel->getUsersYesterday();
            include_once __DIR__ . '/../View/Admin/yesterday-reg-users.php';
        } 
        else {
            // Jika tidak ada ID di session, mungkin pengguna belum login, arahkan mereka ke halaman login
            header("location: /admin");
        }
        
    }

    public function last7DaysUsers()
    {
        session_start();
        // var_dump($_SESSION);
        // Periksa apakah ID ada di session
        if(isset($_SESSION['adminid'])) {
            $userid = $_SESSION['adminid'];
            // Gunakan ID untuk mendapatkan data pengguna
            $users = $this->adminModel->getUsersLast7Days();
            include_once __DIR__ . '/../View/Admin/lastsevendays-reg-users.php';
        } 
        else {
            // Jika tidak ada ID di session, mungkin pengguna belum login, arahkan mereka ke halaman login
            header("location: /admin");
        }
        
    } 

    public function last30DaysUsers()
    {
        session_start();
        // var_dump($_SESSION);
        // Periksa apakah ID ada di session
        if(isset($_SESSION['adminid'])) {
            $userid = $_SESSION['adminid'];
            // Gunakan ID untuk mendapatkan data pengguna
            $users = $this->adminModel->getUsersLast30Days();
            include_once __DIR__ . '/../View/Admin/lastthirtyays-reg-users.php';
        } 
        else {
            // Jika tidak ada ID di session, mungkin pengguna belum login, arahkan mereka ke halaman login
            header("location: /admin");
        }
        
    }

    public function bwdatesReportDs(){
        session_start();
        // var_dump($_SESSION);
        // Periksa apakah ID ada di session
        if(isset($_SESSION['adminid'])) {
            $userid = $_SESSION['adminid'];
            // Gunakan ID untuk mendapatkan data pengguna
            include_once __DIR__ . '/../View/Admin/bwdates-report-ds.php';
        } 
        else {
            // Jika tidak ada ID di session, mungkin pengguna belum login, arahkan mereka ke halaman login
            header("location: /admin");
        }
    }

    public function searchUsers() {
        // Periksa apakah ada permintaan POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['searchkey'])) {
            // Ambil nilai pencarian dari form
            $searchkey = $_POST['searchkey'];

            // Panggil fungsi pencarian pengguna dari model
            $searchResults = $this->adminModel->searchUsers($searchkey);

            // Panggil tampilan untuk menampilkan hasil pencarian
            include_once __DIR__ . '/../View/Admin/search-result.php';
        }
    }

    public function getUserProfile() 
    {
        session_start();
        $uid = $_GET['uid'];
        // Panggil fungsi untuk mendapatkan data pengguna berdasarkan ID
        $userData = $this->adminModel->getUserByID($uid);

        // Panggil tampilan untuk menampilkan profil pengguna
        include_once __DIR__ . '/../View/Admin/user-profile.php';
        
    }

    public function editProfilePage()
    {
        session_start();
        // var_dump($_SESSION);
        // Periksa apakah ID ada di session
        if(isset($_SESSION['adminid'])) {
            $uid = $_GET['uid'];
            // Gunakan ID untuk mendapatkan data pengguna
            $userData = $this->adminModel->getUserData($uid);
            include_once __DIR__ . '/../View/Admin/edit-profile.php';
        } 
        else {
            // Jika tidak ada ID di session, mungkin pengguna belum login, arahkan mereka ke halaman login
            header("location: /admin");
        }
    }

    public function updateProfile() {
        session_start();
        if(isset($_POST['update'])) {
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $contact = $_POST['contact'];
            $userid = $_POST['id'];

            $msg = $this->adminModel->updateUserProfile($fname, $lname, $contact, $userid);

            if($msg) {
                echo "<script>alert('Profile updated successfully');</script>";
                echo "<script type='text/javascript'> document.location = '/manage-users'; </script>";
            }
        }
    }

    public function deleteUser(){
        $uid = $_GET['uid'];
        $msg = $this->adminModel->deleteUserById($uid);
        if($msg) {
            echo "<script>alert('Data deleted');</script>";
            // Redirect kembali ke halaman sebelumnya
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }
    }

    public function generateReport() {
        // Ambil nilai dari form
        $fdate = $_POST['fromdate'];
        $tdate = $_POST['todate'];

        // Panggil fungsi untuk mendapatkan data laporan dari model
        $reportData = $this->adminModel->getReportData($fdate, $tdate);

        // Panggil tampilan untuk menampilkan hasil laporan
        include_once __DIR__ . '/../View/Admin/bwdates-report-result.php';
    }

    public function changePasswordPage()
    {
        session_start();
        // var_dump($_SESSION);
        // Periksa apakah ID ada di session
        if(isset($_SESSION['adminid'])) {
            $userid = $_SESSION['adminid'];
            // Gunakan ID untuk mendapatkan data pengguna
            $userData = $this->adminModel->getUserData($userid);
            include_once __DIR__ . '/../View/Admin/change-password.php';
        } 
        else {
            // Jika tidak ada ID di session, mungkin pengguna belum login, arahkan mereka ke halaman login
            header("location: /login_view");
        }
    }

    public function changePassword() {
        session_start();
        if(isset($_POST['update'])) {
            $oldPassword = $_POST['currentpassword'];
            $newPassword = $_POST['newpassword'];

            $adminId = $_SESSION['adminid'];


            // Panggil fungsi untuk mengupdate password dari model
            $success = $this->adminModel->updatePassword($oldPassword, $newPassword, $adminId);

            if($success) {
                echo "<script>alert('Password Changed Successfully !!');</script>";
                echo "<script type='text/javascript'> document.location = '/admins-change-password'; </script>";
            } else {
                echo "<script>alert('Old Password not match !!');</script>";
                echo "<script type='text/javascript'> document.location = '/admins-change-password'; </script>";
            }
        }
    }
    
}