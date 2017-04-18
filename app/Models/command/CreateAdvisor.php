<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/2/14
 * Time: 0:20
 */
include_once dirname(__FILE__) . "/SQLCmd.php";
include_once dirname(dirname(__FILE__)) . "/login/AdvisorUser.php";

class CreateAdvisor extends SQLCmd{
    private $advisorUser;

    function __construct(AdvisorUser $advisorUser) {
        $this->advisorUser = $advisorUser;
    }

    function queryDB(){
        $userId = $this->advisorUser->getUserId();
        $pName = $this->advisorUser->getPName();
        $notification = $this->advisorUser->getNotification();
        $name_low = $this->advisorUser->getNameLow();
        $name_high = $this->advisorUser->getNameHigh();
        $degree_type = $this->advisorUser->getDegType();

        $query = "INSERT INTO ma_user_advisor 
                  (userId,pName,notification,nameLow,nameHigh,degreeTypes, cutOffTime) 
                  VALUES('$userId','$pName','$notification','$name_low','$name_high','$degree_type','0')";

        $this->result = $this->conn->query($query);
    }

    function processResult(){
        return $this->result;
    }
}