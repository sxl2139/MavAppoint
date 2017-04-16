<?php
/**
 * Created by PhpStorm.
 * User: gaolin
 * Date: 3/20/17
 * Time: 12:41 AM
 */

namespace App\Controllers;

use Models\Bean\AllocateTime;
use Models\Db as db;
Use Models\Helper as Helper;

/**
 * Class DeleteTimeSlotController : This class just has one static method to support other controllers' deleting TimeSlot
 * @package App\Controllers
 */
class DeleteTimeSlotController
{
    public static function deleteTimeSlot($date, $startTime, $endTime, $emailOrName, $repeat, $reason){
        $time = new AllocateTime();
        $time->setDate($date);
        $time->setStartTime($startTime);
        $time->setEndTime($endTime);
        $time->setEmail($emailOrName);
        $time->setReasons($reason);

        $dbm = new db\DatabaseManager();
        $dbm->deleteTimeSlot($time);




        if($repeat !=0 && $repeat!=null){
            for($i = 0 ; $i<$repeat; $i++){
                $time->setDate(Helper\TimeSlotHelper::addDate($time->getDate(),1) );
                $dbm ->deleteTimeSlot($time);
            }


        }

        return "Advising hours have been deleted successfully";


    }

}