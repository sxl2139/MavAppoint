<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2017/4/6
 * Time: 16:19
 */

include("template/header.php");
$role = isset($_SESSION['role']) ? $_SESSION['role'] : "visitor";
include("template/" . $role . "_navigation.php");

$content = json_decode($content, true);
$advisors = isset($content['data']['advisors']) ? $content['data']['advisors'] : null;
$majors = isset($content['data']['majors']) ? $content['data']['majors'] : null;

$assignStudentToAdvisorAction = mav_encrypt("assignStudentToAdvisor");
$showAdvisorAssignmentAction = mav_encrypt("showAdvisorAssignment");
$successAction = mav_encrypt("success");
?>

<div class="panel panel-default">
    <div class="panel-heading"><h1>Assign Students To Advisors</h1></div>
    <div class="panel-body">
        <h2>Ranges - Uses the first letter of the last name</h2>
        <h4>Low - low end of range </h4>
        <h4>High - High end of the range </h4>
    </div>

    <table class="table">
        <thead>
        <tr>
            <th>Advisor</th>
            <th>Low</th>
            <th>High</th>
            <th>Degree</th>
            <th>Major</th>
        </tr>
        </thead>
        <tbody>
        <?php

        $position = 0;
        foreach ($advisors as $rs) {
            echo '<tr>';

            echo "<td id='pName" . $position . "' value = '".$rs['userId']."'>" . $rs['pName'] . "</td>";
            echo "<div id='userId" . $position . "' style=\"visibility:hidden\">".$rs['userId']."</div>";
            echo "<td><select name='lowRange" . $position . "' id='lowRange" . $position . "' 
                    title ='" . $rs['nameLow'] . "' 
                    class='btn btn-default dropdown-toggle  pull-left' 
                    data-toggle='dropdown'>";
            foreach (range('A', 'Z') as $letter) {
                if ($letter == $rs['nameLow'])
                    echo "<option value ='" . $letter . "' selected='selected'>" . $letter . "</option>";
                else
                    echo "<option value ='" . $letter . "'>" . $letter . "</option>";
            }
            echo '</select></td>';

            echo "<td><select name='highRange" . $position . "' id='highRange" . $position . "' 
                    title ='" . $rs['nameHigh'] . "' 
                    class='btn btn-default dropdown-toggle  pull-left' 
                    data-toggle='dropdown'>";
            foreach (range('A', 'Z') as $letter) {
                if ($letter == $rs['nameHigh'])
                    echo "<option value ='" . $letter . "' selected='selected'>" . $letter . "</option>";
                else
                    echo "<option value ='" . $letter . "'>" . $letter . "</option>";
            }
            echo '</select></td>';

            echo '<td>';
            echo "<select multiple='multiple' 
                           name='degree" . $position . "' 
                           id='degree" . $position . "'
                           title ='" . $rs['degreeType'] . "' 
                           class='btn btn-default dropdown-toggle  pull-left' 
                           data-toggle='dropdown'>";

            $degType = $rs['degreeType'];

            if($degType == '1'||$degType == '3'||$degType == '5'||$degType == '7'){
                echo "<option value ='Bachelors' selected='selected'>Bachelors</option>";
            }else
                echo "<option value ='Bachelors' >Bachelors</option>";

            if($degType == '3'||$degType == '6'||$degType == '7'){
                echo "<option value ='Masters' selected='selected'>Masters</option>";
            }else
                echo "<option value ='Masters' >Masters</option>";

            if($degType == '5'||$degType == '6'||$degType == '7'){
                echo "<option value ='Doctorate' selected='selected'>Doctorate</option>";
            }else
                echo "<option value ='Doctorate' >Doctorate</option>";

            echo '</select>';
            echo '</td>';

            echo '<td>';
            echo "<select multiple='multiple' 
                           name='majors" . $position . "' 
                           id='majors" . $position . "'
                           class='btn btn-default dropdown-toggle  pull-left' 
                           data-toggle='dropdown'>";

            foreach ($majors as $major) {
                if(in_array("$major", $rs['majors'])){
                    echo "<option value ='" . $major . "' selected='selected'>" . $major . "</option>";
                }else{
                    echo "<option value ='" . $major . "'>" . $major . "</option>";
                }
            }
            echo '</select>';
            echo '</td>';

            echo '</tr>';

            $position++;
        }
        ?>
        </tbody>
    </table>

    <div class="panel-footer text-center">
        <input id="assignStudentSubmit" type="submit" class="btn-lg" value="Submit">
    </div>

    <input id="adminController" type="hidden" value="<?= $adminController ?>"/>
    <input id="assignStudentToAdvisorAction" type="hidden" value="<?= $assignStudentToAdvisorAction ?>"/>
    <input id="showAdvisorAssignmentAction" type="hidden" value="<?= $showAdvisorAssignmentAction ?>"/>
    <input id="successAction" type="hidden" value="<?= $successAction ?>"/>
    <input id="length" type="hidden" value="<?= $position ?>"/>
</div>
