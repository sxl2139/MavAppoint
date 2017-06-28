<?php

/**
 * Created by PhpStorm.
 * User: shenchen
 * Date: 6/15/17
 * Time: 6:22 AM
 */
include_once dirname(__FILE__) . "/SQLCmd.php";
class AddNewDepartment extends SQLCmd
{
    private $name;

    function __construct($name) {
        $this->name = $name;
    }

    function queryDB(){
        if($this->name != null)
            $query = "INSERT INTO ma_department VALUES('$this->name')";
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