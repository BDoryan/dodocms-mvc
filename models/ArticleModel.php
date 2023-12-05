<?php

Autoloader::require("core/classes/database/model/Model.php");
Autoloader::require("models/ImageModel.php");

class ArticleModel extends Model
{

    public const TABLE_NAME = "Articles";

    protected string $title;
    protected string $subtitle;
    protected string $content;

    /**
     * Définir cette variable en 'private' permet de ne pas de faire une hydration de cette variable mais aussi de ne pas l'envoyer lors de l'update
     * car celle-ci n'est pas un attribut en elle-même.
     *
     * @var array
     */
    private array $images = [];

    /**
     * @param string $title
     * @param string $subtitle
     * @param string $content
     */
    public function __construct(string $title = "", string $subtitle = "", string $content = "")
    {
        parent::__construct(self::TABLE_NAME);

        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->content = $content;
    }

    public function hydrateImages($images)
    {
        if(empty($images)) return;
        $this->images = [];

        $imagesList = explode(',', $images);
        foreach ($imagesList as $image) {
            if (empty($image))
                continue;

            $image = intval($image);
            if (Tools::containsItems($this->images, "getId", $image))
                continue;

            $media = new ResourceModel();
            $media->id($image)->fetch();
            $this->images[] = $media;
        }
    }

    public function hydrate(array $data): void
    {
        $data = Validator::sanitize(["title", "subtitle", "content", "images"], $data);
        if (isset($data["images"])) {
            if (Tools::startsWith($data["images"], ','))
                $data["images"] = substr($data["images"], 1);
        }

        if(isset($data["images"])) {
            // Hydrate images
            $this->hydrateImages($data['images']);

            // Remove images from the data for the parent hydration
            unset($data["images"]);
        }

        parent::hydrate($data);
    }

    public function create(): bool
    {
        if (!parent::create()) return false;

        foreach ($this->images as $image) {
            $this->associateImage($image->getId());
        }

        return true;
    }

    public function updateImages() {
        $images = $this->selectImages();

        foreach ($images as $image) {
            if (Tools::containsItems($this->images, "getId", $image->getId()))
                continue;
            $this->dissociateImage($image->getId());
        }
        foreach ($this->images as $image) {
            if(empty($image))
                continue;
            if (Tools::containsItems($images, "getId", $image->getId()))
                continue;
            $this->associateImage($image->getId());
        }
    }

    public function delete(): bool
    {
        $this->dissociateImages();

        return parent::delete();
    }


    public function update(): bool
    {
        if (!parent::update()) return false;

        $this->updateImages();

        return true;
    }

    public function selectImages(): ?array
    {
        $database = Application::get()->getDatabase();
        $results = $database->fetchAll("SELECT Resources.id, src, alternativeText FROM ArticlesHasImages, Resources WHERE ArticlesHasImages.image_id = Resources.id AND article_id = ?", [$this->id]);

        if (is_bool($results)) return null;
        return array_map(function ($result) {
            $image = new ResourceModel();
            $image->hydrate($result);
            return $image;
        }, $results);
    }

    public function fetchImages()
    {
        $this->images = $this->selectImages();
    }

    public function fetch(): ?ArticleModel
    {
        if (!parent::fetch()) return null;

        $this->fetchImages();

        return $this;
    }

    public function dissociateImages() {
        $database = Application::get()->getDatabase();
        $database->delete("ArticlesHasImages", ["article_id" => $this->id]);
    }

    public function dissociateImage($id)
    {
        $database = Application::get()->getDatabase();
        $database->delete("ArticlesHasImages", ["article_id" => $this->id, "image_id" => $id]);
    }

    public function associateImage($id)
    {
        $database = Application::get()->getDatabase();
        $database->insert("ArticlesHasImages", ["article_id" => $this->getId(), "image_id" => $id]);
    }

    public function getImages(): array
    {
        return $this->images;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getSubtitle(): string
    {
        return $this->subtitle;
    }

    public function setSubtitle(string $subtitle): void
    {
        $this->subtitle = $subtitle;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getFields(): array
    {
        $fields = parent::getFields();
        $fields["title"] = [
            "size" => "w-6/12",
            "field" => Text::create()->name("title")->label("Titre de l'article")->value($this->getTitle() ?? "")->required(),
        ];
        $fields["subtitle"] = [
            "size" => "w-6/12",
            "field" => Text::create()->name("subtitle")->label("Sous-titre de l'article")->value($this->getSubtitle() ?? "")->required(),
        ];
        $fields["content"] = [
            "size" => "w-full",
            "field" => CKEditor::create()->name("content")->label("Contenu de l'article")->value($this->getContent() ?? "")->required(),
        ];
        $fields["images"] = [
            "size" => "w-full",
            "field" => ResourceSelector::create()->multiple()->name("images")->label("Liste des images")->resources($this->getImages() ?? [])->required(),
        ];
        return $fields;
    }

    public static function findAll(string $columns = '*', array $conditions = [], $orderBy = ''): ?array
    {
        return (new ArticleModel())->getAll($columns, $conditions, $orderBy);
    }
}

Table::$models[ArticleModel::TABLE_NAME] = ArticleModel::class;