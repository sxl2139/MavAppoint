<?php
include("template/header.php");
include("template/visitor_navigation.php");

$registerController = mav_encrypt("register");
$getMajorsAction = mav_encrypt("getMajors");
$registerStudentAction = mav_encrypt("registerStudent");

$content = json_decode($content, true);
$departments = $content['data']['departments'];
$majors = $content['data']['majors'];
$degrees = $content['data']['degrees'];
$initials = $content['data']['initials'];
$url = $content['data']['url'];
?>

<style>
.resize {
    width: 60%;
}
.resize-body {
    width: 80%;
}
</style>


<input type="hidden" id="registerController" value="<?=$registerController?>" />
<input type="hidden" id="getMajorsAction" value="<?=$getMajorsAction?>" />
<input type="hidden" id="registerStudentAction" value="<?=$registerStudentAction?>" />
<input type="hidden" id="loginUrl" value="<?=$url?>" />

<div class="container block">
    <!-- Panel -->
    <div class="panel panel-default resize center-block">
        <!-- Default panel contents -->
        <div class="panel-heading text-center"><h1>Register Student</h1></div>
        <form method="post" name="register_form">
            <div class="panel-body center-block resize-body">

                <label id="registerErrorMessage" for="message"></label>
                <div class="">
                    <div class="form-group">

                        <label for="drp_department"><font color="#0" size="4">Departments</font></label>
                        <br>
                        <select id="drp_department" name="drp_department" class="btn btn-default btn-lg dropdown-toggle">

                            <?php
                            foreach ($departments as $department) {
                                echo "<option>$department</option>";
                            }
                            ?>


                        </select>
                        <br>

                        <label for="drp_degreeType"><font color="#0" size="4">Degree Type</font></label>
                        <br>
                        <select id="drp_degreeType" name="drp_degreeType" class="btn btn-default btn-lg dropdown-toggle">

                            <?php
                            foreach ($degrees as $degree) {
                                echo "<option>$degree</option>";
                            }
                            ?>

                        </select>
                        <br>

                        <label for="drp_major"><font color="#0" size="4">Major</font></label>
                        <br>
                        <select id="drp_major" name="drp_major" class="btn btn-default btn-lg dropdown-toggle">

                            <?php
                            foreach ($majors as $major) {
                                echo "<option>$major</option>";
                            }
                            ?>

                        </select>
                        <br>

                        <label for="drp_last_name_initial"><font color="#0" size="4">Last Name Initial</font></label>
                        <br>
                        <select id="drp_last_name_initial" name="drp_last_name_initial" class="btn btn-default btn-lg dropdown-toggle">

                            <?php
                            foreach ($initials as $initial) {
                                echo "<option>$initial</option>";
                            }
                            ?>

                        </select>
                        <br>

                        <label for="student_Id"><font color="#0" size="4">Student ID</font></label>
                        <br>
                        <input type="text" id="studentId" class="form-control" name=student_Id placeholder="1000xxxxxx or 6000xxxxxx">

                        <label for="phone_num"><font color="#0" size="4">Phone Number</font></label>
                        <br>
                        <input type="text" id="phoneNumber" class="form-control" name=phone_num placeholder="xxx-xxx-xxxx">

                        <label for="emailAddress"><font color="#0" size="4">Email Address</font></label>
                        <br>
                        <input type="text" id="email" class="form-control" name=emailAddress placeholder="firstname.lastname@mavs.uta.edu">
                        <br>
                    </div>
                </div>

            </div>
            <div  class="panel-footer text-center">
                <input type="submit" id="registerSubmit" class="btn-lg" value="Submit">
            </div>
        </form>
    </div>
</div>


<?php include("template/footer.php"); ?>