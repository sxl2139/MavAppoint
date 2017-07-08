<?php

include_once dirname(__FILE__) . "/SQLCmd.php";
class GetFeedback extends SQLCmd{

    private $uid;
    private $role;

    function __construct($uid, $role)
    {
        $this->uid = $uid;
        $this->role = $role;
    }

    function queryDB(){
        $query = "";
        if($this->role == "admin")
            $query = "SELECT * FROM ma_feedback WHERE type = 'System'";
        else if ($this->role == 'advisor')
            $query = "select * from ma_feedback WHERE type = 'Advising' AND targetId = $this->uid";

        $this->result = $this->conn->query($query);
    }

    function processResult(){
        $arr = array();
        if (!$this->result) return $arr;

        include_once dirname(dirname(__FILE__)) . "/bean/Feedback.php";
        while($rs = mysqli_fetch_assoc($this->result)){
            $feedback = new Feedback();
            $feedback->setFid($rs['fid']);
            $feedback->setUid($rs['uid']);
            $feedback->setTargetId($rs['targetId']);
            $feedback->setType($rs['type']);
            $feedback->setTitle($rs['title']);
            $feedback->setContent($rs['content']);
            $feedback->setIsHandle($rs['isHandled']);

            array_push($arr, $feedback);
        }

        return $arr;
    }
}