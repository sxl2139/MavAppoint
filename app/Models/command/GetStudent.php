<?php

/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/2/14
 * Time: 7:15
 */
include_once dirname(__FILE__) . "/SQLCmd.php";
class GetStudent extends SQLCmd {
	private $email;

	function __construct($email) {
		$this->email = $email;
	}

	function queryDB() {
		include_once ROOT . "/app/Models/command/GetUserIdByEmail.php";
		$cmd = new GetUserIdByEmail($this->email);
		$id  = $cmd->execute();

		$query = "SELECT ma_user.*,ma_user_student.*
                      FROM ma_user,ma_user_student
                      WHERE ma_user.userId='$id' and ma_user_student.userId='$id'";

		$this->result = $this->conn->query($query)->fetch_assoc();
	}

	function processResult() {
		include_once dirname(dirname(__FILE__)) . "/login/StudentUser.php";
	    $set = new StudentUser();
	    $set->setEmail($this->result["email"]);
        $set->setPassword($this->result["password"]);
        $set->setValidated($this->result["validated"]);
        $set->setRole($this->result["role"]);

	    $set->setUserId($this->result["userId"]);
	    $set->setStudentId($this->result["studentId"]);
        $set->setDegType($this->result["degreeType"]);
        $set->setPhoneNumber($this->result["phoneNum"]);
        $set->setFirstName($this->result["firstName"]);
        $set->setLastName($this->result["lastName"]);
        $set->setNotification($this->result["notification"]);
        $set->setPassword($this->result["password"]);
        $set->setValidated($this->result["validated"]);

		return ($set);
	}
}