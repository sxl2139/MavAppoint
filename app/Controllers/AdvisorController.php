<?php
namespace App\Controllers;
/**
 * Created by PhpStorm.
 * User: gaolin
 * Date: 2/20/17
 * Time: 12:58 AM
 */
use Models\Db\DatabaseManager;
use Models\Bean\AllocateTime;
use Models\Helper\TimeSlotHelper;
use Models\Bean\Appointment;
use Models\Login\AdvisorUser;

class advisorController
{
    private $email;
    private $uid;
    private $role;
    function __construct()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $this->email = isset($_SESSION['email']) ? $_SESSION['email']: null;
        $this->uid = isset($_SESSION['uid']) ? $_SESSION['uid'] : null;
        $this->role = isset($_SESSION['role']) ? $_SESSION['role'] : null;
    }

    function showScheduleAction(){;
        if (!isset($_SESSION['role'])) {
            header("Location:" . getUrlWithoutParameters() . "?c=" .mav_encrypt("login"));
        }

        if($this->role =="advisor" && $this->email!=null){
            $dbm = new DatabaseManager();
            $advisor = $dbm->getAdvisor($this->email);
            $scheduleObjectArr = $dbm->getAdvisorSchedule($advisor->getPName());

            if (sizeof($scheduleObjectArr) != 0) {
                foreach ($scheduleObjectArr as $schedule){
                    $tempSchedules[] = [
                        "name" => $schedule->getName(),
                        "date" => $schedule->getDate(),
                        "startTime" => $schedule->getStartTime(),
                        "endTime" => $schedule->getEndTime(),
                    ];

                }
            }


            $appointments = $dbm->getAppointments($advisor);
            $tempAppointments = array();
            foreach ($appointments as $appointment){
                array_push($tempAppointments,
                    [
                        "advisingDate" => $appointment->getAdvisingDate(),
                        "advisingStartTime" => $appointment->getAdvisingStartTime(),
                        "advisingEndTime" => $appointment->getAdvisingEndTime(),
                        "appointmentType" => $appointment->getAppointmentType()
                    ]
                    );

            }


        }

        return [
            "error" => 0,
            "data" => [
                "email" =>$this->email,
                "advisorName" => $advisor->getPName(),
                "role" => $this->role,
                "schedules" =>$tempSchedules,
                "appointments" => $tempAppointments
            ]
        ];


    }

    function addTimeSlotAction(){

        $dbm = new DatabaseManager();
        $time = new AllocateTime();
        $time->setDate($_POST['opendate']);
        $time->setStartTime($_POST['starttime']);
        $time->setEndTime($_POST['endtime']);
        $repeat = $_POST['repeat'];
        try{
            $rep = intval($repeat);
        }catch (\Exception $e){
            $rep = 0;
        }

        date_default_timezone_set('America/Chicago');
        $todayDate = date("Y-m-d");
        if($time->getDate()<=$todayDate){
            return[
                "error" => 0,
                "dispatch" => "failure",
            ];
        }
        $flag = $dbm->addTimeSlot($time, $this->uid);
        for($i=0;$i<$rep;$i++){
            $time->setDate(TimeSlotHelper::addDate($time->getDate(),1) );
            $flag = $dbm->addTimeSlot($time, $this->uid);
        }

        if($flag == false){
            return[
                "error" => 0,
                "dispatch" => "failure",
            ];
        }
        else
            return[
                "error" => 0,
                "dispatch" => "success",
            ];





    }


    function deleteTimeSlotAction(){
        $requestStartTime = isset($_POST['StartTime2']) ? $_POST['StartTime2'].":00" : null;
        $requestEndTime = isset($_POST['EndTime2']) ? $_POST['EndTime2'].":00" : null;
        $requestDate = isset($_POST['Date']) ? date('Y-m-d',strtotime($_POST['Date'])) : null;
        $repeat = isset($_POST['delete_repeat']) ? intval($_POST['delete_repeat']) : null;
        $reason = isset($_POST['delete_reason']) ? $_POST['delete_reason'] : null;

        //date('Y-m-d',strtotime());
        $dbm = new DatabaseManager();
        $advisor = $dbm->getAdvisor($this->email);
        $date = $requestDate;

        $originalTimeSlots = $dbm->getAdvisorSchedule($advisor->getPName(),true,$date);
        foreach ($originalTimeSlots as $timeSlot){
            if($requestStartTime>=$timeSlot->getStartTime() && $requestEndTime<=$timeSlot->getEndTime())
            {
                $originalStartTime = $timeSlot->getStartTime();
                $originalEndTime = $timeSlot->getEndTime();
                break;
            }
        }

        $this->cancelAppointments($dbm,$advisor,$date,$originalStartTime,$originalEndTime,$reason);
        if($repeat !=0 && $repeat!=null){
            for($i = 0 ; $i<$repeat; $i++){
                $date = date('Y-m-d',strtotime(TimeSlotHelper::addDate($date,1)));
                $this->cancelAppointments($dbm,$advisor,$date,$originalStartTime,$originalEndTime,$reason);


            }


        }




        DeleteTimeSlotController::deleteTimeSlot($requestDate,$originalStartTime,$originalEndTime,$advisor->getPName(),$repeat,$reason);






        return [
            "error" => 0,
            "dispatch" => "success",


        ];
    }

    function cancelAppointments(DatabaseManager $dbm, AdvisorUser $advisor, $date , $originalStartTime, $originalEndTime, $reason){
        $appointments = $dbm->getAppointments($advisor);
        $studentEmailAndMsgArr = array();
        foreach ($appointments as $appointment){
            if(($appointment->getAdvisingDate() === $date) && ($appointment->getAdvisingStartTime() >= $originalStartTime)
                && ($appointment->getAdvisingEndTime() <= $originalEndTime)){
                array_push($studentEmailAndMsgArr,
                    [
                        "studentEmail" => $appointment->getStudentEmail(),
                        "msg"=> "Advising time slot of adviser " .$advisor->getPName(). " on " . $date. " at ". $appointment->getAdvisingStartTime()
                            . "-" .$appointment->getAdvisingEndTime()." has been cancelled."
                            ."\n" ."Reason: ". $reason,
                    ]
                );
                $dbm->cancelAppointment($appointment->getAppointmentId());

            }


        }
        if(sizeof($studentEmailAndMsgArr)!=0){
            $emailSubject = 'MavAppoint: Advisor\'s advising time has been cancelled!';
            foreach ($studentEmailAndMsgArr as $keyValue){
                mav_mail($emailSubject,$keyValue['msg'],[$keyValue['studentEmail']]);
            }
        }

    }


//    public function successAction(){
//        return [
//            "error" => 0,
//            //TODO: change url
//            "data" => "http://localhost/MavAppoint_PHP/?c=" . mav_encrypt("advidor") . "&a=" . mav_encrypt("showSchedule")
//        ];
//    }




}