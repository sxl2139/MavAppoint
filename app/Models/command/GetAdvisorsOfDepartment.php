<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/2/14
 * Time: 16:09
 */
include_once dirname(__FILE__) . "/SQLCmd.php";
class GetAdvisorsOfDepartment extends SQLCmd{
    private $dep;

    function __construct($dep) {
        $this->dep = $dep;
    }

    function queryDB(){
        $query = "SELECT ma_user_advisor.*,ma_user.*
                  FROM ma_user_advisor,ma_department_user,ma_user
                  WHERE ma_department_user.userId=ma_user_advisor.userId 
                  AND ma_user.userId=ma_user_advisor.userId  
                  AND ma_department_user.name = '$this->dep'";
        $this->result = $this->conn->query($query);
    }

    function processResult(){
        include_once dirname(dirname(__FILE__)) . "/login/AdvisorUser.php";
        $arr = array();
        while($rs = mysqli_fetch_row($this->result)){
            $user = new AdvisorUser();
            $user->setUserId($rs[0]);
            $user->setPName($rs[1]);
            $user->setNotification($rs[2]);
            $user->setNameLow($rs[3]);
            $user->setNameHigh($rs[4]);
            $user->setDegType($rs[5]);
            $user->setCutOffPreference($rs[6]);
            $user->setEmail($rs[8]);
            $user->setPassword($rs[9]);
            $user->setRole($rs[11]);
            $user->setValidated($rs[12]);
            array_push($arr, $user);
        }

        return $arr;
    }
}