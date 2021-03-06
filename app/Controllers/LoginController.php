<?php

class LoginController
{
    public function defaultAction()
    {
        $_SESSION['mavAppointUrl'] = getUrlWithoutParameters();
    }

    public function checkAction()
    {

        $email = $_REQUEST['email'];
        $password = $_REQUEST['password'];

        include_once ROOT . "/app/Models/db/DatabaseManager.php";
        $manager = new DatabaseManager();

        include_once ROOT . "/app/Models/bean/GetSet.php";
        $set = new GetSet();
        $set->setEmail($email);
        $set->setPassword($password);
        $res = $manager->checkUser($set);

        if (!$res) {
            return array(
                "error" => 1
            );
        }

        $_SESSION['email'] = $email;
        $_SESSION['role'] = $res['role'];
        $_SESSION['uid'] = $manager->getUserIdByEmail($email);
        $time = $manager->getTemporaryPasswordInterval();
//        $time = 80;

        if($res['sendTemPWDate']!=null){
            $today1 = strtotime(date("Y-m-d", time()));
            $lastDate1 = strtotime($res['sendTemPWDate']);
            $daysBeforetempPasswordExpired = $time - ($today1-$lastDate1)/(3600*24);
        }
        if($res['lastModDate'] !=null) {
            $today = strtotime(date("Y-m-d", time()));
            $lastDate = strtotime($res['lastModDate']);
            $daysBeforePasswordExpired = 90 - ($today-$lastDate)/(3600*24);
        }
        return array(
            "error" => 0,
            "data" => array(
                "role" => $res['role'],
                "validated" => $res['validated'],
                "lastModDate" => $res['lastModDate'],
                "daysBeforeExpired" => isset($daysBeforePasswordExpired) ? $daysBeforePasswordExpired : null,
                "daysBeforetempPasswordExpired" => isset($daysBeforetempPasswordExpired) ? $daysBeforetempPasswordExpired : null

            )
        );

    }

    public function changePasswordDefaultAction(){

    }

    public function changePasswordAction() {
        $currentPassword = $_REQUEST['currentPassword'];
        $newPassword = $_REQUEST['newPassword'];
        $repeatPassword = $_REQUEST['repeatPassword'];

        include_once ROOT . "/app/Models/db/DatabaseManager.php";
        $dbManager = new DatabaseManager();
        if ($_SESSION['role'] == "admin") {
            $user = $dbManager->getAdmin($_SESSION['email']);
        } else if ($_SESSION['role'] == "advisor") {
            $user = $dbManager->getAdvisor($_SESSION['email']);
        } else {
            $user = $dbManager->getStudent($_SESSION['email']);
        }
        if (md5($currentPassword) != $user->getPassword()) {
            return array(
                "error" => 1,
                "description" => "Invalid current password"
            );
        }

        if (!preg_match( '/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/', $newPassword)) {
            return array(
                "error" => 1,
                "description" => "New password must contain at least 8 characters,one number,one lowercase and one uppercase letter."
            );
        }

        if ($newPassword != $repeatPassword) {
            return array(
                "error" => 1,
                "description" => "New password and repeat password must match"
            );
        }

        $user->setPassword($newPassword);
        $user->setValidated(1);
        $user->setLastModDate( date("Y-m-d", time()     ) );
        if (!$dbManager->updateUser($user)) {
            return array(
                "error" => 1,
                "description" => "Errors while updating password"
            );
        }

        return array(
            "error" => 0
        );

    }

    public function successAction(){
        $controller = mav_encrypt($_REQUEST['nc']);
        $action = mav_encrypt($_REQUEST['na']);
        return array(
            "error" => 0,
            "data" => getUrlWithoutParameters() . "?c=$controller&a=$action"
        );
    }

    public function logoutAction()
    {
        session_unset();
        session_destroy();
    }

    public function testAction()
    {
        return array(
            "error" => 0
        );
    }

    public function forgotPasswordAction(){
        $emailAddress = $_REQUEST['emailAddress'];
        if($emailAddress=="" || $emailAddress==null){
            return array(
                "error" =>1,
                "description" => "Please enter your email Address!"
            );
        }

        include_once ROOT . "/app/Models/db/DatabaseManager.php";
        $manager = new DatabaseManager();
        $uid = $manager->getUserIdByEmail($emailAddress);
        $password = generateRandomPassword();
        $time = date("Y-m-d", time());
        if($uid==null){
            return array(
                "error" =>1,
                "description" => "No account exists for this email address!"
            );
        }
        if(!$manager->updatePassword($emailAddress,$password,$time)){
            return array(
                "error" =>1,
                "description" => "Error while reset password, please try again!"
            );
        }

        mav_mail("MavAppoint - Forgot password",
            "<p>The temporary password for your account is:  ". $password . "</p>"
            . "<br><br>Please click  <a href='" . getUrlWithoutParameters() . "?c=" . mav_encrypt("login") . "'>here</a> to login to your account to change password!", array($emailAddress));


        return array(
            "error" => 0,
            "description" => "Reset password successfully! Please check your email for further details!"
        );
    }

    public function forgotPasswordDefaultAction(){
        return array(
            "error" => 0
        );
    }

}


