<?php
/**
 * Created by PhpStorm.
 * User: gaolin
 * Date: 2/20/17
 * Time: 12:58 AM
 */
include_once dirname(dirname(__FILE__))."/Models/login/LoginUser.php";
include_once dirname(dirname(__FILE__))."/Models/login/AdvisorUser.php";
include_once dirname(dirname(__FILE__))."/Models/db/DatabaseManager.php";
//use Models\Db as db;
//use Models\Login as login;
//use Models\Db\DatabaseManager;
//use Models\Login\AdvisorUser;
//use Models\Helper\TimeSlotHelper;

//include_once ROOT. "/app/Models/db/DatabaseManager.php";
//include_once ROOT . "app/Models/login/LoginUser.php";
//include_once ROOT . "app/Models/login/AdvisorUser.php";

class adminController
{
    private $email;
    private $uid;
    private $role;
    private $dep;

    function __construct()
    {
        if(!isset($_SESSION)){
            session_start();
        }

        $this->email = isset($_SESSION['email']) ? $_SESSION['email']: null;
        $this->uid = isset($_SESSION['uid']) ? $_SESSION['uid'] : null;
        $this->role = isset($_SESSION['role']) ? $_SESSION['role'] : null;
    }

    public function addAdvisorAction(){

        $dbm = new DatabaseManager();
        $departments = $dbm->getDepartments();
//        var_dump($departments);
//        die();
        return $departments;
//        return array(
//            "department" => array(
//                0 => array(
//                    "name" => "CSE"
//                ),
//                1 => array(
//                    "name" => "MATH"
//                ),
//                2 => array(
//                    "name" => "MAE"
//                ),
//                3 => array(
//                    "name" => "ARCH"
//                ),
//            )
//        );
    }

    function createNewAdvisorAction(){

        $manager = new DatabaseManager();

        $department = $_REQUEST['drp_department'];
        $email = $_REQUEST['email'];
        $name = $_REQUEST['pname'];
        $password = generateRandomPassword();

        $loginUser = new LoginUser();
        $loginUser->setEmail($email);
        $loginUser->setPassword($password);
        $loginUser->setRole("advisor");
        $loginUser->setDepartments(array($department));
        $loginUser->setMajors(array("Software Engineering"));


        $id = $manager->createUser($loginUser);

        $Advisor = new AdvisorUser();
        $Advisor->setUserId($id);
        $Advisor->setPName($name);
        $Advisor->setNotification("Yes");
        $Advisor->setNameLow("a");
        $Advisor->setNameHigh("Z");
        $Advisor->setDegType("7");

        $manager->createAdvisor($Advisor);

        $apt=new AppointmentType();
        $apt->setType("Other");
        $apt->setDuration("10");
        $res=$manager->addAppointmentType($id,$apt);

        if($res)
        {
            mav_mail("MavAppoint Account Created",
                "<p>Your account for MavAppoint has been created! Your account information is:</p>"
                . "<p>Role: Advisor </p>"
                . "<p>Password: " . $password . "</p>"
                . "<br><br>Click here to <a href='" . getUrlWithoutParameters() . "?c=" . mav_encrypt("login") . "'>Login</a>",
                array($loginUser->getEmail())
            );
            return array(
                "error" => 0,
                "data" => array(
                    "message" => "Advisor created successfully. An email has been sent to the advisor's account with his/her temporary password",

                )

            );

        } else {
            return array(
                "error" => 1,
                "data" => array(
                    "message" => "Fail"
                )
            );
//            return "Failed";
        }




//        echo "department:".$department."<br>";
//        echo "email:".$email."<br>";
//        echo "name:".$name."<br>";


    }

    function deleteAdvisorAction(){
        $tag = isset($_REQUEST["tag"])? $_REQUEST["tag"] : "error";
        $dbm = new DatabaseManager();
        $advisors = $dbm->getAdvisors();
        if(mav_decrypt($tag)=="yes"){
            $advisors["message"] = "Delete advisor successfully";
        }else{
            $advisors["message"] = "";
        }
        return $advisors;
    }

