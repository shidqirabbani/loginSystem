<?php

namespace PBW\login\system\Model;

use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../vendor/autoload.php';

class UserModel {
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

    public function login($useremail, $password) {
        $dec_password = md5($password); // Change to a more secure hashing algorithm if possible
        $sql = "SELECT id, fname FROM users WHERE email='$useremail' AND password='$password'";
        $result = mysqli_query($this->con, $sql);
        if(mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        } else {
            return false;
        }
    }

    public function checkExistingEmail($email)
    {
        $sql = mysqli_query($this->con, "SELECT id FROM users WHERE email='$email'");
        $row = mysqli_num_rows($sql);
        return $row > 0;
    }

    public function registerUser($fname, $lname, $email, $password, $contact)
    {
        $msg = mysqli_query($this->con, "INSERT INTO users(fname, lname, email, password, contactno) VALUES('$fname', '$lname', '$email', '$password', '$contact')");
        return $msg;
    } 

    public function getUserData($userid){
            $userid = $_SESSION['id'];
            $query = mysqli_query($this->con, "select * from users where id='$userid'");
            return mysqli_fetch_array($query);
        
    }

    public function changePassword($oldpassword, $newpassword, $userid) {
        $sql = mysqli_query($this->con, "SELECT password FROM users WHERE id='$userid' AND password='$oldpassword'");
        $num = mysqli_fetch_array($sql);
        if($num > 0) {
            $ret = mysqli_query($this->con, "UPDATE users SET password='$newpassword' WHERE id='$userid'");
            return true; // Berhasil mengubah password
        } else {
            return false; // Password lama tidak cocok
        }
    }

    public function updateUserProfile($fname, $lname, $contact, $userid) {
        $msg = mysqli_query($this->con, "UPDATE users SET fname='$fname', lname='$lname', contactno='$contact' WHERE id='$userid'");
        return $msg;
    }

    public function getEmailInfo($email) {
        $row1 = mysqli_query($this->con,"select email,password,fname from users where email='$email'");
        return mysqli_fetch_array($row1);
    }

    public function sendEmail($toemail, $fname, $password) {
        $mail = new PHPMailer;
        
        $subject = "Information about your password";
        $message = "Your password is ".$password;

        $mail->isSMTP();                            // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';             // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                     // Enable SMTP authentication
        $mail->Username = 'shidqirabbani1003@gmail.com';     // SMTP username
        $mail->Password = 'dindaaulia1003'; // SMTP password
        $mail->SMTPSecure = 'tls';                  // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                          // TCP port to connect to
        $mail->setFrom('shidqirabbani1003@gmail.com','Shidqi Rabbani');
        $mail->addAddress($toemail);                // Add a recipient
        $mail->isHTML(true);                        // Set email format to HTML
        $bodyContent = 'Dear'." ".$fname;
        $bodyContent .='<p>'.$message.'</p>';
        $mail->Subject =$subject;
        $mail->Body = $bodyContent;

        if(!$mail->send()) {
            return $mail->ErrorInfo;
        } else {
            return true;
        }
    }
}

?>
