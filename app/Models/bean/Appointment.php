<?php
namespace Models\Bean;
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/2/13
 * Time: 2:12
 */
class Appointment
{
    private $pname;
    private $advisingDate;
    private $advisingStartTime;
    private $advisingEndTime;
    private $appointmentType;
    private $advisorEmail;
    private $description;
    private $studentId;
    private $appointmentId;
    private $studentEmail;
    private $studentPhoneNumber;
    private $advisorUserId;
    private $studentUserId;

    /**
     * @return mixed
     */
    public function getPname()
    {
        return $this->pname;
    }

    /**
     * @param mixed $pname
     */
    public function setPname($pname)
    {
        $this->pname = $pname;
    }

    /**
     * @return mixed
     */
    public function getAdvisingDate()
    {
        return $this->advisingDate;
    }

    /**
     * @param mixed $advisingDate
     */
    public function setAdvisingDate($advisingDate)
    {
        $this->advisingDate = $advisingDate;
    }

    /**
     * @return mixed
     */
    public function getAdvisingStartTime()
    {
        return $this->advisingStartTime;
    }

    /**
     * @param mixed $advisingStartTime
     */
    public function setAdvisingStartTime($advisingStartTime)
    {
        $this->advisingStartTime = $advisingStartTime;
    }

    /**
     * @return mixed
     */
    public function getAdvisingEndTime()
    {
        return $this->advisingEndTime;
    }

    /**
     * @param mixed $advisingEndTime
     */
    public function setAdvisingEndTime($advisingEndTime)
    {
        $this->advisingEndTime = $advisingEndTime;
    }

    /**
     * @return mixed
     */
    public function getAppointmentType()
    {
        return $this->appointmentType;
    }

    /**
     * @param mixed $appointmentType
     */
    public function setAppointmentType($appointmentType)
    {
        $this->appointmentType = $appointmentType;
    }

    /**
     * @return mixed
     */
    public function getAdvisorEmail()
    {
        return $this->advisorEmail;
    }

    /**
     * @param mixed $advisorEmail
     */
    public function setAdvisorEmail($advisorEmail)
    {
        $this->advisorEmail = $advisorEmail;
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
    public function getStudentPhoneNumber()
    {
        return $this->studentPhoneNumber;
    }

    /**
     * @param mixed $studentPhoneNumber
     */
    public function setStudentPhoneNumber($studentPhoneNumber)
    {
        $this->studentPhoneNumber = $studentPhoneNumber;
    }

    /**
     * @return mixed
     */
    public function getAdvisorUserId()
    {
        return $this->advisorUserId;
    }

    /**
     * @param mixed $advisorUserId
     */
    public function setAdvisorUserId($advisorUserId)
    {
        $this->advisorUserId = $advisorUserId;
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


}