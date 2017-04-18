<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/2/14
 * Time: 8:04
 */
include_once dirname(__FILE__) . "/SQLCmd.php";
class GetAdvisorSchedules extends SQLCmd{
    private $advisors,$available;

    function __construct(array $advisors, $available) {
        $this->advisors = $advisors;
        $this->available = $available;
    }

    function queryDB(){
        $num = count($this->advisors);
        $arr = array();
        for($i=0;$i<$num;++$i) {
            $pName = $this->advisors[$i];

            if($this->available)
                $query = "SELECT pName,date,start,end,id 
                          FROM ma_user,ma_advising_schedule,ma_user_advisor
                          WHERE ma_user.userId=ma_user_advisor.userId 
                          AND ma_user.userId= ma_advising_schedule.userId
                          AND ma_user_advisor.pName= '$pName' 
                          AND studentId is null";

            else
                $query = "SELECT id,ma_user_advisor.pName,date,start,end,studentId 
                          FROM ma_advising_schedule,ma_user_advisor 
                          WHERE ma_user_advisor.userId=ma_advising_schedule.userId 
                          AND ma_user_advisor.pName='$pName' 
                          AND ma_advising_schedule.studentId is not null";

            $res = $this->conn->query($query);

            while($rs = mysqli_fetch_assoc($res)){
                array_push($arr, $rs);
            }
        }
        $this->result = $arr;
    }

    function processResult(){
        include_once dirname(dirname(__FILE__)) . "/PrimitiveTimeSlot.php";
        include_once dirname(dirname(__FILE__)) . "/helper/TimeSlotHelper.php";

        $num = count($this->result);
        $PrimitiveTimeSlotArr = array();
        for($i=0;$i<$num;++$i){
            $rs = $this->result[$i];

            $set = new PrimitiveTimeSlot();
            $set->setName($rs["pName"]);
            $set->setDate($rs["date"]);
            $set->setStartTime($rs["start"]);
            $set->setEndTime($rs["end"]);
            $set->setUniqueid($rs["id"]);
            array_push($PrimitiveTimeSlotArr, serialize($set));
        }

        $compositeTimeSlotArr = TimeSlotHelper::createCompositeTimeSlot2($PrimitiveTimeSlotArr);

        return $compositeTimeSlotArr;
    }
}