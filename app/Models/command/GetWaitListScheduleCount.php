<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/3/28
 * Time: 12:07
 */

namespace Models\Command;


class GetWaitListScheduleCount extends SQLCmd
{
    private $appointment_id;

    function __construct($appointment_id) {
        $this->appointment_id = $appointment_id;
    }

    function queryDB(){
        $query = "SELECT COUNT(*) FROM ma_wait_list_schedule 
                    where aptId = '$this->appointment_id'";
        $this->result = $this->conn->query($query)->fetch_assoc();
    }

    function processResult(){
        return $this->result['COUNT(*)'];
    }
}