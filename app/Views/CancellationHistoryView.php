<?php
include("template/header.php");
$role = isset($_SESSION['role']) ? $_SESSION['role'] : "visitor";
include("template/" . $role . "_navigation.php");

$mavAppointUrl = $_SESSION['mavAppointUrl'];
$content = json_decode($content, true);
$appointments = $content['data']['appointments'];
$errorMsg = ( isset($content['data']['errorMsg']) ) ? $content['data']['errorMsg'] : null;
$appointmentController = mav_encrypt("appointment");
?>


    <style>
        .custab {
            border: 1px solid #ccc;
            padding: 5px;
            margin: auto;
            box-shadow: 3px 3px 2px #ccc;
            transition: 0.5s;
            background-color: #e67e22;
        }

        .custab:hover {
            box-shadow: 3px 3px 0px transparent;
            transition: 0.5s;
        }

    </style>

    <script>
        function editButton() {
            document.getElementById("id2").value = "475";
            document.getElementById("apptype").value = "Drop Class";
            document.getElementById("date").value = "2017-03-29";
            document.getElementById("start").value = "13:00:00";
            document.getElementById("end").value = "13:30:00";
            document.getElementById("pname").value = "Wenbo";
            document.getElementById("description").value = "wilber test 66666";
            document.getElementById("StudentPhoneNumber").value = "682-248-9402";

            $('#addApptModal').modal();
        }
        function emailButton() {
            document.getElementById("to").value = "zhouxu.long@mavs.uta.edu";
            $('#emailModal').modal();
        }
        function validate2() {
            if (document.getElementById("studentid").value == "") {
                alert("Student ID is required.");
                return false;
            }
            if (document.getElementById("description").value.length > 100) {
                alert("Description is too long, please shorten it.");
                return false;
            }
        }
    </script>

    <div class="container-fluid">
        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading text-center">
                <div class="panel-title">
                    <h1>Cancellation History</h1>
                </div>
            </div>
            <div class="panel-body">
                <div class="pull-right">
                    <div><a href="<?php echo $mavAppointUrl?>?c=<?php echo $appointmentController?>&a=<?php echo $showAppointmentAction?>" class="btn btn-default btn-xs" role="button">Appointment History</a></div>
                    <div><a href="<?php echo $mavAppointUrl?>?c=<?php echo $appointmentController?>&a=<?php echo $showCanceledAppointmentAction?>" class="btn btn-default btn-xs active" role="button">Cancellation History</a></div>
                </div>


            </div>
            <table class="table table-striped custab">
                <thead>
                <tr>
                    <th>Advisor Name</th>
                    <th>Appointment Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Advising Task</th>
                    <th>Advising Email</th>
                    <th>Description</th>
                    <th>UTA Student ID</th>
                    <th>Student Email</th>
                    <th>Phone Number</th>
                    <th>Canceled by</th>
                    <th>Remark</th>


                </tr>
                </thead>


                <!-- begin processing appointments  -->

                <?php
                if (count($appointments) != 0) {
                    $i = 0;
                    foreach ($appointments as $appointment) {
                        ?>
                        <tr>
                            <td><?php echo $appointment['pName']?></td>
                            <td><?php echo $appointment['advisingDate']?></td>
                            <td><?php echo $appointment['advisingStartTime']?></td>
                            <td><?php echo $appointment['advisingEndTime']?></td>
                            <td><?php echo $appointment['appointmentType']?></td>
                            <td><?php echo $appointment['advisorEmail']?></td>
                            <td><?php echo $appointment['description']?></td>
                            <td><?php echo $appointment['studentId']?></td>
                            <td><?php echo $appointment['studentEmail']?></td>
                            <td><?php echo $appointment['studentPhoneNumber']?></td>
                            <td><?php echo $appointment['isCanceledBy']?></td>
                            <td><?php echo $appointment['remark']?></td>

                        </tr>

                        <?php
                    }
                }
                ?>
        </div>
        </table>
        <?php if(count($appointments) ==0 && $errorMsg==null)
        {?>
            <h4>Currently, you have no cancellation record.</h4>
        <?php }
        if($errorMsg!==null)
        {?>
            <h4><?php echo $errorMsg ?></h4>
        <?php }?>

    </div>
    </div>






    <form name=addAppt action="manage" onsubmit="return validate2()" method="post">
        <div class="modal fade" id="addApptModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id=addApptTypeLabel">Update Appointment</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name=id2 id="id2" readonly>
                        <b>Type:</b><input type="label" name=apptype id="apptype" readonly><br>
                        <b>Date: </b><input type="label" name=date id="date" readonly><br>
                        <b>Start: </b><input type="label" name=start id="start" readonly><br>
                        <b>End: </b><input type="label" name=end id="end" readonly><br>
                        <b>Advisor: </b><input type="label" name=pname id="pname" readonly><br>
                        <b>Phone Number: </b> <input type="label" name=StudentPhoneNumber id="StudentPhoneNumber" readonly><br>
                        <b>UTA Student ID: </b><br> <input type="text" name=studentid id="studentid"><br>
                        <b>Description:</b><br><textarea rows=4 columns="10" name=description id="description"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-default" value="Submit">
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form name=emailSubmit onsubmit="return emailSend()">
        <div class="modal fade" id="emailModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Send message</h4>
                    </div>
                    <div class="modal-body">
                        <b>Subject:</b><br> <input type=text name=subject id="subject"><br>
                        <b>Message:</b><br>
                        <textarea rows=4 columns="10" name=email id="email"></textarea>
                        <br> <input type=hidden name=to id="to"><br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Close
                        </button>
                        <input type="submit" value="Submit">
                    </div>
                </div>
            </div>
        </div>
    </form>


<?php include("template/footer.php"); ?>