<?php
namespace Models\Db;

use Models\CompositeTimeSlot;
use Models\Db\DbInterface\DBImplInterface;
use Models\Bean as Bean;
use Models\Login as Login;
use Models\Command as Command;
use Models\PrimitiveTimeSlot as PrimitiveTimeSlot;
use Models\Helper as Helper;

class RDBImpl implements DBImplInterface{

    function setWaitListSchedule(Bean\WaitList $waitList)
    {
        $cmd = new Command\SetWaitListSchedule($waitList);
        return $cmd->execute();
    }

    function getStudentWaitList($userId, $aptId)
    {
        $cmd = new Command\GetStudentWaitList($userId, $aptId);
        return $cmd->execute();
    }

    function getFirstWaitList($aptId)
    {
        $cmd = new Command\GetFirstWaitList($aptId);
        return $cmd->execute();
    }

    function getWaitListScheduleCount($aptId)
    {
        $cmd = new Command\GetWaitListScheduleCount($aptId);
        return $cmd->execute();
    }

    function getStudentEmails()
    {
        $cmd = new Command\GetStudentEmails();
        return $cmd->execute();
    }

    function setCutOffTime($id, $time)
    {
        $cmd = new Command\SetCutOffTime($id, $time);
        return $cmd->execute();
    }

    function createAppointment(Bean\Appointment $a, $email)
    {
        $cmd = new Command\CreateAppointment($a, $email);
        return $cmd->execute();
    }

    function updateAppointment(Bean\Appointment $a)
    {
        $cmd = new Command\UpdateAppointment($a);
        return $cmd->execute();
    }

    function getAppointment($d, $e)
    {
        $cmd = new Command\GetAppointment($d, $e);
        return $cmd->execute();
    }

    function getAppointmentsByDate($start, $end)
    {
        $cmd = new Command\GetAppointmentsByDate($start, $end);
        return $cmd->execute();
    }

    function cancelAppointment($id)
    {
        $cmd = new Command\CancelAppointment($id);
        return $cmd->execute();
    }

    function getAppointmentByStuId($id,$date)
    {
        $cmd = new Command\GetAppointmentByStuId($id,$date);
        return $cmd->execute();
    }

    function getAppointmentById($id){
        $cmd = new Command\GetAppointmentById($id);
        return $cmd->execute();
    }

    function getAppointments($user)
    {
        $cmd = new Command\GetAppointments($user);
        return $cmd->execute();
    }

    function addAppointmentType($userId, Bean\AppointmentType $type)
    {
        $cmd = new Command\AddAppointmentType($userId,$type);
        return $cmd->execute();
    }

    function getAppointmentTypes($pName)
    {
        $cmd = new Command\GetAppointmentTypes($pName);
        return $cmd->execute();
    }

    function deleteAppointmentType($userId, Bean\AppointmentType $type)
    {
        $cmd = new Command\DeleteAppointmentType($userId,$type);
        return $cmd->execute();
    }

    function createUser(Login\LoginUser $user)
    {
        $cmd = new Command\CreateUser($user);
        return $cmd->execute();
    }

    function updateUser(Login\LoginUser $user)
    {
        $cmd = new Command\UpdateUser($user);
        return $cmd->execute();
    }

    function checkUser(Bean\GetSet $set)
    {
        $cmd = new Command\CheckUser($set);
        return $cmd->execute();
    }

    function getUserIdByEmail($email){
        $cmd = new Command\GetUserIdByEmail($email);
        return $cmd->execute();
    }

    function updatePassword($email, $password)
    {
        $cmd = new Command\UpdatePassword($email,$password);
        return $cmd->execute();
    }

    function createAdvisor(Login\AdvisorUser $user)
    {
        $cmd = new Command\CreateAdvisor($user);
        return $cmd->execute();
    }

    function updateAdvisor(Login\AdvisorUser $advisorUser)
    {
        $cmd = new Command\UpdateAdvisor($advisorUser);
        return $cmd->execute();
    }

    function getAdvisor($email)
    {
        $cmd = new Command\GetAdvisor($email);
        return $cmd->execute();
    }

    function getAdvisors()
    {
        $cmd = new Command\GetAdvisors();
        return $cmd->execute();
    }

    function getAdvisorsOfDepartment($department)
    {
        $cmd = new Command\GetAdvisorsOfDepartment($department);
        return $cmd->execute();
    }

