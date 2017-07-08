<?php

include_once dirname(__FILE__) . "/SQLCmd.php";

class GetUserById extends SQLCmd {
    private $uid;

    function __construct($uid) {
        $this->uid = $uid;
    }

    function queryDB() {
        $query        = "SELECT * FROM ma_user WHERE id = $this->uid";
        $res          = $this->conn->query($query)->fetch_assoc();
        $this->result = $res;
    }

    function processResult() {
        include_once dirname(dirname(__FILE__)) . "/login/LoginUser.php";
        $user = new LoginUser();
        $user->setEmail($this->result['email']);
        $user->setUserId($this->result['userId']);
        $user->setRole($this->result['role']);
        $user->setValidated($this->result['validated']);
        return $user;
    }
}