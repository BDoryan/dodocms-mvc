<?php

class VueComponent
{

    private string $templateFile;
    private string $script;

    /**
     * @param string $templateFile
     * @param string $script
     */
    public function __construct(string $templateFile, string $script = "")
    {
        $this->templateFile = $templateFile;
        $this->script = $script;
    }

    /**
     * @return mixed
     */
    public function getTemplateFile()
    {
        return $this->templateFile;
    }

    /**
     * @param mixed $templateFile
     */
    public function setTemplateFile($templateFile): void
    {
        $this->templateFile = $templateFile;
    }

    /**
     * @return mixed
     */
    public function getScript()
    {
        return $this->script;
    }

    /**
     * @param mixed $script
     */
    public function setScript($script): void
    {
        $this->script = $script;
    }
}