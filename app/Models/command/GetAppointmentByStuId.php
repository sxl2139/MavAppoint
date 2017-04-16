<?php
/**
 * Created by PhpStorm.
 * User: gaolin
 * Date: 2/27/17
 * Time: 6:54 AM
 */

namespace Models\Command;
use Models\bean\Appointment;

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
        while($rs = mysqli_fetch_array($this->result)){
            $set = new Appointment();
            $set->setAppointmentId($rs["id"]);
            $set->setAdvisingDate($rs["date"]);
            $set->setAdvisingStartTime($rs["start"]);
            $set->setAdvisingEndTime($rs["end"]);
            $set->setAppointmentType($rs["type"]);
            $set->setStudentEmail($rs["studentEmail"]);
            array_push($arr, $set);
        }

        return $arr;
    }

}