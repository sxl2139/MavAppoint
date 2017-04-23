<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/2/14
 * Time: 17:11
 */
include_once dirname(__FILE__) . "/SQLCmd.php";
class GetMajorsOfDepartment extends SQLCmd{
    private $name;

    function __construct($name) {
        $this->name = $name;
    }

    function queryDB(){
        $query = "SELECT name from ma_major where depName='$this->name'";

        $this->result          = $this->conn->query($query);
    }

    function processResult(){
        $arr = array();
        while($rs = mysqli_fetch_assoc($this->result)){
            array_push($arr, ($rs['name']));
        }

        return $arr;
    }
}