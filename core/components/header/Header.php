<?php

class Header extends Component
{

    private string $title;
    private string $description;
    private string $content = '';

    public function __construct()
    {
        parent::__construct();
        $this->template = '/core/views/components/header';
    }

    public function content(string $content): Header
    {
        $this->content = $content;
        return $this;
    }

    public function title(string $title): Header
    {
        $this->title = $title;
        return $this;
    }

    public function description(string $description): Header
    {
        $this->description = $description;
        return $this;
    }

    public function render()
    {
        view("$this->template/header.php", [
            'title' => $this->title,
            'description' => $this->description,
            'content' => $this->content
        ]);
    }

    public static function create(): Header
    {
        return new Header();
    }
}