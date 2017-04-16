<?php
namespace Models\Command;
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/2/21
 * Time: 14:33
 */
use Models\Bean\AllocateTime;
class DeleteTimeSlot extends SQLCmd{
    private $time;

    function __construct(AllocateTime $time) {
        $this->time = $time;

    }

    function queryDB(){
        $date = $this->time->getDate();
        $start = $this->time->getStartTime();
        $end = $this->time->getEndTime();
        $pName = $this->time->getEmail();// 'email' of the AllocateTime object stored pname

        $query = "DELETE Schedule 
                  FROM ma_advising_schedule Schedule 
                  JOIN ma_user_advisor Advisor 
                  ON Schedule.userid=Advisor.userid 
                  WHERE date='$date' 
                  AND start >='$start' 
                  AND end <='$end' 
                  AND Advisor.pName='$pName'";

        $this->result = $this->conn->query($query);
    }

    function processResult(){
        return $this->result;
    }
}