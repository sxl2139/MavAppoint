<?php

/**
 * Created by PhpStorm.
 * User: shenchen
 * Date: 7/6/17
 * Time: 6:43 PM
 */
include_once dirname(__FILE__) . "/SQLCmd.php";
class GetTemporaryPasswordInterval extends SQLCmd{

    function __construct() {
    }

    function queryDB(){

        $query = "SELECT time FROM ma_tempassword_expiration";

        $this->result = $this->conn->query($query);
    }

    function processResult(){
//        $arr = array();
        while($rs = mysqli_fetch_assoc($this->result)){
//            array_push($arr, ($rs['time']));
            $time = $rs['time'];
        }

        return $time;
    }
}