<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/2/13
 * Time: 3:06
 */
namespace Models\Login;

Class StudentUser extends LoginUser{
    private $studentId;
    private $phoneNumber;
    private $lastNameInitial;
    private $carrier;
    private $notification;

    /**
     * @return mixed
     */
    public function getStudentId()
    {
        return $this->studentId;
    }

    /**
     * @param mixed $studentId
     */
    public function setStudentId($studentId)
    {
        $this->studentId = $studentId;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param mixed $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return mixed
     */
    public function getLastNameInitial()
    {
        return $this->lastNameInitial;
    }

    /**
     * @param mixed $lastNameInitial
     */
    public function setLastNameInitial($lastNameInitial)
    {
        $this->lastNameInitial = $lastNameInitial;
    }

    /**
     * @return mixed
     */
    public function getNotification()
    {
        return $this->notification;
    }

    /**
     * @param mixed $notification
     */
    public function setNotification($notification)
    {
        $this->notification = $notification;
    }


}