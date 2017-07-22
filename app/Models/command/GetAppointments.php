<?php
include_once dirname(__FILE__) . "/SQLCmd.php";
include_once dirname(dirname(__FILE__)) . "/login/LoginUser.php";
include_once dirname(dirname(__FILE__)) . "/login/StudentUser.php";
include_once dirname(dirname(__FILE__)) . "/login/AdvisorUser.php";

class GetAppointments extends SQLCmd{
    private $user;

    function __construct(LoginUser $user) {
        $this->user = $user;
    }

    function queryDB(){
        $email = $this->user->getEmail();
        $id = $this->user->getUserId();

        if($this->user instanceof AdvisorUser){
            $query = "SELECT ma_appointments.*, ma_user_advisor.pName AS pName, ma_user.email AS email
                      FROM ma_appointments,ma_user_advisor,ma_user
                      WHERE ma_user.email= '$email' 
                      AND ma_user_advisor.userId = ma_appointments.advisorUserId 
                      AND ma_user.userId = ma_appointments.advisorUserId";
        }else if($this->user instanceof StudentUser){
            $query = "SELECT ma_appointments.*, ma_user_advisor.pName AS pName, ma_user.email AS email
                      FROM ma_appointments,ma_user_advisor,ma_user
                      WHERE ma_appointments.studentEmail= '$email' 
                      AND ma_user_advisor.userId = ma_appointments.advisorUserId 
                      AND ma_user.userId = ma_appointments.advisorUserId";
        }else{
            $query = "select name from ma_department_user where userId = '$id'";

            $department = $this->conn->query($query)->fetch_assoc();
            $dep = $department['name'];

            $query = "SELECT ma_appointments.*,ma_user.email as email,ma_user_advisor.pName as pName
                      FROM ma_appointments,ma_department_user,ma_user,ma_user_advisor
                      WHERE ma_appointments.advisorUserId = ma_department_user.userId 
                      AND ma_appointments.advisorUserId = ma_user.userId
                      AND ma_appointments.advisorUserId = ma_user_advisor.userId
                      AND ma_department_user.name = '$dep'";
        }
        $this->result = $this->conn->query($query);
    }

    function processResult(){
        $arr = array();

        while($rs = mysqli_fetch_assoc($this->result)){
            include_once dirname(dirname(__FILE__)) . "/bean/Appointment.php";
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
            $set->setStatus($rs['status']);
            $set->setIsCanceledBy($rs['isCanceledBy']);
            $set->setRemark($rs['remark']);

            $set->setPname($rs["pName"]);
            $set->setAdvisorEmail($rs['email']);
            array_push($arr, $set);
        }

        return $arr;
    }
}