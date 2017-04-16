<?php

namespace Models\Command;

use Models\Login\CSEStudent;

class GetCSEStudentByNetId extends SQLCmd
{
    private $netId;

    function __construct($netId)
    {
        $this->netId = $netId;
    }

    function queryDB()
    {
        $query = "SELECT * FROM students where NETID='$this->netId'";
        $this->result = $this->conn->query($query)->fetch_assoc();
    }

    function processResult()
    {
        $user = null;
        if ($this->result != null) {
            $user = new CSEStudent();
            $user->setNetId($this->result['NETID']);
            $user->setStudentId($this->result['STUID']);
            $user->setEmail($this->result['MavsEmail']);
            $user->setDegree($this->result['Degree']);
            $user->setFname($this->result['Fname']);
            $user->setMname($this->result['Mname']);
            $user->setLname($this->result['Lname']);
            $user->setPhoneNumber($this->result['Phone']);
            $user->setProgram($this->result['Program']);
        }
        return $user;
    }
}