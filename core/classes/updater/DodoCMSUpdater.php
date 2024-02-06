<?php

Autoloader::require('core/classes/updater/Updater.php');

class DodoCMSUpdater extends Updater
{
    public function __construct()
    {
        parent::__construct(DodoCMS::VERSION, 'https://dodocms.doryanbessiere.fr/');
    }

    public function update()
    {
        $this->downloadLastVersion();
        $destination =$this->extractLastVersion();

        if (substr($destination, -1) === '/')
            $destination = substr($destination, 0, -1);

        include $destination . 'setup/update/update.php';

//        Tools::deleteDirectory($destination);
    }
}