<?php
$loginController = mav_encrypt("login");
$logoutAction = mav_encrypt("logout");
$changePasswordDefaultAction = mav_encrypt("changePasswordDefault");
$advisingController = mav_encrypt("advising");
$appointmentController = mav_encrypt("appointment");
$getAdvisingInfoAction = mav_encrypt("getAdvisingInfo");
$showAppointmentAction = mav_encrypt("showAppointment");
?>
<div>
    <ul class="nav navbar-nav">

        <li><a href="?c=<?php echo $loginController?>&a=<?php echo $changePasswordDefaultAction?>"><font style="color: #e67e22" size="3">Change Password</font></a></li>
        <li><a href="?c=<?php echo $advisingController?>&a=<?php echo $getAdvisingInfoAction?>"><font style="color: #e67e22" size="3">Advising </font></a></li>
        <li><a href="#"><font style="color: #e67e22" size="3">Customize Settings</font></a></li>
        <li><a href="?c=<?php echo $appointmentController?>&a=<?php echo $showAppointmentAction?>"><font style="color: #e67e22" size="3">Appointments </font></a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
        <li><a href="#"><font style="color: #e67e22" size="3">You are logged in as a Student. </font></a></li>
        <li><a href="?c=<?php echo $loginController?>&a=<?php echo $logoutAction?>"><span class="glyphicon glyphicon-log-in"><font style="color: #e67e22" size="3">Logout</font></a></li>
    </ul>
</div>
</div>
</nav>