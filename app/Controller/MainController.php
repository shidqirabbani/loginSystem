<?php

namespace PBW\login\system\Controller;


use PBW\login\system\Model\UserModel;

class MainController
{
    public $userModel;

    public function __construct()
    {
        $this->userModel = new userModel();
    }

    public function index()
    {
        include_once __DIR__ . '/../View/index.php';
    } 

    public function login_view()
    {
        include_once __DIR__ . '/../View/login.php';
    }

    public function login()
    {
        if(isset($_POST['login'])) {
            $useremail = $_POST['uemail'];
            $password = $_POST['password'];

            $userData = $this->userModel->login($useremail, $password);

            if($userData) {
                session_start();
                $_SESSION['id'] = $userData['id'];
                $_SESSION['name'] = $userData['fname'];
                var_dump($_SESSION);
                header("location: /welcome");
                exit();
            } else {
                echo "<script>alert('Invalid username or password');</script>";
            }
        }
    }
    
    public function signup_view()
    {
        include_once __DIR__ . '/../View/signup.php';
    } 

    public function signup()
    {
        if(isset($_POST['submit'])) {
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $contact = $_POST['contact'];
            
            if($this->userModel->checkExistingEmail($email)) {
                echo "<script>alert('Email id already exist with another account. Please try with other email id');</script>";
            } else {
                $msg = $this->userModel->registerUser($fname, $lname, $email, $password, $contact);
        
                if($msg) {
                    echo "<script>alert('Registered successfully');</script>";
                    echo "<script type='text/javascript'> document.location = '/login_view'; </script>";
                }
            }
        }
    } 

    public function logout(){
        include_once __DIR__ . '/../View/logout.php';
    }

    public function welcome()
    {
        session_start();
        // var_dump($_SESSION);
        // Periksa apakah ID ada di session
        if(isset($_SESSION['id'])) {
            $userid = $_SESSION['id'];
            // Gunakan ID untuk mendapatkan data pengguna
            $userData = $this->userModel->getUserData($userid);
            include_once __DIR__ . '/../View/welcome.php';
        } 
        else {
            // Jika tidak ada ID di session, mungkin pengguna belum login, arahkan mereka ke halaman login
            header("location: /login_view");
        }
    }

    public function profile()
    {
        session_start();
        // var_dump($_SESSION);
        // Periksa apakah ID ada di session
        if(isset($_SESSION['id'])) {
            $userid = $_SESSION['id'];
            // Gunakan ID untuk mendapatkan data pengguna
            $userData = $this->userModel->getUserData($userid);
            include_once __DIR__ . '/../View/profile.php';
        } 
        else {
            // Jika tidak ada ID di session, mungkin pengguna belum login, arahkan mereka ke halaman login
            header("location: /login_view");
        }
    }

    public function editProfilePage()
    {
        session_start();
        // var_dump($_SESSION);
        // Periksa apakah ID ada di session
        if(isset($_SESSION['id'])) {
            $userid = $_SESSION['id'];
            // Gunakan ID untuk mendapatkan data pengguna
            $userData = $this->userModel->getUserData($userid);
            include_once __DIR__ . '/../View/edit-profile.php';
        } 
        else {
            // Jika tidak ada ID di session, mungkin pengguna belum login, arahkan mereka ke halaman login
            header("location: /login_view");
        }
    }

    public function updateProfile() {
        session_start();
        if(isset($_POST['update'])) {
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $contact = $_POST['contact'];
            $userid = $_SESSION['id'];

            $msg = $this->userModel->updateUserProfile($fname, $lname, $contact, $userid);

            if($msg) {
                echo "<script>alert('Profile updated successfully');</script>";
                echo "<script type='text/javascript'> document.location = '/profile'; </script>";
            }
        }
    }

    public function changePasswordPage()
    {
        session_start();
        // var_dump($_SESSION);
        // Periksa apakah ID ada di session
        if(isset($_SESSION['id'])) {
            $userid = $_SESSION['id'];
            // Gunakan ID untuk mendapatkan data pengguna
            $userData = $this->userModel->getUserData($userid);
            include_once __DIR__ . '/../View/change-password.php';
        } 
        else {
            // Jika tidak ada ID di session, mungkin pengguna belum login, arahkan mereka ke halaman login
            header("location: /login_view");
        }
    }

    public function updatePassword()
    {
        session_start();
        if(isset($_POST['update'])) {
            $oldpassword = $_POST['currentpassword']; 
            $newpassword = $_POST['newpassword'];
            $userid = $_SESSION['id'];

            $passwordChanged = $this->userModel->changePassword($oldpassword, $newpassword, $userid);

            if($passwordChanged) {
                echo "<script>alert('Password Changed Successfully !!');</script>";
            } else {
                echo "<script>alert('Old Password not match !!');</script>";
            }
            echo "<script type='text/javascript'> document.location = '/change-password'; </script>";
        }
    }

    public function passwordRecovery()
    {
        
            include_once __DIR__ . '/../View/password-recovery.php';
        
    }

    public function sendPasswordEmail() {

        if(isset($_POST['send'])) {
            $femail = $_POST['femail'];

            $emailInfo = $this->userModel->getEmailInfo($femail);
            if($emailInfo) {
                $toemail = $emailInfo['email'];
                $fname = $emailInfo['fname'];
                $password = $emailInfo['password'];

                $success = $this->userModel->sendEmail($toemail, $fname, $password);
                if($success === true) {
                    echo  "<script>alert('Your Password has been sent Successfully');</script>";
                } else {
                    echo  "<script>alert('Message could not be sent');</script>";
                    echo 'Mailer Error: ' . $success;
                }
            } else {
                echo "<script>alert('Email not register with us');</script>";   
            }
        }
    }
}
