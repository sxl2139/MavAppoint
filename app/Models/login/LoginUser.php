<?php
namespace Models\Login;
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/2/13
 * Time: 3:00
 */
class LoginUser
{
    private $userId;
    private $password;
    private $validated;
    private $role;
    private $majors;
    private $departments;
    private $degType;
    private $email;
    private $msg;

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getValidated()
    {
        return $this->validated;
    }

    /**
     * @param mixed $validated
     */
    public function setValidated($validated)
    {
        $this->validated = $validated;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @return mixed
     */
    public function getMajors()
    {
        return $this->majors;
    }

    /**
     * @param mixed $majors
     */
    public function setMajors($majors)
    {
        $this->majors = $majors;
    }

    /**
     * @return mixed
     */
    public function getDepartments()
    {
        return $this->departments;
    }

    /**
     * @param mixed $departments
     */
    public function setDepartments($departments)
    {
        $this->departments = $departments;
    }

    /**
     * @return mixed
     */
    public function getDegType()
    {
        return $this->degType;
    }

    /**
     * @param mixed $degType
     */
    public function setDegType($degType)
    {
        $this->degType = $degType;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getMsg()
    {
        return $this->msg;
    }

    /**
     * @param mixed $msg
     */
    public function setMsg($msg)
    {
        $this->msg = $msg;
    }

    public function accept(){

    }

    public function setDegreeTypeFromString($degreeTypeString) {
		if($degreeTypeString == "Bachelor")
            $degreeType = 1;
        else if($degreeTypeString == "Master")
            $degreeType = 2;
        else if($degreeTypeString == "Bachelor,Master")
            $degreeType = 3;
        else if($degreeTypeString == "Doctorate")
            $degreeType = 4;
        else if($degreeTypeString == "Bachelor,Doctorate")
            $degreeType = 5;
        else if($degreeTypeString == "Master,Doctorate")
            $degreeType = 6;
        else
            $degreeType = 7;

		$this->degType = $degreeType;
    }
}