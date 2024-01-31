<?php

class Modal extends Component
{

    private string $title = "";
    private string $description = "";
    private string $body = "";
    private string $footer = "";

    public function __construct()
    {
        parent::__construct();
    }

    public function title(string $title): Modal
    {
        $this->title = $title;
        return $this;
    }

    public function description(string $description): Modal
    {
        $this->description = $description;
        return $this;
    }

    public function body(string $body): Modal
    {
        $this->body = $body;
        return $this;
    }

    public function footer(string $footer): Modal
    {
        $this->footer = $footer;
        return $this;
    }

    public function render()
    {

    }

    public static function create(): Modal
    {
        return new Modal();
    }
}