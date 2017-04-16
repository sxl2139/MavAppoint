<?php
namespace Models\Command;
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/2/14
 * Time: 15:11
 */
use Models\bean\AppointmentType;
class GetAppointmentTypes extends SQLCmd{
    private $pName;

    function __construct($pName) {
        $this->pName = $pName;
    }

    function queryDB(){
        $query = "SELECT type,duration,ma_user.email 
                  FROM  ma_appointment_types,ma_user_advisor,ma_user 
                  WHERE ma_appointment_types.userId=ma_user_advisor.userId 
                  AND ma_user_advisor.userId=ma_user.userId 
                  AND ma_user_advisor.pName='$this->pName'";
        $this->result = $this->conn->query($query);
    }

    function processResult(){
        $arr = array();
        while($rs = mysqli_fetch_array($this->result)){
            $set = new AppointmentType();
            $set->setType($rs["type"]);
            $set->setDuration($rs["duration"]);
            $set->setEmail($rs["email"]);
            array_push($arr, ($set));
        }

        return $arr;
    }
}