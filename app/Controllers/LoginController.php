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

        return array(
            "error" => 0,
            "data" => array(
                "role" => $res['role'],
                "validated" => $res['validated']
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

        if (strlen($newPassword) < 8) {
            return array(
                "error" => 1,
                "description" => "New password must be 8 characters long"
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

}


