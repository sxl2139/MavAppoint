<?php
$loginController = mav_encrypt("login");
$logoutAction = mav_encrypt("logout");
$advisingController = mav_encrypt("advising");
$appointmentController = mav_encrypt("appointment");
$getAdvisingInfoAction = mav_encrypt("getAdvisingInfo");
$showAppointmentAction = mav_encrypt("showAppointment");
?>
<div>
    <ul class="nav navbar-nav">

        <li><a href="changePassword"><font style="color: #e67e22" size="3">Change Password</font></a></li>
        <li><a href="?c=<?=$advisingController?>&a=<?=$getAdvisingInfoAction?>"><font style="color: #e67e22" size="3">Advising </font></a></li>
        <li><a href="customize"><font style="color: #e67e22" size="3">Customize Settings</font></a></li>
        <li><a href="?c=<?=$appointmentController?>&a=<?=$showAppointmentAction?>"><font style="color: #e67e22" size="3">Appointments </font></a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
        <li><a href="#"><font style="color: #e67e22" size="3">You are logged in as a Student. </font></a></li>
        <li><a href="?c=<?=$loginController?>&a=<?=$logoutAction?>"><span class="glyphicon glyphicon-log-in"><font style="color: #e67e22" size="3">Logout</font></a></li>
    </ul>
</div>
</div>
</nav>