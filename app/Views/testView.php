<?php

/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/2/13
 * Time: 17:25
 */
use Models\Db as db;
use Models\Login as login;
use Models\Bean as bean;

use Models\CompositeTimeSlot;


$manager = new db\DatabaseManager();

echo "getStudentEmails</br>";
$res = $manager->getStudentEmails();
print_r($res);echo '</br>';
echo "==============================</br>";

echo "getAdvisorsOfDepartment</br>";
$res = $manager->getAdvisorsOfDepartment("CSE");
print_r($res);echo '</br>';
echo "==============================</br>";

echo "getCSEStudent</br>";
$res = $manager->getCSEStudent("1001455617");
var_dump($res);echo '</br>';
echo "==============================</br>";

echo "getCSEUser</br>";
$res = $manager->getCSEUser("User1");
var_dump($res);echo '</br>';
echo "==============================</br>";


echo "getUserIdByEmail</br>";
$res = $manager->getUserIdByEmail("admin@uta.edu");
var_dump($res);echo '</br>';
echo "==============================</br>";

echo "createUser</br>";
////include_once dirname(dirname(__FILE__))."/login/LoginUser.php";
$user = new login\LoginUser();
$user->setEmail("aaaa@uta.edu");
$user->setPassword("12345678");
$user->setRole("student");
$user->setMajors(array("m1"));
$user->setDepartments(array("dep1"));
$res = $manager->createUser($user);
var_dump($res);echo '</br>';
echo "==============================</br>";

echo "CreateStudent</br>";
////include_once dirname(dirname(__FILE__))."/login/StudentUser.php";
$studentUser = new login\StudentUser();
$studentUser->setUserId("11");
$studentUser->setStudentId("1001455666");
$studentUser->setDegType("1");
$studentUser->setPhoneNumber("1231321111");
$studentUser->setLastNameInitial("A");
$studentUser->setNotification("Yes");
$res = $manager->createStudent($studentUser);
var_dump($res);echo '</br>';
echo "==============================</br>";

echo "getStudent</br>";
$res = $manager->getStudent("shaoying.li@mavs.uta.edu");
var_dump($res);echo '</br>';
echo "==============================</br>";

echo "createAdvisor</br>";
//include_once dirname(dirname(__FILE__))."/login/AdvisorUser.php";
$advisorUser = new login\AdvisorUser();
$advisorUser->setUserId("99");
$advisorUser->setPName("abcd");
$advisorUser->setNotification("no");
$advisorUser->setNameLow("a");
$advisorUser->setNameHigh("b");
$advisorUser->setDegType("1");
$res = $manager->createAdvisor($advisorUser);
var_dump($res);echo '</br>';
echo "==============================</br>";

echo "getAdvisor</br>";
$res = $manager->getAdvisor("ad1@uta.edu");
var_dump($res);echo '</br>';
echo "==============================</br>";

echo "getAdvisors</br>";
$res = $manager->getAdvisors();
var_dump($res);echo '</br>';
echo "==============================</br>";

echo "AddAppointmentType</br>";
//include_once dirname(dirname(__FILE__))."/bean/AppointmentType.php";
$at = new bean\AppointmentType();
$at->setType("type_test");
$at->setDuration("10");
$at->setEmail("ad1@uta.edu");
$res = $manager->addAppointmentType($advisorUser, $at);
var_dump($res);echo '</br>';
echo "==============================</br>";

echo "DeleteAppointmentType</br>";
//include_once dirname(dirname(__FILE__))."/bean/AppointmentType.php";
$res = $manager->deleteAppointmentType($advisorUser, $at);
var_dump($res);echo '</br>';
echo "==============================</br>";

echo "CheckUser</br>";
//include_once dirname(dirname(__FILE__))."/bean/GetSet.php";
$set = new bean\GetSet();
$set->setEmail("cathysui307@gmail.com");
$set->setPassword("123456789");
$res = $manager->checkUser($set);
var_dump($res);echo '</br>';
echo "==============================</br>";

echo "getAdmin</br>";
$res = $manager->getAdmin("cathysui307@gmail.com");
var_dump($res);echo '</br>';
echo "==============================</br>";

echo "getFaculty</br>";
$res = $manager->getFaculty("cathysui307@gmail.com");
var_dump($res);echo '</br>';
echo "==============================</br>";

echo "updatePassword</br>";
$res = $manager->updatePassword("cathysui307@gmail.com", "123456789");
var_dump($res);echo '</br>';
echo "==============================</br>";

