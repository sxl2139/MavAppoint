<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/2/13
 * Time: 22:12
 */
include_once dirname(__FILE__) . "/SQLCmd.php";
include_once dirname(dirname(__FILE__)) . "/login/LoginUser.php";

class CreateUser extends SQLCmd
{
    private $user;

    function __construct(LoginUser $user)
    {
        $this->user = $user;
    }

    function queryDB()
    {
        $this->result = 0;

        $email = $this->user->getEmail();
        $password = md5($this->user->getPassword());
        $role = $this->user->getRole();
        $sendTemPWDate = $this->user->getSendTemPWDate();

        $query = "INSERT INTO ma_user 
                  (email,password,role,sendTemPWDate) 
                  VALUES('$email','$password','$role','$sendTemPWDate')";
        $res = $this->conn->query($query);

        if ($res) {
            include_once dirname(__FILE__) . "/GetUserIdByEmail.php";
            $cmd = new GetUserIdByEmail($email);
            $id = ($cmd->execute());


            $majors = $this->user->getMajors();

            foreach ($majors as $major) {
                $query = "INSERT INTO ma_major_user 
                          (name, userId) 
                          VALUES ('$major','$id')";
                $this->conn->query($query);
            }

            $departments = $this->user->getDepartments();

            foreach ($departments as $department) {
                $query = "INSERT INTO ma_department_user 
                          (name, userId) 
                          VALUES ('$department','$id')";
                $this->conn->query($query);
            }


            $this->result = $id;

        }
    }

    function processResult()
    {
        return $this->result;
    }
}