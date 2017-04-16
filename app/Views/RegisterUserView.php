<?php

/**
 * Created by PhpStorm.
 * User: oguni
 * Date: 3/20/2017
 * Time: 12:11 AM
 */




?>

<?php
/**
 * Created by PhpStorm.
 * User: oguni
 * Date: 2/21/2017
 * Time: 6:45 PM
 */


include 'template/header.php';
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

<div class="container" style="margin-top: 40px">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>Create your profile</strong>
                </div>
                <div class="panel-body">
                    <form role="form" action="create_user.php" method="POST">
                        <fieldset>
                            <div class="row">
                                <div class="center-block">
                                    <img class="profile-img" src="img/mavblue.jpg" alt="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-10  col-md-offset-1 ">

                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="firstName"
                                                   placeholder="First Name">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="lastName"
                                                   placeholder="Last Name">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="tel" class="form-control" name="phone"
                                                   placeholder="8888888888">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="carrier">Phone Carrier</label>
                                            <select name ="carrier" class="form-control">
                                                <option value="att.net">AT&T</option>
                                                <option value="tmbobile.net">T-Mobile</option>
                                                <option value="verizon">Verizon</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <input type="submit" name = "submit" class="btn btn-lg btn-primary btn-block"
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

<?php
include 'template/footer.php';
?>
