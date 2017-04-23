<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/4/18
 * Time: 4:48
 */
include_once dirname(__FILE__) . "/SQLCmd.php";
class GetAdvisorSchedule extends SQLCmd
{
    private $name,$includeReserved,$date;

    function __construct($name,$includeReserved,$date) {
        $this->name = $name;
        $this->includeReserved = $includeReserved;
        $this->date = $date;
    }

    function queryDB(){
        try {
            if($this->includeReserved == true && $this->date!=null){
                // get one specific adviser's all time slots(include reserved).
                $command = "SELECT pName,date,start,end,id 
                            FROM ma_user,ma_advising_schedule,ma_user_advisor 
                            WHERE ma_user.userId=ma_user_advisor.userId 
                            AND ma_user.userId=ma_advising_schedule.userId 
                            AND ma_user.userId=ma_advising_schedule.userId 
                            AND ma_user_advisor.pName='$this->name'";

            }else{
                if ($this->name === "all" && $this->includeReserved==false) {
                    //get all advisers' available time slots.
                    $command = "SELECT pName,date,start,end,id 
                                FROM ma_user,ma_advising_schedule,ma_user_advisor 
                                WHERE ma_user.userId=ma_user_advisor.userId 
                                AND ma_user.userId=ma_advising_schedule.userId 
                                AND studentId is null";
                } else {
                    //get one specific adviser's available time slots
                    $command = "SELECT pName,date,start,end,id 
                                FROM ma_user,ma_advising_schedule,ma_user_advisor 
                                WHERE ma_user.userId=ma_user_advisor.userId 
                                AND ma_user.userId=ma_advising_schedule.userId 
                                AND ma_user.userId=ma_advising_schedule.userId 
                                AND ma_user_advisor.pName='$this->name' 
                                AND studentId is null";
                }

            }

            $this->result = $this->conn->query($command);

        } catch (\Exception $e) {

        }
    }

    function processResult(){
        include_once dirname(dirname(__FILE__)) . "/PrimitiveTimeSlot.php";
        include_once dirname(dirname(__FILE__)) . "/helper/TimeSlotHelper.php";

        $PrimitiveTimeSlotArr = array();
        $adviserSchedule = array();

        while ($rs = mysqli_fetch_assoc($this->result)) {
            $set = new PrimitiveTimeSlot();
            $set->setName($rs["pName"]);
            $set->setDate($rs["date"]);
            $set->setStartTime($rs["start"]);
            $set->setEndTime($rs["end"]);
            $set->setUniqueId($rs["id"]);
            array_push($PrimitiveTimeSlotArr, serialize($set));
        }

        $compositeTimeSlotArr = TimeSlotHelper::createCompositeTimeSlot($PrimitiveTimeSlotArr);


        if($this->date!=null){
            for ($i = 0; $i < sizeof($compositeTimeSlotArr); $i++) {
                $scheduleObject = unserialize($compositeTimeSlotArr[$i]);
                $startDate = $scheduleObject->getDate();
                if($startDate==$this->date)
                {
                    array_push($adviserSchedule,$scheduleObject);
                }
            }
        }
        else{
            for ($i = 0; $i < sizeof($compositeTimeSlotArr); $i++) {
                $scheduleObject = unserialize($compositeTimeSlotArr[$i]);
                $startDate = $scheduleObject->getDate();
                date_default_timezone_set('America/Chicago');
                $todayDate = date("Y-m-d");
                if($startDate>$todayDate)
                {
                    array_push($adviserSchedule,$scheduleObject);

                }
            }
        }
        return $adviserSchedule;
    }
}