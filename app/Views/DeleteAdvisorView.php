<?php
/**
 * Created by PhpStorm.
 * User: shenchen
 * Date: 6/15/17
 * Time: 12:41 AM
 */

include ("template/header.php");
$role = isset($_SESSION['role']) ? $_SESSION['role'] : "visitor";
include ("template/" . $role . "_navigation.php");
$mavAppointUrl = $_SESSION['mavAppointUrl'];
$content = json_decode($content, true);
$adminController = mav_encrypt("admin");
$deleteSelectAdvisorAction = mav_encrypt("deleteSelectAdvisor");
$success2Action=mav_encrypt("success2");

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
<input id="deleteSelectAdvisorAction" type="hidden" value="<?php echo $deleteSelectAdvisorAction?>"/>
<input type="hidden" id="success2Action" value="<?php echo $success2Action?>">
<input class="mavAppointUrl" type="hidden" value="<?php echo $mavAppointUrl?>"/>
<div class="container">
    <!-- Panel -->
    <div class="panel panel-default resize center-block">
        <!-- Default panel contents -->
        <form action="#>" method="post" name="advisor_form" id="advisor_form" onsubmit="return false;">
            <div class="panel-heading text-center"><h1>Delete Advisor</h1></div>
            <div class="panel-body resize-body center-block">
                <div id="shenchenshen"class="form-group">
                    <?php
                    if(isset($content)){

                        for($i=0;$i<count($content["userId"]);$i++){
                            ?>
                            <input type="checkbox"  id="advisor" name="advisor[]" value=<?php echo $content["userId"][$i]?>>
                            <label><font color="#0" size="4"><?php echo $content["pName"][$i]?></font></label>
                            <br/>
                            <?php

                        }
                    } else {?>
                        No advisors currently available <?php } ?>
                </div>
            </div>

<!--            <div class= "panel-footer text-center">-->
<!--                <input onclick="javascript:FormSubmit();" id="deleteAdvisorButton" type="submit" class="btn-lg" value="Submit">-->
<!--            </div>-->


            <div class= "panel-footer text-center">
                <input id="deleteAdvisorSubmit" type="submit" class="btn-lg" value="Submit">
            </div>
        </form>
        <label id="deleteAdvisorResult"><?php echo $content["message"]?><font color="#0" size="4"></font></label>
    </div>
</div>

<script>
    function FormSubmit(){

        if ($("input[name='advisor[]']:checked").length === 0) {
            alert('Select atleast one advisor');
            return false;
        }
        document.getElementById('advisor_form').submit();
    }
</script>
<?php include("template/footer.php");?>
