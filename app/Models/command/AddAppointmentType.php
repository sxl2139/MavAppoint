<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/2/14
 * Time: 6:17
 */
include_once dirname(__FILE__) . "/SQLCmd.php";
include_once dirname(dirname(__FILE__)) . "/bean/AppointmentType.php";

class AddAppointmentType extends SQLCmd
{

    private $at, $id;

    public function __construct($id, AppointmentType $at)
    {
        $this->at = $at;
        $this->id = $id;


    }

    function queryDB()
    {
        if ($this->at != null && $this->at->getDuration() > 0) {
            $type = $this->at->getType();
            $duration = $this->at->getDuration();

            $query = "INSERT INTO ma_appointment_types 
                      (userId, type, duration) 
                      VALUES('$this->id','$type','$duration')";
            $this->conn->query($query);

            if (mysqli_affected_rows($this->conn) > 0) {
                $this->result = true;
            }else {
                $this->result = false;
            }
        } else {
            $this->result = false;
        }
    }

    function processResult()
    {
        return $this->result;
    }
}