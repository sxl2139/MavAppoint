<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/2/13
 * Time: 2:18
 */

class CustomizeSettings{

    private $pName;
    private $email;
    private $notification;

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