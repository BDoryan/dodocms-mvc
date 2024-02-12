<?php

abstract class Updater
{

    private string $current_version;
    private string $server_url;

    public function __construct(string $current_version, string $server_url)
    {
        if (substr($server_url, -1) == '/')
            $server_url = substr($server_url, 0, -1);

        $this->server_url = $server_url;
        $this->current_version = $current_version;
    }

    /**
     * Download the last version of the software
     *
     * @return void
     */
    public function downloadLastVersion()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->server_url . '/last-version.zip');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        Cache::storeFileInCache('last-version.zip', $output);
    }

    /**
     * This method extract zip file in cache
     * Warning: if the directory already exists, it will be deleted
     *
     * @return string|null the directory of the last version or nul if it has failed
     */
    public function extractLastVersion(): ?string
    {
        $zip = new ZipArchive;
        $res = $zip->open(Cache::toFileInCache('last-version.zip'));
        if ($res === TRUE) {
            $destination = Cache::toFileInCache('last-version');

            if (file_exists($destination))
                Tools::deleteDirectory($destination);

            $zip->extractTo($destination);
            $zip->close();

            return $destination;
        }
        return null;
    }

    public function hasUpdate(): bool
    {
        return trim($this->getLastVersion()) !== trim($this->getCurrentVersion());
    }

    public abstract function update();

    /**
     * Return the last version of the software
     *
     * @return string
     */
    public function getLastVersion(): string
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->server_url . '/version.txt');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    /**
     * Return the current version of the software
     *
     * @return string
     */
    public function getCurrentVersion(): string
    {
        return $this->current_version;
    }

    /**
     * Return the url of server where the data is stored
     *
     * @return string
     */
    public function getServerUrl(): string
    {
        return $this->server_url;
    }
}