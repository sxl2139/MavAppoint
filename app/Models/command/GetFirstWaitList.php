<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/3/28
 * Time: 12:14
 */
include_once dirname(__FILE__) . "/SQLCmd.php";
class GetFirstWaitList extends SQLCmd
{
    private $appointment_id;

    function __construct($appointment_id) {
        $this->appointment_id = $appointment_id;
    }

    function queryDB(){
        $query = "SELECT * FROM ma_wait_list_schedule 
                  WHERE aptId = '$this->appointment_id' order by id asc limit 1";
        $this->result = $this->conn->query($query)->fetch_assoc();
    }

    function processResult(){
        if ($this->result){
            $wl = new WaitList();
            $wl->setId($this->result['id']);
            $wl->setAppointmentId($this->result['aptId']);
            $wl->setStudentId($this->result['studentId']);
            $wl->setStudentUserId($this->result['studentUserId']);
            $wl->setType($this->result['aptType']);
            $wl->setDescription($this->result['description']);
            $wl->setStudentEmail($this->result['studentEmail']);
            $wl->setStudentPhone($this->result['studentCell']);
            return $wl;
        }

        return null;
    }
}