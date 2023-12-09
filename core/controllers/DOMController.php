<?php

Autoloader::require('core/classes/Controller.php');

abstract class DOMController extends Controller
{

    protected string $title = '';
    protected string $description = '';
    protected string $keywords = '';
    protected string $author = '';
    protected string $head_path = '';
    protected string $header = '';
    protected string $footer = '';

    public function __construct(string $name, string $root, string $asset = '/', $head_path = '', $layout = '/page/layout')
    {
        parent::__construct($name, $root, $asset, $layout);
        $this->head_path = $head_path;
    }

    public abstract function index();

    public function view($view, $data = []): void
    {
        $data['head'] = $this->fetch($this->head_path, [
            "title" => $this->title,
            "description" => $this->description,
            "keywords" => $this->keywords,
            "author" => $this->author
        ]);
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;

        parent::view($view, $data);
    }
}