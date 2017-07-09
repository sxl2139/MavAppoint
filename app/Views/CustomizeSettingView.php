<?php
include("template/header.php");
$role = isset($_SESSION['role']) ? $_SESSION['role'] : "visitor";
include("template/" . $role . "_navigation.php");
$mavAppointUrl = $_SESSION['mavAppointUrl'];
$customizeSettingController = mav_encrypt("customizeSetting");
$cutOffTimeAction = mav_encrypt("cutOffTime");
$successAction = mav_encrypt("success");
$setEmailNotificationsAction = mav_encrypt("setEmailNotifications");
$addTypeAndDurationAction = mav_encrypt("addTypeAndDuration");
$deleteTypeAndDurationAction = mav_encrypt("deleteTypeAndDuration");
$changeTypeAndDurationAction = mav_encrypt("changeTypeAndDuration");
$content = json_decode($content, true);
$typeAndDuration = $content['data']['typeAndDuration'];
$advisorNotificationState = $content['data']['advisorNotificationState'];
$notificationYes = $advisorNotificationState == "yes" ? "checked" : "";
$notificationNo = $advisorNotificationState == "no" ? "checked" : "";
?>

    <style>
        .resize {
            width: 60%;
        }

        .resize-body {
            width: 80%;
        }
    </style>
    <input class="mavAppointUrl" type="hidden" value="<?php echo $mavAppointUrl ?>"/>
    <input id="customizeSettingController" type="hidden" value="<?php echo $customizeSettingController ?>"/>
    <input id="successAction" type="hidden" value="<?php echo $successAction ?>"/>
    <input id="cutOffTimeAction" type="hidden" value="<?php echo $cutOffTimeAction ?>"/>
    <input id="deleteTypeAndDurationAction" type="hidden" value="<?php echo $deleteTypeAndDurationAction ?>"/>
    <input id="changeTypeAndDurationAction" type="hidden" value="<?php echo $changeTypeAndDurationAction ?>"/>
    <input id="setEmailNotificationsAction" type="hidden" value="<?php echo $setEmailNotificationsAction ?>"/>
    <input id="addTypeAndDurationAction" type="hidden" value="<?php echo $addTypeAndDurationAction ?>"/>
    <div class="container">

        <!-- Panel -->
        <div class="panel panel-default resize center-block">
            <!-- Default panel contents -->
            <div class="panel-heading text-center"><h1>Customize Settings</h1></div>

            <div class="panel-body resize-body center-block">

                <?php
                    if($role == "advisor")
                        include("AdvisorSettingView.php"); ?>

                <div class="panel-body resize-body center-block">
                    <form method="POST">
                        <div class="panel-heading text-center"><h3>Email Notifications</h3></div>

                        <div class="form-group">
                            <input type="radio" name="notify" id="radioyes"
                                   value="yes" <?php echo $notificationYes ?>><label for="radioyes">Yes</label>
                        </div>
                        <div class="form-group">

                            <input type="radio" name="notify" id="radiono" value="no" <?php echo $notificationNo ?>><label
                                    for="radiono">No</label>

                        </div>
                        <div class="panel-footer text-center">
                            <input id="setEmailNotificationsSubmit" type="submit" class="btn-lg" value="submit"/>
                        </div>

                    </form>
                </div>
        </div>
    </div>

    <script>
        function FormSubmit() {
            var apptype = document.getElementById("apptypes").value;
            var minutes = document.getElementById("minutes").value;
            var params = ('minutes=' + minutes + '&apptypes=' + apptype);
            var xmlhttp;
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4) {
                    document.getElementById("result").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("POST", "add_app_type", true);
            xmlhttp.setRequestHeader("Content-type",
                "application/x-www-form-urlencoded");
            xmlhttp.setRequestHeader("Content-length", params.length);
            xmlhttp.setRequestHeader("Connection", "close");
            xmlhttp.send(params);
            document.getElementById("result").innerHTML = "Adding appointment type...";
            window.location.href = window.location;
        }
    </script>
<?php include("template/footer.php"); ?>