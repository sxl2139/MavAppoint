<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/3/27
 * Time: 14:10
 */

namespace Test;

use Models\Bean\AppointmentType;
use Models\Bean\WaitList;
use Models\Db\DatabaseManager;
use Models\bean\Appointment;
use Models\Login\AdvisorUser;
use Models\Login\LoginUser;
use Models\Login\StudentUser;
use Models\Bean\AllocateTime;

class DatabaseManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testGetStudentEmails()
    {
        $dbManager = new DatabaseManager();
        $res = $dbManager->getStudentEmails();
        self::assertContainsOnly('string', $res);
    }

    public function testGetCSEUser()
    {
        $dbManager = new DatabaseManager();
        $res = $dbManager->getCSEUser("");
        self::assertEquals(null, $res);
        $res = $dbManager->getCSEUser("doesnotexist");
        self::assertEquals(null, $res);
        $res = $dbManager->getCSEUser("User1");
        self::assertInstanceOf(AdvisorUser::class, $res);
    }

    public function testGetCSEStudent()
    {
        $dbManager = new DatabaseManager();
        $res = $dbManager->getCSEStudent("");
        self::assertEquals(null, $res);
        $res = $dbManager->getCSEStudent("1111111111");
        self::assertEquals(null, $res);
        $res = $dbManager->getCSEStudent("1001455617");
        self::assertInstanceOf(StudentUser::class, $res);
    }

    public function testSetCutOffTime()
    {
        $dbManager = new DatabaseManager();
        $res = $dbManager->setCutOffTime(100, rand(0, 100));
        self::assertEquals(true, $res);
        $res = $dbManager->setCutOffTime(100, -1);
        self::assertEquals(false, $res);
        $res = $dbManager->setCutOffTime(000, 1);
        self::assertEquals(false, $res);
    }

    public function testAddAppointmentType()
    {
        $at = new AppointmentType();
        $dbManager = new DatabaseManager();

        $at->setType("Test");
        $at->setDuration("100");
        $res = $dbManager->addAppointmentType(103, $at);
        self::assertEquals(true, $res);
        $res = $dbManager->addAppointmentType(103, $at);
        self::assertEquals(false, $res);

        $at->setType("Test2");
        $at->setDuration("-1");
        $res = $dbManager->addAppointmentType(103, $at);
        self::assertEquals(false, $res);
    }

    public function testDeleteAppointmentType(){
        $at = new AppointmentType();
        $dbManager = new DatabaseManager();

        $at->setType("Test");
        $at->setDuration("100");
        $res = $dbManager->deleteAppointmentType(103, $at);
        self::assertEquals(true, $res);
        $res = $dbManager->deleteAppointmentType(103, $at);
        self::assertEquals(false, $res);
        $res = $dbManager->deleteAppointmentType(100, $at);
        self::assertEquals(false, $res);
    }

    public function testGetAppointmentTypes(){
        $dbManager = new DatabaseManager();
        $res = $dbManager->getAppointmentTypes("Zhenyu Chen");
        self::assertContainsOnly(AppointmentType::class, $res);
    }

    public function testGetAppointment(){
        $dbManager = new DatabaseManager();
        $res = $dbManager->getAppointment("2017-02-14","zhangjwuta@gmail.com");
        self::assertInstanceOf(Appointment::class, $res);
    }

    public function testGetAppointments(){
        $dbManager = new DatabaseManager();

        $user = new LoginUser();
        $user->setUserId('65');
        $user->setEmail("admin@uta.edu");


        $res = $dbManager->getAppointments($user);

        self::assertContainsOnly(Appointment::class, $res);
    }

    function testGetAppointmentByStuId(){
        $dbManager = new DatabaseManager();
        $res = $dbManager->getAppointmentByStuId("1001331545","2017-02-14");
        self::assertContainsOnly(Appointment::class, $res);
    }

    public function testSetWaitListSchedule(){
        $apt = new WaitList();
        $dbManager = new DatabaseManager();

        $apt->setAppointmentId("444");
        $apt->setStudentUserId("111");
        $apt->setStudentId('1001'.(rand(0,9)).(rand(0,9)).(rand(0,9)).(rand(0,9)).(rand(0,9)).(rand(0,9)));
        $apt->setType("Swap Course");
        $apt->setDescription("Description");
        $apt->setStudentPhone("1111111111");
        $apt->setStudentEmail("test.ccc@uts.edu");

        $res = $dbManager->setWaitListSchedule($apt);
        self::assertEquals(true, $res);
    }

    public function testGetWaitListScheduleCount(){
        $dbManager = new DatabaseManager();
        $res = $dbManager->getWaitListScheduleCount("000");
        self::assertEquals(0, $res);

        $res = $dbManager->getWaitListScheduleCount("355");
        self::assertEquals(1, $res);
    }

    public function testGetStudentWaitList(){
        $dbManager = new DatabaseManager();
        $res = $dbManager->getStudentWaitList("111","444");
        //var_dump($res);
    }

    public function testGetWaitListSchedule(){
        $dbManager = new DatabaseManager();
        $res = $dbManager->getFirstWaitList("444");
        //var_dump($res);
    }

    public function testUpdateUserNotification(){
        $dbManager = new DatabaseManager();
        $user = new AdvisorUser();
        $user->setUserId('99');
        $res = $dbManager->updateUserNotification($user, "yes");
        //??
        self::assertEquals(false, $res);

        $dbManager->updateUserNotification($user, "no");

        $user->setUserId('00');
        $res = $dbManager->updateUserNotification($user, "yes");
        self::assertEquals(false, $res);
    }

    public function testUpdateAdvisor(){
        $dbManager = new DatabaseManager();
        $user = new AdvisorUser();
        $user->setUserId('99');
        $user->setPName('abcd');
        $user->setNameLow(rand(0, 9));
        $user->setNameHigh(rand(0, 9));
        $user->setNotification('yes');
        $user->setDegType('1');

        //??
        $res = $dbManager->updateAdvisor($user);
        self::assertEquals(true, $res);

        $user->setUserId('00');
        $res = $dbManager->updateAdvisor($user);
        self::assertEquals(false, $res);
    }

    public function testUpdateAppointment(){
        $apt = new Appointment();
        $dbManager = new DatabaseManager();

        $apt->setAppointmentId("1");
        $apt->setStudentId('1001331545');
        $apt->setAppointmentType("Swap Course");
        $apt->setDescription("Description");
        $apt->setStudentPhoneNumber((rand(0,9)).(rand(0,9)).(rand(0,9)).(rand(0,9)).(rand(0,9)).(rand(0,9)));
        $apt->setStudentEmail("zhangjwuta@gmail.com");

        $res = $dbManager->updateAppointment($apt);
        self::assertEquals(true, $res);

        $apt->setAppointmentId("999090");
        $res = $dbManager->updateAppointment($apt);
        self::assertEquals(false, $res);
    }

    public function testUpdatePassword(){
        $dbManager = new DatabaseManager();
        $res = $dbManager->updatePassword("zhangjwuta@gmail.com",
            (rand(0,9)).(rand(0,9)).(rand(0,9)).(rand(0,9)).(rand(0,9)).(rand(0,9)));
        self::assertEquals(true, $res);
    }

    public function testUpdateUser(){
        $dbManager = new DatabaseManager();

        $user = new LoginUser();
        $user->setUserId('99');
        $user->setEmail('zhangjwuta@gmail.com');
        $user->setPassword((rand(0,9)).(rand(0,9)).(rand(0,9)).(rand(0,9)).(rand(0,9)).(rand(0,9)));
        $user->setRole('student');
        $user->setValidated('1');

        $res = $dbManager->updateUser($user);
        self::assertEquals(true, $res);

        $user->setUserId(";");
        $res = $dbManager->updateUser($user);
        self::assertEquals(false, $res);
    }

    public function testGetMajorsOfDepartment(){
        $dbManager = new DatabaseManager();
        $res = $dbManager->getMajorsOfDepartment("CSE");
        self::assertContainsOnly('string', $res);
    }

    public function testGetDepartment(){
        $dbManager = new DatabaseManager();
        $res = $dbManager->getDepartment("100");
        self::assertContainsOnly('string', $res);
    }

    public function testGetMajor(){
        $dbManager = new DatabaseManager();
        $res = $dbManager->getMajor("100");
        self::assertContainsOnly('string', $res);
    }

    public function testGetAdvisorSchedule(){
        $dbManager = new DatabaseManager();
        $res = $dbManager->getAdvisorSchedule("Lin Gao");
        self::assertContainsOnly(TimeSlotComponent::class, $res);
    }

    public function testGetStudent(){
        $dbManager = new DatabaseManager();
        $res = $dbManager->getStudent("zhangjwuta@gmail.com");
        self::assertInstanceOf(StudentUser::class, $res);
    }

    public function testGetAdvisorsOfDepartment(){
        $dbManager = new DatabaseManager();
        $res = $dbManager->getAdvisorsOfDepartment("CSE");
        self::assertContainsOnly(AdvisorUser::class, $res);
    }

    public function testGetAdvisors(){
        $dbManager = new DatabaseManager();
        $res = $dbManager->getAdvisors();
        self::assertContainsOnly("string", $res);
    }

    public function testGetAdvisor(){
        $dbManager = new DatabaseManager();
        $res = $dbManager->getAdvisor("ad1@uta.edu");
        self::assertInstanceOf(AdvisorUser::class, $res);
    }

    public function testGetUserIdByEmail(){
        $dbManager = new DatabaseManager();
        $res = $dbManager->getUserIdByEmail("ad1@uta.edu");
        self::assertEquals(103,$res);

        $res = $dbManager->getUserIdByEmail("aaaa");
        self::assertEquals(null,$res);
    }

    public function testCreateAppointment()
    {
        $apt = new Appointment();
        $dbManager = new DatabaseManager();

        $apt->setAdvisingDate("2017-03-01");
        $apt->setAdvisingStartTime("13:55:00");
        $apt->setAdvisingEndTime("14:15:00");
        $apt->setStudentId("1001331545");
        $apt->setPname("Lin Gao");
        $apt->setAppointmentId("365");
        $apt->setAppointmentType("Swap Course");
        $apt->setDescription("Description");
        $apt->setStudentPhoneNumber("1111111111");

        $res = $dbManager->createAppointment($apt, "zhangjwuta@gmail.com");
        self::assertEquals(true, $res['response']);
    }

    public function testCancelAppointment(){
        $dbManager = new DatabaseManager();
        $res = $dbManager->cancelAppointment("365");
        self::assertEquals(true,$res);
    }

    public function testAddTimeSlot(){
        $dbManager = new DatabaseManager();
        $time = new AllocateTime();
        $time->setDate('2017-03-03');
        $time->setEmail('tengyaoli@gmail.com');
        $time->setStartTime('10:00:00');
        $time->setEndTime('10:20:00');
        $time->setReasons('advising');
        $res = $dbManager->addTimeSlot($time,'99');
        self::assertEquals(true,$res);
    }

    public function testDeleteTimeSlot(){
        $dbManager = new DatabaseManager();
        $time = new AllocateTime();
        $time->setDate('2017-03-03');
        $time->setEmail('abcd');
        $time->setStartTime('10:00:00');
        $time->setEndTime('10:20:00');
        $time->setReasons('advising');
        $res = $dbManager->deleteTimeSlot($time);
        self::assertEquals(true,$res);
    }

    public function testCreateUser(){
        $dbManager = new DatabaseManager();
        $user = new LoginUser();
        $user->setUserId('111');
        $user->setEmail(rand(0,99).'hopelty@gmail.com');
        $user->setPassword('12345678');
        $user->setRole('advisor');
        $user->setDepartments('CSE');
        $user->setMajors('Computer Science');
        $res = $dbManager->createUser($user);
        self::assertInternalType('integer',$res);
    }

    public function testCreateStudent(){
        $dbManager = new DatabaseManager();
        $user = new StudentUser();
        $user->setEmail(rand(0,9).rand(0,9).rand(0,9).'hopelty@gmail.com');
        $user->setPassword('12345678');
        $user->setStudentId('1001'.rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9));
        $user->setPhoneNumber('12345678');
        $user->setNotification('Yes');
        $user->setRole('student');
        $user->setDepartments('CSE');
        $user->setMajors('Computer Science');
        $user->setDegType("1");
        $user->setLastNameInitial("L");
        $userId = $dbManager->createUser($user);

        //??
        $user->setUserId($userId);
        $res = $dbManager->createStudent($user);
        self::assertEquals(false,$res);
    }

    public function testCreateAdvisor(){
        $dbManager = new DatabaseManager();
        $adUser = new AdvisorUser();
        $adUser->setEmail(rand(0,9).rand(0,9).rand(0,9).'hopelty@gmail.com');
        $adUser->setPassword('12345678');
        $adUser->setRole('advisor');
        $adUser->setDepartments('CSE');
        $adUser->setMajors('Computer Science');
        $adUser->setPName('tengyaoli'.rand(0,9).rand(0,9).rand(0,9));
        $adUser->setNotification('Yes');
        $adUser->setDept('a');
        $adUser->setNameHigh('z');
        $adUser->setNameLow('a');
        $adUser->setDegType('1');
        $userId = $dbManager->createUser($adUser);
        $adUser->setUserId($userId);
        $res = $dbManager->createAdvisor($adUser);
        //??
        self::assertEquals(false,$res);
    }

    public function testDeleteAdvisor(){
        $dbManager = new DatabaseManager();
        $res = $dbManager->deleteAdvisor('156');
        self::assertEquals(false,$res);
    }
}
