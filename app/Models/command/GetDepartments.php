<?php

/**
 * Created by PhpStorm.
 * User: shenchen
 * Date: 6/15/17
 * Time: 5:37 AM
 */
include_once dirname(__FILE__) . "/SQLCmd.php";
class GetDepartments extends SQLCmd
{
    function __construct() {
    }

    function queryDB(){
        $query = "SELECT * FROM ma_department";
        $this->result = $this->conn->query($query);
    }

    function processResult(){
        $arr = array();
        while($rs = mysqli_fetch_assoc($this->result)){
            array_push($arr, $rs['name']);
        }
        return $arr;
    }
}