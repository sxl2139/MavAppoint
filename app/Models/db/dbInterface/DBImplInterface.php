<?php

interface DBImplInterface
{
    /*User method*/
    function createUser($user);
    function updateUser($user);
    function checkUser($set);
    function getUserIdByEmail($email);
    function updatePassword($email,$password,$time);

    function setCutOffTime($id,$time);
    function createAppointment($a, $email);
    function updateAppointment($a);
    function cancelAppointment($id);
    function getAppointment($d,$e);
    function getAppointments($user);
    function getAppointmentsByDate($start, $end);

    function addAppointmentType($userId,$type);
    function getAppointmentTypes($pName);
    function deleteAppointmentType($userId,$type);

    function createAdvisor($user);
    function getAdvisor($email);
    function getAdvisors();

    function getAdvisorsOfDepartment($department);
    function getAdvisorSchedule($name);
    function getAdvisorSchedules(array $advisorUsers);
    function getAdvisorWaitlistSchedules(array $advisorUsers);
    function deleteAdvisor($id);
    function addNewDepartment($name);
    function setTemporaryPasswordInterval($time);
    function getTemporaryPasswordInterval();
    function updateNotification($user,$notification);

    function createStudent($user);
    function getStudent($email);

    function getAdmin($email);
    function getFaculty($email);

    function addTimeSlot($at, $id);
    function deleteTimeSlot($at);

    function getDepartment($id);
    function getDepartments();
    function getMajorsOfDepartment($name);
    function getMajor($id);

    function getCSEUser($pName);
    function getCSEStudent($studentId);
    function getCSEStudentByNetId($netId);

    function getStudentEmails();

    function getWaitListScheduleCount($aptId);
    function getStudentWaitList($userId, $aptId);
    function getFirstWaitList($aptId);
    function setWaitListSchedule($waitList);
    function addFeedback($feedback);
    function getFeedback($uid, $role);
    function getUserById($uid);
    function updateFeedback($fid);
}
