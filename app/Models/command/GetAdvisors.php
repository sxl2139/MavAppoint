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
        $query = "SELECT pName,ma_user_advisor.userId
                  FROM ma_user,ma_user_advisor 
                  WHERE role='advisor' 
                  AND ma_user.userId = ma_user_advisor.userId";
        $this->result = $this->conn->query($query);
    }

    function processResult(){
        $arrid = array();
        $arrname=array();
        $arr=array();

        while($rs = mysqli_fetch_assoc($this->result)){
            array_push($arrid, $rs['userId']);
            array_push($arrname, $rs['pName']);
        }
        $arr["userId"] = $arrid;
        $arr["pName"] = $arrname;
        return $arr;
    }
}