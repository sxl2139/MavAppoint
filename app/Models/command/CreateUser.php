<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/2/13
 * Time: 22:12
 */
namespace Models\Command;

use Models\Login as login;

class CreateUser extends SQLCmd
{
    private $user;

    function __construct(login\LoginUser $user)
    {
        $this->user = $user;
    }

    function queryDB()
    {
        $this->result = 0;

        $email = $this->user->getEmail();
        $password = md5($this->user->getPassword());
        $role = $this->user->getRole();

        $query = "INSERT INTO ma_user 
                  (email,password,role) 
                  VALUES('$email','$password','$role')";
        $res = $this->conn->query($query);

        if ($res) {
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