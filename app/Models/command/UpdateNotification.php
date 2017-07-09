<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/2/14
 * Time: 16:58
 */
include_once dirname(__FILE__) . "/SQLCmd.php";
include_once dirname(dirname(__FILE__)) . "/login/LoginUser.php";
class UpdateNotification extends SQLCmd{

    private $user,$notification;

    function __construct(LoginUser $user, $notification) {
        $this->user = $user;
        $this->notification = $notification;
    }

    function queryDB(){
        $id = $this->user->getUserId();

        if($this->user->getRole() == "advisor") {
            $query = "UPDATE ma_user_advisor 
                      SET notification = '$this->notification' 
                      WHERE userId = '$id'";
        }else{
            $query = "UPDATE ma_user_student 
                      SET notification = '$this->notification' 
                      WHERE userId = '$id'";
        }
        $this->conn->query($query);
    }

    function processResult(){
        if(mysqli_affected_rows($this->conn) > 0)
            return true;
        else
            return false;
    }
}