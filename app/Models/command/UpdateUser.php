<?php
namespace Models\Command;
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/2/14
 * Time: 16:25
 */
use Models\Login\LoginUser;
class UpdateUser extends SQLCmd{
    private $user;

    function __construct(LoginUser $user) {
        $this->user = $user;
    }

    function queryDB(){
        $id = $this->user->getUserId();
        $email = $this->user->getEmail();
        $password = md5($this->user->getPassword());
        $role = $this->user->getRole();
        $validate = $this->user->getRole();

        $query = "UPDATE ma_user 
                  SET email = '$email', password = '$password', role = '$role', validated = '$validate'
                  WHERE userId='$id'";
        $this->result = $this->conn->query($query);
    }

    function processResult(){
        if(mysqli_affected_rows($this->conn) == 0)
            return false;
        else
            return true;
    }
}