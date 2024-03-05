<?php

Autoloader::require("core/exceptions/FileUnauthorizedException.php");

class FileManager
{

    private string $upload_directory;
    private array $allowed_mime_types = [
        'image/jpeg',
        'image/png',
        'application/pdf'
    ];

    private string $upload_max_filesize = '5M';

    /**
     * @param string $upload_directory
     */
    public function __construct(string $upload_directory = "uploads")
    {
        $this->upload_directory = $upload_directory;

        ini_set('upload_max_filesize', $this->upload_max_filesize);
        ini_set('post_max_size', $this->upload_max_filesize);
    }

    /**
     * @throws Exception
     */
    public function uploadFile(array $file, string $destination = null): ?string
    {
        if (!isset($file)) return null;

        $pathinfo = pathinfo($file["name"]);

        $destination = isset($destination) ? $this->upload_directory . "/" . trim($destination, '/') : $this->upload_directory;
        $destination = rtrim($destination, "/") . "/";

        if (!file_exists($destination)) {
            mkdir($destination, 0775, true);
        }

        $destination .= Tools::slugify($pathinfo["filename"]) . "_" . date("Y-m-d_H-m-s") . "." . $pathinfo["extension"];

        $file_size = $file["size"];
        if ($file_size <= 0) return null;

        $mime_type = Tools::getMimeType($file["tmp_name"]);

        if (!in_array($mime_type, $this->allowed_mime_types))
            throw new FileUnauthorizedException("File type not allowed", $file["name"]);

        if (move_uploaded_file($file["tmp_name"], $destination))
            return $destination;

        return null;
    }

    public function uploadFiles(array $files, $destination = null): ?array
    {
        $destinations = [];
        foreach ($files as $file) {
            $destination_path = $this->uploadFile($file, $destination);
            if (!isset($destination_path))
                return null;

            $destinations[] = $destination_path;
        }
        return $destinations;
    }

    public function getFile(string $name): ?array
    {
        if (!isset($_FILES[$name])) return null;

        return $_FILES[$name];
    }

    public function getFiles(string $name): ?array
    {
        if (!isset($_FILES[$name])) return null;


        $files = [];
        foreach ($_FILES[$name]["name"] as $key => $file_name) {
            $files[] = [
                "name" => $file_name,
                "type" => $_FILES[$name]["type"][$key],
                "tmp_name" => $_FILES[$name]["tmp_name"][$key],
                "error" => $_FILES[$name]["error"][$key],
                "size" => $_FILES[$name]["size"][$key],
            ];
        }

        return $files;
    }

    public function deleteFile(string $path, string $destination = null): void
    {
        if (file_exists($path)) {
            unlink($path);
        }
    }

    /**
     * @return string
     */
    public function getUploadDirectory(): string
    {
        return $this->upload_directory;
    }
}