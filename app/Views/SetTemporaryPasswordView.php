<?php
/**
 * Created by PhpStorm.
 * User: shenchen
 * Date: 7/10/17
 * Time: 2:52 PM
 */
include ("template/header.php");
$role = isset($_SESSION['role']) ? $_SESSION['role'] : "visitor";
include ("template/" . $role . "_navigation.php");
$mavAppointUrl = $_SESSION['mavAppointUrl'];
$content = json_decode($content, true);

$adminController = mav_encrypt("admin");
$setTemporaryPasswordIntervalAction = mav_encrypt("setTemporaryPasswordInterval");
$successAction=mav_encrypt("success");
?>

    <style>
        .resize {
            width: 60%;
        }
        .resize-body {
            width: 80%;
        }
    </style>


    <input id="adminController" type="hidden" value="<?php echo $adminController?>"/>
    <input id="setTemporaryPasswordInterval" type="hidden" value="<?php echo $setTemporaryPasswordIntervalAction?>"/>
    <input type="hidden" id="successAction" value="<?php echo $successAction?>">
    <input class="mavAppointUrl" type="hidden" value="<?php echo $mavAppointUrl?>"/>
    <div class="container">

        <!-- Panel -->
        <div class="panel panel-default resize center-block">
            <div class="panel-heading text-center"><h1>Set Temporary Password Expiration Time</h1></div>
            <!-- Default panel contents -->

            <form action="#" method="post" name="setTemporaryPasswordInterval_form" id="setTemporaryPasswordInterval_form" onsubmit="return false;">
                <div class="panel-body resize-body center-block">

                    <div class="form-group">
                        <label for="setTemporaryPasswordInterval"><font color="#0" size="4">Time(days)</font></label><br>
                        <input type="text" style="width: 350px;" class="form-control" id="entertemporaryPasswordInterval" name="temporaryPasswordInterval" placeholder="">

                        <!--                        <label for="pname"><font color="#0" size="4">Display-->
                        <!--                                Name</font></label><br> <input type="text" style="width: 350px;"-->
                        <!--                                                               class="form-control" id="pname" placeholder="">-->
                        <br>
                    </div>

                </div>

                <div class= "panel-footer text-center">
                    <input id="setTemporaryPasswordIntervalSubmit" type="submit" class="btn-lg" value="Submit">
                </div>
            </form>
        </div>
    </div>

    <script>
        function FormSubmit(){
            var text = document.department_form.department.value;
            var textValue = text.replace(/(^\s*)|(\s*$)/g, "");
            if(textValue==null || textValue==""){
                alert("Need to enter a department");
            }else {
                document.getElementById("department_form").submit();
            }

        }
    </script>
<?php include("template/footer.php");?>