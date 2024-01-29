<?php

Autoloader::require("core/classes/database/model/Model.php");

class PageModel extends ModelAssociated
{
    public const TABLE_NAME = "Page";

    protected string $name;
    protected string $seo_title;
    protected string $seo_description;
    protected string $seo_keywords;
    protected string $slug;
    protected array $blocks;

//    protected ?ResourceModel $favicon;

    /**
     * @param string $name
     * @param string $seo_title
     * @param string $seo_description
     * @param ?int $favicon
     */
    public function __construct(string $name = "", string $seo_title = "", string $seo_description = "", string $seo_keywords = "", string $slug = "", array $blocks = [], ?ResourceModel $favicon = null)
    {
        parent::__construct(self::TABLE_NAME);
        $this->name = $name;
        $this->seo_title = $seo_title;
        $this->seo_description = $seo_description;
        $this->seo_keywords = $seo_keywords;
        $this->slug = $slug;
        $this->blocks = $blocks;
//        $this->favicon = $favicon;
    }

    public function getBlocks(): array
    {
        return $this->blocks;
    }

    public function setBlocks(array $blocks): void
    {
        $this->blocks = $blocks;
    }

    public function getSeoKeywords(): string
    {
        return $this->seo_keywords;
    }

    public function setSeoKeywords(string $seo_keywords): void
    {
        $this->seo_keywords = $seo_keywords;
    }

    public function getSeoKeywordsList(): ?array
    {
        return explode(",", $this->seo_keywords);
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getSeoTitle(): string
    {
        return $this->seo_title;
    }

    public function setSeoTitle(string $seo_title): void
    {
        $this->seo_title = $seo_title;
    }

    public function getSeoDescription(): string
    {
        return $this->seo_description;
    }

    public function getPageStructures(): ?array
    {
        return PageStructureModel::findAll("*", ["page_id" => $this->id], 'page_order ASC');
    }

    public function setSeoDescription(string $seo_description): void
    {
        $this->seo_description = $seo_description;
    }

//    public function getFavicon(): ?int
//    {
//        return $this->favicon->getId();
//    }
//
//    public function getFaviconResourceId(): ?ResourceModel
//    {
//        return $this->favicon ?? null;
//    }
//
//    public function setFaviconResourceModel(?ResourceModel $favicon): void
//    {
//        $this->favicon = $favicon;
//    }
//
//    /**
//     * @throws Exception
//     */
//    public function setFavicon($resource_id): void
//    {
//        if(empty($resource_id)){
//            $this->favicon = null;
//            return;
//        }
//
//        $resourceModel = Model::getModelByTableName(ResourceModel::TABLE_NAME);
//        $resourceModel->id($resource_id);
//        if($resourceModel->fetch() !== null) {
//            $this->favicon = $resourceModel;
//            return;
//        }
//        throw new Exception("Resource not found : $resource_id");
//    }

    public function getFields(): array
    {
        $fields = parent::getFields();
        $fields["name"] = [
            "size" => "dodocms-w-full",
            "field" => Text::create()->name("name")->label(__('admin.panel.pages.fields.label.name'))->value($this->name)
        ];
        $fields["seo_title"] = [
            "size" => "dodocms-w-full",
            "field" => Text::create()->name("seo_title")->label(__('admin.panel.pages.fields.label.seo_title'))->value($this->seo_title)
        ];
        $fields["seo_description"] = [
            "size" => "dodocms-w-full",
            "field" => Text::create()->name("seo_description")->label(__('admin.panel.pages.fields.label.seo_description'))->value($this->seo_description)
        ];
        $fields["seo_keywords"] = [
            "size" => "dodocms-w-full",
            "field" => Text::create()->name("seo_keywords")->label(__('admin.panel.pages.fields.label.seo_keywords'))->value($this->seo_keywords)
        ];
        $fields["slug"] = [
            "size" => "dodocms-w-full",
            "field" => Text::create()->name("slug")->label(__('admin.panel.pages.fields.label.slug'))->value($this->slug)
        ];
//        $fields["favicon"] = [
//            "size" => "dodocms-w-full",
//            "field" => ResourceSelector::create()->name("favicon")->label(__('admin.panel.pages.fields.label.favicon'))->resources(isset($this->favicon) ? [$this->favicon] : [])
//        ];
        return $fields;
    }

    public static function findAll(string $columns, array $conditions = [], $orderBy = ''): ?array
    {
        return (new PageModel())->getAll($columns, $conditions, $orderBy);
    }

    public function associates(): ?array
    {
        return [
            "blocks" => new ModelAssociation(
                BlockModel::TABLE_NAME,
                "PagesStructures",
                "page_id",
                "block_id",
            )
        ];
    }
}

Table::$models[PageModel::TABLE_NAME] = PageModel::class;