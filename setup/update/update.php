<?php

/**
 * Here write the process to update the system
 */

$dir = __DIR__ . '/../../';
$document_root = $_SERVER['DOCUMENT_ROOT'];

$local_core = $document_root . '/core/';
Tools::deleteDirectory($local_core);
Application::get()->getLogger()->debug('Local core deleted');

$core_dir = $dir . 'core/';
Tools::copyDirectory($core_dir, $local_core);
Application::get()->getLogger()->debug('Core copied');

// fetch all migrations
$migrations = Tools::getFiles(__DIR__ . '/../' . 'migrations/', true);
foreach ($migrations as $file) {
    try {
        Application::get()->getLogger()->debug('Try to execute migration ' . $file . ' executed');
        $migration = new Migration(__DIR__ . '/../' . $file);
        $migration->load();
        $migration->execute();
        Application::get()->getLogger()->debug('Migration ' . $file . ' executed');
    } catch (Exception $e) {
        Application::get()->getLogger()->error('Error on migration ' . $file . ' ' . $e->getMessage());
        continue;
    }
}