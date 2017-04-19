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
    <input class="mavAppointUrl" type="hidden" value="<?=$mavAppointUrl?>"/>
    <input id="customizeSettingController" type="hidden" value="<?=$customizeSettingController?>"/>
    <input id="successAction" type="hidden" value="<?=$successAction?>"/>
    <input id="cutOffTimeAction" type="hidden" value="<?=$cutOffTimeAction?>"/>
    <input id="deleteTypeAndDurationAction" type="hidden" value="<?=$deleteTypeAndDurationAction?>"/>
    <input id="setEmailNotificationsAction" type="hidden" value="<?=$setEmailNotificationsAction?>"/>
    <input id="addTypeAndDurationAction" type="hidden" value="<?=$addTypeAndDurationAction?>"/>
    <div class="container">

    <!-- Panel -->
    <div class="panel panel-default resize center-block">
        <!-- Default panel contents -->
        <div class="panel-heading text-center"><h1>Customize Settings</h1></div>

        <div class="panel-body resize-body center-block">
            <form method="post">
                <div class="panel-heading text-center"><h3>Appointment Manager</h3></div>
                <input type=hidden name=cancel_button id="cancel_button">
                <input type=hidden name=edit_button id="edit_button">
                <table class="table table-striped custab">
                    <thead>
                    <tr>
                        <th><font style="color: #0" size="4">Appointment Type</font></th>
                        <th><font style="color: #0" size="4">Duration</font></th>
                    </tr>
                    </thead>

                    <!-- begin processing appointments  -->
                    <?php if(sizeof($typeAndDuration)!=0)
                    {
                        for($i = 0 ; $i<sizeof($typeAndDuration);$i++){ ?>

                    <tr>
                        <td style="color: #000000; size: 10px"><?php echo $typeAndDuration[$i]['type'];?></td>
                        <td style="color: #000000; size: 10px"><?php echo $typeAndDuration[$i]['duration'];?></td>
                        <td><button class="btn deleteTypeAndDurationSubmit" type="button" > <span class="glyphicon glyphicon-remove"></span></button></td>
                    </tr>

                            <script> function deleteapptype<?=$i?>(){
                                    var apptype = "<?=$typeAndDuration[$i]['type']?>";
                                    var minutes = "<?php echo $typeAndDuration[$i]['duration']?>";
                                    if (validate(apptype) == true){

                                        var params = ('minutes=' + minutes + '&apptypes=' + apptype);
                                        var xmlhttp;
                                        xmlhttp = new XMLHttpRequest();
                                        xmlhttp.onreadystatechange = function() {
                                            if (xmlhttp.readyState == 4) {
                                                if(xmlhttp.status == 200){
                                                    document.getElementById("result").innerHTML = xmlhttp.responseText;
                                                }
                                            }else{
                                                //alert(xmlhttp.readyState+" "+xmlhttp.status);
                                            }
                                        }

                                        xmlhttp.open("POST", "appointment_type", true);
                                        xmlhttp.setRequestHeader("Content-type",
                                            "application/x-www-form-urlencoded");
                                        xmlhttp.setRequestHeader("Content-length", params.length);
                                        xmlhttp.setRequestHeader("Connection", "close");
                                        xmlhttp.send(params);
                                        //window.location.reload();
                                        window.location.href=window.location;
                                    }
                                }</script>
                    <?php }
                    }?>

                    <!-- end processing advisors -->
                </table>
            </form>
        </div>
        <div class="panel-footer text-center">
            <input id="addAppointmentTypeSubmit" type="submit" class="btn-lg" value="Add Appointment Type" href="#" data-toggle="modal" data-target="#addApptType">
        </div>

        <form method="post">
            <div class="modal fade" id="addApptType" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"></button>
                            <h4 class="modal-title" id="addApptTypeLabel">Add Appointment Type</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="apptypes">Appointment Type:</label>
                                <input type="typeText" class="form-control" id="apptypes" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="minutes">Minutes</label> <input type="number" class="form-control" id="minutes" step="5" placeholder="">
                            </div>
                            <div>
                                <label id="result"><font style="color: #0" size="4"></font></label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <input id="addTypeAndDurationSubmit" type="submit" value="submit"
                                   >
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="panel-body resize-body center-block">
            <form method="post">
                <div class="panel-heading text-center"><h3>Cut-Off Time Preference</h3></div>

                <div class="form-group">
                    <label for="cutOffTimeText">Cut-Off Time (in hours):<br></label>
                    <input type="text" name="cutOffTimeText" id="cutOffTimeText" placeholder="">
                </div>

                <div class="panel-footer text-center">
                    <input id="cutOffTimeSubmit" type="submit" class="btn-lg" value="submit"/>
                </div>
            </form>
        </div>

        <div class="panel-body resize-body center-block">
            <form method="POST">
                <div class="panel-heading text-center"><h3>Email Notifications</h3></div>
                <label style="text-align: center" for="message"><font color="#0" size="4">Username or Password Invalid</font></label> <br>

                <div class="form-group">
                    <input type="radio" name="notify" id="radioyes" value="yes" <?=$notificationYes?>><label for="radioyes">Yes</label>
                </div>
                <div class="form-group">

                    <input type="radio" name="notify" id="radiono" value="no" <?=$notificationNo?>><label for="radiono">No</label>

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
        xmlhttp.onreadystatechange = function() {
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
        window.location.href=window.location;
    }

<?php include ("template/footer.php"); ?>