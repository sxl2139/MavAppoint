<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/4/10
 * Time: 17:11
 */
include_once dirname(__FILE__) . "/SQLCmd.php";
class DeleteWaitListSchedule extends SQLCmd
{
    private $id;

    function __construct($id) {
        $this->id = $id;
    }

    function queryDB(){
        $query = "DELETE FROM ma_wait_list_schedule where id = '$this->id'";
        $this->result = $this->conn->query($query);
    }

    function processResult(){
        return $this->result;
    }
}