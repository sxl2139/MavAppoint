<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/2/14
 * Time: 6:17
 */
namespace Models\Command;

class SetCutOffTime extends SQLCmd
{

    private $time, $id;

    function __construct($id, $time)
    {
        $this->id = $id;
        $this->time = $time;
    }

    function queryDB()
    {
        if ($this->time >= 0) {
            $query = "UPDATE  ma_user_advisor set cutOffTime = '$this->time' where userId = '$this->id'";
            $this->result = $this->conn->query($query);
        }
    }

    function processResult()
    {
        if ($this->conn->affected_rows > 0)
            return true;
        else
            return false;
    }
}