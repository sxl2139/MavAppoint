<?php
/**
 * Created by PhpStorm.
 * User: gaolin
 * Date: 2/27/17
 * Time: 6:54 AM
 */
include_once dirname(__FILE__) . "/SQLCmd.php";
class GetAppointmentByStuId extends SQLCmd
{
    private $studentId,$date;

    function __construct($stuId, $date) {
        $this->studentId = $stuId;
        $this->date = $date;
    }

    function queryDB(){
        $query = "SELECT id,date,start,end,type,studentEmail 
                  FROM ma_appointments a 
                  WHERE a.studentId='$this->studentId' AND date ='$this->date' ";
        $this->result = $this->conn->query($query);
    }

    function processResult(){
        $arr = array();
        while($rs = mysqli_fetch_row($this->result)){
            $set = new Appointment();
            $set->setAppointmentId($rs[0]);
            $set->setAdvisingDate($rs[1]);
            $set->setAdvisingStartTime($rs[2]);
            $set->setAdvisingEndTime($rs[3]);
            $set->setAppointmentType($rs[4]);
            $set->setStudentEmail($rs[5]);
            array_push($arr, $set);
        }

        return $arr;
    }

}