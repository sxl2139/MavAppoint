<?php
include ("template/header.php");
$role = isset($_SESSION['role']) ? $_SESSION['role'] : "visitor";
include ("template/" . $role . "_navigation.php");
$mavAppointUrl = $_SESSION['mavAppointUrl'];
$content = json_decode($content, true);
$departments = $content;

$adminController = mav_encrypt("admin");
$createNewDepartmentAction = mav_encrypt("createNewDepartment");
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
    <input id="createNewDepartmentAction" type="hidden" value="<?php echo $createNewDepartmentAction?>"/>
    <input type="hidden" id="success2Action" value="<?php echo $success2Action?>">
    <input class="mavAppointUrl" type="hidden" value="<?php echo $mavAppointUrl?>"/>
    <div class="container">
        <!-- Panel -->
        <div class="panel panel-default resize center-block">
            <!-- Default panel contents -->
            <form action="#" method="post" name="department_form" id="department_form" onsubmit="return false;">
                <div class="panel-heading text-center"><h1>Add New Department</h1></div>
                <div class="panel-body resize-body center-block">

                    <div class="form-group">

                        <!--                        <label for="drp_department"><font color="#0" size="4">Departments</font></label>-->
                        <!--                        <br>-->
                        <!--                        <select id="drp_department" name="drp_department" class="btn btn-default btn-lg dropdown-toggle">-->
                        <!--                            --><?php
                        //                            for($i=0; $i<count($departments);$i++){?>
                        <!--                                <option value=--><?php //echo $departments[$i]?><!-- >-->
                        <!--                                    --><?php //echo $departments[$i]?>
                        <!--                                </option>-->
                        <!--                            --><?php //} ?>
                        <!--                        </select>-->
                        <!--                        <br>-->

                        <label for="department"><font color="#0" size="4">Department</font></label><br>
                        <input type="text" style="width: 350px;" class="form-control" id="enterDepartment" name="department" placeholder="">

                        <!--                        <label for="pname"><font color="#0" size="4">Display-->
                        <!--                                Name</font></label><br> <input type="text" style="width: 350px;"-->
                        <!--                                                               class="form-control" id="pname" placeholder="">-->
                        <br>
                    </div>

                </div>

                <div class= "panel-footer text-center">
                    <input id="addDepartmentSubmit" type="submit" class="btn-lg" value="Submit">
                </div>

<!--                <div class= "panel-footer text-center">-->
<!--                    <input onclick="javascript:FormSubmit();" id="addDepartmentButton" type="submit" class="btn-lg" value="Submit">-->
<!--                </div>-->
            </form>

            <label id="addDepartmentResult"><?php echo $departments['message']?></label>

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