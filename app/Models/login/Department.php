<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/2/13
 * Time: 3:05
 */
namespace Models\Login;

class Department{
    private $name;
    private $majors;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
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


}