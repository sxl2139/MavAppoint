<?php
/**
 * Created by PhpStorm.
 * User: gaolin
 * Date: 3/14/17
 * Time: 12:57 AM
 */

namespace Models;


class PrimitiveTimeSlot extends TimeSlotComponent
{
    private $name;
    private $date;
    private $starttime;
    private $endtime;
    private $uniqueid;

    public function getEvent($m)
    {

        return "{\n"
            .	"title:'Available'," . "\n"
            .	"start:'". $this->getDate() . "T" .$this->getStartTime()."',\n"
            .	"end:'" . $this->getDate() . "T" . $this->getEndTime() . "',\n"
            .	"id:" . $this->getUniqueId() . ",\n"
            ."}\n";
    }

    public function expandTimeSlots($tsArr)
    {

        array_push($tsArr,serialize($this));
        return $tsArr;
    }

    public function getName()
    {
        return $this->name;

    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getDate()
    {
        return  $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getStartTime()
    {
        return $this->starttime;
    }

    public function setStartTime($starttime)
    {
        $this->starttime = $starttime;
    }

    public function getEndTime()
    {
        return $this->endtime;
    }

    public function setEndTime($endtime)
    {
        $this->endtime = $endtime;
    }

    public function getUniqueId()
    {
        return $this->uniqueid;
    }

    public function setUniqueId($id)
    {
        $this->uniqueid = $id;
    }


}