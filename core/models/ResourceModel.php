<?php

class ResourceModel extends Model implements JsonSerializable
{

    /**
     * TODO: Il y a un très gros problème avec les chemins src de resource model, ce n'est pas normal de devoir 'bricoler' pour trouver la bonne route grâce aux 'root'
     */

    public const TABLE_NAME = "Resources";

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

    public function getMimeType(): string
    {
        if (!file_exists($this->getPath()))
            return "application/octet-stream";

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $this->getPath());
        finfo_close($finfo);
        return $mime_type;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDefaultSrc(): string
    {
        return $this->src;
    }

    public function deleteModel(): bool
    {
        return parent::delete();
    }

    public function deleteAll(): bool
    {
        return $this->deleteModel() && $this->deleteFile();
    }

    public function deleteFile(): bool
    {
        if (file_exists($this->getPath()))
            return unlink($this->getPath());
        return true;
    }

    public function getPath(): string
    {
        return Application::get()->toRoot($this->src);
    }

    public function getURL(): string
    {
        return Application::get()->toURL($this->src);
    }

    public function getSrc(): string
    {
        if (!file_exists($this->getPath()))
            return Application::get()->toURL("/core/assets/imgs/applications/404.jpg");

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $this->getPath());
        finfo_close($finfo);
        $extension = explode("/", $mime_type)[1];

        if (Tools::startsWith($mime_type, "image/")) {
            $src = $this->getURL();
        } else {
            // Warning: here if extension image doesn't exist return a invalid image
            $src = Application::get()->toURL("/core/assets/imgs/applications/$extension.jpg");
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
            "size" => "tw-w-4/12",
            "field" => Text::create()->name("name")->label("Nom de l'image")->value($this->getName() ?? "")->required(),
        ];
        $fields["src"] = [
            "size" => "tw-w-4/12",
            "field" => Text::create()->name("src")->label("Chemin de l'image")->value($this->getDefaultSrc() ?? "")->required(),
        ];
        $fields["alternativeText"] = [
            "size" => "tw-w-4/12",
            "field" => Text::create()->name("alternativeText")->label("Texte alternatif de l'image")->value($this->getAlternativeText() ?? "")->required(),
        ];
        return $fields;
    }

    public static function findAll(string $columns = '*', array $conditions = [], $orderBy = ''): ?array
    {
        return (new ResourceModel())->getAll($columns, $conditions, $orderBy);
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}

Table::registerModel(ResourceModel::TABLE_NAME, ResourceModel::class);