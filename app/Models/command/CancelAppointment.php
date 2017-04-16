<?php
namespace Models\Command;
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/2/14
 * Time: 14:22
 */

class CancelAppointment extends SQLCmd{
    private $id;

    function __construct($id) {
        $this->id = $id;
    }

    function queryDB(){
        $query = "SELECT count(*),date,start, end 
                  FROM ma_appointments WHERE id='$this->id'";

        $res = $this->conn->query($query)->fetch_assoc();
        $date = $res['date'];
        $start = $res['start'];
        $end = $res['end'];

        if($res['count(*)'] == 1){
            $this->result = true;
            $query = "DELETE FROM ma_apointments 
                      WHERE id='$this->id'";
            $this->conn->query($query);
            $query = "UPDATE ma_advising_schedule 
                      SET studentId=null 
                      WHERE date='$date' 
                      AND start >='$start' 
                      AND end <='$end'";
            $this->conn->query($query);
        }else{
            $this->result = false;
        }
    }

    function processResult(){
        return $this->result;
    }
}