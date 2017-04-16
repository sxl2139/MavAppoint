<?php
/**
 * Created by PhpStorm.
 * User: gaolin
 * Date: 3/14/17
 * Time: 12:41 AM
 */
namespace Models;
abstract class TimeSlotComponent{
    public function add( TimeSlotComponent $ts ){}
    public function remove( TimeSlotComponent $ts){}
    public function get( TimeSlotComponent $ts){return null;}
    public function setStartTime($starttime){}
    public function setEndTime($endtime){}
    public function setDate($date){}
    public function setUniqueId($id){}
    public function getUniqueId(){return -1;}
    public function getName(){return null;}
    public function refactorTimeSlots($m){}
    public function setName($name){}
    abstract public function getStartTime();
    abstract public function getEndTime();
    abstract public function getDate();
    abstract public function getEvent($m);
    abstract public function expandTimeSlots( $tsArr);
}

