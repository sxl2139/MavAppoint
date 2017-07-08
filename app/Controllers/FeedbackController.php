<?php
include_once ROOT . "/app/Models/db/DatabaseManager.php";
class FeedbackController
{
    public function getFeedbackAdvisorAction(){

        $_SESSION['mavAppointUrl'] = getUrlWithoutParameters();
        $advisors = "";
        if (isset($_SESSION['email'])) {
            $dbManager = new DatabaseManager();
            $advisors = $dbManager->getAdvisors();
        }

        return array(
            "error" => 0,
            "data" => array(
                "advisors" => $advisors
            )
        );
    }

    public function addFeedbackAction() {
        include_once ROOT . "/app/Models/bean/Feedback.php";
        $feedback = new Feedback();
        $feedback->setUid($_SESSION['uid']);
        $feedback->setTargetId($_REQUEST['tid']);
        $feedback->setType($_REQUEST['type']);
        $feedback->setTitle($_REQUEST['title']);
        $feedback->setContent($_REQUEST['content']);
        $feedback->setIsHandle(0);

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

    public function getFeedbackAction(){
        return array(
            "error" => 0
        );
    }
}