<?php
include_once ROOT . "/app/Models/db/DatabaseManager.php";

class AppointmentController
{
    public function makeAppointmentAction(){
        include_once ROOT . "/app/Models/bean/Appointment.php";

        $appointment = new Appointment();
        $appointment->setStudentPhoneNumber($_REQUEST['phoneNumber']);
        $appointment->setStudentId($_REQUEST['studentId']);
        $appointment->setDescription($_REQUEST['description']);
        $appointment->setAppointmentType($_REQUEST['appointmentType']);
        $appointment->setPname($_REQUEST['pName']);
        $appointment->setStatus(0);

        $start = $_REQUEST['start'];
        $dateTime = explode(" ", $start);
        $date = $dateTime[3] . "-" . convertMonth($dateTime[1]) . "-" . $dateTime[2];
        $startTime = $dateTime[4];
        $duration = $_REQUEST['duration'];
        $endTime = $this->addTime($startTime, $duration);

        $appointment->setAdvisingDate($date);
        $appointment->setAdvisingStartTime($startTime);
        $appointment->setAdvisingEndTime($endTime);

        $dbManager = new DatabaseManager();
        $result = $dbManager->createAppointment($appointment, $_REQUEST['email']);
        if (!isset($result['response']) || !$result['response']) {
            return array(
                "error" => 1
            );
        }

        if ($result['student_notify'] == 'yes') {
            mav_mail("MavAppoint: Advising appointment with " . $appointment->getPname(),
                "\nAn appointment has been set for " . $appointment->getAppointmentType() . " on " . $appointment->getAdvisingDate() . " at " .
                $appointment->getAdvisingStartTime() . " - " . $appointment->getAdvisingEndTime() . "\nThanks!",
                array($_REQUEST['email']));
        }

        if ($result['advisor_notify'] == 'yes') {
            mav_mail("MavAppoint: Advising appointment with " . $appointment->getStudentId(),
                "\nAn appointment has been set for " . $appointment->getAppointmentType() . " on " . $appointment->getAdvisingDate() . " at " .
                $appointment->getAdvisingStartTime() . " - " . $appointment->getAdvisingEndTime(),
                array($result['advisor_email']));
        }

        return array(
            "error" => 0,
        );
    }

    public function showAppointmentAction() {
        $dbManager = new DatabaseManager();
        switch ($_SESSION['role']){
            case 'student':
                $user = $dbManager->getStudent($_SESSION['email']);
                break;
            case 'advisor':
                $user = $dbManager->getAdvisor($_SESSION['email']);
                break;
            default:
                return array("error" => 1);
                break;
        }

        return array(
            "error" => 0,
            "data" => array(
                "appointments" => $this->getAppointments($user, $dbManager)
            )
        );
    }

    public function showCanceledAppointmentAction(){
        $dbManager = new DatabaseManager();
        switch ($_SESSION['role']){
            case 'student':
                $user = $dbManager->getStudent($_SESSION['email']);
                break;
            case 'advisor':
                $user = $dbManager->getAdvisor($_SESSION['email']);
                break;
            default:
                return array("error" => 1);
                break;
        }

        return array(
            "error" => 0,
            "data" => array(
                "appointments" => $this->getCanceledAppointments($user, $dbManager)
            )
        );
    }

