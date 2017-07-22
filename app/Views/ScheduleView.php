<?php
include("template/header.php");
$role = isset($_SESSION['role']) ? $_SESSION['role'] : "visitor";
include("template/" . $role . "_navigation.php");
$mavAppointUrl = $_SESSION['mavAppointUrl'];

$advisingController = mav_encrypt("advising");
$appointmentController = mav_encrypt("appointment");
$scheduleAction = mav_encrypt("schedule");
$makeAppointmentAction = mav_encrypt("makeAppointment");
$getAdvisingInfoAction = mav_encrypt("getAdvisingInfo");
$successAction = mav_encrypt("success");

$content = json_decode($content, true);
$appointmentTypes = $content['data']['appointmentTypes'];
$schedules = $content['data']['timeSlot'];
$pName = $content['data']['pName'];
$id1 = $content['data']['id1'];
$duration = $content['data']['duration'];
$appType = $content['data']['appType'];
$advisorEmail = $content['data']['advisorEmail'];
$studentEmail = $content['data']['studentEmail'];
$studentId = $content['data']['studentId'];
$studentPhone = $content['data']['studentPhone'];
?>

    <input class="mavAppointUrl" type="hidden" value="<?php echo $mavAppointUrl ?>"/>
    <div class="input-group-btn">

        <?php
        if (count($appointmentTypes) != 0) {
            ?>
            <button class="btn btn-default btn-lg dropdown-toggle" type="button" data-toggle="dropdown">
                Select Advising Type for
                <?php echo $pName ?>
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <?php
                foreach ($appointmentTypes as $appointmentType) {
                    echo "<li><a href=\"?c=$advisingController&a=$scheduleAction&appType=" . $appointmentType['type'] . "&pname=$pName&advisor_email="
                        . $appointmentType['email'] . "&id1=$id1&duration=" . $appointmentType['duration'] . "\">" . $appointmentType['type'] . "</a></li>";
                }
                ?>
            </ul>
            <?php
        }
        ?>
    </div>
    <br>
    <br>
    <hr>
    <div id='calendar'></div>

<?php
if (count($schedules) != 0) {

    ?>
    <script>
        $(document).ready(function () {
            $('#calendar').fullCalendar({
                defaultView: 'basicDay',
                viewRender: function (view, element) {
                    $('#calendar').fullCalendar('gotoDate', '<?php echo $schedules['date']?>');
                },
                displayEventEnd: {
                    month: false,
                    basicWeek: false,
                    'default': false,
                }
                <?php
                if ($duration != 0) {
                ?>
                ,
                eventClick: function (event, element) {
                    document.getElementById("appointmentId").value = event.id;
                    document.getElementById("appointmentType").value = '<?php echo $appType?>';
                    document.getElementById("duration").value = '<?php echo $duration?>';
                    document.getElementById("pName").value = '<?php echo $pName?>';
                    document.getElementById("advisor_email").value = '<?php echo $advisorEmail?>';
                    document.getElementById("appointmentController").value = '<?php echo $appointmentController?>';
                    document.getElementById("makeAppointmentAction").value = '<?php echo $makeAppointmentAction?>';
                    document.getElementById("getAdvisingInfoAction").value = '<?php echo $getAdvisingInfoAction?>';
                    document.getElementById("successAction").value = '<?php echo $successAction?>';
                    document.getElementById("start").value = event.start;
                    document.getElementById("end").value = event.end;
                    document.getElementById("starttime").value = event.start.format();
                    document.getElementById("endtime").value = event.end.format();

                    $('#addApptModal').modal();
                },
                events: [
                    <?php
                    echo $schedules['event'];
                    ?>
                ]
                <?php
                }
                ?>
            });
        });
    </script>

    <?php
}
?>
    <br/>
    <br/>
    <hr>
    <form id=addAppt method="post">
        <div class="modal fade" id="addApptModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id=addApptTypeLabel">Add Appointment</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name=appointmentId id="appointmentId">
                        <input type="hidden" name=appointmentType id="appointmentType">
                        <input type="hidden" name=start id="start">
                        <input type="hidden" name=end id="end">
                        <input type="hidden" name=starttime id="starttime">
                        <input type="hidden" name=endtime id="endtime">
                        <input type="hidden" name=pName id="pName">
                        <input type="hidden" name=duration id="duration">
                        <input type="hidden" name=advisor_email id="advisor_email">
                        <input type="hidden" id="appointmentController">
                        <input type="hidden" id="makeAppointmentAction">
                        <input type="hidden" id="getAdvisingInfoAction">
                        <input type="hidden" id="successAction">
                        <b>Email address: </b><br><input type="text" name="email" id="email" value="<?php echo $studentEmail ?>"><br>
                        <b>UTA Student ID: </b><br><input type="text" name="studentId" id="studentId" value="<?php echo $studentId ?>"> <br>
                        <b>Phone Number: </b><br> <input type="text" name="phoneNumber" id="phoneNumber" value="<?php echo $studentPhone ?>"> <br>
                        <b>Reason: </b><br><textarea rows=4 columns="10" name="description" id="description"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="makeAppointment">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <style>
        #calendar {
            background-color: white;
        }
    </style>


<?php include("template/footer.php"); ?>