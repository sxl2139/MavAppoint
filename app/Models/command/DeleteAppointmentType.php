<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/2/14
 * Time: 7:22
 */
include_once dirname(__FILE__) . "/SQLCmd.php";
include_once dirname(dirname(__FILE__)) . "/bean/AppointmentType.php";
class DeleteAppointmentType extends SQLCmd{
    private $at,$id;

    function __construct($id,AppointmentType $at) {
        $this->at = $at;
        $this->id = $id;
    }

    function queryDB(){
        $type = $this->at->getType();
        $duration = $this->at->getDuration();

        $query = "DELETE FROM ma_appointment_types WHERE userId = '$this->id' and type = '$type' and duration = '$duration'";
        $this->result = $this->conn->query($query);
    }

    function processResult(){
        if ($this->conn->affected_rows > 0)
            return true;
        else
            return false;
    }
}