    function deleteSelectAdvisorAction(){

        $advisors = isset($_REQUEST['advisors']) ? $_REQUEST['advisors'] : "error";
        $advisors = explode(',',$advisors);
        $dbm = new DatabaseManager();
        if($advisors != "error") {
            for ($i = 0; $i < count($advisors); $i++) {
                $dbm->deleteAdvisor($advisors[$i]);
            }
            return array(
                "error" => 0,
            );
        //            $advisors = $dbm->getAdvisors();
        //            $advisors["message"] = "delete advisor successfully";
        }else{
            return null;
        }

        //            $advisors = $dbm->getAdvisors();
        //            $advisors["message"] = "Select atleast one advisor";

        //        return $advisors; //dont use success view.

    }

    public function success2Action(){
        $controller = mav_encrypt($_REQUEST['nc']);
        $action = mav_encrypt($_REQUEST['na']);
        $tag = mav_encrypt($_REQUEST['nt']);
        return array(
            "error" => 0,
            "data" => getUrlWithoutParameters() . "?c=$controller&a=$action&tag=$tag"
        );
    }

    function addDepartmentAction(){
        $tag = isset($_REQUEST["tag"])? $_REQUEST["tag"] : "error";
        if(mav_decrypt($tag)=="yes"){
            return array("message" => "Add department Successfully");
        }else{
            return null;
        }
    }

    function createNewDepartmentAction(){
        $department = isset($_REQUEST['department']) ? $_REQUEST['department']: null;
        $dbm = new DatabaseManager();
        if($department!=null) {
            $res = $dbm->addNewDepartment($department);

        }else{
            $res=false;

        }

        if($res) {
            return array(
                "error" =>0,
//                "data" =>getUrlWithoutParameters()."?c=$controller&a=$action&m=$tag"
                );
//            return array(
//                "error" => 0,
//                "data" => array(
//                    "message" => "Department Create successfully.",
//
//                )
//
//            );

        } else {
            return array(
                "error" => 1,
                "data" => array(
                    "message" => "Need enter a department"
                )
            );
        }

    }


    function showDepartmentScheduleAction()
    {
        if (!isset($_SESSION['role'])) {
            header("Location:" . getUrlWithoutParameters() . "?c=" .mav_encrypt("login"));
        }

        $tempSchedules = array();
        $tempAppointments = array();

        if ($this->role == "admin" && $this->email != null) {
            $dbm = new DatabaseManager();
            $adminUser = $dbm->getAdmin($this->email);
            $department = $dbm->getDepartment($this->uid);
            $advisors = $dbm->getAdvisorsOfDepartment($department[0]);
            $tempSchedules = $this->getSchedules($advisors, $dbm, 0);

            $appointments = $dbm->getAppointments($adminUser);
            if(sizeof($appointments) != 0 ){

                foreach ($appointments as $appointment){



                    $advisor = $dbm->getAdvisor($appointment->getAdvisorEmail());
                    array_push($tempAppointments, array(
                            "advisingDate" => $appointment->getAdvisingDate(),
                            "advisingStartTime" => $appointment->getAdvisingStartTime(),
                            "advisingEndTime" => $appointment->getAdvisingEndTime(),
//                            "appointmentType" => $appointment->getAppointmentType()
                            "appointmentType" => $appointment->getAppointmentType()." - ".$advisor->getPName()
                    ));


                }

            }

//            $scheduleObjectArr = $dbm->getAdvisorSchedule("all");
//            if (sizeof($scheduleObjectArr) != 0) {
//
//                foreach ($scheduleObjectArr as $schedule){
//                    array_push($tempSchedules ,
//                        array(
//                        "name" => $schedule->getName(),
//                        "date" => $schedule->getDate(),
//                        "startTime" => $schedule->getStartTime(),
//                        "endTime" => $schedule->getEndTime(),
//
//                        )
//                    );
//
//                }
//            }


        }
        return array(
            "error" => 0,
            "data" => array(
                "email" =>$this->email,
                "role" => $this->role,
                "schedules" =>$tempSchedules,
                "appointments" => $tempAppointments
            )
        );
    }


