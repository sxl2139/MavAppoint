<?php
session_start();

define("ROOT", __DIR__);

require (ROOT . "/app/Application.php");

date_default_timezone_set("America/Chicago");

$config = include_once ROOT . '/config/web.php';

$app = new Application($config);

$app->run();


