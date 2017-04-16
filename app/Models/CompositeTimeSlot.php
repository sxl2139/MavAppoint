<?php
/**
 * Created by PhpStorm.
 * User: gaolin
 * Date: 3/14/17
 * Time: 1:29 AM
 */

namespace Models;


class CompositeTimeSlot extends TimeSlotComponent
{
    private $children;

    /**
     * @return array
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param array $children
     */
    public function setChildren($children)
    {
        $this->children = $children;
    }// an Array stored TimeSlotComponent

    function __construct()
    {
        $this->children = array();
    }

    public function getName()
    {
        return unserialize($this->children[0])->getName();

    }

    public function add(TimeSlotComponent $ts)
    {
        array_push($this->children,serialize($ts));
    }

    public function remove(TimeSlotComponent $ts)
    {
        unset($this->children[array_search(serialize($ts) , $this->children)]);

    }

    public function get(TimeSlotComponent $ts)
    {
        return $ts;
    }

    public function getStartTime()
    {
        return unserialize($this->children[0])->getStartTime();
    }

    public function getEndTime()
    {
        return unserialize($this->children[sizeof($this->children) -1])->getEndTime();
    }

    public function getDate()
    {
        return unserialize($this->children[0])->getDate();
    }

    public function getEvent($m)
    {
        $childrenSize = sizeof($this->children);
        $cat="";
        if($m < 1) {$m=1;}
        for($i = 0 ; $i<$childrenSize + 1 - $m ; $i = $i + $m){
            $cat = $cat.unserialize($this->children[$i])->getEvent(0);
            if ($i != $childrenSize -1){
                $cat = $cat.",";
            }
            $cat = $cat."\n";
        }
        return $cat;
    }

    public function expandTimeSlots($tsArr)
    {
        for($i = 0 ; $i < sizeof($this->children); $i++){
            $tsArr = unserialize($this->children[$i])->expandTimeSlots($tsArr);
        }
        return $tsArr;
    }


}