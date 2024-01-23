<?php

Autoloader::require('core/ui/components/Component.php');

class Alert extends Component
{

    const TYPE_INFO = "info";
    const TYPE_SUCCESS = "success";
    const TYPE_ERROR = "error";
    const TYPE_WARNING = "warning";

    const STYLES = [
        self::TYPE_INFO => "blue",
        self::TYPE_SUCCESS => "green",
        self::TYPE_ERROR => "red",
        self::TYPE_WARNING => "orange",
    ];

    protected string $type = self::TYPE_INFO;
    protected string $title;
    protected string $message;

    /**
     * @param string $title
     * @param string $message
     */
    public function __construct(string $title = '', string $message = '', string $type = self::TYPE_INFO)
    {
        parent::__construct('core/ui/views/components/alert');
        $this->title = $title;
        $this->message = $message;
        $this->type = $type;
    }

    public function title(string $title): Alert
    {
        $this->title = $title;
        return $this;
    }

    public function message(string $message): Alert
    {
        $this->message = $message;
        return $this;
    }

    public function type(string $type): Alert
    {
        $this->type = $type;
        return $this;
    }

    public function render()
    {
        include "$this->template/alert.php";
    }

    public static function create(): Alert
    {
        return new Alert();
    }
}