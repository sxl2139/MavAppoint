<?php
include_once dirname(__FILE__) . "/dbInterface/DBImplInterface.php";

class RDBImpl implements DBImplInterface
{

    function setWaitListSchedule($waitList)
    {
        include_once dirname(dirname(__FILE__)) . "/command/SetWaitListSchedule.php";
        $cmd = new SetWaitListSchedule($waitList);
        return $cmd->execute();
    }

    function getStudentWaitList($userId, $aptId)
    {
        include_once dirname(dirname(__FILE__)) . "/command/GetStudentWaitList.php";
        $cmd = new GetStudentWaitList($userId, $aptId);
        return $cmd->execute();
    }

    function getFirstWaitList($aptId)
    {
        include_once dirname(dirname(__FILE__)) . "/command/GetFirstWaitList.php";
        $cmd = new GetFirstWaitList($aptId);
        return $cmd->execute();
    }

    function getWaitListScheduleCount($aptId)
    {
        include_once dirname(dirname(__FILE__)) . "/command/GetWaitListScheduleCount.php";
        $cmd = new GetWaitListScheduleCount($aptId);
        return $cmd->execute();
    }

    function getStudentEmails()
    {
        include_once dirname(dirname(__FILE__)) . "/command/GetStudentEmails.php";
        $cmd = new GetStudentEmails();
        return $cmd->execute();
    }

    function setCutOffTime($id, $time)
    {
        include_once dirname(dirname(__FILE__)) . "/command/SetCutOffTime.php";
        $cmd = new SetCutOffTime($id, $time);
        return $cmd->execute();
    }

    function createAppointment($a, $email)
    {
        include_once dirname(dirname(__FILE__)) . "/command/CreateAppointment.php";
        $cmd = new CreateAppointment($a, $email);
        return $cmd->execute();
    }

    function updateAppointment($a)
    {
        include_once dirname(dirname(__FILE__)) . "/command/UpdateAppointment.php";
        $cmd = new UpdateAppointment($a);
        return $cmd->execute();
    }

    function getAppointment($d, $e)
    {
        include_once dirname(dirname(__FILE__)) . "/command/GetAppointment.php";
        $cmd = new GetAppointment($d, $e);
        return $cmd->execute();
    }

    function getAppointmentsByDate($start, $end)
    {
        include_once dirname(dirname(__FILE__)) . "/command/GetAppointmentsByDate.php";
        $cmd = new GetAppointmentsByDate($start, $end);
        return $cmd->execute();
    }

    function cancelAppointment($id)
    {
        include_once dirname(dirname(__FILE__)) . "/command/CancelAppointment.php";
        $cmd = new CancelAppointment($id);
        return $cmd->execute();
    }

    function getAppointmentByStuId($id, $date)
    {
        include_once dirname(dirname(__FILE__)) . "/command/GetAppointmentByStuId.php";
        $cmd = new GetAppointmentByStuId($id, $date);
        return $cmd->execute();
    }

    function getAppointmentById($id)
    {
        include_once dirname(dirname(__FILE__)) . "/command/GetAppointmentById.php";
        $cmd = new GetAppointmentById($id);
        return $cmd->execute();
    }

    function getAppointments($user)
    {
        include_once dirname(dirname(__FILE__)) . "/command/GetAppointments.php";
        $cmd = new GetAppointments($user);
        return $cmd->execute();
    }

    function addAppointmentType($userId, $type)
    {
        include_once dirname(dirname(__FILE__)) . "/command/AddAppointmentType.php";
        $cmd = new AddAppointmentType($userId, $type);
        return $cmd->execute();
    }

    function updateAppointmentType($userId, $type)
    {
        include_once dirname(dirname(__FILE__)) . "/command/UpdateAppointmentType.php";
        $cmd = new UpdateAppointmentType($userId, $type);
        return $cmd->execute();
    }

    function getAppointmentTypes($pName)
    {
        include_once dirname(dirname(__FILE__)) . "/command/GetAppointmentTypes.php";
        $cmd = new GetAppointmentTypes($pName);
        return $cmd->execute();
    }

    function deleteAppointmentType($userId, $type)
    {
        include_once dirname(dirname(__FILE__)) . "/command/DeleteAppointmentType.php";
        $cmd = new DeleteAppointmentType($userId, $type);
        return $cmd->execute();
    }

    function createUser($user)
    {
        include_once dirname(dirname(__FILE__)) . "/command/CreateUser.php";
        $cmd = new CreateUser($user);
        return $cmd->execute();
    }

    function updateUser($user)
    {
        include_once dirname(dirname(__FILE__)) . "/command/UpdateUser.php";
        $cmd = new UpdateUser($user);
        return $cmd->execute();
    }

    function checkUser($set)
    {
        include_once dirname(dirname(__FILE__)) . "/command/CheckUser.php";
        $cmd = new CheckUser($set);
        return $cmd->execute();
    }

    function getUserIdByEmail($email)
    {
        include_once dirname(dirname(__FILE__)) . "/command/GetUserIdByEmail.php";
        $cmd = new GetUserIdByEmail($email);
        return $cmd->execute();
    }

    function updatePassword($email, $password)
    {
        include_once dirname(dirname(__FILE__)) . "/command/UpdatePassword.php";
        $cmd = new UpdatePassword($email, $password);
        return $cmd->execute();
    }

    function createAdvisor($user)
    {
        include_once dirname(dirname(__FILE__)) . "/command/CreateAdvisor.php";
        $cmd = new CreateAdvisor($user);
        return $cmd->execute();
    }

    function updateAdvisor(AdvisorUser $advisorUser)
    {
        include_once dirname(dirname(__FILE__)) . "/command/UpdateAdvisor.php";
        $cmd = new UpdateAdvisor($advisorUser);
        return $cmd->execute();
    }

