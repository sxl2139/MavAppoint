<?php

class IndexController
{
    public function defaultAction(){
        //$_SERVER['REMOTE_USER'] = "zxl5624xxxxxxxx";
        //Create student account automatically for CSE department
//        if (isset($_SERVER['REMOTE_USER'])) {
//            $netId = substr($_SERVER['REMOTE_USER'], 0, -8);
//
//            include_once ROOT . "/app/Models/db/DatabaseManager.php";
//            $dbManager = new DatabaseManager();
//            $cseStudent = $dbManager->getCSEStudentByNetId($netId);
//            $email = $cseStudent->getEmail();
//
//            $uid = $dbManager->getUserIdByEmail($email);
//            if (!$uid) {
//                $studentUser = new StudentUser();
//                $studentUser->setEmail($cseStudent->getEmail());
//                $studentUser->setPhoneNumber($cseStudent->getPhoneNumber());
//                $studentUser->setStudentId($cseStudent->getStudentId());
//                $studentUser->setRole("student");
//                $studentUser->setLastNameInitial(substr(ucfirst($cseStudent->getLname()), 0, 1));
//                $studentUser->setDepartments(array("CSE"));
//                $studentUser->setMajors(array(config("majors." . $cseStudent->getProgram())));
//                $studentUser->setDegreeTypeFromString(config("degrees." . $cseStudent->getDegree()));
//                $studentUser->setNotification("yes");
//
//                $password = generateRandomPassword();
//                $studentUser->setPassword($password);
//
//                $uid = $dbManager->createUser($studentUser);
//                if ($uid) {
//                    $studentUser->setUserId($uid);
//                } else {
//                    die("Errors while creating user for advising");
//                }
//
//                if (!$dbManager->createStudent($studentUser)) {
//                    die("Errors while creating student for advising");
//                }
//
//            }
//
//            $_SESSION['email'] = $email;
//            $_SESSION['role'] = "student";
//            $_SESSION['uid'] = $uid;
//
//        }

        $_SESSION['mavAppointUrl'] = getUrlWithoutParameters();

        return array(
            "error" => 0
        );
    }
}