<?php

Autoloader::require("core/classes/database/model/Model.php");

class ArticlesModel extends ModelAssociated
{
    public const TABLE_NAME = "Articles";

    protected string $title;
    protected string $subtitle;
    protected ?int $illustration;
    protected array $images;

    public function __construct(string $title = "", $subtitle = "", ?int $illustration = null)
    {

        parent::__construct(self::TABLE_NAME);
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->illustration = $illustration;
    }

    public function getImages(): array
    {
        return $this->images;
    }

    public function setImages(array $images): void
    {
        $this->images = $images;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
    }

    public function getSubtitle(): string
    {
        return $this->subtitle;
    }

    public function getIllustrationResource(): ?ResourceModel
    {
        $find = ResourceModel::findAll('*', ["id" => $this->illustration]);
        return !empty($find) ? $find[0] : null;
    }

    public function setIllustration($illustration)
    {
        if (empty($illustration)) {
            $this->illustration = null;
        } else if (is_numeric($illustration)) {
//            var_dump($illustration);
            $this->illustration = $illustration;
        }
    }

    public function getIllustration(): ?int
    {
        return $this->illustration;
    }

    public function getFields(): array
    {
        $fields = parent::getFields();
        $fields['title'] = [
            'size' => 'dodocms-w-1/2',
            "field" => Text::create()->name("title")->label(__('admin.panel.articles.fields.label.title'))->value($this->title)
        ];
        $fields['subtitle'] = [
            'size' => 'dodocms-w-1/2',
            "field" => Text::create()->name("subtitle")->label(__('admin.panel.articles.fields.label.path'))->value($this->subtitle)
        ];
        $fields['illustration'] = [
            'size' => 'dodocms-w-full',
            "field" => ResourceViewer::create()->name("illustration")->label(__('admin.panel.articles.fields.label.illustration'))->resources($this->getIllustrationResource() !== null ? [$this->getIllustrationResource()] : [])
        ];
        $fields['images'] = [
            'size' => 'dodocms-w-full',
            "field" => ResourceViewer::create()->multiple()->name("images")->label(__('admin.panel.articles.fields.label.images'))->resources($this->getImages())
        ];
        return $fields;
    }

    public static function findAll(string $columns, array $conditions = [], $orderBy = ''): ?array
    {
        return (new ArticlesModel())->getAll($columns, $conditions, $orderBy);
    }

    public function associates(): ?array
    {
        return [
            "images" => new ModelAssociation(
                ResourceModel::TABLE_NAME,
                ArticlesHasImagesModel::TABLE_NAME,
                "resource_id",
                "article_id"
            )
        ];
    }
}

Table::$models[ArticlesModel::TABLE_NAME] = ArticlesModel::class;