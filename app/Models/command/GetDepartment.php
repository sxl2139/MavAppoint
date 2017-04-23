<?php

/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/2/14
 * Time: 17:06
 */
include_once dirname(__FILE__) . "/SQLCmd.php";
class GetDepartment extends SQLCmd{
    private $id;

    function __construct($id) {
        $this->id = $id;
    }

    function queryDB(){
        if($this->id == null)
            $query = "SELECT name FROM ma_department";
        else
            $query = "select name from ma_department_user where userId ='$this->id'";

        $this->result = $this->conn->query($query);
    }

    function processResult(){
        $arr = array();
        while($rs = mysqli_fetch_assoc($this->result)){
            array_push($arr, ($rs['name']));
        }

        return $arr;
    }
}