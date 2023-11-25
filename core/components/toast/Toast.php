<?php

class Toast extends Component
{

    const TYPE_INFO = "info";
    const TYPE_SUCCESS = "success";
    const TYPE_DANGER = "danger";
    const TYPE_WARNING = "warning";

    const STYLES = [
        self::TYPE_INFO => "blue",
        self::TYPE_SUCCESS => "green",
        self::TYPE_DANGER => "red",
        self::TYPE_WARNING => "orange",
    ];

    protected string $type = self::TYPE_INFO;
    protected string $title;
    protected string $message;

    protected int $timeout = 5000;

    /**
     * @param string $title
     * @param string $message
     */
    public function __construct(string $title = '', string $message = '')
    {
        parent::__construct('core/views/components/toast');
        $this->title = $title;
        $this->message = $message;
    }

    public function title(string $title): Toast
    {
        $this->title = $title;
        return $this;
    }

    public function message(string $message): Toast
    {
        $this->message = $message;
        return $this;
    }

    public function type(string $type): Toast
    {
        $this->type = $type;
        return $this;
    }

    public function timeout(int $timeout): Toast
    {
        $this->timeout = $timeout;
        return $this;
    }

    public function render()
    {
        include "$this->template/toast.php";
    }

    public static function create(): Toast
    {
        return new Toast();
    }
}