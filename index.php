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
$application = new Application(__DIR__, "/");

/**
 * Here you override the default routes
 */

// Simple route sans paramètre dans celle-ci
Application::get()->getRouter()->get("/helloworld/", function () {
    echo "Hello world";
});

// Route avec paramètre dans celle-ci
Application::get()->getRouter()->get("/helloworld/{dodo}", function (array $parameters) {
    echo "Hello world " . $parameters['dodo'];
});

/**
 * Run the application
 */
$application->run();