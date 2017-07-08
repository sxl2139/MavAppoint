<?php
    include("template/header.php");
    $role = isset($_SESSION['role']) ? $_SESSION['role'] : "visitor";
    include("template/" . $role . "_navigation.php");
    $mavAppointUrl = $_SESSION['mavAppointUrl'];

    $content = json_decode($content, true);
?>

<div class="panel panel-default">
    <div class="panel-heading"><h2>Feedbacks</h2></div>
    <div class="panel-body">
        <div>
            <strong>Title title title title title title title</strong><br>
            <p class="text-muted">Content content content content content content content content </p>
        </div>
        <hr>
        <div>
            <strong>Title title title title title title title</strong><br>
            <p class="text-muted">Content content content content content content content content </p>
        </div>
    </div>
</div>
