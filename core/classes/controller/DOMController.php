<?php

Autoloader::require('core/classes/controller/Controller.php');

abstract class DOMController extends Controller
{

    protected string $title = '';
    protected string $description = '';
    protected string $keywords = '';
    protected string $author = '';
    protected ?ResourceModel $favicon = null;
    protected string $head_path = '';
    protected string $header = '';
    protected string $footer = '';
    protected string $scripts = '';

    public function __construct(string $name, string $root, string $asset = '/', $head_path = '', $layout = '')
    {
        parent::__construct($name, $root, $asset, $layout);
        $this->head_path = $head_path;
    }

    public abstract function index();

    public function view(string $view, array $data = []): void
    {
        $data['head'] = $this->fetch($this->head_path, [
            "title" => $this->title,
            "description" => $this->description,
            "keywords" => $this->keywords,
            "author" => $this->author,
            'favicon' => $this->favicon ?? null
        ]);
        $data['header'] = $this->header;
        $data['footer'] = $this->footer;
        $data['scripts'] = $this->scripts;

        parent::view($view, $data);
    }
}