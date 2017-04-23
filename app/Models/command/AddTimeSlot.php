<?php

/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/2/14
 * Time: 14:59
 */
include_once dirname(__FILE__) . "/SQLCmd.php";
include_once dirname(dirname(__FILE__) ). "/helper/TimeSlotHelper.php";

class AddTimeSlot extends SQLCmd {
    private $time,$id,$helper,$timeSlot;

    function __construct(AllocateTime $time, $id) {
        $this->time = $time;
        $this->id = $id;
        $this->helper = new TimeSlotHelper();
        $this->timeSlot = $this->helper->count($time->getStartTime(),$time->getEndTime());
    }

    function queryDB(){
        $date = $this->time->getDate();
        $start = $this->time->getStartTime();
        $end = $this->time->getEndTime();

        $query = "SELECT COUNT(*) FROM  ma_advising_schedule 
                  WHERE date='$date' 
                  AND start >='$start' 
                  AND end <='$end' 
                  AND userId='$this->id'";
        $res = ($this->conn->query($query)->fetch_assoc());

        if($res['COUNT(*)'] == "0") {
            $date = $this->time->getDate();

            for($i = 0; $i < count($this->timeSlot); $i++) {
                $start = $this->timeSlot[$i]['start'];
                $end = $this->timeSlot[$i]['end'];

                $query = "INSERT INTO ma_advising_schedule 
                          (date,start,end,studentId,userId) 
                          VALUES('$date','$start','$end',null,'$this->id')";
                $this->result = $this->conn->query($query);
            }
        }else
            $this->result = false;
    }

    function processResult(){
        return $this->result;
    }
}