<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/2/13
 * Time: 2:24
 */

class WaitList{
    private $id;
    private $appointmentId;
    private $studentUserId;
    private $studentId;
    private $studentEmail;
    private $studentPhone;
    private $type;
    private $description;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getAppointmentId()
    {
        return $this->appointmentId;
    }

    /**
     * @param mixed $appointmentId
     */
    public function setAppointmentId($appointmentId)
    {
        $this->appointmentId = $appointmentId;
    }

    /**
     * @return mixed
     */
    public function getStudentUserId()
    {
        return $this->studentUserId;
    }

    /**
     * @param mixed $studentUserId
     */
    public function setStudentUserId($studentUserId)
    {
        $this->studentUserId = $studentUserId;
    }

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
    public function getStudentEmail()
    {
        return $this->studentEmail;
    }

    /**
     * @param mixed $studentEmail
     */
    public function setStudentEmail($studentEmail)
    {
        $this->studentEmail = $studentEmail;
    }

    /**
     * @return mixed
     */
    public function getStudentPhone()
    {
        return $this->studentPhone;
    }

    /**
     * @param mixed $studentPhone
     */
    public function setStudentPhone($studentPhone)
    {
        $this->studentPhone = $studentPhone;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }


}