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

        $manager = new DatabaseManager();

        $set = new GetSet();
        $set->setEmail($email);
        $set->setPassword($password);
        $res = $manager->checkUser($set);

        if (!$res) {
            return [
                "error" => 1
            ];
        }


        $_SESSION['email'] = $email;
        $_SESSION['role'] = $res['role'];
        $_SESSION['uid'] = $manager->getUserIdByEmail($email);

        return [
            "error" => 0,
            "data" => [
                "role" => $res['role']
            ]
        ];

    }

    public function logoutAction()
    {
        session_unset();
        session_destroy();
    }

    public function testAction()
    {
        return [
            "error" => 0
        ];
    }

}


