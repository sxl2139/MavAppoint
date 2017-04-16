<?php
/**
 * Created by PhpStorm.
 * User: oguni
 * Date: 3/23/2017
 * Time: 10:51 PM
 */

include 'template/header.php';

?>

<h3>Processing account creation. Please wait...</h3>

<?php

if ($_SERVER['REQUEST_METHOD'] == "POST"){
    //$NETID = substr($_SERVER['REMOTE_USER'], 0, -8);
    $NETID = "teo5264";

    $fName =  $_REQUEST['firstName'];
    $lName = $_REQUEST['lastName'];
    $phone = $_REQUEST['phone'];

    $db = new \Models\Db\DatabaseManager();
    $user = new \Models\Login\StudentUser();
    $user->setStudentId($NETID);
    $user->setLastNameInitial($lName[0]);
    $user->setPhoneNumber($phone);
    $student = $db->createStudent($user);

} else {
    echo '<h3>Error!</h3>';
    var_dump($_REQUEST);

}

?>
<?php
include 'template/footer.php';
?>