echo "createAppointment</br>";
//include_once dirname(dirname(__FILE__))."/bean/Appointment.php";
$apt = new bean\Appointment();
$apt->setPname("Lin Gao");
$apt->setAppointmentId("1");
$apt->setAdvisingDate("2017-02-14");
$apt->setAdvisingStartTime("0");
$apt->setAdvisingEndTime("0");
$apt->setAppointmentType("1");
$apt->setDescription("description");
$apt->setStudentPhoneNumber("1111111111");
$res = $manager->createAppointment($apt, "shaoying.li@mavs.uta.edu");
var_dump($res);echo '</br>';
echo "==============================</br>";


//echo "getAdvisorSchedule</br>";
//$name = "Lin Gao";
//$res = $manager->getAdvisorSchedule($name);
//var_dump($res);
//echo '</br>';
//echo "==============================</br>";

echo "getAdvisorSchedules</br>";
$arr = array('test4');
$res = $manager->getAdvisorSchedules($arr);
var_dump($res);echo '</br>';
echo "==============================</br>";

echo "getAdvisorWaitlistSchedules</br>";
$arr = array('Lin Gao');
$res = $manager->getAdvisorWaitlistSchedules($arr);
var_dump($res);echo '</br>';
echo "==============================</br>";

echo "getAppointment</br>";
$res = $manager->getAppointment("2017-02-14", "shaoying.li@mavs.uta.edu");
var_dump($res);echo '</br>';
echo "==============================</br>";

echo "getAppointments</br>";
$studentUser = new login\StudentUser();
$studentUser->setEmail("shaoying.li@mavs.uta.edu");
$studentUser->setUserId("99");
$res = $manager->getAppointments($studentUser);
var_dump($res);echo '</br>';
echo "==============================</br>";

echo "getAppointmentTypes</br>";
$res = $manager->getAppointmentTypes('Lin Gao');
var_dump($res);echo '</br>';
echo "==============================</br>";

echo "updateAppointment</br>";
$res = $manager->updateAppointment($apt);
var_dump($res);echo '</br>';
echo "==============================</br>";

echo "cancelAppointments</br>";
$res = $manager->cancelAppointment('1');
var_dump($res);echo '</br>';
echo "==============================</br>";

echo "getMajor</br>";
$res = $manager->getMajor(null);
var_dump($res);echo '</br>';
echo "==============================</br>";

echo "getAdvisorsOfDepartment</br>";
$res = $manager->getAdvisorsOfDepartment('CSE');
var_dump($res);echo '</br>';
echo "==============================</br>";

echo "updateAdvisor</br>";
$res = $manager->updateAdvisor($advisorUser);
var_dump($res);echo '</br>';
echo "==============================</br>";

echo "updateUser</br>";
$res = $manager->updateUser($user);
var_dump($res);echo '</br>';
echo "==============================</br>";

echo "deleteAdvisor</br>";
$res = $manager->deleteAdvisor('8');
var_dump($res);echo '</br>';
echo "==============================</br>";

echo "updateNotification</br>";
$res = $manager->updateUserNotification($advisorUser, "new notice");
var_dump($res);echo '</br>';
echo "==============================</br>";

echo "getDepartment</br>";
$res = $manager->getDepartment("102");
var_dump($res);echo '</br>';
echo "==============================</br>";

echo "getMajorsOfDepartment</br>";
$res = $manager->getMajorsOfDepartment("CSE");
var_dump($res);echo '</br>';
echo "==============================</br>";

echo "addTimeSlot</br>";
//include_once dirname(dirname(__FILE__))."/bean/AllocateTime.php";
$time = new bean\AllocateTime();
$time->setDate("2016-02-22");
$time->setStartTime("10:55");
$time->setEndTime("11:15");
$res = $manager->addTimeSlot($time, '99');
var_dump($res);echo '</br>';
echo "==============================</br>";

echo "deleteTimeSlot</br>";
$time = new bean\AllocateTime();
$time->setDate("2016-02-22");
$time->setStartTime("10:55");
$time->setEndTime("11:15");
$res = $manager->deleteTimeSlot($time, '99');
var_dump($res);echo '</br>';
echo "==============================</br>";

echo "setCutOffTime</br>";
$res = $manager->setCutOffTime("99","1");
var_dump($res);echo '</br>';
echo "==============================</br>";