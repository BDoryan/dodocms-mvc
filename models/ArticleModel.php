<?php

Autoloader::require("models/ImageModel.php");

class ArticleModel extends ModelAssociated
{

    public const TABLE_NAME = "Articles";

    protected string $title;
    protected string $subtitle;
    protected string $content;

    protected array $images = [];

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

    public function associates(): ?array
    {
        return [
            "images" => new ModelAssociation(
                ResourceModel::TABLE_NAME,
                "ArticlesHasImages",
                "article_id",
                "image_id"
            )
        ];
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