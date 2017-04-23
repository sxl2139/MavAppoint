<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/3/26
 * Time: 18:19
 */

include_once dirname(__FILE__) . "/SQLCmd.php";
class GetStudentEmails extends SQLCmd{

    function __construct() {
    }

    function queryDB(){
        $query = "SELECT email FROM ma_user where role = 'student'";
        $this->result = $this->conn->query($query);
    }

    function processResult(){
        $arr = array();
        while($rs = mysqli_fetch_row($this->result)){
            array_push($arr, ($rs[0]));
        }

        return $arr;
    }
}