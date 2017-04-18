<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/4/11
 * Time: 16:35
 */
include_once dirname(__FILE__) . "/SQLCmd.php";
class GetMajorsByUserId extends SQLCmd
{
    private $userId;

    function __construct($userId) {
        $this->userId = $userId;
    }

    function queryDB(){
        $query = "SELECT name from ma_major_user where userId='$this->userId'";

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