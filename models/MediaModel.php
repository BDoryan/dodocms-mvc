<?php

class MediaModel extends Model
{

    public const TABLE_NAME = "Medias";

    protected string $name;
    protected string $src;
    protected string $alternativeText;
    protected string $caption;

    /**
     * @param string $name
     * @param string $src
     * @param string $alternativeText
     * @param string $caption
     */
    public function __construct(string $name = "", string $src = "", string $alternativeText = "", string $caption = "")
    {
        parent::__construct(self::TABLE_NAME);

        $this->name = $name;
        $this->src = $src;
        $this->caption = $caption;
        $this->alternativeText = $alternativeText;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDefaultSrc()
    {
        return $this->src;
    }

    public function deleteModel(): bool
    {
        return parent::delete();
    }

    public function deleteAll()
    {
        return $this->deleteModel() && $this->deleteFile();
    }

    public function deleteFile(): bool
    {

        if (file_exists($this->src))
            return unlink($this->src);
        return true;
    }

    public function getSrc(): string
    {
        if (!file_exists($this->src))
            return Application::toAsset("/admin/assets/imgs/applications/404.jpg");

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $this->src);
        finfo_close($finfo);
        $extension = explode("/", $mime_type)[1];


        if (Tools::startsWith($mime_type, "image/")) {
            $src = Application::toAsset($this->src);
        } else {
            // Warning: here if extension image doesn't exist return a invalid image
            $src = Application::toAsset("/admin/assets/imgs/applications/$extension.jpg");
        }

        return $src;
    }

    /**
     * @param string $caption
     */
    public function setCaption(string $caption): void
    {
        $this->caption = $caption;
    }

    /**
     * @return string
     */
    public function getCaption(): string
    {
        return $this->caption;
    }

    public function setSrc(string $src): void
    {
        $this->src = $src;
    }

    public function getAlternativeText(): string
    {
        return $this->alternativeText;
    }

    public function setAlternativeText(string $alternativeText): void
    {
        $this->alternativeText = $alternativeText;
    }

    public function getFields(): array
    {
        $fields = parent::getFields();
        $fields["name"] = [
            "size" => "w-4/12",
            "field" => Text::create()->name("name")->label("Nom de l'image")->value($this->getName() ?? "")->required(),
        ];
        $fields["src"] = [
            "size" => "w-4/12",
            "field" => Text::create()->name("src")->label("Chemin de l'image")->value($this->getSrc() ?? "")->required(),
        ];
        $fields["alternativeText"] = [
            "size" => "w-4/12",
            "field" => Text::create()->name("alternativeText")->label("Texte alternatif de l'image")->value($this->getAlternativeText() ?? "")->required(),
        ];
        return $fields;
    }
}

Table::$models[MediaModel::TABLE_NAME] = MediaModel::class;