<?php

Autoloader::require('models/PageModel.php');

class PageController extends DOMController
{

    public function __construct()
    {
        parent::__construct('page', $this->toRoot('/views'), 'assets/', 'head', '/template');
    }

    public function index()
    {
    }

    public function viewPage(PageModel $page) {
        ob_start();
        echo "<pre>";
        var_dump($page);
        echo "</pre>";
        $content = ob_get_clean();

        $this->header = $this->fetch("header");
        $this->footer = $this->fetch("footer");
        $this->title = $page->getSeoTitle();
        $this->description = $page->getSeoDescription();
        $this->keywords = $page->getSeoKeywords();

        $this->view('layout', ['content' => $content]);
    }
}