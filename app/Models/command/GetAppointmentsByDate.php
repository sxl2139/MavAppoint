<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/4/10
 * Time: 17:08
 */
include_once dirname(__FILE__) . "/SQLCmd.php";
class GetAppointmentsByDate extends SQLCmd
{

    private $start,$end;

    function __construct($start, $end) {
        $this->start = $start;
        $this->end = $end;
    }

    function queryDB(){
        $query = "SELECT * FROM ma_appointments WHERE date >='$this->start' 
                  and date <= '$this->end' ORDER BY date";
        $this->result          = $this->conn->query($query);
    }

    function processResult(){
        include_once ROOT . "/app/Models/bean/Appointment.php";
        $arr = array();
        while($rs = mysqli_fetch_row($this->result)){
            $set = new Appointment();

            $set->setAppointmentId($rs[0]);
            $set->setAdvisorUserId($rs[1]);
            $set->setStudentUserId($rs[2]);
            $set->setAdvisingDate($rs[3]);
            $set->setAdvisingStartTime($rs[4]);
            $set->setAdvisingEndTime($rs[5]);
            $set->setAppointmentType($rs[6]);
            $set->setDescription($rs[7]);
            $set->setStudentId($rs[8]);
            $set->setStudentEmail($rs[9]);
            $set->setStudentPhoneNumber($rs[10]);

            $set->setPname($rs[11]);
            $set->setAdvisorEmail($rs[12]);
            array_push($arr, $set);
        }

        return $arr;
    }
}