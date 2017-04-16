<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/3/28
 * Time: 11:58
 */

namespace Models\Command;


use Models\Bean\WaitList;

class SetWaitListSchedule extends SQLCmd
{
    private $apt;

    function __construct(WaitList $apt)
    {
        $this->apt = $apt;
    }

    function queryDB()
    {
        $appointment_id = $this->apt->getAppointmentId();
        $student_id = $this->apt->getStudentId();
        $student_user_id = $this->apt->getStudentUserId();
        $type = $this->apt->getType();
        $description = $this->apt->getDescription();
        $student_email = $this->apt->getStudentEmail();
        $student_cell = $this->apt->getStudentPhone();

        $query = "SELECT COUNT(*) 
                  FROM ma_wait_list_schedule 
                  where aptId ='$appointment_id' 
                  AND studentId ='$student_id'";
        $count = $this->conn->query($query)->fetch_assoc()['COUNT(*)'];

        if ($count == 0) {
            $query = "INSERT INTO ma_wait_list_schedule 
                      (aptId,studentUserId,studentId,type,description,studentEmail,studentCell)
                      VALUES ('$appointment_id','$student_user_id','$student_id','$type','$description',
                      '$student_email','$student_cell')";
            $this->conn->query($query);

            if($this->conn->affected_rows > 0)
                $this->result = true;
            else
                $this->result = false;
        }else
            $this->result = false;
    }

    function processResult()
    {
        return $this->result;
    }
}