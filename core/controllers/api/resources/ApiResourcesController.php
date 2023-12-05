<?php

Autoloader::require("core/exceptions/file/FileUnauthorizedException.php");

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
                    $resourceModel = new ResourceModel($file['name'], $src, $alternative_text);
                    $resourceModel->createAndFetch();

                    $this->success("resource.upload", $resourceModel->toArray());
                    return true;
                }
            } else {
                $this->error("missing_parameters");
            }
        } catch (FileUnauthorizedException $e) {
            Application::get()->getLogger()->printException($e);
            $this->error("resource_upload_unauthorized");
            return;
        } catch (Exception $e) {
            Application::get()->getLogger()->printException($e);
            $this->error("resource_upload_error", ["exception" => $e->getMessage()]);
            return;
        }
        $this->error("resource_upload_failed");
    }

    public function edit(array $params)
    {
        $_PUT = Tools::getPut();

        try {
            if (isset($params['id']) && isset($_PUT["alternativeText"])) {
                $id = $params['id'];

                $resourceModel = new ResourceModel();
                $resourceModel->id($id);
                if ($resourceModel->fetch() !== null) {
                    $alternative_text = $_PUT["alternativeText"];

                    $resourceModel = new ResourceModel();
                    $resourceModel->id($id);
                    if ($resourceModel->fetch() !== null) {
                        $resourceModel->setAlternativeText($alternative_text);
                        $resourceModel->update();

                        $this->success("resource_updated", $resourceModel->toArray());
                        return;
                    }
                } else {
                    $this->error("resource_not_found");
                    return;
                }
            } else {
                $this->error("missing_parameters");
                return;
            }
        } catch (Exception $e) {
            $this->error("resource_delete_error");
            Application::get()->getLogger()->printException($e);
            return;
        }
        $this->error("resource_delete_failed");
    }

    public function delete(array $params)
    {
        try {
            if (isset($params['id'])) {
                $id = $params['id'];

                $resourceModel = new ResourceModel();
                $resourceModel->id($id);
                if ($resourceModel->fetch() !== null) {
                    if (!$resourceModel->deleteModel() || !$resourceModel->deleteFile()) {
                        $this->error("resource_cant_be_deleted");
                        return;
                    }
                    $this->success("resource_deleted");
                    return;
                }
                $this->error("resource_not_found");
                return;
            }
            $this->error("missing_parameters");
            return;
        } catch (Exception $e) {
            Application::get()->getLogger()->printException($e);
            if ($e->getCode() == 23000) {
                $this->error("resource_cant_be_deleted_when_has_been_used");
            }
            $this->error("sql_error[" . $e->getCode() . "]");
        }
    }
}