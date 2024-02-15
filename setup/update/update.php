<?php

/**
 * Here write the process to update the system
 */

Application::get()->getLogger()->info('Start update.');
$dir = __DIR__ . '/../../';
$document_root = $_SERVER['DOCUMENT_ROOT'];
$local_core = $document_root . '/core/';
$core_dir = $dir . 'core/';

// fetch all migrations
$migration_dir = __DIR__ . '/../' . 'migrations/';
$migrations = Tools::getFiles($migration_dir, true);

// Sort migrations by timestamp in filename
usort($migrations, function($a, $b) {
    $timestampA = (int)pathinfo($a, PATHINFO_FILENAME);
    $timestampB = (int)pathinfo($b, PATHINFO_FILENAME);
    return $timestampA - $timestampB;
});

// Filter migrations based on DodoCMS::VERSION_TIMESTAMP
$filteredMigrations = array_filter($migrations, function($file) {
    $migrationTimestamp = (int)pathinfo($file, PATHINFO_FILENAME);
    return $migrationTimestamp > DodoCMS::VERSION_TIMESTAMP;
});

foreach ($filteredMigrations as $file) {
    try {
        Application::get()->getLogger()->info('Try to execute migration ' . $file . ' executed');
        $migration = new Migration($migration_dir . $file);
        $migration->load();
        Application::get()->getLogger()->info('SQL -> '.$migration->getSql());
        $migration->execute();
        Application::get()->getLogger()->info('Migration ' . $file . ' executed');
    } catch (Exception $e) {
        Application::get()->getLogger()->error('Error on migration ' . $file . ' ' . $e->getMessage());
        echo 'Error on migration ' . $file . ' ' . $e->getMessage();
        if(!isset($_GET['force']))
        die;
    }
}

Application::get()->getLogger()->info('Starting to update core (delete current core directory)');
Tools::deleteDirectory($local_core);
Application::get()->getLogger()->info('Local core deleted');

Application::get()->getLogger()->info('Copy new core directory');
Tools::copyDirectory($core_dir, $local_core);
Application::get()->getLogger()->info('Core copied');