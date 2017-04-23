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
        include_once dirname(dirname(__FILE__)) . "/bean/Appointment.php";
        $arr = array();
        while($rs = mysqli_fetch_assoc($this->result)){
            $set = new Appointment();
            $set->setAppointmentId($rs['id']);
            $set->setAdvisorUserId($rs['advisorUserId']);
            $set->setStudentUserId($rs['studentUserId']);

            $set->setAdvisingDate($rs["date"]);
            $set->setAdvisingStartTime($rs["start"]);
            $set->setAdvisingEndTime($rs["end"]);

            $set->setAppointmentType($rs["type"]);
            $set->setDescription($rs['description']);

            $set->setStudentId($rs['studentId']);
            $set->setStudentEmail($rs['student_email']);
            $set->setStudentPhoneNumber($rs['student_cell']);

            array_push($arr, $set);
        }

        return $arr;
    }
}