<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/2/13
 * Time: 17:06
 */
include_once dirname(__FILE__) . "/SQLCmd.php";
class GetAdvisor extends SQLCmd {
	private $email,$id,$majors;

	function __construct($email) {
		$this->email = $email;
	}

	function queryDB() {
		$cmd = new GetUserIdByEmail($this->email);
		$this->id  = $cmd->execute();

		$query = "SELECT name FROM ma_major_user WHERE userId = '$this->id'";
        $this->result = $this->conn->query($query);
        $this->majors = array();
        while($rs = mysqli_fetch_assoc($this->result)){
            array_push($this->majors, $rs['name']);
        }

		$query = "SELECT ma_user.*,ma_user_advisor.*,ma_department_user.name dep
                  FROM ma_user,ma_user_advisor,ma_department_user
                  WHERE ma_user.userId='$this->id' 
                  AND ma_user_advisor.userId='$this->id' 
                  AND ma_department_user.userId='$this->id'";

		$this->result = $this->conn->query($query)->fetch_assoc();

	}

	function processResult() {
        $set = new AdvisorUser();
        $set->setUserId($this->id);
        $set->setEmail($this->email);
        $set->setNotification($this->result["notification"]);
        $set->setPassword($this->result["password"]);
        $set->setValidated($this->result["validated"]);
        $set->setPName($this->result["pName"]);
        $set->setNameLow($this->result["nameLow"]);
        $set->setNameHigh($this->result["nameHigh"]);
        $set->setDegType($this->result["degreeTypes"]);
        $set->setDepartments($this->result["dep"]);
        $set->setMajors($this->majors);
        $set->setCutOffPreference($this->result["cutOffTime"]);

		return ($set);
	}
}