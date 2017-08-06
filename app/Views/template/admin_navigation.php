<?php
$adminController = mav_encrypt("admin");
$addAdvisorAction = mav_encrypt("addAdvisor");

$loginController = mav_encrypt("login");
$addDepartmentAction = mav_encrypt("addDepartment");
$deleteAdvisorAction = mav_encrypt("deleteAdvisor");
$setTemporaryPasswordAction = mav_encrypt("setTemporaryPassword");
$changePasswordDefaultAction = mav_encrypt("changePasswordDefault");
$logoutAction = mav_encrypt("logout");
$showDepartmentScheduleAction = mav_encrypt("showDepartmentSchedule");
$deleteTimeSlotAction = mav_encrypt("deleteTimeSlot");
$showAdvisorAssignmentAction = mav_encrypt("showAdvisorAssignment");

$feedbackController = mav_encrypt("feedback");
$getFeedbackAction = mav_encrypt("getFeedback");
?>

<div class="navbar-header">
    <a class="navbar-brand" href="/MavAppoint">
        <font style="font-weight:bold; color: #e67e22" size="6"> MavAppoint </font>
        <font style="color: #e67e22; margin-left: 10px;" size="3">Logged in as Admin</font>
    </a>
</div>

<div id="navbar">

    <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <font style="color: #e67e22" size="3">Department</font>
                <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="?c=<?php echo $adminController?>&a=<?php echo $addDepartmentAction?>"><font size="3">Add Department</font></a></li>
                <li><a href="?c=<?php echo $adminController?>&a=<?php echo $showDepartmentScheduleAction?>"><font size="3">Show Department Schedule</font></a></li>
            </ul>
        </li>

        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <font style="color: #e67e22" size="3">Advisor</font>
                <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="?c=<?php echo $adminController?>&a=<?php echo $addAdvisorAction?>"><font size="3">Add New Advisor</font></a></li>
                <li><a href="?c=<?php echo $adminController?>&a=<?php echo $deleteAdvisorAction?>"><font size="3">Delete Advisor</font></a></li>
                <li><a href="?c=<?php echo $adminController?>&a=<?php echo $showAdvisorAssignmentAction?>"><font size="3">Assign Students To Advisors</font></a></li>
            </ul>
        </li>

        <li><a href="?c=<?php echo $feedbackController?>&a=<?php echo $getFeedbackAction?>"><font style="color: #e67e22" size="3">Feedback</font></a></li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <font style="color: #e67e22" size="3">Setting</font>
                <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="?c=<?php echo $loginController?>&a=<?php echo $changePasswordDefaultAction?>"><font size="3">Change Password</font></a></li>
                <li class="divider"></li>
                <li><a href="?c=<?php echo $adminController?>&a=<?php echo $setTemporaryPasswordAction?>"><font size="3">Temporary Password</font></a></li>
            </ul>
        </li>
        <li><a href="?c=<?php echo $loginController?>&a=<?php echo $logoutAction?>"><font style="color:#e67e22" size="3">Logout</font></a></li>
    </ul>

</div>
</div>
</nav>