<?php
include("template/header.php");
$role = isset($_SESSION['role']) ? $_SESSION['role'] : "visitor";
include("template/" . $role . "_navigation.php");
$mavAppointUrl = $_SESSION['mavAppointUrl'];

$loginController = mav_encrypt("login");
$indexController = mav_encrypt("index");
$successAction = mav_encrypt("success");
$changePasswordAction = mav_encrypt("changePassword");
$defaultAction = mav_encrypt("default");

?>

<style>
    .resize {
        width: 60%;
    }

    .resize-body {
        width: 80%;
    }


</style>

<input class="mavAppointUrl" type="hidden" value="<?php echo $mavAppointUrl?>"/>
<input id="loginController" type="hidden" value="<?php echo $loginController?>"/>
<input id="indexController" type="hidden" value="<?php echo $indexController?>"/>
<input id="successAction" type="hidden" value="<?php echo $successAction?>"/>
<input id="changePasswordAction" type="hidden" value="<?php echo $changePasswordAction?>"/>
<input id="defaultAction" type="hidden" value="<?php echo $defaultAction?>"/>

<div class="container">

    <div class="panel panel-default resize center-block">
        <form method="post">
            <!-- Default panel contents -->
            <div class="panel-heading text-center"><h1>Change Password</h1></div>

            <div class="panel-body resize-body center-block">

                <label id="changePasswordErrorMessage" for="message"></label>

                <div class="form-group">

                    <label for="currentpassword"><font color="#0" size="4">Current Password</font></label>
                    <br>
                    <input type="password" class="form-control" id="currentPassword" name=currentPassword>

                    <label for="password"><font color="#0" size="4">New Password (Length 8+ Required)</font></label>
                    <br>
                    <input type="password" class="form-control" id="newPassword" name=newPassword>

                    <label for="repeatPassword"><font color="#0" size="4">Repeat Password</font></label>
                    <br>
                    <input type="password" class="form-control" id="repeatPassword" name=repeatPassword>
                </div>

            </div>
            <div class="panel-footer text-center">
                <input type="submit" class="btn-lg" id="changePasswordSubmit" value="Submit">
            </div>
        </form>
    </div>
</div>

<?php include("template/footer.php"); ?>