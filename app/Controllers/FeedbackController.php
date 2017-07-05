<?php

class FeedbackController
{
    public function addFeedbackAction() {
        include_once ROOT . "/app/Models/bean/Feedback.php";
        $feedback = new Feedback();
        $feedback->setUid($_REQUEST['uid']);
        $feedback->setTargetId($_REQUEST['tid']);
        $feedback->setType($_REQUEST['type']);
        $feedback->setTitle($_REQUEST['title']);
        $feedback->setContent($_REQUEST['content']);
        $feedback->setIsHandle(0);

        include_once ROOT . "/app/Models/db/DatabaseManager.php";
        $dbManager = new DatabaseManager();
        if (!$dbManager->addFeedback($feedback)) {
            return array(
                "error" => 1,
                "description" => "Errors while creating feedback"
            );
        }

        return array(
            "error" => 0
        );
    }
}