    function getAdvisor($email)
    {
        include_once dirname(dirname(__FILE__)) . "/command/GetAdvisor.php";
        $cmd = new GetAdvisor($email);
        return $cmd->execute();
    }

    function getAdvisors()
    {
        include_once dirname(dirname(__FILE__)) . "/command/GetAdvisors.php";
        $cmd = new GetAdvisors();
        return $cmd->execute();
    }

    function getAdvisorsOfDepartment($department)
    {
        include_once dirname(dirname(__FILE__)) . "/command/GetAdvisorsOfDepartment.php";
        $cmd = new GetAdvisorsOfDepartment($department);
        return $cmd->execute();
    }

    /**
     * @param $name : one specific adviser's name or "all"
     * @param bool $includeReserved : true means include reserved time slots, false means just include available time slots.
     * @param null $date
     * @return array : adviser(s)'s schedule
     */
    function getAdvisorSchedule($name, $includeReserved = false, $date = null)
    {
        include_once dirname(dirname(__FILE__)) . "/command/GetAdvisorSchedule.php";
        $cmd = new GetAdvisorSchedule($name, $includeReserved, $date);
        return $cmd->execute();
    }

    function getAdvisorSchedules(array $advisorUsers)
    {
        include_once dirname(dirname(__FILE__)) . "/command/GetAdvisorSchedules.php";
        $cmd = new GetAdvisorSchedules($advisorUsers, true);
        return $cmd->execute();
    }

    function getAdvisorWaitlistSchedules(array $advisorUsers)
    {
        include_once dirname(dirname(__FILE__)) . "/command/GetAdvisorSchedules.php";
        $cmd = new GetAdvisorSchedules($advisorUsers, false);
        return $cmd->execute();
    }

    function deleteAdvisor($id)
    {
        include_once dirname(dirname(__FILE__)) . "/command/DeleteAdvisor.php";
        $cmd = new DeleteAdvisor($id);
        return $cmd->execute();
    }

    function addNewDepartment($name)
    {
        include_once dirname(dirname(__FILE__)) . "/command/addNewDepartment.php";
        $cmd = new AddNewDepartment($name);
        return $cmd->execute();
    }

    function updateNotification($user, $notification)
    {
        include_once dirname(dirname(__FILE__)) . "/command/UpdateNotification.php";
        $cmd = new UpdateNotification($user, $notification);
        return $cmd->execute();
    }

    function createStudent($user)
    {
        include_once dirname(dirname(__FILE__)) . "/command/CreateStudent.php";
        $cmd = new CreateStudent($user);
        return $cmd->execute();
    }

    function getStudent($email)
    {
        include_once dirname(dirname(__FILE__)) . "/command/GetStudent.php";
        $cmd = new GetStudent($email);
        return $cmd->execute();
    }

    function getAdmin($email)
    {
        include_once dirname(dirname(__FILE__)) . "/command/GetAdmin.php";
        $cmd = new GetAdmin($email);
        return $cmd->execute();
    }

    function getFaculty($email)
    {
        include_once dirname(dirname(__FILE__)) . "/command/GetAdmin.php";
        $cmd = new GetAdmin($email);
        return $cmd->execute();
    }

    function addTimeSlot($at, $id)
    {
        include_once dirname(dirname(__FILE__)) . "/command/AddTimeSlot.php";
        $cmd = new AddTimeSlot($at, $id);
        return $cmd->execute();
    }

    function deleteTimeSlot($at)
    {
        include_once dirname(dirname(__FILE__)) . "/command/DeleteTimeSlot.php";
        $cmd = new DeleteTimeSlot($at);
        return $cmd->execute();
    }

    function getDepartment($id)
    {
        include_once dirname(dirname(__FILE__)) . "/command/GetDepartment.php";
        $cmd = new GetDepartment($id);
        return $cmd->execute();
    }

    function getDepartments()
    {
        include_once dirname(dirname(__FILE__)) . "/command/GetDepartments.php";
        $cmd = new GetDepartments();
        return $cmd->execute();
    }

    function getMajorsOfDepartment($name)
    {
        include_once dirname(dirname(__FILE__)) . "/command/GetMajorsOfDepartment.php";
        $cmd = new GetMajorsOfDepartment($name);
        return $cmd->execute();
    }

    function getMajor($id)
    {
        include_once dirname(dirname(__FILE__)) . "/command/GetMajor.php";
        $cmd = new GetMajor($id);
        return $cmd->execute();
    }

    function getMajorsByUserId($userId)
    {
        include_once dirname(dirname(__FILE__)) . "/command/GetMajorsByUserId.php";
        $cmd = new GetMajorsByUserId($userId);
        return $cmd->execute();
    }

    function getCSEUser($pName)
    {
        include_once dirname(dirname(__FILE__)) . "/command/GetCSEUser.php";
        $cmd = new GetCSEUser($pName);
        return $cmd->execute();
    }

    function getCSEStudent($studentId)
    {
        include_once dirname(dirname(__FILE__)) . "/command/GetCSEStudent.php";
        $cmd = new GetCSEStudent($studentId);
        return $cmd->execute();
    }

    public function getCSEStudentByNetId($netId)
    {
        include_once dirname(dirname(__FILE__)) . "/command/GetCSEStudentByNetId.php";
        $cmd = new GetCSEStudentByNetId($netId);
        return $cmd->execute();
    }

    public function deleteWaitListSchedule($id)
    {
        include_once dirname(dirname(__FILE__)) . "/command/DeleteWaitListSchedule.php";
        $cmd = new DeleteWaitListSchedule($id);
        return $cmd->execute();
    }
}