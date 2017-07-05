<?php
include_once dirname(__FILE__) . "/RDBImpl.php";

class DatabaseManager{
    private $impl;

    function __construct() {
        $this->impl = new RDBImpl();
    }

    function getFirstWaitList($aptId){
        return $this->impl->getFirstWaitList($aptId);
    }

    function getStudentWaitList($userId, $aptId){
        return $this->impl->getStudentWaitList($userId,$aptId);
    }

    function getWaitListScheduleCount($aptId){
        return $this->impl->getWaitListScheduleCount($aptId);
    }

    function setWaitListSchedule($waitList){
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
     * @param $netId
     * @return CSEStudent
     */
    public function getCSEStudentByNetId($netId) {
        return $this->impl->getCSEStudentByNetId($netId);
    }

    function setCutOffTime($id, $time){
        return $this->impl->setCutOffTime($id,$time);
    }

    function addAppointmentType($userId,$at){
       return $this->impl->addAppointmentType($userId,$at);
    }

    function updateAppointmentType($userId,$at){
        return $this->impl->updateAppointmentType($userId,$at);
    }

    function createAppointment($apt, $email){
        return $this->impl->createAppointment($apt, $email);
    }

    function addTimeSlot($time, $id){
        return $this->impl->addTimeSlot($time, $id);
    }

    function deleteTimeSlot($time){
        return $this->impl->deleteTimeSlot($time);
    }

    function cancelAppointment($id){
        return $this->impl->cancelAppointment($id);
    }

    function createAdvisor($advisorUser){
        return $this->impl->createAdvisor($advisorUser);
    }

    function createUser($loginUser){
        return $this->impl->createUser($loginUser);
    }

    function createStudent($user){
        return $this->impl->createStudent($user);
    }

    function checkUser($set){
        return $this->impl->checkUser($set);
    }

    function deleteAppointmentType($userId,$at){
        return $this->impl->deleteAppointmentType($userId,$at);
    }

    function deleteAdvisor($id){
        return $this->impl->deleteAdvisor($id);
    }

    function addNewDepartment($name){
        return $this->impl->addNewDepartment($name);
    }

    function getUserIdByEmail($email){
        return $this->impl->getUserIdByEmail($email);
    }

    /**
     * @param $email
     * @return AdvisorUser
     */
    function getAdvisor($email){
        return $this->impl->getAdvisor($email);
    }

    function getAdvisors(){
        return $this->impl->getAdvisors();
    }

    function getDepartments(){
        return $this->impl->getDepartments();
    }

    /**
     * @param $dep
     * @return AdvisorUser[]
     */
    function getAdvisorsOfDepartment($dep){
        return $this->impl->getAdvisorsOfDepartment($dep);
    }

    /**
     * @param $email
     * @return StudentUser
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
     * @return Appointment
     */
    function getAppointmentById($id) {
        return $this->impl->getAppointmentById($id);
    }

    function getAppointments($user){
        return $this->impl->getAppointments($user);
    }

    function getAppointmentsByDate($start, $end) {
        return $this->impl->getappointmentsByDate($start, $end);
    }


    function getAppointmentTypes($pName){
        return $this->impl->getAppointmentTypes($pName);
    }

    function updateUser($user){
        return $this->impl->updateUser($user);
    }

    function updatePassword($email,$password){
        return $this->impl->updatePassword($email,$password);
    }

    function updateAppointment($apt){
        return $this->impl->updateAppointment($apt);
    }

    function updateAdvisor($user){
        return $this->impl->updateAdvisor($user);
    }

    function updateUserNotification($user,$notification){
        return $this->impl->updateNotification($user,$notification);
    }

    public function deleteWaitListSchedule($id) {
        return $this->impl->deleteWaitListSchedule($id);
    }

    public function addFeedback($feedback) {
        return $this->impl->addFeedback($feedback);
    }
}