<?php
include_once dirname(__FILE__) . "/SQLCmd.php";
class GetAppointmentById extends SQLCmd
{
    private $id;

    public function __construct($appointmentId) {
        $this->id = $appointmentId;
    }

    function queryDB()
    {
        $query = "SELECT ma_appointments.*, ma_user_advisor.pName AS pName, ma_user.email AS email
                  FROM ma_appointments,ma_user_advisor,ma_user
                  WHERE id=$this->id 
                  AND ma_user_advisor.userId = ma_appointments.advisorUserId 
                  AND ma_user.userId = ma_appointments.advisorUserId";

        $this->result = $this->conn->query($query)->fetch_assoc();
    }

    function processResult()
    {
        $rs = $this->result;
        if ($rs != null) {
            $set = new Appointment();
            $set->setAppointmentId($rs['id']);
            $set->setAdvisorUserId($rs['advisorUserId']);
            $set->setStudentUserId($rs['studentUserId']);
            $set->setAdvisingDate($rs["date"]);
            $set->setAdvisingStartTime($rs["start"]);
            $set->setAdvisingEndTime($rs["end"]);
            $set->setAppointmentType($rs["type"]);
            $set->setDescription($rs['description']);
            $set->setStudentId($rs['studentId']);
            $set->setStudentEmail($rs['studentEmail']);
            $set->setStudentPhoneNumber($rs['studentCell']);

            $set->setPname($rs["pName"]);
            $set->setAdvisorEmail($rs['email']);

            return $set;
        }

        return $rs;




    }
}