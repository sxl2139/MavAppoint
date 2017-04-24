<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/2/14
 * Time: 7:28
 */
include_once dirname(__FILE__) . "/SQLCmd.php";
class GetAdmin extends SQLCmd{
    private $email;

    function __construct($email) {
        $this->email = $email;
    }

    function queryDB(){
        $query = "SELECT * FROM ma_user WHERE email='$this->email'";
        $this->result = $this->conn->query($query)->fetch_assoc();
    }

    function processResult(){
        include_once dirname(dirname(__FILE__)) . "/login/LoginUser.php";
        $set = new LoginUser();
        $set->setUserId($this->result["userId"]);
        $set->setEmail($this->result["email"]);
        $set->setRole($this->result["role"]);
        $set->setValidated($this->result["validated"]);
        $set->setPassword($this->result["password"]);

        return ($set);
    }
}