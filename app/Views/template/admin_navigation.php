<?php
$adminController = mav_encrypt("admin");
$addAdvisorAction = mav_encrypt("addAdvisor");
$loginController = mav_encrypt("login");
$logoutAction = mav_encrypt("logout");
$showDepartmentScheduleAction = mav_encrypt("showDepartmentSchedule");
$deleteTimeSlotAction = mav_encrypt("deleteTimeSlot");
$showAdvisorAssignmentAction = mav_encrypt("showAdvisorAssignment");
?>
<div id="navbar">
    <ul class="nav navbar-nav">

        <li><a href="changePassword"><font style="color: #e67e22" size="3">Change Password</font></a></li>
        <li><a href="?c=<?php echo $adminController?>&a=<?php echo $addAdvisorAction?>"><font style="color: #e67e22" size="3">Add New Advisor </font></a></li>
        <li><a href="delete_advisor"><font style="color: #e67e22" size="3">Delete Advisor </font></a></li>
        <li><a href="?c=<?php echo $adminController?>&a=<?php echo $showDepartmentScheduleAction?>"><font style="color: #e67e22" size="3">Show Department Schedule</font></a></li>
        <li><a href="?c=<?php echo $adminController?>&a=<?php echo $showAdvisorAssignmentAction?>"><font style="color: #e67e22" size="3">Assign Students To Advisors</font></a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">

        <li><a href="#"><font style="color: #e67e22" size="3">You are
                    logged in as an Admin.</font></a></li>
        <li><a href="?c=<?php echo $loginController?>&a=<?php echo $logoutAction?>"><span class="glyphicon glyphicon-log-in"><font style="color: #e67e22" size="3">Logout</font></a></li>
    </ul>
</div>
</div>
</nav>