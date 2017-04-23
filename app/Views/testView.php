<?php

/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/2/13
 * Time: 17:25
 */

include_once dirname(dirname(__FILE__)) . "/Models/db/DatabaseManager.php";
$manager = new DatabaseManager();

include_once dirname(dirname(__FILE__))."/Models/bean/GetSet.php";
$set = new GetSet();
$set->setEmail("cathysui307@gmail.com");
$set->setPassword("123456789");

include_once dirname(dirname(__FILE__))."/Models/login/LoginUser.php";
$user = new LoginUser();
$user->setEmail("aaaa@uta.edu");
$user->setPassword("12345678");
$user->setRole("student");
$user->setMajors(array("m1"));
$user->setDepartments(array("dep1"));

include_once dirname(dirname(__FILE__))."/Models/login/StudentUser.php";
$studentUser = new StudentUser();
$studentUser->setUserId("11");
$studentUser->setStudentId("1001455666");
$studentUser->setDegType("1");
$studentUser->setPhoneNumber("1231321111");
$studentUser->setLastNameInitial("A");
$studentUser->setNotification("Yes");

include_once dirname(dirname(__FILE__))."/Models/login/AdvisorUser.php";
$advisorUser = new AdvisorUser();
$advisorUser->setUserId("99");
$advisorUser->setPName("abcd");
$advisorUser->setNotification("no");
$advisorUser->setNameLow("a");
$advisorUser->setNameHigh("b");
$advisorUser->setDegType("1");

include_once dirname(dirname(__FILE__))."/Models/bean/Appointment.php";
$apt = new Appointment();
$apt->setPname("Lin Gao");
$apt->setAppointmentId("1");
$apt->setAdvisingDate("2017-02-14");
$apt->setAdvisingStartTime("0");
$apt->setAdvisingEndTime("0");
$apt->setAppointmentType("1");
$apt->setDescription("description");
$apt->setStudentPhoneNumber("1111111111");

include_once dirname(dirname(__FILE__))."/Models/bean/AppointmentType.php";
$at = new AppointmentType();
$at->setType("type_test");
$at->setDuration("10");
$at->setEmail("ad1@uta.edu");

include_once dirname(dirname(__FILE__))."/Models/bean/AllocateTime.php";
$time = new AllocateTime();
$time->setDate("2016-02-22");
$time->setStartTime("10:55");
$time->setEndTime("11:15");


echo "getStudentWaitList</br>";
$res = $manager->getStudentWaitList("111","444");
var_dump($res);echo '</br>';
echo "==============================</br>";

echo "getStudentEmails</br>";
$res = $manager->getStudentEmails();
var_dump($res);echo '</br>';
echo "==============================</br>";

echo "getAdvisorsOfDepartment</br>";
$res = $manager->getAdvisorsOfDepartment("CSE");
var_dump($res);echo '</br>';
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
$res = $manager->createUser($user);
var_dump($res);echo '</br>';
echo "==============================</br>";

echo "CreateStudent</br>";
$res = $manager->createStudent($studentUser);
var_dump($res);echo '</br>';
echo "==============================</br>";

echo "getStudent</br>";
var_dump($res);echo '</br>';
echo "==============================</br>";

echo "createAdvisor</br>";
$res = $manager->createAdvisor($advisorUser);
var_dump($res);echo '</br>';
echo "==============================</br>";

echo "getAdvisor</br>";
$res = $manager->getAdvisor("ad2@uta.edu");
var_dump($res);echo '</br>';
echo "==============================</br>";

echo "getAdvisors</br>";
$res = $manager->getAdvisors();
var_dump($res);echo '</br>';
echo "==============================</br>";

echo "AddAppointmentType</br>";
$res = $manager->addAppointmentType($advisorUser->getUserId(), $at);
var_dump($res);echo '</br>';
echo "==============================</br>";

echo "DeleteAppointmentType</br>";
$res = $manager->deleteAppointmentType($advisorUser->getUserId(), $at);
var_dump($res);echo '</br>';
echo "==============================</br>";

echo "CheckUser</br>";
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
$res = $manager->createAppointment($apt, "shaoying.li@mavs.uta.edu");
var_dump($res);echo '</br>';
echo "==============================</br>";


echo "getAdvisorSchedule</br>";
$name = "all";
$res = $manager->getAdvisorSchedule($name);
var_dump($res);
echo '</br>';
echo "==============================</br>";

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

echo "getAppointmentByStuId</br>";
$res = $manager->getAppointmentByStuId("1001331545","2017-02-14");
var_dump($res);echo '</br>';
echo "==============================</br>";

echo "getAppointments</br>";
$studentUser = new StudentUser();
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
$res = $manager->addTimeSlot($time, '99');
var_dump($res);echo '</br>';
echo "==============================</br>";

echo "deleteTimeSlot</br>";
$res = $manager->deleteTimeSlot($time, '99');
var_dump($res);echo '</br>';
echo "==============================</br>";

echo "setCutOffTime</br>";
$res = $manager->setCutOffTime("99","1");
var_dump($res);echo '</br>';
echo "==============================</br>";