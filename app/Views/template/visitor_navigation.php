<?php
$loginController = mav_encrypt("login");
$registerController = mav_encrypt("register");
$advisingController = mav_encrypt("advising");
$getAdvisingInfoAction = mav_encrypt("getAdvisingInfo");
?>

<div class="navbar-header">
    <a class="navbar-brand" href="/MavAppoint">
        <font style="font-weight:bold; color: #e67e22" size="6"> MavAppoint </font>
    </a>
</div>

<div>
    <ul class="nav navbar-nav navbar-right" style="margin-right: 20px;">
<!--        <li><a href="?c=--><?php //echo $advisingController?><!--&a=--><?php //echo $getAdvisingInfoAction?><!--"><font style="color: #e67e22" size="3">Advising</font></a></li>-->
        <li><a href="?c=<?php echo $registerController?>"><span class="glyphicon glyphicon-user"></span><font style="margin-left:5px; color: #e67e22" size="3">Register</font></a></li>
        <li><a href="?c=<?php echo $loginController?>"><span class="glyphicon glyphicon-log-in"></span><font id="login" style="margin-left:5px; color: #e67e22" size="3">Login</font></a></li>
    </ul>
</div>
</div>
</nav>