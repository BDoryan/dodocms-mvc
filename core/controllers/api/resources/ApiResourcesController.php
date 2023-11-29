<?php

class ApiResourcesController extends ApiController
{

    private FileManager $fileManager;

    public function __construct()
    {
        $this->fileManager = new FileManager(Application::get()->toRoot("/storage/resources"));
    }

    /**
     * @return FileManager
     */
    public function getFileManager(): FileManager
    {
        return $this->fileManager;
    }

    public function upload()
    {
        try {
            $fileManager = $this->getFileManager();
            $file = $fileManager->getFile("file");

            if (!empty($file)) {
                $alternative_text = $_POST["alternativeText"] ?? "";
                $src = $fileManager->uploadFile($file, '');
                if (isset($src)) {
                    $src = str_replace(Application::get()->getRoot(), '', $src);
                    $mediaModel = new ResourceModel($file['name'], $src, $alternative_text);
                    $mediaModel->create();

                    $this->success("media_uploaded", $mediaModel->toArray());
                    return true;
                }
            } else {
                $this->error("missing_parameters");
            }
        } catch (Exception $e) {
            Application::get()->getLogger()->printException($e);
            $this->error("media_upload_error");
            return;
        }
        $this->error("media_upload_failed");
    }
}