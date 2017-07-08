<?php
$loginController = mav_encrypt("login");
$logoutAction = mav_encrypt("logout");
$changePasswordDefaultAction = mav_encrypt("changePasswordDefault");
$advisingController = mav_encrypt("advising");
$appointmentController = mav_encrypt("appointment");
$getAdvisingInfoAction = mav_encrypt("getAdvisingInfo");
$showAppointmentAction = mav_encrypt("showAppointment");
?>

<div class="navbar-header">
    <a class="navbar-brand" href="/MavAppoint">
        <font style="font-weight:bold; color: #e67e22" size="6"> MavAppoint </font>
        <font style="color: #e67e22; margin-left: 10px;" size="2">Logged in as Student</font>
    </a>
</div>

<div>
    <ul class="nav navbar-nav navbar-right">
        <li><a href="?c=<?php echo $advisingController?>&a=<?php echo $getAdvisingInfoAction?>"><font style="color: #e67e22" size="3">Advising </font></a></li>
        <li><a href="?c=<?php echo $appointmentController?>&a=<?php echo $showAppointmentAction?>"><font style="color: #e67e22" size="3">Appointments </font></a></li>

        <li class="dropdown" style="margin-right: 20px;">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <font style="color: #e67e22" size="3">Setting</font>
                <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="?c=<?php echo $loginController?>&a=<?php echo $changePasswordDefaultAction?>"><font size="3">Change Password</font></a></li>
                <li><a href="#"><font size="3">Customize Settings</font></a></li>
                <li class="divider"></li>
                <li><a href="?c=<?php echo $loginController?>&a=<?php echo $logoutAction?>"><font style="color:red" size="3">Logout</font></a></li>
            </ul>
        </li>
    </ul>
</div>
</div>
</nav>