<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'autoloader.php';

$application = new Application(__DIR__, "/dodocms-mvc");
$application->run();