<?php
include("template/header.php");
$role = isset($_SESSION['role']) ? $_SESSION['role'] : "visitor";
include("template/" . $role . "_navigation.php");
$advisingController = mav_encrypt("advising");
$appointmentController = mav_encrypt("appointment");
$getWaitListInfoAction = mav_encrypt("getWaitListInfo");
$successAction = mav_encrypt("success");
$addToWaitListAction = mav_encrypt("addToWaitList");
$scheduleAction = mav_encrypt("schedule");
$showAppointmentAction = mav_encrypt("showAppointment");

$content = json_decode($content, true);
$departments = $content['data']['departments'];
$degrees = $content['data']['degrees'];
$majors = $content['data']['majors'];
$letters = $content['data']['letters'];
$advisors = $content['data']['advisors'];
$schedules = $content['data']['schedules'];
$appointments = $content['data']['appointments'];
$waitLists = $content['data']['waitLists'];
$studentEmail = $content['data']['studentEmail'];
$studentId = $content['data']['studentId'];
$studentPhone = $content['data']['studentPhone'];
?>
    <input id="loginController" type="hidden" value="<?php echo $loginController?>"/>
    <input id="loginController" type="hidden" value="<?php echo $loginController?>"/>
    <div class="container-fluid">
        <!-- Panel -->
        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading text-center"><h1>Student Information</h1></div>
            <div class="panel-body">

                <form action="advising" method="post" name="advisor_form">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="drp_department"><font color="#0" size="4">Department</font></label>

                            <br>
                            <select id="drp_department" onchange="submit();" name="drp_department"
                                    class="btn btn-default btn-lg dropdown-toggle">

                                <?php
                                $i = 0;
                                foreach ($departments as $department) {
                                    echo "<option id=\"option\" value = $i> $department</option>";
                                    $i++;
                                }
                                ?>


                            </select>

                        </div>
                        <div class="col-md-2">

                            <label for="drp_degreeType"><font color="#0" size="4">Degree Type</font></label>
                            <br>
                            <select id="drp_degreeType" name="drp_degreeType" onchange="submit();"
                                    class="btn btn-default btn-lg dropdown-toggle">

                                <?php
                                $i = 0;
                                foreach ($degrees as $degree) {
                                    echo "<option id = \"degree\" value=$i > $degree</option>";
                                    $i++;
                                }
                                ?>


                            </select>
                            <br>

                        </div>
                        <div class="col-md-4">

                            <label for="drp_major"><font color="#0" size="4">Major</font></label>
                            <br>
                            <select id="drp_major" name="drp_major" onchange="submit();"
                                    class="btn btn-default btn-lg dropdown-toggle">

                                <?php
                                $i = 0;
                                foreach ($majors as $major) {
                                    echo "<option id = \"major\" value=$i > $major</option>";
                                    $i++;
                                }
                                ?>

                                <script>function selectmajor() {
                                        document.getElementById("major").value;
                                        advisor_form.submit();
                                    }
                                </script>
                            </select>
                            <br>

                        </div>

                        <div class="col-md-4"></div>
                        <label for="drp_lastName"><font color="#0" size="4">Last Name</font></label>
                        <br>
                        <select id="drp_lastName" name="drp_lastName" onchange="submit();"
                                class="btn btn-default btn-lg dropdown-toggle">

                            <?php

                            echo "<option id = \"letter\" value=0 > $letters</option>";

                            ?>

                            <script>function selectLetter() {
                                    document.getElementById("letter").value;
                                    advisor_form.submit();
                                }
                            </script>
                        </select>
                        <br>

                    </div>


                    <div class="pull-right form-inline">
                        <div class="btn-group">

                            <input type=hidden name=advisor_button id="advisor_button">
                            <script>

                                document.getElementById("advisor_button").value = "all";
                            </script>

                            <!-- begin processing advisors  -->
                            <button type="button" id="all1" onclick="alladvisors()">All</button>
                            <script> function alladvisors() {
                                    document.getElementById("advisor_button").value = "all";
                                    advisor_form.submit();
                                }
                            </script>


                            <?php
                            $i = 0;
                            foreach ($advisors as $advisor) {
                                ?>
                                <button type="button" id="button1<?php echo  $i ?>"
                                        onclick="button<?php echo  $i ?>()"><?php echo  $advisor['pName'] ?></button>
                                <script> function button<?php echo $i?>() {
                                        document.getElementById("advisor_button").value = "<?php echo $advisor['pName']?>";
                                        advisor_form.submit();
                                    }
                                </script>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </form>

                <!-- end processing advisors -->
            </div>
        </div>
    </div>
<?php
if (count($advisors) == 0) {
    echo "<div><label> No advisors available for advising </label></div>";
} else {
    ?>
    <div class="container-fluid">
        <div class="date-display span12">


            <div id='calendar'>


                <!--  begin processing schedules -->
                <script>
                    $(document).ready(function () {
                        $('#calendar').fullCalendar({
                            header: {
                                left: 'month,basicWeek,basicDay',
                                right: 'today, prev,next',
                                center: 'title'
                            },
                            displayEventEnd: {
                                month: true,
                                basicWeek: true,
                                'default': true,
                            },
                            eventClick: function (event, element) {
                                if (event.backgroundColor == 'blue') {
                                    document.getElementById("id1").value = event.id;
                                    document.getElementById("pname").value = event.title;
                                    addAppt.submit();
                                } else if (event.backgroundColor == 'orange') {
                                    updateAppt.submit();
                                }
//                                else {
//                                    document.getElementById("appointmentId").value = event.id;
//                                    document.getElementById("appType").value = event.title;
//                                    $.ajax({
//                                        url: "/MavAppoint_PHP/",
//                                        type: "post",
//                                        data: {
//                                            c : $("#advisingController").val(),
//                                            a : $("#getWaitListInfoAction").val(),
//                                            appointmentId : event.id
//                                        },
//                                        success: function(data){
//                                            var data = JSON.parse(data);
//                                            if (data.error == 0) {
//                                                if(data.data.isAdded) {
//                                                    $("#waitListHead").text("You have already been added to the wait list!")
//                                                    $("#addToWaitListSubmit").hide();
//                                                } else {
//                                                    $("#appointmentType").text(data.data.appointmentType);
//                                                    $("#waitStudentsNumber").text(data.data.waitListCount);
//                                                }
//                                                $("#advisor").val(data.data.advisor);
//                                            }else{
//                                                alert("Errors while getting waitList information");
//                                            }
//                                        }
//                                    });
//
//                                    $('#addToWLModal').modal();
//                                }
                            },
                            events: [
                                <?php
                                $i = 0;
                                foreach ($schedules as $schedule) {
                                    echo "
                                {
                                    title: '" . $schedule['name'] . "',
                                    start: '" . $schedule['date'] . "T" . $schedule['startTime'] . "',
                                    end: '" . $schedule['date'] . "T" . $schedule['endTime'] . "',
                                    id: $i,
                                    backgroundColor: 'blue'
                                }
                                ";

                                    if ($i != count($schedules) - 1 || (count($appointments) != 0 || count($waitLists) != 0)) echo ",";
                                    $i++;
                                }

                                $i = 1;
                                foreach ($appointments as $appointment) {
                                    echo "
                                {
                                    title:'" . $appointment['appointmentType'] . "',
                                    start:'" . $appointment['advisingDate'] . "T" . $appointment['advisingStartTime'] . "',
                                    end:'" . $appointment['advisingDate'] . "T" . $appointment['advisingEndTime'] . "',
                                    id:" . -$i . ",
                                    backgroundColor: 'orange'
                                }";
                                    if ($i != count($appointments) || count($waitLists) != 0) echo ",";
                                    $i++;
                                }

//                                $i = 0;
//                                foreach ($waitLists as $waitList) {
//                                    echo "
//                                {
//                                    title:'" . $waitList['appointmentType'] . "',
//                                    start:'" . $waitList['advisingDate'] . "T" . $waitList['advisingStartTime'] . "',
//                                    end:'" . $waitList['advisingDate'] . "T" . $waitList['advisingEndTime'] . "',
//                                    id:" . $waitList['appointmentId'] . ",
//                                    backgroundColor: 'red'
//                                }";
//                                    if ($i != count($waitLists) - 1) echo ",";
//                                    $i++;
//                                }
                                ?>

                            ]
                        });
                    });
                </script>

                <form name="addToWL" method="post">
                    <div class="modal fade" id="addToWLModal" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Add to wait list</h4>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" id="advisingController" value="<?php echo $advisingController?>">
                                    <input type="hidden" id="getWaitListInfoAction" value="<?php echo $getWaitListInfoAction?>">
                                    <input type="hidden" id="addToWaitListAction" value="<?php echo $addToWaitListAction?>">
                                    <input type="hidden" id="successAction" value="<?php echo $successAction?>">


                                    <input type="hidden" id="appointmentId">
                                    <input type="hidden" id="appType">
                                    <div style="font-size: large" id="waitListHead">This advising session is for
                                        <span id="appointmentType" style="font-weight:bold;color:red"></span><br>
                                        You have <span id="waitStudentsNumber" style="font-weight:bold;color:red"></span> students ahead of you</div><br>
                                    <b>Advisor</b><br><input name=advisor id="advisor" readonly><br>
                                    <b>Student ID</b><br> <input type="text" name="studentId" id="studentId" value="<?php echo  $studentId ?>"><br>
                                    <b>Student Email</b><br> <input type="text" name="email" id="email" value="<?php echo  $studentEmail ?>"><br>
                                    <b>Student Phone Number</b><br> <input type="text" name="phoneNumber" id="phoneNumber" value="<?php echo  $studentPhone ?>"> <br>
                                    <b>Description:</b><br><textarea rows=4 columns="10" name=description id="description"></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-default" id="addToWaitListSubmit" >Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <form name=addAppt method="get">
                    <input type="hidden" name="c" value="<?php echo  $advisingController ?>">
                    <input type="hidden" name="a" value="<?php echo  $scheduleAction ?>">
                    <input type="hidden" name="id1" id="id1">
                    <input type="hidden" name="pname" id="pname">
                    <input type="hidden" name="advisor_email" id="advisor_email">
                </form>

                <form name=updateAppt method="get">
                    <input type="hidden" name=c value="<?php echo  $appointmentController ?>">
                    <input type="hidden" name=a value="<?php echo  $showAppointmentAction ?>">
                </form>

                <br/> <br/>
                <hr>
            </div>
        </div>
    </div>
    <?php
}
?>
    <style>
        #calendar {
            background-color: white;
        }
    </style>

<?php include("template/footer.php"); ?>