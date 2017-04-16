<?php
namespace App\Controllers;
/**
 * Created by PhpStorm.
 * User: gaolin
 * Date: 2/20/17
 * Time: 12:58 AM
 */
//include_once dirname(dirname(__FILE__))."/Models/login/LoginUser.php";
//include_once dirname(dirname(__FILE__))."/Models/login/AdvisorUser.php";
use Models\Db as db;
use Models\Login as login;
use Models\Db\DatabaseManager;
use Models\Login\AdvisorUser;
use Models\Helper\TimeSlotHelper;


class adminController extends BasicController
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
        return [
            "department" => [
                0 => [
                    "name" => "CSE"
                ],
                1 => [
                    "name" => "MATH"
                ],
                2 => [
                    "name" => "MAE"
                ],
                3 => [
                    "name" => "ARCH"
                ],
            ]
        ];
    }

    function createNewAdvisorAction(){
        $manager = new db\DatabaseManager();

        $department = $_REQUEST['drp_department'];
        $email = $_REQUEST['email'];
        $name = $_REQUEST['pname'];

        $loginUser = new login\LoginUser();
        $loginUser->setEmail($email);
        $loginUser->setPassword("password");
        $loginUser->setRole("advisor");
        $loginUser->setDepartments(($department));
        $loginUser->setMajors("Software Engineering");


        $id = $manager->createUser($loginUser);


        $Advisor = new login\AdvisorUser();
        $Advisor->setUserId($id);
        $Advisor->setPName($name);
        $Advisor->setNotification("Yes");
        $Advisor->setNameLow("a");
        $Advisor->setNameHigh("Z");
        $Advisor->setDegType("7");

        $res=$manager->createAdvisor($Advisor);


        if($res)
        {
            return [
                "error" => 0,
                "data" => [
                    "message" => "Advisor created successfully. An email has been sent to the advisor's account with his/her temporary password",


                ]
            ];
//            return "Advisor created successfully. An email has been sent to the advisor's account with his/her temporary password";
        } else {
            return [
                "error" => 1,
                "data" => [
                    "message" => "Fail"
                ]
            ];
//            return "Failed";
        }




//        echo "department:".$department."<br>";
//        echo "email:".$email."<br>";
//        echo "name:".$name."<br>";


    }

    function showDepartmentScheduleAction()
    {
        if (!isset($_SESSION['role'])) {
            header("Location:" . getUrlWithoutParameters() . "?c=" .mav_encrypt("login"));
        }

        if ($this->role == "admin" && $this->email != null) {
            $dbm = new db\DatabaseManager();
            $adminUser = $dbm->getAdmin($this->email);
            $appointments = $dbm->getAppointments($adminUser);
            if(sizeof($appointments) != 0 ){
                foreach ($appointments as $appointment){



                    $advisor = $dbm->getAdvisor($appointment->getAdvisorEmail());
                    $tempSchedules[] = [
                            "advisingDate" => $appointment->getAdvisingDate(),
                            "advisingStartTime" => $appointment->getAdvisingStartTime(),
                            "advisingEndTime" => $appointment->getAdvisingEndTime(),
//                            "appointmentType" => $appointment->getAppointmentType()
                            "appointmentType" => $appointment->getAppointmentType()." - ".$advisor->getPName()
                        ];


                }

            }

            $scheduleObjectArr = $dbm->getAdvisorSchedule("all");
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


        }
        return [
            "error" => 0,
            "data" => [
                "email" =>$this->email,
                "role" => $this->role,
                "schedules" =>$tempSchedules,
                "appointments" => $tempSchedules
            ]
        ];
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
            if($adv->getPName() == $advisorName){
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



    function showAdvisorAssignmentAction(){
        $dbm = new db\DatabaseManager();

        $this->dep = $dbm->getDepartment($this->uid)[0];

        $advisors = $dbm->getAdvisorsOfDepartment($this->dep);
        $majors = $dbm->getMajorsOfDepartment($this->dep);

        $res = array();
        foreach ($advisors as $rs){
            $advisorMajors = $dbm->getMajorsByUserId($rs->getUserId());

            array_push($res,
                [
                    "userId"=>$rs->getUserId(),
                    "pName"=>$rs->getPName(),
                    "nameLow"=>$rs->getNameLow(),
                    "nameHigh"=>$rs->getNameHigh(),
                    "degreeType"=>$rs->getDegType(),
                    "majors"=>$advisorMajors
                ]
                );
        }

        return [
            "error" => 0,
            "data" => [
                "advisors" => $res,
                "majors" => $majors
            ],
        ];
    }

    function assignStudentToAdvisorAction(){
        $dbm = new db\DatabaseManager();
        $advisorsNew = isset($_POST['advisors']) ? $_POST['advisors'] : null;
        $advisorsNew = json_decode($advisorsNew, true);

        foreach ($advisorsNew as $res){
            $user = new login\AdvisorUser();
            $user->setUserId($res['userId']);
            $user->setPName($res['pName']);
            $user->setNameLow($res['nameLow']);
            $user->setNameHigh($res['nameHigh']);
            $user->setDegType($res['degreeType']);
            $user->setMajors($res['majors']);

            $dbm->updateAdvisor($user);
        }

        return [
            "error" => 0
        ];
    }

    public function successAction(){
        return [
            "error" => 0,
            "data" => "http://localhost/MavAppoint_PHP/?c=" . mav_encrypt("admin") . "&a=" . mav_encrypt("showAdvisorAssignment")
        ];
    }
}