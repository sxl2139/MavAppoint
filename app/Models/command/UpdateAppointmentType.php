<?php

/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/6/26
 * Time: 16:01
 */
include_once dirname(__FILE__) . "/SQLCmd.php";
include_once dirname(dirname(__FILE__)) . "/bean/AppointmentType.php";
class UpdateAppointmentType extends SQLCmd{
    private $at,$id;

    function __construct($id,AppointmentType $at) {
        $this->at = $at;
        $this->id = $id;
    }

    function queryDB(){
        $duration = $this->at->getDuration();

        $query = "UPDATE ma_appointment_types 
                SET duration='$duration'
                WHERE userId = '$this->id'";
        $this->result = $this->conn->query($query);
    }

    function processResult(){
        if ($this->conn->affected_rows > 0)
            return true;
        else
            return false;
    }
}