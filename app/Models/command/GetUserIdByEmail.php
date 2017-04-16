<?php
namespace Models\Command;
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/2/13
 * Time: 17:11
 */
//include_once dirname(__FILE__)."/SQLCmd.php";

class GetUserIdByEmail extends SQLCmd {
	private $email;

	function __construct($email) {
		$this->email = $email;
	}

	function queryDB() {
		$query        = "SELECT userId FROM ma_user WHERE email= '$this->email'";
		$res          = $this->conn->query($query);
		$this->result = mysqli_fetch_array($res)['userId'];
	}

	function processResult() {
		return ($this->result);
	}
}