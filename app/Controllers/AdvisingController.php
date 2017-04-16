<?php

namespace App\Controllers;

use Models\Bean\Appointment;
use Models\Bean\AppointmentType;
use Models\Bean\WaitList;
use Models\CompositeTimeSlot;
use Models\Db\DatabaseManager;
use Models\Login\StudentUser;

class AdvisingController
{
    public function getAdvisingInfoAction()
    {
        if (!isset($_SESSION['email'])) {
            header("Location:" . getUrlWithoutParameters() . "?c=" . mav_encrypt("login"));
        }

        $dbManager = new DatabaseManager();

        $user = $dbManager->getStudent($_SESSION['email']);

        $departments = $this->getDepartments($user, $dbManager);
        $advisors = $this->getAdvisors($user, $departments[0], $dbManager);
        $schedules = $this->getSchedules($advisors, $dbManager, 4);

        return [
            "error" => 0,
            "data" => [
                "departments" => $departments,
                "majors" => $this->getMajors($user, $departments[0], $dbManager),
                "degrees" => $this->getDegrees($user),
                "letters" => $this->getLetters($user),
                "advisors" => $advisors,
                "schedules" => $schedules,
                "appointments" => $this->getAppointments($user, $dbManager),
                "waitLists" => $this->getWaitListAction($user, $dbManager),
                "studentEmail" => $user->getEmail(),
                "studentId" => $user->getStudentId(),
                "studentPhone" => $user->getPhoneNumber()
            ]
        ];
    }

    public function getWaitListInfoAction() {
        $appointmentId = isset($_REQUEST['appointmentId']) ? $_REQUEST['appointmentId'] : 0;

        $isAdded = false;

        $dbManager = new DatabaseManager();
        $count = $dbManager->getWaitListScheduleCount($appointmentId);
        $appointment = $dbManager->getAppointmentById($appointmentId);
        $uid = $dbManager->getUserIdByEmail($_SESSION['email']);
        $waitList = $dbManager->getStudentWaitList($uid, $appointmentId);

        if ($waitList != null) {
            $isAdded = true;
        }

        return [
            "error" => 0,
            "data" => [
                "isAdded" => $isAdded,
                "waitListCount" => $count,
                "appointmentType" => $appointment->getAppointmentType(),
                "advisor" => $appointment->getPname()
            ]
        ];
    }

    public function addToWaitListAction() {
        $dbManager = new DatabaseManager();
        $uid = $dbManager->getUserIdByEmail($_SESSION['email']);

        $waitList = new WaitList();
        $waitList->setStudentId($_REQUEST['studentId']);
        $waitList->setStudentUserId($uid);
        $waitList->setAppointmentId($_REQUEST['appointmentId']);
        $waitList->setStudentEmail($_REQUEST['email']);
        $waitList->setStudentPhone($_REQUEST['phoneNumber']);
        $waitList->setType($_REQUEST['appointmentType']);
        $waitList->setDescription($_REQUEST['description']);


        if (!$dbManager->setWaitListSchedule($waitList)) {
            return [
                "error" => 1,
                "description" => "Errors while adding to wait list."
            ];
        }

        return [
            "error" => 0
        ];
    }

    public function scheduleAction() {
        if (!isset($_SESSION['role'])) {
            header("Location:" . getUrlWithoutParameters() . "?c=" . mav_encrypt("login"));
        }
        $duration = isset($_REQUEST['duration']) ? $_REQUEST['duration'] : 0;
        $dbManager = new DatabaseManager();

        $user = $dbManager->getStudent($_SESSION['email']);

        $departments = $this->getDepartments($user, $dbManager);
        $advisors = $this->getAdvisors($user, $departments[0], $dbManager);
        $schedules = $this->getSchedules($advisors, $dbManager, $duration / 5);
        $ats = $this->getAppointmentTypes($_REQUEST['pname'], $dbManager);

        $email = $ats[0]['email'];
        $ts = $schedules[$_REQUEST['id1']];
        $advisor = $dbManager->getAdvisor($email);
        $cutOffTime = $advisor->getCutOffPreference();
        if ($cutOffTime != 0) {
            $tsTime = $ts['date'] . " " . $ts['startTime'];
            $startDate = strtotime($tsTime);
            $difference = $startDate - time();
            $hours = $difference / 3600;
            if ($hours < $cutOffTime) {
                //TODO: change url
                die("Time remained is less than cutOff hours");
                header("Location:" . getUrlWithoutParameters() . "?c=" .mav_encrypt("advising"));
            }
        }

        return [
            "error" => 0,
            "data" => [
                "pName" => $_REQUEST['pname'],
                "id1" => $_REQUEST['id1'],
                "duration" => $duration,
                "appType" => isset($_REQUEST['appType']) ? $_REQUEST['appType'] : "",
                "advisorEmail" => isset($_REQUEST['advisor_email']) ? $_REQUEST['advisor_email'] : "",
                "appointmentTypes" => $ats,
                "timeSlot" => $ts,
                "userEmail" => $user->getEmail(),
                'url' => $_SERVER['SERVER_ADDR'] . $_SERVER['REQUEST_URI']
            ]
        ];
    }

