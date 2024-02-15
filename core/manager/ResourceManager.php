<?php

class ResourceManager
{

    private string $root;
    private array $css_files = [];
    private array $styles = [];
    private array $javascript_files = [];
    private array $scripts = [];

    public function __construct($root = '')
    {
        if (!empty($root) && substr($root, -1) === '/')
            $root = substr($root, 0, -1);
        $this->root = $root;
    }

    /**
     * @return string
     */
    public function getRoot(): string
    {
        return $this->root;
    }

    public function toRoot(string $path): string
    {
        if (preg_match('/^https?:\/\//', $path))
            return $path;

        if ($path[0] !== '/')
            $path = '/' . $path;
        return $this->root . $path;
    }

    /**
     * @param string $path path to the css file (from the root of the resources)
     * @param string $media media type of the css file
     * @param array $attributes more attributes to add to the link tag
     * @return void
     */
    public function addCSS(string $path, string $media = 'all', string $rel = 'stylesheet', array $attributes = [])
    {
        $this->css_files[] = ['path' => $this->toRoot($path), 'media' => $media, 'rel' => $rel, 'attributes' => $attributes];
    }

    public function addJavaScript(string $path, bool $async = false, bool $defer = false, array $attributes = [])
    {
        $this->javascript_files[] = ['path' => $this->toRoot($path), 'async' => $async, 'defer' => $defer, 'attributes' => $attributes];
    }

    public function addScript(string $script)
    {
        $this->scripts[] = $script;
    }

    public function addStyle(string $style)
    {
        $this->styles[] = $style;
    }

    /**
     * Return the rendered attributes
     *
     * @param $attributes
     * @return string
     */
    private function renderAttributes($attributes): string
    {
        $rendered = '';
        foreach ($attributes as $key => $value) {
            $rendered .= ' ' . htmlspecialchars($key) . '="' . htmlspecialchars($value) . '"';
        }
        return $rendered;
    }

    /**
     * Return the rendered css and clear the css files array and the styles array
     *
     * @param bool $print print the css or not
     * @return string
     */
    public function css(bool $print = true): string
    {
        ob_start();
        foreach ($this->css_files as $cssFile) {
            $attributes = $this->renderAttributes($cssFile['attributes']);
            echo '<link rel="' . $cssFile['rel'] . '" href="' . $cssFile['path'] . '" media="' . $cssFile['media'] . '"' . $attributes . '>' . PHP_EOL;
        }
        foreach ($this->styles as $style) {
            if (preg_match('/<style.*?>.*?<\/style>/', $style))
                echo $style . PHP_EOL;
            else
                echo '<style>' . $style . '</style>' . PHP_EOL;
        }
        $css = ob_get_clean();
        if ($print)
            echo $css;
        $this->css_files = [];
        $this->styles = [];
        return $css;
    }

    /**
     * Return the rendered javascript and clear the javascript files array and the scripts array
     *
     * @param bool $print print the javascript or not
     * @return string
     */
    public function scripts(bool $print = true): string
    {
        ob_start();
        foreach ($this->javascript_files as $jsFile) {
            $attributes = $this->renderAttributes($jsFile['attributes']);
            $async = $jsFile['async'] ? ' async' : '';
            $defer = $jsFile['defer'] ? ' defer' : '';
            echo '<script src="' . $jsFile['path'] . '"' . $async . $defer . $attributes . '></script>' . PHP_EOL;
        }
        foreach ($this->scripts as $script) {
            if (preg_match('/<script.*?>.*?<\/script>/', $script))
                echo $script . PHP_EOL;
            else
                echo '<script>' . $script . '</script>' . PHP_EOL;
        }
        $scripts = ob_get_clean();
        if ($print)
            echo $scripts;
        $this->javascript_files = [];
        $this->scripts = [];
        return $scripts;
    }
}

// Exemple d'utilisation de la classe ResourceManager avec attributs personnalisés
//$resourceManager = new ResourceManager();
//
//// Ajout des fichiers CSS avec attributs personnalisés
//$cssAttributes = ['integrity' => 'your-integrity-value', 'crossorigin' => 'anonymous'];
//$resourceManager->addCss('chemin/vers/style1.css', 'screen', $cssAttributes);
//
//// Ajout des fichiers JS avec attributs personnalisés
//$jsAttributes = ['integrity' => 'your-integrity-value', 'crossorigin' => 'anonymous'];
//$resourceManager->addJs('chemin/vers/script1.js', true, false, $jsAttributes);