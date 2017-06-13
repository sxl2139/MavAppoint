<?php
include("template/header.php");
include("template/visitor_navigation.php");
$mavAppointUrl = $_SESSION['mavAppointUrl'];
$loginController = mav_encrypt("login");
$checkAction = mav_encrypt("check");
$changePasswordDefaultAction = mav_encrypt("changePasswordDefault");
$indexController = mav_encrypt("index");
$testAction = mav_encrypt("test");
?>
    <style>
        .panel-heading {
            padding: 5px 15px;
        }

        .panel-footer {
            padding: 1px 15px;
            color: #A0A0A0;
        }

        .profile-img {
            width: 96px;
            height: 96px;
            margin: 0 auto 10px;
            display: block;
            -moz-border-radius: 50%;
            -webkit-border-radius: 50%;
            border-radius: 50%;
        }
    </style>

    <input id="loginController" type="hidden" value="<?php echo $loginController?>"/>
    <input id="checkAction" type="hidden" value="<?php echo $checkAction?>"/>
    <input id="changePasswordDefaultAction" type="hidden" value="<?php echo $changePasswordDefaultAction?>"/>
    <input id="indexController" type="hidden" value="<?php echo $indexController?>"/>
    <input class="mavAppointUrl" type="hidden" value="<?php echo $mavAppointUrl?>"/>
<!--    <input id="testAction" type="hidden" value="--><?//=$testAction?><!--"/>-->

    <div class="container" style="margin-top: 40px">
        <div id="message" style="visibility: hidden"><label for="message"><font color="#e67e22" size="4"><center>Username or Password Invalid</center></label></div>
        <div class="row">
            <div class="col-sm-6 col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>Sign in to continue</strong>
                    </div>
                    <div class="panel-body">
                        <form id="loginForm" role="form">
                            <fieldset>
                                <div class="row">
                                    <div class="center-block">
                                        <img class="profile-img" src="app/Views/img/mavblue.jpg" alt="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-10  col-md-offset-1 ">
                                        <div class="form-group">
                                            <div class="input-group">
											<span class="input-group-addon"> <i class="glyphicon glyphicon-user"></i></span>
                                                <input type="text" class="form-control" id="email" name=email placeholder="yourname@mavs.uta.edu">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="input-group">
											<span class="input-group-addon"> <i class="glyphicon glyphicon-lock"></i></span>
                                                <input type="password" class="form-control" id="password" name=password>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <input id="signIn" type="submit" name="signIn" class="btn btn-lg btn-primary btn-block" value="Sign in">
                                            <input type="submit" name="forgotPassword" class="btn btn-lg btn-primary btn-block" value="Forgot Password">
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    <div class="panel-footer "></div>
                </div>
            </div>
        </div>
    </div>

<!--    <a href="?c=--><?php //echo $loginController?><!--&a=--><?php //echo $testAction?><!--" >test DB</a>-->


<?php include("template/footer.php"); ?>