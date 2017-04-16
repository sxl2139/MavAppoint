<?php
namespace Models\Command;
use Models\Login\LoginUser;

/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/2/14
 * Time: 7:28
 */
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
        $set = new LoginUser();
        $set->setUserId($this->result["userId"]);
        $set->setEmail($this->result["email"]);
        $set->setRole($this->result["role"]);
        $set->setValidated($this->result["validated"]);

        return ($set);
    }
}