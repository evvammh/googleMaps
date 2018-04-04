<?php

class Forgotpassword extends dbcon {

    /**
     * Admin Login DAO Constructor
     */
    var $rand_key;
    var $site_name;
    var $email_address;

    public function __construct() {

        parent::__construct();

        $this->sitename = 'GolfPilot.com';
        $this->rand_key = '0iQx5oBk66oVZep';
    }

    /**
     * To send reset password link
     * @return type 
     */
    function sendForgotpassword() {
        try {
            $this->email_address = add_quote($_POST["txtEmailAddress"]);

            $sql = "SELECT * FROM  " . DBPREFIX . "fgusers WHERE  `email` =  '" . $this->email_address . "'";

            $result = $this->Query($sql);

            while ($rs = $this->FetchRow()) {

                $name = $rs["name"];
                $username = $rs["username"];
                $password = $rs["password"];
                $email = $rs["email"];
            }

            if ($password != "") {
                $reset_code = $this->getResetPasswordCode();
                $password_reset_url = $this->GetAbsoluteURLFolder() . '/reset_password.php?code=' . $reset_code;
                $msg = 'Dear ' . $name . ',<br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $msg.='Please click the link to reset your password <a href="' . $password_reset_url . '" target="blank" ><b>reset my password</b></a>.<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $msg.='This link can be used only once to reset the password.<br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $msg.='Thanks! for contacting.<br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $msg.='With Best Regards,<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $msg.='GolfPilot Team.';

                SendMail($email, "GolfPilot password recovery", $msg);

                header('location: forgotpassword.php?msg=' . urlencode("<font color=blue>Link has been sent to your email address " . $email . " to reset password</font>."));
                die;
            } else {
                header('location: forgotpassword.php?msg=' . urlencode("<font color=red>Sorry!! email " . $this->email_address . " isn't registered.</font>"));
                die;
            }
        } catch (Exception $e) {
            return "Error in sendForgotpassword - " . $e->getMessage();
        }
    }

    /**
     * To give reset password code
     * @return type 
     */
    function getResetPasswordCode() {
        try {
            $reset_code = $this->MakeConfirmationMd5($this->email_address);
            $sql = "SELECT * FROM  " . DBPREFIX . "reset_password WHERE  `email` =  '" . $this->email_address . "'";
            $result = $this->Query($sql);
            while ($rs = $this->FetchRow()) {
                $email = $rs["email"];
                $id = $rs["id"];
            }
            if ($email != "") {
                $sql = "UPDATE  " . DBPREFIX . "reset_password SET  `reset_code` =  '" . $reset_code . "', `created_on`=NOW() WHERE  `id` ='" . $id . "'";
            } else {
                $sql = "INSERT INTO   " . DBPREFIX . "reset_password (`id` ,`email` ,`reset_code` ,`created_on` )VALUES (NULL ,  '" . $this->email_address . "',  '" . $reset_code . "',  NOW())";
            }
            $result = $this->Query($sql);
            return $reset_code;
        } catch (Exception $e) {
            return "Error in getResetPasswordLisnk - " . $e->getMessage();
        }
    }

    /**
     * To generate code
     * @param type $email
     * @return type 
     */
    function MakeConfirmationMd5($email) {
        $randno1 = rand();
        $randno2 = rand();
        return md5($email . $this->rand_key . $randno1 . '' . $randno2);
    }

    /**
     * To get absolute url
     * @return string 
     */
    function GetAbsoluteURLFolder() {
        $scriptFolder = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on')) ? 'https://' : 'http://';
        $scriptFolder .= $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']);
        return $scriptFolder;
    }

    /**
     * To check the validity of password reset code
     * @param type $code
     * @return type 
     */
    function confirmResetPassword($code) {
        try {
            $code = add_quote($code);
            if (empty($_GET['code']) || strlen($_GET['code']) <= 10) {
                $objResult->msg = "Please provide the reset code.";
                $objResult->result = false;
                return $objResult;
            } else {
                $sql = "SELECT * FROM  " . DBPREFIX . "reset_password WHERE  `reset_code` =  '" . $code . "'";
                $result = $this->Query($sql);
                while ($rs = $this->FetchRow()) {
                    $email = $rs["email"];
                    $id = $rs["id"];
                }
                if ($email == "") {
                    $objResult->msg = "Wrong reset code. Either it has been used already or you have made another request after this.";
                    $objResult->result = false;
                    return $objResult;
                } else {
                    $objResult->msg = $email;
                    $objResult->result = true;
                    $sql = "DELETE FROM  " . DBPREFIX . "reset_password WHERE  `reset_code` =  '" . $code . "'";
                    $result = $this->Query($sql);
                    return $objResult;
                }
            }
        } catch (Exception $e) {
            return "Error in confirmResetPassword - " . $e->getMessage();
        }
    }

    /**
     * To update password in database
     * @return type 
     */
    function save_new_password() {
        try {
            $email = add_quote($_REQUEST["email"]);
            $password = add_quote($_REQUEST["txtPassword"]);
            $sql = "UPDATE  " . DBPREFIX . "fgusers SET  `password` =  '" . md5($password) . "' WHERE  `email` ='" . $email . "'";
            $result = $this->Query($sql);
            header("Location: success_reset_password.php");
            die;
        } catch (Exception $e) {
            return "Error in save_new_password - " . $e->getMessage();
        }
    }

}

?>