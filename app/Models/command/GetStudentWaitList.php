<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/4/11
 * Time: 0:17
 */
include_once dirname(__FILE__) . "/SQLCmd.php";
class GetStudentWaitList extends SQLCmd
{
    private $user_id,$appointment_id;

    function __construct($user_id, $appointment_id) {
        $this->appointment_id = $appointment_id;
        $this->user_id = $user_id;
    }

    function queryDB(){
        $query = "SELECT * FROM ma_wait_list_schedule 
                  WHERE aptId = '$this->appointment_id' 
                  AND studentUserId = '$this->user_id' limit 1";
        $this->result = $this->conn->query($query);
    }

    function processResult(){
        if ($rs = mysqli_fetch_array($this->result)){
            $apt = new WaitList();
            $apt->setId($rs['id']);
            $apt->setAppointmentId($rs['aptId']);
            $apt->setStudentId($rs['studentId']);
            $apt->setStudentUserId($rs['studentUserId']);
            $apt->setType($rs['aptType']);
            $apt->setDescription($rs['description']);
            $apt->setStudentEmail($rs['studentEmail']);
            $apt->setStudentPhone($rs['studentCell']);
            return $apt;
        }

        return null;
    }
}