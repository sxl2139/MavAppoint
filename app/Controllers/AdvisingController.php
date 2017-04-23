<?php
include_once ROOT . "/app/Models/db/DatabaseManager.php";

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

        $pName = isset($_REQUEST['pName']) ? $_REQUEST['pName'] : "all";
        if ($pName != "all") {
            $arr = array(array("pName" => $pName));
            $schedules = $this->getSchedules($arr, $dbManager, 0);
        } else {
            $schedules = $this->getSchedules($advisors, $dbManager, 0);
        }


        return array(
            "error" => 0,
            "data" => array(
                "departments" => $departments,
                "majors" => $this->getMajors($user, $departments[0], $dbManager),
                "degrees" => $this->getDegrees($user),
                "letters" => $this->getLetters($user),
                "advisors" => $advisors,
                "schedules" => $schedules,
                "appointments" => $this->getAppointments($user, $dbManager),

//                "waitLists" => $this->getWaitListAction($user, $dbManager),
                "studentEmail" => $user->getEmail(),
                "studentId" => $user->getStudentId(),
                "studentPhone" => $user->getPhoneNumber()
            )
        );
    }

//    public function getWaitListInfoAction() {
//        $appointmentId = isset($_REQUEST['appointmentId']) ? $_REQUEST['appointmentId'] : 0;
//
//        $isAdded = false;
//
//        $dbManager = new DatabaseManager();
//        $count = $dbManager->getWaitListScheduleCount($appointmentId);
//        $appointment = $dbManager->getAppointmentById($appointmentId);
//        $uid = $dbManager->getUserIdByEmail($_SESSION['email']);
//        $waitList = $dbManager->getStudentWaitList($uid, $appointmentId);
//
//        if ($waitList != null) {
//            $isAdded = true;
//        }
//
//        return [
//            "error" => 0,
//            "data" => [
//                "isAdded" => $isAdded,
//                "waitListCount" => $count,
//                "appointmentType" => $appointment->getAppointmentType(),
//                "advisor" => $appointment->getPname()
//            ]
//        ];
//    }
//
//    public function addToWaitListAction() {
//        $dbManager = new DatabaseManager();
//        $uid = $dbManager->getUserIdByEmail($_SESSION['email']);
//
//        $waitList = new WaitList();
//        $waitList->setStudentId($_REQUEST['studentId']);
//        $waitList->setStudentUserId($uid);
//        $waitList->setAppointmentId($_REQUEST['appointmentId']);
//        $waitList->setStudentEmail($_REQUEST['email']);
//        $waitList->setStudentPhone($_REQUEST['phoneNumber']);
//        $waitList->setType($_REQUEST['appointmentType']);
//        $waitList->setDescription($_REQUEST['description']);
//
//
//        if (!$dbManager->setWaitListSchedule($waitList)) {
//            return [
//                "error" => 1,
//                "description" => "Errors while adding to wait list."
//            ];
//        }
//
//        return [
//            "error" => 0
//        ];
//    }

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
                die("Time remained is less than cutOff hours");
                header("Location:" . getUrlWithoutParameters() . "?c=" .mav_encrypt("advising"));
            }
        }

        return array(
            "error" => 0,
            "data" => array(
                "pName" => $_REQUEST['pname'],
                "id1" => $_REQUEST['id1'],
                "duration" => $duration,
                "appType" => isset($_REQUEST['appType']) ? $_REQUEST['appType'] : "",
                "advisorEmail" => isset($_REQUEST['advisor_email']) ? $_REQUEST['advisor_email'] : "",
                "appointmentTypes" => $ats,
                "timeSlot" => $ts,
                "studentEmail" => $user->getEmail(),
                "studentId" => $user->getStudentId(),
                "studentPhone" => $user->getPhoneNumber()
            )
        );
    }

    public function successAction() {
        $controller = mav_encrypt($_REQUEST['nc']);
        $action = mav_encrypt($_REQUEST['na']);

        return array(
            "error" => 0,
            "data" => getUrlWithoutParameters() . "?c=$controller&a=$action"
        );
    }






    private function getDegrees(StudentUser $user)
    {
        $degrees = array();
        $degreeType = $user->getDegType();
        if ($degreeType >= 4) {
            array_push($degrees, "Doctorate");
            $degreeType -= 4;
        }

        if ($degreeType >= 2) {
            array_push($degrees, "Masters");
            $degreeType -= 2;
        }

        if ($degreeType >= 1) {
            array_push($degrees, "Bachelors");
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
        $tempMajors = array();
        $majors = $dbManager->getMajor($user->getUserId());

        foreach ($majors as $major) {
            if (in_array($major, $dbManager->getMajorsOfDepartment($department))) {
                array_push($tempMajors, $major);
            }
        }
        return $tempMajors;
    }

    private function getAdvisors(StudentUser $user, $department, DatabaseManager $dbManager)
    {
        $tempAdvs = array();
        $advisors = $dbManager->getAdvisorsOfDepartment($department);
        $lastInitial = $user->getLastNameInitial();
        foreach ($advisors as $advisor) {
            $reg = "#[" . strtolower($advisor->getNameLow()) . "-" . strtolower($advisor->getNameHigh())
                . strtoupper($advisor->getNameLow()) . "-" . strtoupper($advisor->getNameHigh()) . "]#";
            if (preg_match($reg, $lastInitial)) {
                array_push($tempAdvs, array("pName" => $advisor->getPName()));
            }
        }
        return $tempAdvs;
    }

    private function getSchedules($advisors, DatabaseManager $dbManager, $times)
    {
        $tempSchedules = array();

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
                array_push($tempSchedules, array(
                    "name" => $schedule->getName(),
                    "date" => $schedule->getDate(),
                    "startTime" => $schedule->getStartTime(),
                    "endTime" => $schedule->getEndTime(),
                    "event" => $schedule->getEvent($times)
                ));
            }
        }

        return $tempSchedules;
    }

    private function getAppointments(StudentUser $user, DatabaseManager $dbManager)
    {
        $appointments = $dbManager->getAppointments($user);
        $tempAppointments = array_map(function (Appointment $appointment) {
            return array(
                "advisingDate" => $appointment->getAdvisingDate(),
                "advisingStartTime" => $appointment->getAdvisingStartTime(),
                "advisingEndTime" => $appointment->getAdvisingEndTime(),
                "appointmentType" => $appointment->getAppointmentType(),
            );
        }, $appointments);


        return $tempAppointments;
    }

    private function getAppointmentTypes($pname, DatabaseManager $dbManager)
    {
        $types = $dbManager->getAppointmentTypes($pname);
        return array_map(function (AppointmentType $type) {
            return array(
                'type' => $type->getType(),
                'email' => $type->getEmail(),
                'duration' => $type->getDuration()
            );
        }, $types);
    }

//    private function getWaitListAction(StudentUser $user, DatabaseManager $dbManager)
//    {
//        $startDate = date("Y-m-d", time() - 24 * 60 * 60);
//        $endDate = date("Y-m-d", time() + 30 * 24 * 60 * 60);
//
//        $waitList = array();
//        $allAppointments = $dbManager->getAppointmentsByDate($startDate, $endDate);
//
//        /** @var Appointment $appointment */
//        foreach ($allAppointments as $appointment) {
//            $tmp = [
//                "appointmentId" => $appointment->getAppointmentId(),
//                "advisingDate" => $appointment->getAdvisingDate(),
//                "advisingStartTime" => $appointment->getAdvisingStartTime(),
//                "advisingEndTime" => $appointment->getAdvisingEndTime(),
//                "appointmentType" => $appointment->getAppointmentType()
//            ];
//
//            if ($user->getUserId() != $appointment->getStudentUserId()) {
//                array_push($waitList, $tmp);
//            }
//        }
//
//        return $waitList;
//    }

}