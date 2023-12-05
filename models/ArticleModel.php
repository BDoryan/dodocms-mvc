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

    public function hydrateImages($data)
    {
        if (isset($data["images"])) {
            foreach ($this->images as $image) {
                if (in_array($image->getId(), explode(',', $data["images"])))
                    continue;
                $this->removeImage($image->getId());
            }
            foreach (explode(',', $data["images"]) as $image) {
                if(empty($image))
                    continue;
                $image = intval($image);
                if (Tools::containsItem($this->images, "getId", $image))
                    continue;
                $media = new ResourceModel();
                $media->id($image)->fetch();
                $this->addImage($image);
            }
            $this->fetch();
        }
    }

    public function hydrate(array $data): void
    {

        $data = Validator::sanitize(["title", "subtitle", "content", "images"], $data);
        if(isset($data["images"])){
            if(Tools::startsWith($data["images"], ','))
                $data["images"] = substr($data["images"], 1);
        }
        $this->hydrateImages($data);
        unset($data["images"]);

//        echo "<pre>";
//        var_dump($this);
//        exit;

        parent::hydrate($data);
    }

    public function create(): bool
    {
        if (!parent::create()) return false;

        return true;
    }

    public function update(): bool
    {
        if (!parent::update()) return false;

        return true;
    }


    public function fetch(): ?ArticleModel
    {
        if (!parent::fetch()) return null;

        $database = Application::get()->getDatabase();
        $results = $database->fetchAll("SELECT Resources.id, src, alternativeText FROM ArticlesHasImages, Resources WHERE ArticlesHasImages.image_id = Resources.id AND article_id = ?", [$this->id]);

        if (is_bool($results)) return null;
        $this->images = array_map(function ($result) {
            $image = new ResourceModel();
            $image->hydrate($result);
            return $image;
        }, $results);

//        echo "<pre>";
//        var_dump($this->images);
//        exit;

        return $this;
    }

    public function clearImages(): void
    {
        $database = Application::get()->getDatabase();
        $database->delete("ArticlesHasImages", ["article_id" => $this->id]);
        $images = $this->getImages();
        foreach ($images as $image) {
            if (!$image->hasId())
                continue;
            $image->deleteAll();
        }
    }

    public function removeImage($id) {
        $database = Application::get()->getDatabase();
        $database->delete("ArticlesHasImages", ["article_id" => $this->id, "image_id" => $id]);
    }

    public function addImage($id) {
        $database = Application::get()->getDatabase();
        $database->insert("ArticlesHasImages", ["article_id" => $this->getId(), "image_id" => $id]);
    }

    /**
     * @return array
     */
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