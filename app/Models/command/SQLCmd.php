<?php
if (!class_exists("SQLCmd")){
	abstract class SQLCmd {

		/**
		 * @var \mysqli
		 */
		public $conn;
		public $result;

		function getResult(){return $this->result;}

		function execute() {
			try {
				$this->connectDB();
				$this->queryDB();
				$this->result = $this->processResult();
				$this->disconnect();
			} catch (Exception $e) {
				$this->disconnect();
			}

			return $this->result;
		}

		function connectDB() {
			$this->conn = new mysqli(
				config("DB.HOST"), config("DB.USERNAME"), config("DB.PASSWORD"), config("DB.DATABASE"));
//                "localhost","CSE5328Spring16","er1ja@18xs@3","mavappointdb2s");
			    //env("DB_HOST"),env("DB_USERNAME"),env("DB_PASSWORD"),env("DB_DATABASE"));
		}

		abstract function queryDB();

		abstract function processResult();

		function disconnect() {
			if($this->conn)
				$this->conn->close();
		}
	}
}