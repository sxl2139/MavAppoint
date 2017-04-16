<?php
namespace Models\Command;
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/2/14
 * Time: 17:11
 */
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
        while($rs = mysqli_fetch_array($this->result)){
            array_push($arr, ($rs['name']));
        }

        return $arr;
    }
}