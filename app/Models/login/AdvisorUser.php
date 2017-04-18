<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/2/13
 * Time: 3:02
 */
include_once dirname(__FILE__) . "/LoginUser.php";
class AdvisorUser extends LoginUser{
    private $pName;
    private $dept;
    private $notification;
    private $nameLow;
    private $nameHigh;
    private $cutOffPreference;

    /**
     * @return mixed
     */
    public function getPName()
    {
        return $this->pName;
    }

    /**
     * @param mixed $pName
     */
    public function setPName($pName)
    {
        $this->pName = $pName;
    }

    /**
     * @return mixed
     */
    public function getDept()
    {
        return $this->dept;
    }

    /**
     * @param mixed $dept
     */
    public function setDept($dept)
    {
        $this->dept = $dept;
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

    /**
     * @return mixed
     */
    public function getNameLow()
    {
        return $this->nameLow;
    }

    /**
     * @param mixed $nameLow
     */
    public function setNameLow($nameLow)
    {
        $this->nameLow = $nameLow;
    }

    /**
     * @return mixed
     */
    public function getNameHigh()
    {
        return $this->nameHigh;
    }

    /**
     * @param mixed $nameHigh
     */
    public function setNameHigh($nameHigh)
    {
        $this->nameHigh = $nameHigh;
    }

    /**
     * @return mixed
     */
    public function getCutOffPreference()
    {
        return $this->cutOffPreference;
    }

    /**
     * @param mixed $cutOffPreference
     */
    public function setCutOffPreference($cutOffPreference)
    {
        $this->cutOffPreference = $cutOffPreference;
    }


}