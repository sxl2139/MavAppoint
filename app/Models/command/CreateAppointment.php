<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/2/14
 * Time: 9:29
 */
include_once dirname(__FILE__) . "/SQLCmd.php";
include_once dirname(dirname(__FILE__)) . "/bean/Appointment.php";
class CreateAppointment extends SQLCmd {
	private $apt, $email;

	function __construct(Appointment $apt, $email) {
		$this->apt   = $apt;
		$this->email = $email;
	}

	function queryDB() {
		$query = "SELECT userId FROM ma_user WHERE email='$this->email'";
		$res   = $this->conn->query($query)->fetch_assoc();
		$userId    = $res['userId'];

		$query  = "SELECT studentId,notification 
                   FROM ma_user_student 
                   WHERE userId='$userId'";
		$res    = $this->conn->query($query)->fetch_assoc();
		$notify = $res['notification'];
        $studentId = $res['studentId'];

		$pName     = $this->apt->getPname();
		$query     = "SELECT userId 
                      FROM ma_user_advisor 
                      WHERE ma_user_advisor.pName='$pName'";
			$res       = $this->conn->query($query)->fetch_assoc();
		$advisorId = $res['userId'];

		$query          = "SELECT notification 
                           FROM ma_user_advisor 
                           WHERE userId='$advisorId'";
		$res            = $this->conn->query($query)->fetch_assoc();
		$notify_advisor = $res['notification'];

		$query        = "SELECT email 
                         FROM ma_user 
                         WHERE userId='$advisorId'";
		$res          = $this->conn->query($query)->fetch_assoc();
		$advisorEmail = $res['email'];

		$aptId       = $this->apt->getAppointmentId();
		$date        = $this->apt->getAdvisingDate();
		$start       = $this->apt->getAdvisingStartTime();
		$end         = $this->apt->getAdvisingEndTime();
		$type        = $this->apt->getAppointmentType();
		$description = $this->apt->getDescription();
		$phone       = $this->apt->getStudentPhoneNumber();

		$query = "SELECT COUNT(*) 
                  FROM ma_advising_schedule
                  WHERE userId='$advisorId' AND date='$date' 
                  AND start>='$start' AND end<='$end' AND studentId is not null";
		$count = $this->conn->query($query)->fetch_assoc();
		if ($count['COUNT(*)'] == 0) {
            $flag = true;

			$query = "INSERT INTO ma_appointments
                      (id,advisorUserId,studentUserId,date,start,end,
                      type,studentId,description,studentEmail,studentCell)
                      VALUES('$aptId','$advisorId','$userId','$date','$start','$end','$type','$studentId','$description','$this->email','$phone')";
            $flag = $flag && $this->conn->query($query);

            if($flag) {
                $query = "UPDATE ma_advising_schedule 
                          SET studentId='$studentId' WHERE userId='$advisorId' AND date='$date' AND start >= '$start' AND end <= '$end'";
                $flag = $flag && $this->conn->query($query);
            }

            $success = $flag;
		} else {
			$success = false;
		}

		$this->result = array(
			"student_notify" => $notify,
			"advisor_notify" => $notify_advisor,
			"advisor_email"  => $advisorEmail,
			"response"       => $success,
		);
	}

	function processResult() {
		return $this->result;
	}
}