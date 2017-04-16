<?php
/**
 * Created by PhpStorm.
 * User: ren xiaolei
 * Date: 4/6/16
 * Time: 17:56
 */

namespace App\Controllers;


use Models\Bean\AppointmentType;
use Models\Db\DatabaseManager;
use Models\Login\AdvisorUser;

class CustomizeSettingController extends BasicController
{
    public function defaultAction()
    {
    }

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

    function showAppointmentTypeAction(){
        if($this->role =="advisor" && $this->email!=null){
            $dbm = new DatabaseManager();
            $advisor = $dbm->getAdvisor($this->email);
            $appointmentTypeObjectArr = $dbm->getAppointmentTypes($advisor->getPName());
            $typeAndDuration = array();
            if (sizeof($appointmentTypeObjectArr) != 0) {
                foreach ($appointmentTypeObjectArr as $appointmentType){
                    array_push($typeAndDuration,
                        [
                            "type" => $appointmentType->getType(),
                            "duration" => $appointmentType->getDuration()
                        ]
                    );
                }
            }
            $getAdvisorNotificationState = $advisor->getNotification();
        }

        return [
            "error" => 0,
            "data" => [
                "typeAndDuration" =>$typeAndDuration,
                "advisorNotificationState" =>$getAdvisorNotificationState
            ]
        ];
    }

    function cutOffTimeAction(){
        $cutOffTime = isset($_REQUEST['cutOffTime']) ? $_REQUEST['cutOffTime'] : "";

        $dbm = new DatabaseManager();
        $uid = $dbm->getUserIdByEmail($_SESSION['email']);
        $dbm->setCutOffTime($uid, $cutOffTime);

        return[
            "error" => 0,
            "dispatch" => "success"
        ];
    }

    function setEmailNotificationsAction(){
        $radioValue = isset($_REQUEST['notify']) ? $_REQUEST['notify'] : "";
        $dbm = new DatabaseManager();
        $uid = $dbm->getUserIdByEmail($_SESSION['email']);
        $user = new AdvisorUser();
        $user->setUserId($uid);
//        var_dump($user);
//        var_dump($radioValue);die();
        if (!$dbm->updateUserNotification($user, $radioValue)) {
            return [
                "error" => 1
            ];
        }

        return [
            "error" => 0,
            "dispatch" => "success",
        ];
    }

    function addTypeAndDurationAction(){
        $at = new AppointmentType();
        $type = isset($_REQUEST['apptypes']) ? $_REQUEST['apptypes'] : "";
        $duration = isset($_REQUEST['minutes']) ? $_REQUEST['minutes'] : "";
        if (!$duration){
            $duration = "5";
        }

        $at->setType($type);
        $at->setDuration($duration);
        $dbm = new DatabaseManager();
        $uid = $dbm->getUserIdByEmail($_SESSION['email']);
        $dbm->addAppointmentType($uid,$at);

        return [
            "error" => 0,
            "dispatch" => "success",
        ];
    }

    function deleteTypeAndDurationAction(){
        $at = new AppointmentType();
        $type = isset($_REQUEST['apptypes']) ? $_REQUEST['apptypes'] : "";
        $duration = isset($_REQUEST['minutes']) ? $_REQUEST['minutes'] : "";
        $at->setType($type);
        $at->setDuration($duration);
        $dbm = new DatabaseManager();
        $uid = $dbm->getUserIdByEmail($_SESSION['email']);
        $dbm->deleteAppointmentType($uid,$at);//

        return [
            "error" => 0,
            "dispatch" => "success",
        ];
    }

    public function successAction(){
        return [
            "error" => 0,
            "data" => getUrlWithoutParameters() . "?c=" . mav_encrypt("customizeSetting") . "&a=" . mav_encrypt("showAppointmentType")
        ];
    }
}