<?php
include("template/header.php");
include("template/visitor_navigation.php");
$mavAppointUrl = $_SESSION['mavAppointUrl'];
$loginController = mav_encrypt("login");
$forgotPasswordDefaultAction = mav_encrypt("forgotPasswordDefault");
$forgotPasswordAction = mav_encrypt("forgotPassword");
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

<input class="mavAppointUrl" type="hidden" value="<?php echo $mavAppointUrl?>"/>
<input id="loginController" type="hidden" value="<?php echo $loginController?>"/>
<input id="forgotPasswordAction" type="hidden" value="<?php echo $forgotPasswordAction?>"/>


<div class="container" style="margin-top: 40px">
    <div><label id="forgotPasswordMessage" for="message"></label></div>
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>Forgot Password?</strong>
                </div>
                <div class="panel-body">
                    <form role="form" action="#" method="POST">
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
											<span class="input-group-addon"> <i
                                                    class="glyphicon glyphicon-user"></i>
											</span> <input id="emailAddress" type="text" class="form-control" name=emailAddress
                                                           placeholder="yourname@mavs.uta.edu">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input id="forgotPassword" type="submit" name = "signIn" class="btn btn-lg btn-primary btn-block"
                                               value="Submit">
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

<?php include("template/footer.php"); ?>

