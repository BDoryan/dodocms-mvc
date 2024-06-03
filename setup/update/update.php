<?php

/**
 * Here write the process to update the system
 */

Application::get()->getLogger()->info('Start update.');
$dir = __DIR__ . '/../../';
$document_root = $_SERVER['DOCUMENT_ROOT'];
$local_core = $document_root . '/core/';
$core_dir = $dir . 'core/';

// Get the owner (user:group) of the core directory
$own_user = fileowner($local_core);
$own_group =  filegroup($local_core);

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
        echo 'Error on migration ' . $file . ' <strong>' . $e->getMessage()."</strong>";
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

function chownUserGroup($dir, $own_user, $own_group) {
    chown($dir, $own_user);
    chgrp($dir, $own_group);
    $dh = opendir($dir);
    while (($file = readdir($dh)) !== false) {
        if ($file != '.' && $file != '..') {
            $path = $dir . '/' . $file;
            if (is_dir($path)) {
                chownUserGroup($path, $own_user, $own_group);
            } else {
                chown($path, $own_user);
                chgrp($path, $own_group);

            }
        }
    }
    closedir($dh);
}

Application::get()->getLogger()->info('Change owner of core directory');
chownUserGroup($local_core, $own_user, $own_group);
Application::get()->getLogger()->info('Owner changed');

Application::get()->getLogger()->info('Replace changelog.md');
rename($dir . 'changelog.md', $document_root . '/changelog.md');
