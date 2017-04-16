<?php
namespace Models\Command;
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/2/14
 * Time: 6:35
 */
//include_once dirname(__FILE__)."/SQLCmd.php";

class AddDepartmentByUserId extends SQLCmd{
    private $userId,$departments;

    function __construct($userId,array $deparments) {
        $this->userId = $userId;
        $this->departments = $deparments;
    }

    function queryDB(){
        $this->result = true;

        $num = count($this->departments);
        for($i=0;$i<$num;++$i){
            $department = ($this->departments)[$i];
            $query = "INSERT INTO ma_department_user 
                      (name, userId) 
                      VALUES  ('$department','$this->userId')";
            $res = $this->conn->query($query);

            if(!$res){
                $this->result = false;
            }
        }
    }

    function processResult(){
        return $this->result;
    }
}