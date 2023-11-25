<?php

Autoloader::require('core/classes/Cache.php');

class Internationalization
{

    const DEFAULT_LANGUAGE = "en";

    private string $language;
    private string $root;
    private array $translations;

    public function __construct(string $language, $root = '/core/translations/')
    {
        $this->language = $language;
        $this->translations = [];

        $this->setRoot($root);
        $this->loadTranslations();
    }

    public function loadTranslations(): void
    {
        $path = Application::get()->toRoot($this->root . '/' . $this->language . '.json');
        if (!file_exists($path)) throw new Exception("Language file not found: " . $path);
        $file = file_get_contents($path);
        $this->translations = json_decode($file, true);
    }

    public function addTranslation(string $key, string $value): void
    {
        $this->translations[$key] = $value;
    }

    public function fetch(string $key): string
    {
        if (isset($this->translations[$key]))
            return $this->translations[$key];

        if($this->language == self::DEFAULT_LANGUAGE)
            return $key;

        if (Cache::get("DEFAULT_TRANSLATION") == null)
            Cache::set("DEFAULT_TRANSLATION", new Internationalization(self::DEFAULT_LANGUAGE), $this->root);

        return Cache::get("DEFAULT_TRANSLATION")->fetch($key) ?? $key;
    }

    public function translate(string $key, array $options = []): string
    {
        $translation = $this->fetch($key);
        foreach ($options as $key => $value)
            $translation = str_replace("{" . $key . "}", $value, $translation);

        return $translation;
    }

    public function setRoot(string $root): void
    {
        $this->root = Tools::toURI($root);
    }

    public function getRoot(): string
    {
        return $this->root;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function getTranslations(): array
    {
        return $this->translations;
    }
}