<?php

include_once dirname(__FILE__) . "/SQLCmd.php";
include_once dirname(dirname(__FILE__)) . "/bean/Feedback.php";

class AddFeedback extends SQLCmd
{
    private $feedback;

    function __construct(Feedback $feedback)
    {
        $this->feedback = $feedback;
    }

    function queryDB()
    {
        if ($this->feedback != null) {
            $uid = $this->feedback->getUid();
            $tid = $this->feedback->getTargetId();
            $type = $this->feedback->getType();
            $title = $this->feedback->getTitle();
            $content = $this->feedback->getContent();
            $isHandled = $this->feedback->getIsHandle();

            $query = "INSERT INTO ma_feedback
                      (uid, targetId, type, title, content, isHandled)
                      VALUES($uid, $tid, '$type','$title', '$content', $isHandled)";
            $this->conn->query($query);

            if (mysqli_affected_rows($this->conn) > 0)
                $this->result = true;
            else
                $this->result = false;
        } else{
            $this->result = false;
        }
    }

    function processResult()
    {
        return $this->result;
    }
}