    public function successAction() {
        $controller = mav_encrypt($_REQUEST['nc']);
        $action = mav_encrypt($_REQUEST['na']);

        return [
            "error" => 0,
            "data" => getUrlWithoutParameters() . "?c=$controller&a=$action"
        ];
    }






    private function getDegrees(StudentUser $user)
    {
        $degrees = [];
        $degreeType = $user->getDegType();
        if ($degreeType >= 4) {
            $degrees[] = "Doctorate";
            $degreeType -= 4;
        }

        if ($degreeType >= 2) {
            $degrees[] = "Masters";
            $degreeType -= 2;
        }

        if ($degreeType >= 1) {
            $degrees[] = "Bachelors";
        }

        return $degrees;
    }

    private function getLetters(StudentUser $user)
    {
        return $user->getLastNameInitial();
    }

    private function getDepartments(StudentUser $user, DatabaseManager $dbManager)
    {
        $tempDeps = $dbManager->getDepartment($user->getUserId());
        return $tempDeps;
    }

    private function getMajors(StudentUser $user, $department, DatabaseManager $dbManager)
    {
        $tempMajors = [];
        $majors = $dbManager->getMajor($user->getUserId());

        foreach ($majors as $major) {
            if (in_array($major, $dbManager->getMajorsOfDepartment($department))) {
                $tempMajors[] = $major;
            }
        }
        return $tempMajors;
    }

    private function getAdvisors(StudentUser $user, $department, DatabaseManager $dbManager)
    {
        $tempAdvs = [];
        $advisors = $dbManager->getAdvisorsOfDepartment($department);
        $lastInitial = $user->getLastNameInitial();
        foreach ($advisors as $advisor) {
            $reg = "#[" . strtolower($advisor->getNameLow()) . "-" . strtolower($advisor->getNameHigh())
                . strtoupper($advisor->getNameLow()) . "-" . strtoupper($advisor->getNameHigh()) . "]#";
            if (preg_match($reg, $lastInitial)) {
                $tempAdvs[] = [
                    "pName" => $advisor->getPName()
                ];
            }
        }
        return $tempAdvs;
    }

    private function getSchedules($advisors, DatabaseManager $dbManager, $times)
    {
        $tempSchedules = [];

        $advisors = array_map(function ($advisor) {
            return $advisor['pName'];
        }, $advisors);

        $schedules = $dbManager->getAdvisorSchedules($advisors);
        foreach ($schedules as $schedule) {
            /** @var CompositeTimeSlot $schedule */
            $schedule = unserialize($schedule);
            $scheduleDate = strtotime($schedule->getDate());
            $todayDate = strtotime(date("Y-m-d", time()));
            if ($scheduleDate > $todayDate) {
                $tempSchedules[] = [
                    "name" => $schedule->getName(),
                    "date" => $schedule->getDate(),
                    "startTime" => $schedule->getStartTime(),
                    "endTime" => $schedule->getEndTime(),
                    "event" => $schedule->getEvent($times),
//                    "countChildren" => count($schedule->getChildren()),
//                    "test" => array_map(function($children){
//                        return unserialize($children)->getStartTime();
//                    }, $schedule->getChildren())
                ];
            }
        }

        return $tempSchedules;
    }

    private function getAppointments(StudentUser $user, DatabaseManager $dbManager)
    {
        $appointments = $dbManager->getAppointments($user);
        $tempAppointments = array_map(function (Appointment $appointment) {
            return [
                "advisingDate" => $appointment->getAdvisingDate(),
                "advisingStartTime" => $appointment->getAdvisingStartTime(),
                "advisingEndTime" => $appointment->getAdvisingEndTime(),
                "appointmentType" => $appointment->getAppointmentType(),
            ];
        }, $appointments);


        return $tempAppointments;
    }

    private function getWaitListAction(StudentUser $user, DatabaseManager $dbManager)
    {
        $startDate = date("Y-m-d", time() - 24 * 60 * 60);
        $endDate = date("Y-m-d", time() + 30 * 24 * 60 * 60);

        $waitList = array();
        $allAppointments = $dbManager->getAppointmentsByDate($startDate, $endDate);

        /** @var Appointment $appointment */
        foreach ($allAppointments as $appointment) {
            $tmp = [
                "appointmentId" => $appointment->getAppointmentId(),
                "advisingDate" => $appointment->getAdvisingDate(),
                "advisingStartTime" => $appointment->getAdvisingStartTime(),
                "advisingEndTime" => $appointment->getAdvisingEndTime(),
                "appointmentType" => $appointment->getAppointmentType()
            ];

            if ($user->getUserId() != $appointment->getStudentUserId()) {
                array_push($waitList, $tmp);
            }
        }

        return $waitList;
    }

    private function getAppointmentTypes($pname, DatabaseManager $dbManager)
    {
        $types = $dbManager->getAppointmentTypes($pname);
        return array_map(function (AppointmentType $type) {
            return [
                'type' => $type->getType(),
                'email' => $type->getEmail(),
                'duration' => $type->getDuration()
            ];
        }, $types);
    }

}