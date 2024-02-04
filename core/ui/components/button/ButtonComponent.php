<?php

Autoloader::require("core/ui/components/Component.php");

abstract class ButtonComponent extends Component
{

    const BUTTON_DEFAULT = 'tw-bg-white tw-text-gray-700 tw-border-[1px] tw-border-gray-300 tw-bg-opacity-75 hover:tw-bg-opacity-100 hover:tw-border-stone-300 hover:tw-text-gray-800';
    const BUTTON_GREEN = 'tw-bg-green-700 hover:tw-bg-green-800 tw-text-white focus:tw-outline-none focus:tw-shadow-outline-green active:tw-bg-green-800';
    const BUTTON_GRAY = 'tw-bg-gray-700 hover:tw-bg-gray-800 tw-text-white focus:tw-outline-none focus:tw-shadow-outline-gray active:tw-bg-gray-800';
    const BUTTON_RED = 'tw-bg-red-700 hover:tw-bg-red-800 tw-text-white focus:tw-outline-none focus:tw-shadow-outline-red active:tw-bg-red-800';
    const BUTTON_BLUE = 'tw-bg-blue-600 hover:tw-bg-blue-700 tw-text-white focus:tw-outline-none focus:tw-shadow-outline-blue active:tw-bg-blue-800';

    protected string $text;
    protected string $class;
    protected string $customClass = '';

    public function __construct(string $text = '')
    {
        parent::__construct('core/ui/views/components/button');
        $this->text = $text;
        $this->default();
    }

    public function style($class): ButtonComponent {
        $this->class = "tw-text-center tw-px-3 tw-py-[4px] tw-rounded-lg tw-shadow-sm tw-font-semibold $class";
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

    public function default(): ButtonComponent
    {
        $this->style(self::BUTTON_DEFAULT);
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