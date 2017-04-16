<?php
$loginController = mav_encrypt("login");
$logoutAction = mav_encrypt("logout");
$advisorController = mav_encrypt("advisor");
$showScheduleAction = mav_encrypt("showSchedule");
$addTimeSlotAction = mav_encrypt("addTimeSlot");
$deleteTimeSlotAction = mav_encrypt("deleteTimeSlot");
$customizeSettingController = mav_encrypt("customizeSetting");
$showAppointmentTypeAction = mav_encrypt("showAppointmentType");
?>

<div>
    <ul class="nav navbar-nav">

        <li><a href="changePassword"><font style="color: #e67e22" size="3">Change Password</font></a></li>

        <li><a href="?c=<?=$advisorController?>&a=<?=$showScheduleAction?>"><font style="color: #e67e22" size="3">
                    Update Schedule</font> </a></li>
        <li><a href="appointments"><font style="color: #e67e22" size="3">
                    Appointments</font> </a></li>
        <li><a href="?c=<?=$customizeSettingController?>&a=<?=$showAppointmentTypeAction?>"><font style="color: #e67e22" size="3">Customize Settings</font></a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">

        <li><a href="#"><font style="color: #e67e22" size="3">You are logged in as an Advisor.</font></a></li>
        <li><a href="?c=<?=$loginController?>&a=<?=$logoutAction?>"><span class="glyphicon glyphicon-log-in"><font style="color: #e67e22" size="3">Logout</font></span></a></li>
    </ul>

</div>
</div>
</nav>