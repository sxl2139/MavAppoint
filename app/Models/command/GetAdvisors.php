<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/2/14
 * Time: 7:06
 */
include_once dirname(__FILE__) . "/SQLCmd.php";
class GetAdvisors extends SQLCmd{
    function __construct() {
    }

    function queryDB(){
        $query = "SELECT pName 
                  FROM ma_user,ma_user_advisor 
                  WHERE role='advisor' 
                  AND ma_user.userId = ma_user_advisor.userId";
        $this->result = $this->conn->query($query);
    }

    function processResult(){
        $arr = array();
        while($rs = mysqli_fetch_array($this->result)){
            array_push($arr, $rs['pName']);
        }

        return $arr;
    }
}