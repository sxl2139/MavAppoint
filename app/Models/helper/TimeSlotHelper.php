<?php
include_once dirname(dirname(__FILE__)) . "/CompositeTimeSlot.php";
class TimeSlotHelper {
    function count($start,$end){
        $start_split = explode(':',$start);
        $end_split = explode(':',$end);

        $start_h = $start_split[0];
        $end_h = $end_split[0];

        $start_m = $start_split[1];
        $end_m = $end_split[1];

        $arr = array();

        if ($start_h == $end_h){
            for($j = $start_m; $j < $end_m; $j = $j + 5){
                $timeArr = array(
                    "start"=> ($start_h.":".$j),
                    "end"=>($end_h.":".($j+5))
                );

                array_push($arr,$timeArr);
            }
		}else
            for ($i = $start_h; $i <= $end_h; $i++){
                if($i == $start_h){
                    for ($j = $start_m; $j < 55; $j=$j+5){
                        $timeArr = array(
                            "start"=> ($start_h.":".$j),
                            "end"=>($start_h.":".($j+5))
                        );

                        array_push($arr,$timeArr);
                    }

                    $timeArr = array(
                        "start"=> ($start_h.":55"),
                        "end"=>(($start_h+1).":00")
                    );

                    array_push($arr,$timeArr);
                }
                elseif ($i != $end_h && count($arr) != 0){
                    for ($j = 0; $j < 55; $j = $j + 5){
                        $timeArr = array(
                            "start"=> ($i.":".$j),
                            "end"=>($i.":".($j+5))
                        );

                        array_push($arr,$timeArr);
                    }

                    $timeArr = array(
                        "start"=> ($i.":55"),
                        "end"=>(($i+1).":00")
                    );

                    array_push($arr,$timeArr);
                }
                elseif ($i == $end_h){
                    for($j=0;$j<$end_m;$j=$j+5){
                        $timeArr = array(
                            "start"=> ($end_h.":".$j),
                            "end"=>($end_h.":".($j+5))
                        );

                        array_push($arr,$timeArr);
                    }
                }
            }
		return $arr;
    }

    /**
     * @param $date : input time
     * @param $amount =1(default)
     * @return string : the date + 7days (yyyy-mm-dd)
     */
    public static function addDate($date , $amount=1){
        $start = explode("-",$date);
        $st_y = $start[0];
        $st_m = $start[1];
        $st_d = $start[2];
        $leapyear = false;
        $count = 7*$amount;

        if( ($st_y % 4 ==0) &&!( ($st_y % 100 == 0) &&!($st_y %400 == 0))){
            $leapyear = true;
        }
        while ($count > 0){
            while (($st_m==2)&&$count>0){
                if($st_d == 28&&!$leapyear){
                    $st_d = 1;
                    $st_m++;
                    $count--;
                    break;
                }
                else if($st_d == 29&&$leapyear){
                    $st_d = 1;
                    $st_m++;
                    $count--;
                    break;
                }
                else{
                    $st_d++;
                    $count--;
                }
            }
            while (($st_m==1||$st_m==3||$st_m==5||$st_m==7||$st_m==8||$st_m==10)&&$count>0){
                if ($st_d == 31){
                    $st_d = 1;
                    $st_m++;
                    $count--;
                    break;
                }
                else{
                    $st_d++;
                    $count--;
                }
            }
            while (($st_m==4||$st_m==6||$st_m==9||$st_m==11)&&$count>0){
                if ($st_d == 30){
                    $st_d = 1;
                    $st_m++;
                    $count--;
                    break;
                }
                else{
                    $st_d++;
                    $count--;
                }
            }
            while ($st_m==12&&$count>0){
                if ($st_d == 31){
                    $st_d = 1;
                    $st_m = 1;
                    $st_y++;
                    $count--;
                    break;
                }
                else{
                    $st_d++;
                    $count--;
                }
            }
        }
        $newString = $st_y. "-" . $st_m . "-" . $st_d;
        return $newString;

    }

    /**
     * @param $TimeSlotComponentArray: An array stored serialized TimeSlotComponent object
     * @return mixed: same format as input
     */
    public static function createCompositeTimeSlot($TimeSlotComponentArray){
        if(sizeof($TimeSlotComponentArray) ==1 ){
            return $TimeSlotComponentArray;
        }

        $result = false;
        $fin = $TimeSlotComponentArray;
        while(!$result){
            $result = true;
            for($i=0 ; $i<sizeof($fin) -1 ; $i++){
                $k = $i+1;

                $fin_i = unserialize($fin[$i]);
                $fin_ip1 = unserialize($fin[$i+1]);
                $fin_k = unserialize($fin[$k]);

                if( $fin_i->getEndTime() === $fin_k->getStartTime() && $fin_i->getName() === $fin_ip1->getName() ){
                    $result = false;
                    $cts = new CompositeTimeSlot();
                    $cts->add($fin_i);
                    $h = $k;
                    while($cts->getEndTime() === $fin_k->getStartTime() && $fin_i->getName() === $fin_ip1->getName() ) {
                        if ($fin_i->getName() === $fin_k->getName() ) { //don't group different user slots together
                            $cts->add($fin_k);
                            $h++;
                        }
                        if (++$k == sizeof($fin)) //prevent out of bounds exception
                            break;
                    }
                    for ($j=$i+1;$j<$h;$j++){
                        array_splice($fin, $i+1, 1);
//                        unset($fin[$i+1]);
                    }
                    $fin[$i] = serialize($cts);
//                    array_splice($fin, $i, 1, serialize($cts) );  //fin.set(i, cts);

                }
            }
        }
        return $fin;
    }

    public static function createCompositeTimeSlots($timeSlotComponentArray) {
        if (count($timeSlotComponentArray) == 1) {
            return $timeSlotComponentArray;
        }

        $arr = array();
        foreach ($timeSlotComponentArray as $slot) {

        }
    }

    public static function createCompositeTimeSlot2($TimeSlotComponentArray){
        $arr = array();
        $newComponent = new CompositeTimeSlot();

        for($i = 0; $i < count($TimeSlotComponentArray); $i ++){
            /** @var PrimitiveTimeSlot $children */
            $children = unserialize($TimeSlotComponentArray[$i]);

            if(count($newComponent->getChildren()) == 0){

                $newComponent->add($children);
            }elseif($newComponent->getEndTime() == $children->getStartTime()
                && $newComponent->getDate() == $children->getDate()){
                $newComponent->add($children);
            }else{
                array_push($arr, serialize($newComponent));
                $newComponent = new CompositeTimeSlot();
                $i--;
            }

        }

        array_push($arr, serialize($newComponent));

        return $arr;
    }
}