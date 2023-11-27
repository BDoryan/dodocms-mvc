<?php

Autoloader::require("core/classes/database/model/Model.php");

class ImageModel extends Model
{

    public const TABLE_NAME = "Images";

    protected string $name;
    protected string $src;
    protected string $alternativeText;

    /**
     * @param string $name
     * @param string $src
     * @param string $alternativeText
     */
    public function __construct(string $name = "", string $src = "", string $alternativeText = "")
    {
        parent::__construct(self::TABLE_NAME);

        $this->name = $name;
        $this->src = $src;
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

    public function getSrc(): string
    {
        return $this->src;
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

Table::$models[ImageModel::TABLE_NAME] = ImageModel::class;