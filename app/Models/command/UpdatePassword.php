<?php
namespace Models\Command;
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/2/14
 * Time: 7:55
 */
class UpdatePassword extends SQLCmd {
	private $email, $password;

	function __construct($email, $password) {
		$this->email    = $email;
		$this->password = md5($password);
	}

	function queryDB() {
		$query = "UPDATE ma_user 
                  SET password='$this->password', validated = 0 where email='$this->email'";
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