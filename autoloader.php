<?php

/**
 * Get the PHP version.
 */
$php_version = phpversion();

/**
 * Check if the PHP version is 7.4.0 or higher.
 */
if (version_compare($php_version, '7.4.0') < 0) {
    echo "Your PHP version is $php_version. Please upgrade to 7.4.0 or higher.";
    exit;
}

/**
 * Load all the classes, controllers, routes and components.
 */
require_once 'core/classes/Autoloader.php';
Autoloader::require('core/classes', true);
Autoloader::require('core/controllers', true);
Autoloader::require('core/exceptions', true);
Autoloader::require('core/routes', true);
Autoloader::require('core/components', true);
Autoloader::require('models', true);

/**
 * Initialize session.
 */
Session::start();

/**
 * Translate with a key and replaces options
 *
 * @param $key
 * @param array $options
 * @return string
 */
function __($key, array $options = []): string
{
    $application = Application::get();
    if(!isset($application)) return $key;
    if($application->getInternationalization() == null) return $key;

    return Application::get()->getInternationalization()->translate($key, $options);
}

/**
 * Get the view content
 *
 * @param $path string the path to the view
 * @return void
 */
function fetch(string $path, array $data = []): string
{
    if(!Tools::endsWith($path, '.php'))
        $path .= ".php";

    Application::get()->getLogger()->debug("fetch($path)");
    ob_start();
    view($path, $data);
    return ob_get_clean();
}

/**
 * Render the view
 *
 * @param $path string the path to the view
 * @return void
 */
function view(string $path, array $data = []){
    if(!Tools::endsWith($path, '.php'))
        $path .= ".php";

    Application::get()->getLogger()->debug("view($path)");
    if(!empty($data)){
        extract($data);
    }
    include $path;
}