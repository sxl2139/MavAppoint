<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/3/20
 * Time: 16:47
 */
include_once dirname(__FILE__) . "/SQLCmd.php";
include_once dirname(dirname(__FILE__)) . "/login/AdvisorUser.php";
class GetCSEUser extends SQLCmd
{
    private $Fname;
    private $user;

    function __construct($Fname)
    {
        $this->Fname = $Fname;
        $this->user = new AdvisorUser();
    }

    function queryDB()
    {
        $query = "SELECT * FROM users where Fname='$this->Fname'";
        $this->result = $this->conn->query($query)->fetch_assoc();
    }

    function processResult()
    {
        if ($this->result != null) {
            $this->user->setPName($this->result["Fname"]);
            $this->user->setRole($this->result["UsrRole"]);
            $this->user->setEmail($this->result["Email"]);
            $this->user->setPassword($this->result["Pwd"]);
            return ($this->user);
        } else
            return ($this->result);
    }
}