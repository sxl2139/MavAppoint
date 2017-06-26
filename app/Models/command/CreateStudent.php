<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/2/14
 * Time: 6:53
 */
include_once dirname(__FILE__) . "/SQLCmd.php";
include_once dirname(dirname(__FILE__)) . "/login/StudentUser.php";
class CreateStudent extends SQLCmd{
    private $user;

    function __construct(StudentUser $user) {
        $this->user = $user;
    }

    function queryDB(){
        $userId = $this->user->getUserId();
        $studentId = $this->user->getStudentId();
        $degreeType = $this->user->getDegType();
        $phoneNum = $this->user->getPhoneNumber();
        $notification = $this->user->getNotification();
        $firstName = $this->user->getFirstName();
        $lastName = $this->user->getLastName();

        $query = "INSERT INTO ma_user_student 
                  (userId,studentId,degreeType,phoneNum,notification,firstName,lastName)
				  VALUES('$userId','$studentId','$degreeType','$phoneNum','$notification','$firstName','$lastName')";
        $this->result = $this->conn->query($query);
    }

    function processResult(){
        return $this->result;
    }
}