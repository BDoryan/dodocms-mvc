<?php

Autoloader::require("core/ui/components/Component.php");

abstract class ButtonComponent extends Component
{

    const BUTTON_GREEN = 'dodocms-bg-green-700 hover:dodocms-bg-green-800 dodocms-text-white focus:dodocms-outline-none focus:dodocms-shadow-outline-green active:dodocms-bg-green-800';
    const BUTTON_GRAY = 'dodocms-bg-gray-700 hover:dodocms-bg-gray-800 dodocms-text-white focus:dodocms-outline-none focus:dodocms-shadow-outline-gray active:dodocms-bg-gray-800';
    const BUTTON_RED = 'dodocms-bg-red-700 hover:dodocms-bg-red-800 dodocms-text-white focus:dodocms-outline-none focus:dodocms-shadow-outline-red active:dodocms-bg-red-800';
    const BUTTON_BLUE = 'dodocms-bg-blue-600 hover:dodocms-bg-blue-700 dodocms-text-white focus:dodocms-outline-none focus:dodocms-shadow-outline-blue active:dodocms-bg-blue-800';

    protected string $text;
    protected string $class;
    protected string $customClass = '';

    public function __construct(string $text = '')
    {
        parent::__construct('core/ui/views/components/button');
        $this->text = $text;
        $this->gray();
    }

    public function style($class): ButtonComponent {
        $this->class = "dodocms-text-center dodocms-px-3 dodocms-py-[6px] dodocms-rounded-lg dodocms-shadow-sm dodocms-font-semibold dodocms-uppercase $class";
        $this->class .= $this->customClass;
        return $this;
    }

    /**
     *
     * Warning: For now, this method only works if you call it before the style() method.
     *
     * @param string $class
     * @return $this
     */
    public function addClass(string $class): ButtonComponent
    {
        if (substr($class, 0, 1) != ' ')
            $class = ' ' . $class;

        $this->customClass .= $class;
        return $this;
    }

    public function green(): ButtonComponent
    {
        $this->style(self::BUTTON_GREEN);
        return $this;
    }

    public function gray(): ButtonComponent
    {
        $this->style(self::BUTTON_GRAY);
        return $this;
    }

    public function red(): ButtonComponent
    {
        $this->style(self::BUTTON_RED);
        return $this;
    }

    public function blue(): ButtonComponent
    {
        $this->style(self::BUTTON_BLUE);
        return $this;
    }

    public function text(string $text): ButtonComponent
    {
        $this->text = $text;
        return $this;
    }

    public function setClass(string $class): ButtonComponent
    {
        $this->class = $class;
        return $this;
    }

    public abstract function render();
}