    public function cancelAppointmentAction() {
        $result = 0;
        $appointmentId = $_REQUEST['appointmentId'];
        $reason = $_REQUEST['cancellationReason'];
        $isCanceledBy = isset($_SESSION['role']) ? $_SESSION['role'] : null;
        $dbManager = new DatabaseManager();
        $appointment = $dbManager->getAppointmentById($appointmentId);
//        $waitList = $dbManager->getFirstWaitList($appointmentId);
//        if ($waitList != null) {
//
//            $appointment->setStudentUserId($waitList->getStudentUserId());
//            $appointment->setStudentId($waitList->getStudentId());
//            $appointment->setStudentEmail($waitList->getStudentEmail());
//            $appointment->setStudentPhoneNumber($waitList->getStudentPhone());
//            $appointment->setAppointmentType($waitList->getType());
//            $appointment->setDescription($waitList->getDescription());
//
//            if ($dbManager->updateAppointment($appointment) && $dbManager->deleteWaitListSchedule($waitList->getId())) {
//
//                mav_mail("MavAppoint: Advising appointment with " . $appointment->getPname(),
//                    "\nAn appointment has been set for " . $appointment->getAppointmentType() . " on " . $appointment->getAdvisingDate() . " at " .
//                    $appointment->getAdvisingStartTime() . " - " . $appointment->getAdvisingEndTime() . "\nThanks!",
//                    [$appointment->getStudentEmail()]);
//
//                mav_mail("MavAppoint: Advising appointment with " . $appointment->getStudentId(),
//                    "\nAn appointment has been updated for " . $appointment->getAppointmentType() . " on " . $appointment->getAdvisingDate() . " at " .
//                    $appointment->getAdvisingStartTime() . " - " . $appointment->getAdvisingEndTime() .
//                    "\nSome student cancelled the appointment and the first one in the wait list is scheduled\nThanks!",
//                    [$appointment->getAdvisorEmail()]);
//
//            } else {
//                $result = 1;
//            }
//
//        } else {

        if ($dbManager->cancelAppointment($appointmentId, $isCanceledBy,$reason)) {

            mav_mail("Advising Appointment with " . $appointment->getPname() . " cancelled",
                "Your appointment on " . $appointment->getAdvisingDate() . " from " . $appointment->getAdvisingStartTime() .
                " to " . $appointment->getAdvisingEndTime() . " has been cancelled",
                array($appointment->getStudentEmail()));

            mav_mail("Advising Appointment with Student Id: " . $appointment->getStudentId() . " cancelled",
                "Your appointment on " . $appointment->getAdvisingDate() . " from " . $appointment->getAdvisingStartTime() .
                " to " . $appointment->getAdvisingEndTime() . " has been cancelled",
                array($appointment->getAdvisorEmail()));

        } else {
            $result = 1;
        }
//        }

        return array(
            "error" => $result,
//            "description" =>"Error while cancelling appointment, please try again."

        );
    }

    public function successAction(){
        $controller = mav_encrypt($_REQUEST['nc']);
        $action = mav_encrypt($_REQUEST['na']);
        return array(
            "error" => 0,
            "data" => getUrlWithoutParameters() . "?c=$controller&a=$action"
        );
    }

   private function getAppointments(LoginUser $user, DatabaseManager $dbManager) {
        $appointments = $dbManager->getAppointments($user);

        $tempAppointments = array();
        foreach ($appointments as $appointment) {
            $statusName = ($appointment->getStatus()==0) ? "Reserved" : "Canceled" ;
            array_push($tempAppointments, array(
                "pName" => $appointment->getPname(),
                "advisingDate" => $appointment->getAdvisingDate(),
                "advisingStartTime" => $appointment->getAdvisingStartTime(),
                "advisingEndTime" => $appointment->getAdvisingEndTime(),
                "appointmentType" => $appointment->getAppointmentType(),
                "appointmentId" => $appointment->getAppointmentId(),
                "advisorEmail" => $appointment->getAdvisorEmail(),
                "description" => $appointment->getDescription(),
                "studentId" => $appointment->getStudentId(),
                "studentEmail" => $appointment->getStudentEmail(),
                "studentPhoneNumber" => $appointment->getStudentPhoneNumber(),
                "status" => $appointment->getStatus(),
                "statusName" => $statusName
            ));
        }

        return $tempAppointments;
    }


    private function getCanceledAppointments(LoginUser $user, DatabaseManager $dbManager) {
        $appointments = $dbManager->getAppointments($user);

        $tempAppointments = array();
        foreach ($appointments as $appointment) {
            if($appointment->getStatus() == -1){
                array_push($tempAppointments, array(
                    "pName" => $appointment->getPname(),
                    "advisingDate" => $appointment->getAdvisingDate(),
                    "advisingStartTime" => $appointment->getAdvisingStartTime(),
                    "advisingEndTime" => $appointment->getAdvisingEndTime(),
                    "appointmentType" => $appointment->getAppointmentType(),
                    "appointmentId" => $appointment->getAppointmentId(),
                    "advisorEmail" => $appointment->getAdvisorEmail(),
                    "description" => $appointment->getDescription(),
                    "studentId" => $appointment->getStudentId(),
                    "studentEmail" => $appointment->getStudentEmail(),
                    "studentPhoneNumber" => $appointment->getStudentPhoneNumber(),
                    "isCanceledBy" => $appointment->getIsCanceledBy(),
                    "remark" => $appointment->getRemark()
                ));

            }

        }

        return $tempAppointments;
    }


    private function addTime($startTime, $duration) {
        $tmp = explode(":", $startTime);
        $hours = $tmp[0];
        $minutes = $tmp[1] + $duration;
        if ($minutes >= 60) {
            $minutes -= 60;
            $hours += 1;

            if ($hours < 10) {
                $hours = "0" . $hours;
            }
        }

        if ($minutes < 10) {
            $minutes = "0" . $minutes;
        }
        $tmp[1] = $minutes;
        $tmp[0] = $hours;

        return join(":", $tmp);
    }
}