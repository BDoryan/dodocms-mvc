<?php

/**
 * Configure php
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * Load all requires
 */
include 'autoloader.php';

/**
 * Run the application
 */
$application = new Application(__DIR__, "/dodocms-mvc");
$application->run();