<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/2/14
 * Time: 7:55
 */
include_once dirname(__FILE__) . "/SQLCmd.php";
class UpdateFeedback extends SQLCmd {
    private $fid,$isHandled;

    function __construct($fid,$isHandled) {
        $this->fid = $fid;
        $this->isHandled = $isHandled;
    }

    function queryDB() {
        $query = "UPDATE ma_feedback SET isHandled = '$this->isHandled' where fid = '$this->fid'";
        $this->conn->query($query);

        if (mysqli_affected_rows($this->conn) == 0) {
            $this->result = false;
        } else {
            $this->result = true;
        }
    }

    function processResult() {
        return $this->result;
    }
}