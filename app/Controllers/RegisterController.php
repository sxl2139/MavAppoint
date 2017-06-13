<?php

class RegisterController
{
    public function defaultAction() {
        $_SESSION['mavAppointUrl'] = getUrlWithoutParameters();
        include_once ROOT . "/app/Models/db/DatabaseManager.php";
        $dbManager = new DatabaseManager();
        $departments = $dbManager->getDepartment();
        $majors = $dbManager->getMajorsOfDepartment($departments[0]);
        return array(
            "error" => 0,
            "data" => array(
                "degrees" => $this->getDegrees(),
                "departments" => $departments,
                "majors" => $majors,
                "initials" => $this->getInitials(),
                "url" => getUrlWithoutParameters() . "?c=" . mav_encrypt("login")
            )
        );
    }

    public function getMajorsAction() {
//        $department = isset($_REQUEST['department']) ? $_REQUEST['department'] : "CSE";
        $department = $_REQUEST['department'];
        include_once ROOT . "/app/Models/db/DatabaseManager.php";
        $dbManager = new DatabaseManager();
        $majors = $dbManager->getMajorsOfDepartment($department);
        return array(
            "error" => 0,
            "data" => array(
                "majors" => $majors
            )
        );
    }

    public function registerStudentAction() {
        $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : "";
        $studentId = isset($_REQUEST['studentId']) ? $_REQUEST['studentId'] : "";
        $phoneNumber = isset($_REQUEST['phoneNumber']) ? $_REQUEST['phoneNumber'] : "";

        if (!validateStudentId($studentId)) {
            return array(
                "error" => 1,
                "description" => "Invalid Student ID"
            );
        }

        if (!validatePhoneNumber($phoneNumber)) {
            return array(
                "error" => 1,
                "description" => "Invalid Phone Number"
            );
        }

        if (!validateEmail($email)) {
            return array(
                "error" => 1,
                "description" => "Invalid Email Address"
            );
        }
        include_once ROOT . "/app/Models/login/StudentUser.php";
        $studentUser = new StudentUser();
        $studentUser->setEmail($email);
        $studentUser->setPhoneNumber($phoneNumber);
        $studentUser->setStudentId($studentId);
        $studentUser->setRole("student");
        $studentUser->setLastNameInitial($_REQUEST['initial']);
        $studentUser->setDepartments(array($_REQUEST['department']));
        $studentUser->setMajors(array($_REQUEST['major']));
        $studentUser->setDegreeTypeFromString($_REQUEST['degree']);
        $studentUser->setNotification("yes");

        $password = generateRandomPassword();
        $studentUser->setPassword($password);

        include_once ROOT . "/app/Models/db/DatabaseManager.php";
        $dbManager = new DatabaseManager();

        $uid = $dbManager->createUser($studentUser);
        if ($uid) {
            $studentUser->setUserId($uid);
        } else {
            return array(
                "error" => 1,
                "description" => "Errors while creating user"
            );
        }

        if (!$dbManager->createStudent($studentUser)) {
            return array(
                "error" => 1,
                "description" => "Errors while creating student"
            );
        }

        mav_mail("MavAppoint Account Created",
            "<p>Your account for MavAppoint has been created! Your account information is:</p>"
            . "<p>Role: Student </p>"
            . "<p>Password: " . $password . "</p>"
            . "<br><br>Click here to <a href='" . getUrlWithoutParameters() . "?c=" . mav_encrypt("login") . "'>Login</a>", array($studentUser->getEmail()));

        return array(
            "error" => 0,
        );
    }

    public function successAction(){
        $controller = mav_encrypt($_REQUEST['nc']);
        $action = mav_encrypt($_REQUEST['na']);
        return array(
            "error" => 0,
            "data" => getUrlWithoutParameters() . "?c=$controller&a=$action"
        );
    }











    private function getDegrees() {
        return array("Bachelor", "Master", "Doctorate");
    }

    private function getInitials() {
        return array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
    }
}