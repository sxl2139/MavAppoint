<?php

/**
 * Created by PhpStorm.
 * User: shenchen
 * Date: 7/6/17
 * Time: 5:24 PM
 */
include_once dirname(__FILE__) . "/SQLCmd.php";
class SetTemporaryPasswordInterval extends SQLCmd
{
    private $time;

    function __construct($time) {
        $this->time = $time;
    }

    function queryDB(){
        if($this->time != null)
            $query = "UPDATE ma_tempassword_expiration SET time = '$this->time'";
        $this->conn->query($query);
        if (mysqli_affected_rows($this->conn) > 0)
            $this->result = true;
        else
            $this->result = false;
    }

    function processResult(){

        return $this->result;
    }
}