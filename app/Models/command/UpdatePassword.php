<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/2/14
 * Time: 7:55
 */
include_once dirname(__FILE__) . "/SQLCmd.php";
class UpdatePassword extends SQLCmd {
	private $email, $password, $time;

	function __construct($email, $password,$time) {
		$this->email    = $email;
		$this->password = md5($password);
		$this->time = $time;
	}

	function queryDB() {
		$query = "UPDATE ma_user 
                  SET password='$this->password', validated = 0, sendTemPWDate = '$this->time' where email='$this->email'";
		$this->conn->query($query);

		if (mysqli_affected_rows($this->conn) == 0) {
			$this->result = false;
		} else {
			$this->result = true;
		}
	}

	function processResult() {
		return $this->result;
	}
}