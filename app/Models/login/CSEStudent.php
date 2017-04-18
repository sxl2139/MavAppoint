<?php
class CSEStudent
{

    /**
     * @var string
     */
    private $netId;

    /**
     * @var int
     */
    private $studentId;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $phoneNumber;

    /**
     * @var string
     */
    private $Fname;

    /**
     * @var string
     */
    private $Mname;

    /**
     * @var string
     */
    private $Lname;

    /**
     * @var string
     */
    private $program;

    /**
     * @var string
     */
    private $degree;



    /**
     * @return string
     */
    public function getNetId()
    {
        return $this->netId;
    }

    /**
     * @param string $netId
     */
    public function setNetId($netId)
    {
        $this->netId = $netId;
    }

    /**
     * @return int
     */
    public function getStudentId()
    {
        return $this->studentId;
    }

    /**
     * @param int $studentId
     */
    public function setStudentId($studentId)
    {
        $this->studentId = $studentId;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return string
     */
    public function getFname()
    {
        return $this->Fname;
    }

    /**
     * @param string $Fname
     */
    public function setFname($Fname)
    {
        $this->Fname = $Fname;
    }

    /**
     * @return string
     */
    public function getMname()
    {
        return $this->Mname;
    }

    /**
     * @param string $Mname
     */
    public function setMname($Mname)
    {
        $this->Mname = $Mname;
    }

    /**
     * @return string
     */
    public function getLname()
    {
        return $this->Lname;
    }

    /**
     * @param string $Lname
     */
    public function setLname($Lname)
    {
        $this->Lname = $Lname;
    }

    /**
     * @return string
     */
    public function getProgram()
    {
        return $this->program;
    }

    /**
     * @param string $program
     */
    public function setProgram($program)
    {
        $this->program = $program;
    }

    /**
     * @return string
     */
    public function getDegree()
    {
        return $this->degree;
    }

    /**
     * @param string $degree
     */
    public function setDegree($degree)
    {
        $this->degree = $degree;
    }


}