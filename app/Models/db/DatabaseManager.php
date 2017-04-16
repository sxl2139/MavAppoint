<?php
namespace Models\Db;

use Models\Bean as bean;
use Models\Login as login;
use Models\TimeSlotComponent;

class DatabaseManager{
    private $impl;

    function __construct() {
        $this->impl = new RDBImpl();
    }

    /**
     * @param int $aptId
     * @return bean\WaitList
     */
    function getFirstWaitList($aptId){
        return $this->impl->getFirstWaitList($aptId);
    }

    function getStudentWaitList($userId, $aptId){
        return $this->impl->getStudentWaitList($userId,$aptId);
    }

    function getWaitListScheduleCount($aptId){
        return $this->impl->getWaitListScheduleCount($aptId);
    }

    function setWaitListSchedule(bean\WaitList $waitList){
        return $this->impl->setWaitListSchedule($waitList);
    }

    function getStudentEmails(){
        return $this->impl->getStudentEmails();
    }

    function getCSEUser($pName){
        return $this->impl->getCSEUser($pName);
    }

    function getCSEStudent($studentId){
        return $this->impl->getCSEStudent($studentId);
    }

    /**
     * @param string $netId
     * @return login\CSEStudent
     */
    public function getCSEStudentByNetId($netId) {
        return $this->impl->getCSEStudentByNetId($netId);
    }

    function setCutOffTime($id, $time){
        return $this->impl->setCutOffTime($id,$time);
    }

    function addAppointmentType($userId, bean\AppointmentType $at){
       return $this->impl->addAppointmentType($userId,$at);
    }

    function createAppointment(bean\Appointment $apt, $email){
        return $this->impl->createAppointment($apt, $email);
    }

    function addTimeSlot(bean\AllocateTime $time, $id){
        return $this->impl->addTimeSlot($time, $id);
    }

    function deleteTimeSlot(bean\AllocateTime $time){
        return $this->impl->deleteTimeSlot($time);
    }

    function cancelAppointment($id){
        return $this->impl->cancelAppointment($id);
    }

    function createAdvisor(login\AdvisorUser $advisorUser){
        return $this->impl->createAdvisor($advisorUser);
    }

    function createUser(login\LoginUser $loginUser){
        return $this->impl->createUser($loginUser);
    }

    function createStudent(login\StudentUser $user){
        return $this->impl->createStudent($user);
    }

    function checkUser(bean\GetSet $set){
        return $this->impl->checkUser($set);
    }

    function deleteAppointmentType($userId, bean\AppointmentType $at){
        return $this->impl->deleteAppointmentType($userId,$at);
    }

    function deleteAdvisor($id){
        return $this->impl->deleteAdvisor($id);
    }

    function getUserIdByEmail($email){
        return $this->impl->getUserIdByEmail($email);
    }

    /**
     * @param $email
     * @return login\AdvisorUser
     */
    function getAdvisor($email){
        return $this->impl->getAdvisor($email);
    }

    function getAdvisors(){
        return $this->impl->getAdvisors();
    }

    /**
     * @param $dep
     * @return login\AdvisorUser[]
     */
    function getAdvisorsOfDepartment($dep){
        return $this->impl->getAdvisorsOfDepartment($dep);
    }

    /**
     * @param string $email
     * @return login\StudentUser
     */
    function getStudent($email){
        return $this->impl->getStudent($email);
    }

    function getAdmin($email){
        return $this->impl->getAdmin($email);
    }

    function getFaculty($email){
        return $this->impl->getFaculty($email);
    }

    function getAdvisorSchedule($name ,$includeReserved = false, $date=null ){
        return$this->impl->getAdvisorSchedule($name,$includeReserved,$date);
    }

    function getAdvisorSchedules(array $advisorUsers){
        return $this->impl->getAdvisorSchedules($advisorUsers);
    }

    function getAdvisorWaitlistSchedules(array $advisorUsers){
        return $this->impl->getAdvisorWaitlistSchedules($advisorUsers);
    }

    function getMajor($id){
        return $this->impl->getMajor($id);
    }

    function getDepartment($id = null){
        return $this->impl->getDepartment($id);
    }

    function getMajorsOfDepartment($name){
        return $this->impl->getMajorsOfDepartment($name);
    }
    
    function getMajorsByUserId($userId){
        return $this->impl->getMajorsByUserId($userId);
    }

    function getAppointment($date,$email){
        return $this->impl->getAppointment($date,$email);
    }

    function getAppointmentByStuId($id,$date){
        return $this->impl->getAppointmentByStuId($id,$date);
    }

    /**
     * @param $id
     * @return bean\Appointment
     */
    function getAppointmentById($id) {
        return $this->impl->getAppointmentById($id);
    }

    /**
     * @param login\LoginUser $user
     * @return bean\Appointment[]
     */
    function getAppointments(login\LoginUser $user){
        return $this->impl->getAppointments($user);
    }

    function getAppointmentsByDate($start, $end) {
        return $this->impl->getappointmentsByDate($start, $end);
    }

    /**
     * @param $pName
     * @return bean\AppointmentType[]
     */
    function getAppointmentTypes($pName){
        return $this->impl->getAppointmentTypes($pName);
    }

    function updateUser(login\LoginUser $user){
        return $this->impl->updateUser($user);
    }

    function updatePassword($email,$password){
        return $this->impl->updatePassword($email,$password);
    }

    function updateAppointment(bean\Appointment $apt){
        return $this->impl->updateAppointment($apt);
    }

    function updateAdvisor(login\AdvisorUser $user){
        return $this->impl->updateAdvisor($user);
    }

    function updateUserNotification(login\LoginUser $user,$notification){
        return $this->impl->updateNotification($user,$notification);
    }

    public function deleteWaitListSchedule($id) {
        return $this->impl->deleteWaitListSchedule($id);
    }
}