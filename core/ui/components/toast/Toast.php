<?php

class Toast extends Component
{

    const TYPE_INFO = "info";
    const TYPE_SUCCESS = "success";
    const TYPE_ERROR = "error";
    const TYPE_WARNING = "warning";

    protected string $type = self::TYPE_INFO;
    protected string $title;
    protected string $message;

    protected int $duration = 5000;

    /**
     * @param string $title
     * @param string $message
     */
    public function __construct(string $title = '', string $message = '', string $type = self::TYPE_INFO)
    {
        parent::__construct('core/ui/views/components/toast');
        $this->title = $title;
        $this->message = $message;
        $this->type = $type;
    }

    public function getTitle(): string
    {
        return str_replace("'", "\\'", $this->title);
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function getMessage(): string
    {
        return str_replace("'", "\\'", $this->message);
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

    public function duration(int $duration): Toast
    {
        $this->duration = $duration;
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