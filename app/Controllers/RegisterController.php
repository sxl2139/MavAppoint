<?php

namespace App\Controllers;

use Models\Db\DatabaseManager;
use Models\Login\StudentUser;

class RegisterController
{
    public function defaultAction() {
        $dbManager = new DatabaseManager();
        $departments = $dbManager->getDepartment();
        $majors = $dbManager->getMajorsOfDepartment($departments[0]);
        return [
            "error" => 0,
            "data" => [
                "degrees" => $this->getDegrees(),
                "departments" => $departments,
                "majors" => $majors,
                "initials" => $this->getInitials(),
                "url" => getUrlWithoutParameters() . "?c=" . mav_encrypt("login")
            ]
        ];
    }

    public function getMajorsAction() {
//        $department = isset($_REQUEST['department']) ? $_REQUEST['department'] : "CSE";
        $department = $_REQUEST['department'];
        $dbManager = new DatabaseManager();
        $majors = $dbManager->getMajorsOfDepartment($department);
        return [
            "error" => 0,
            "data" => [
                "majors" => $majors
            ]
        ];
    }

    public function registerStudentAction() {
        $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : "";
        $studentId = isset($_REQUEST['studentId']) ? $_REQUEST['studentId'] : "";
        $phoneNumber =isset($_REQUEST['phoneNumber']) ? $_REQUEST['phoneNumber'] : "";

        if (!validateStudentId($studentId)) {
            return [
                "error" => 1,
                "description" => "Invalid Student ID"
            ];
        }

        if (!validatePhoneNumber($phoneNumber)) {
            return [
                "error" => 1,
                "description" => "Invalid Phone Number"
            ];
        }

        if (!validateEmail($email)) {
            return [
                "error" => 1,
                "description" => "Invalid Email Address"
            ];
        }

        $studentUser = new StudentUser();
        $studentUser->setEmail($email);
        $studentUser->setPhoneNumber($phoneNumber);
        $studentUser->setStudentId($studentId);
        $studentUser->setRole("student");
        $studentUser->setLastNameInitial($_REQUEST['initial']);
        $studentUser->setDepartments([$_REQUEST['department']]);
        $studentUser->setMajors([$_REQUEST['major']]);
        $studentUser->setDegreeTypeFromString($_REQUEST['degree']);
        $studentUser->setNotification("yes");

        $password = generateRandomPassword();
        $studentUser->setPassword($password);

        $dbManager = new DatabaseManager();

        $uid = $dbManager->createUser($studentUser);
        if ($uid) {
            $studentUser->setUserId($uid);
        } else {
            return [
                "error" => 1,
                "description" => "Errors while creating user"
            ];
        }

        if (!$dbManager->createStudent($studentUser)) {
            return [
                "error" => 1,
                "description" => "Errors while creating student"
            ];
        }

        mav_mail("MavAppoint Account Created",
            "<p>Your account for MavAppoint has been created! Your account information is:</p>"
            . "<p>Role: Student </p>"
            . "<p>Password: " . $password . "</p>"
            . "<br><br>Click here to <a href='" . getUrlWithoutParameters() . "?c=" . mav_encrypt("login") . "'>Login</a>", [$studentUser->getEmail()]);

        return [
            "error" => 0,
        ];
    }











    private function getDegrees() {
        return array("Bachelor", "Master", "Doctorate");
    }

    private function getInitials() {
        return array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
    }
}