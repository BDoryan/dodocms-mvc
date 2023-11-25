<?php

Autoloader::require('core/classes/Controller.php');

abstract class DOMController extends Controller
{

    protected string $title = '';
    protected string $description = '';
    protected string $keywords = '';
    protected string $author = '';
    protected string $head = '';

    public function __construct(string $name, string $root, string $asset = '/', $head = '')
    {
        parent::__construct($name, $root, $asset, '/page/layout');
        $this->head = $head;
    }

    public abstract function index();


    public function view($view, $data = []): void
    {
        $data['head'] = $this->fetch($this->head, [
            "title" => $this->title,
            "description" => $this->description,
            "keywords" => $this->keywords,
            "author" => $this->author
        ]);
        parent::view($view, $data);
    }
}