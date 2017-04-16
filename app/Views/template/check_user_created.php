<?php
/**
 * Created by PhpStorm.
 * User: oguni
 * Date: 3/24/2017
 * Time: 4:21 AM
 */

$NETID = substr($_SERVER['REMOTE_USER'], 0, -8);
$db = new \Models\Db\DatabaseManager();
$student = $db->getStudentByNetID($NETID);
if ($student[0] == null){
    //No user created. redirect to
    header("Location: RegisterUserView.php");
}
?>