    /**
     * @param $name : one specific adviser's name or "all"
     * @param bool $includeReserved : true means include reserved time slots, false means just include available time slots.
     * @param null $date
     * @return array : adviser(s)'s schedule
     */
    function getAdvisorSchedule($name,$includeReserved = false, $date=null)
    {
        $PrimitiveTimeSlotArr = array();
        $adviserSchedule = array();
        try {
            $conn = new \mysqli( env("DB_HOST"),env("DB_USERNAME"),env("DB_PASSWORD"),env("DB_DATABASE"));
            if($includeReserved == true && $date!=null){
                // get one specific adviser's all time slots(include reserved).
                $command = "SELECT pName,date,start,end,id 
                            FROM ma_user,ma_advising_schedule,ma_user_advisor 
                            WHERE ma_user.userId=ma_user_advisor.userId 
                            AND ma_user.userId=ma_advising_schedule.userId 
                            AND ma_user.userId=ma_advising_schedule.userId 
                            AND ma_user_advisor.pName='$name'";

            }else{
                if ($name === "all" && $includeReserved==false) {
                    //get all advisers' available time slots.
                    $command = "SELECT pName,date,start,end,id 
                                FROM ma_user,ma_advising_schedule,ma_user_advisor 
                                WHERE ma_user.userId=ma_user_advisor.userId 
                                AND ma_user.userId=ma_advising_schedule.userId 
                                AND studentId is null";
                } else {
                    //get one specific adviser's available time slots
                    $command = "SELECT pName,date,start,end,id 
                                FROM ma_user,ma_advising_schedule,ma_user_advisor 
                                WHERE ma_user.userId=ma_user_advisor.userId 
                                AND ma_user.userId=ma_advising_schedule.userId 
                                AND ma_user.userId=ma_advising_schedule.userId 
                                AND ma_user_advisor.pName='$name' 
                                AND studentId is null";
                }

            }



            $res = $conn->query($command);

            while ($rs = mysqli_fetch_assoc($res)) {
                $set = new PrimitiveTimeSlot();
                $set->setName($rs["pName"]);
                $set->setDate($rs["date"]);
                $set->setStartTime($rs["start"]);
                $set->setEndTime($rs["end"]);
                $set->setUniqueId($rs["id"]);
                array_push($PrimitiveTimeSlotArr, serialize($set));
            }

            $compositeTimeSlotArr = Helper\TimeSlotHelper::createCompositeTimeSlot($PrimitiveTimeSlotArr);


            if($date!=null){
                for ($i = 0; $i < sizeof($compositeTimeSlotArr); $i++) {
                    $scheduleObject = unserialize($compositeTimeSlotArr[$i]);
                    $startDate = $scheduleObject->getDate();
                    if($startDate==$date)
                    {
                        array_push($adviserSchedule,$scheduleObject);

                    }
                }

            }
            else{
                for ($i = 0; $i < sizeof($compositeTimeSlotArr); $i++) {
                    $scheduleObject = unserialize($compositeTimeSlotArr[$i]);
                    $startDate = $scheduleObject->getDate();
                    date_default_timezone_set('America/Chicago');
                    $todayDate = date("Y-m-d");
                    if($startDate>$todayDate)
                    {
                        array_push($adviserSchedule,$scheduleObject);

                    }
                }

            }

            $conn->close();

        } catch (\Exception $e) {

        }
        return $adviserSchedule;
    }

    function getAdvisorSchedules(array $advisorUsers)
    {
        $cmd = new Command\GetAdvisorSchedules($advisorUsers,true);
        return $cmd->execute();
    }

    function getAdvisorWaitlistSchedules(array $advisorUsers)
    {
        $cmd = new Command\GetAdvisorSchedules($advisorUsers,false);
        return $cmd->execute();
    }

    function deleteAdvisor($id)
    {
        $cmd = new Command\DeleteAdvisor($id);
        return $cmd->execute();
    }

    function updateNotification($user, $notification)
    {
        $cmd = new Command\UpdateNotification($user,$notification);
        return $cmd->execute();
    }

    function createStudent(Login\StudentUser $user)
    {
        $cmd = new Command\CreateStudent($user);
        return $cmd->execute();
    }

    function getStudent($email)
    {
        $cmd = new Command\GetStudent($email);

        return $cmd->execute();
    }

    function getAdmin($email)
    {
//        include_once dirname(dirname(__FILE__)) . "/Command/GetAdmin.php";
        $cmd = new Command\GetAdmin($email);
        return $cmd->execute();
    }

    function getFaculty($email)
    {
//        include_once dirname(dirname(__FILE__)) . "/Command/GetAdmin.php";
        $cmd = new Command\GetAdmin($email);
        return $cmd->execute();
    }

    function createWaitlist(Bean\WaitList $list)
    {
    }

    function addTimeSlot(Bean\AllocateTime $at, $id)
    {
//        include_once dirname(dirname(__FILE__)) . "/Command/AddTimeSlot.php";
        $cmd = new Command\AddTimeSlot($at,$id);
        return $cmd->execute();
    }

    function deleteTimeSlot(Bean\AllocateTime $at)
    {
//        include_once dirname(dirname(__FILE__)) . "/Command/DeleteTimeSlot.php";
        $cmd = new Command\DeleteTimeSlot($at);
        return $cmd->execute();
    }

    function updateCutOffTime(Login\AdvisorUser $user, $time)
    {
    }

    function getDepartment($id)
    {
//        include_once dirname(dirname(__FILE__)) . "/Command/GetDepartment.php";
        $cmd = new Command\GetDepartment($id);
        return $cmd->execute();
    }

    function getMajorsOfDepartment($name)
    {
//        include_once dirname(dirname(__FILE__)) . "/Command/GetMajorsOfDepartment.php";
        $cmd = new Command\GetMajorsOfDepartment($name);
        return $cmd->execute();
    }

    function getMajor($id)
    {
        $cmd = new Command\GetMajor($id);
        return $cmd->execute();
    }

    function getMajorsByUserId($userId){
        $cmd = new Command\GetMajorsByUserId($userId);
        return $cmd->execute();
    }

    function getCSEUser($pName){
        $cmd = new Command\GetCSEUser($pName);
        return $cmd->execute();
    }

    function getCSEStudent($studentId){
        $cmd = new Command\GetCSEStudent($studentId);
        return $cmd->execute();
    }

    public function getCSEStudentByNetId($netId)
    {
        $cmd = new Command\GetCSEStudentByNetId($netId);
        return $cmd->execute();
    }

    public function deleteWaitListSchedule($id) {
        $cmd = new Command\DeleteWaitListSchedule($id);
        return $cmd->execute();
    }
}