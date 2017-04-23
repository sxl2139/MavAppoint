<?php

/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/2/14
 * Time: 10:25
 */
include_once dirname(__FILE__) . "/SQLCmd.php";
class GetAppointment extends SQLCmd{
    private $date,$email;

    function __construct($date,$email) {
        $this->date = $date;
        $this->email = $email;
    }

    function queryDB(){
        $query = "SELECT date,start,end,type 
                  FROM ma_appointments a,ma_user u 
                  WHERE a.studentUserId=u.userId 
                  AND u.email='$this->email' 
                  AND date >='$this->date' 
                  ORDER BY date,start LIMIT 1";
        $this->result = $this->conn->query($query)->fetch_assoc();
    }

    function processResult(){
        include_once dirname(dirname(__FILE__)) . "/bean/Appointment.php";
        $set = new Appointment();
        $rs = $this->result;
        $set->setAdvisingDate($rs["date"]);
        $set->setAdvisingStartTime($rs["start"]);
        $set->setAdvisingEndTime($rs["end"]);
        $set->setAppointmentType($rs["type"]);

        return $set;
    }
}
