<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/2/14
 * Time: 16:01
 */
include_once dirname(__FILE__) . "/SQLCmd.php";
class GetMajor extends SQLCmd{
    private $id;

    function __construct($id) {
        $this->id = $id;
    }

    function queryDB(){
        if($this->id == null)
            $query = "SELECT name FROM ma_major";
        else
            $query = "select name from ma_major_user where userId ='$this->id'";

        $this->result = $this->conn->query($query);
    }

    function processResult(){
        $arr = array();
        while($rs = mysqli_fetch_array($this->result)){
            array_push($arr, ($rs['name']));
        }

        return $arr;
    }
}