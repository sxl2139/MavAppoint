<?php
$loginController = mav_encrypt("login");
$registerController = mav_encrypt("register");
$advisingController = mav_encrypt("advising");
$getAdvisingInfoAction = mav_encrypt("getAdvisingInfo");
?>
<div>
    <ul class="nav navbar-nav">
        <li><a href="?c=<?php echo $advisingController?>&a=<?php echo $getAdvisingInfoAction?>"><font style="color: #e67e22" size="3">Advising</font></a></li>
    </ul>

    <ul class="nav navbar-nav navbar-right">
        <li><a href="?c=<?php echo $registerController?>"><span class="glyphicon glyphicon-user"><font style="color: #e67e22" size="3">Register</font></a></li>
        <li><a href="?c=<?php echo $loginController?>"><span class="glyphicon glyphicon-log-in"><font id="login" style="color: #e67e22" size="3">Login</font></a></li>
    </ul>
</div>
</div>
</nav>