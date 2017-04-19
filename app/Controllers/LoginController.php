<?php

class LoginController
{
    public function defaultAction()
    {
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
        $_SESSION['url'] = getUrlWithoutParameters();

        return array(
            "error" => 0,
            "data" => array(
                "role" => $res['role']
            )
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


