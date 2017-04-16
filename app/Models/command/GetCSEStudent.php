<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/3/25
 * Time: 9:12
 */

namespace Models\Command;

use Models\Login\StudentUser;

class GetCSEStudent extends SQLCmd
{
    private $studentId;
    private $user;

    function __construct($studentId)
    {
        $this->studentId = $studentId;
        $this->user = new StudentUser();
    }

    function queryDB()
    {
        $query = "SELECT * FROM students where STUID='$this->studentId'";
        $this->result = $this->conn->query($query)->fetch_assoc();

        if ($this->result == null) {
            $query = "SELECT * FROM graduates where STUID='$this->studentId'";
            $this->result = $this->conn->query($query)->fetch_assoc();
        }
    }

    function processResult()
    {
        if ($this->result != null) {
            $this->user->setRole('student');
            $this->user->setStudentId($this->result["STUID"]);
            $this->user->setEmail($this->result["MavsEmail"]);
            $this->user->setDegType($this->result["Degree"]);
            $this->user->setPhoneNumber($this->result["Phone"]);
            $this->user->setLastNameInitial($this->result["Lname"]);
            return $this->user;
        }
        return ($this->result);
    }
}