    function deleteTimeSlotAction(){
        $requestStartTime = isset($_POST['StartTime2']) ? $_POST['StartTime2'].":00" : null;
        $requestEndTime = isset($_POST['EndTime2']) ? $_POST['EndTime2'].":00" : null;
        $requestDate = isset($_POST['Date']) ? date('Y-m-d',strtotime($_POST['Date'])) : null;
        $repeat = isset($_POST['delete_repeat']) ? intval($_POST['delete_repeat']) : null;
        $reason = isset($_POST['delete_reason']) ? $_POST['delete_reason'] : null;
        $tittle = isset($_POST['pname']) ? $_POST['pname'] : null;
        $pieces = explode(" ", $tittle);
        $advisorName = $pieces[sizeof($pieces)-1];
        $dbm = new DatabaseManager();
        $department = $dbm->getDepartment($this->uid);
        $advisors = $dbm->getAdvisorsOfDepartment($department[0]);
        $advisor = null;
        foreach ($advisors as $adv){
//            var_dump($adv->getPName());
//            var_dump($tittle);
            if($adv->getPName() == $tittle){
                $advisor = $adv;
                break;
            }
        }

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
        include_once ROOT . "/app/Controllers/DeleteTimeSlotController.php";
        DeleteTimeSlotController::deleteTimeSlot($requestDate,$originalStartTime,$originalEndTime,$advisor->getPName(),$repeat,$reason);
        return array(
            "error" => 0,
            "dispatch" => "success",
        );
    }

    function cancelAppointments(DatabaseManager $dbm, AdvisorUser $advisor, $date , $originalStartTime, $originalEndTime, $reason){
        $appointments = $dbm->getAppointments($advisor);
        $studentEmailAndMsgArr = array();
        foreach ($appointments as $appointment){
            if(($appointment->getAdvisingDate() === $date) && ($appointment->getAdvisingStartTime() >= $originalStartTime)
                && ($appointment->getAdvisingEndTime() <= $originalEndTime)){
                array_push($studentEmailAndMsgArr,
                    array(
                        "studentEmail" => $appointment->getStudentEmail(),
                        "msg"=> "Your appointment with advisor " .$advisor->getPName()." on " . $date. " at ". $appointment->getAdvisingStartTime()
                            . "-" .$appointment->getAdvisingEndTime()." has been canceled by system admin."
                            ."\n" ."Reason: ". $reason,
                    )
                );
                $dbm->cancelAppointment($appointment->getAppointmentId());

            }


        }
        if(sizeof($studentEmailAndMsgArr)!=0){
            $emailSubject = 'MavAppoint: Advisor\'s advising time has been cancelled!';
            foreach ($studentEmailAndMsgArr as $keyValue){
                mav_mail($emailSubject,$keyValue['msg'],array($keyValue['studentEmail']));
            }
        }

    }



    function showAdvisorAssignmentAction(){
        $dbm = new DatabaseManager();

        $department = $dbm->getDepartment($this->uid);
        $this->dep = $department[0];

        $advisors = $dbm->getAdvisorsOfDepartment($this->dep);
        $majors = $dbm->getMajorsOfDepartment($this->dep);

        $res = array();
        foreach ($advisors as $rs){
            $advisorMajors = $dbm->getMajorsByUserId($rs->getUserId());

            array_push($res,
                array(
                    "userId"=>$rs->getUserId(),
                    "pName"=>$rs->getPName(),
                    "nameLow"=>$rs->getNameLow(),
                    "nameHigh"=>$rs->getNameHigh(),
                    "degreeType"=>$rs->getDegType(),
                    "majors"=>$advisorMajors
                )
                );
        }

        return array(
            "error" => 0,
            "data" => array(
                "advisors" => $res,
                "majors" => $majors
            ),
        );
    }

    private function getSchedules($advisors, DatabaseManager $dbManager, $times)
    {
        $tempSchedules = array();

        $tmpAdvisors = array();

        foreach ($advisors as $advisor) {
            array_push($tmpAdvisors, $advisor->getPname());
        }
        $advisors = $tmpAdvisors;

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
//                    "event" => $schedule->getEvent($times)
                ));
            }
        }

        return $tempSchedules;
    }

    function assignStudentToAdvisorAction(){
        $dbm = new DatabaseManager();
        $advisorsNew = isset($_POST['advisors']) ? $_POST['advisors'] : null;
        $advisorsNew = json_decode($advisorsNew, true);

        foreach ($advisorsNew as $res){
            $user = new AdvisorUser();
            $user->setUserId($res['userId']);
            $user->setPName($res['pName']);
            $user->setNameLow($res['nameLow']);
            $user->setNameHigh($res['nameHigh']);
            $user->setDegType($res['degreeType']);
            $user->setMajors($res['majors']);

            $dbm->updateAdvisor($user);
        }

        return array(
            "error" => 0
        );
    }

    public function successAction(){
        return array(
            "error" => 0,
            "data" => getUrlWithoutParameters(). "?c=" . mav_encrypt("admin") . "&a=" . mav_encrypt("showAdvisorAssignment")
        );
    }
}