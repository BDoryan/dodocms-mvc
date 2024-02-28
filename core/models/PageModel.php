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

    protected ?int $favicon;

    /**
     * Page constructor.
     *
     * @param string $name the name of the page
     * @param string $seo_title the SEO title of the page
     * @param string $seo_description the SEO description of the page
     * @param string $seo_keywords the SEO keywords of the page
     * @param string $slug the slug of the page
     * @param array $blocks the blocks of the page
     * @param ResourceModel|null $favicon
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

    /**
     * Get the blocks of the page (structure of the page)
     *
     * @return array
     */
    public function getBlocks(): array
    {
        return $this->blocks;
    }

    /**
     * Set the blocks of the page (structure of the page)
     *
     * @param array $blocks
     * @return void
     */
    public function setBlocks(array $blocks): void
    {
        $this->blocks = $blocks;
    }

    /**
     * Return the SEO keywords of the page (meta keywords)
     *
     * @return string
     */
    public function getSeoKeywords(): string
    {
        return $this->seo_keywords;
    }

    /**
     * Set the SEO keywords of the page
     *
     * @param string $seo_keywords
     * @return void
     */
    public function setSeoKeywords(string $seo_keywords): void
    {
        $this->seo_keywords = $seo_keywords;
    }

    /**
     * Return the SEO keywords of the page (meta keywords) as an array (each keyword is separated by a comma
     *
     * @return array|null
     */
    public function getSeoKeywordsList(): ?array
    {
        return explode(" ", str_replace(',', '', $this->seo_keywords));
    }

    /**
     * Return the slug of the page (route of the page)
     *
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * Set the slug of the page (route of the page)
     *
     * @param string $slug
     * @return void
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * Return the name of the page
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the name of the page
     *
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Return the SEO title of the page (title of the page)
     *
     * @return string
     */
    public function getSeoTitle(): string
    {
        return $this->seo_title;
    }

    /**
     * Set the SEO title of the page (title of the page)
     *
     * @param string $seo_title
     * @return void
     */
    public function setSeoTitle(string $seo_title): void
    {
        $this->seo_title = $seo_title;
    }

    /**
     * Return the SEO description (meta description) of the page
     *
     * @return string
     */
    public function getSeoDescription(): string
    {
        return $this->seo_description;
    }

    /**
     * Get the page structure (blocks of the page)
     *
     * @return array|null
     */
    public function getPageStructures(): ?array
    {
        return PageStructureModel::findAll("*", ["page_id" => $this->id], 'page_order ASC');
    }

    /**
     * Set the SEO description (meta description) of the page
     *
     * @param string $seo_description
     * @return void
     */
    public function setSeoDescription(string $seo_description): void
    {
        $this->seo_description = $seo_description;
    }

    public function filteredAttributes(): array
    {
        $filtered =  parent::filteredAttributes();
        $filtered["favicon_resource"] = "";
        return $filtered;
    }


    /**
     * Set the favicon (resource) with id of the resource
     *
     * @param int|null $resource_id
     * @return void
     */
    public function setFavicon($resource_id): void
    {
        if(empty($resource_id)) {
            $this->favicon = null;
            return;
        }
        $this->favicon = $resource_id;
    }

    /**
     * Return the id of the favicon
     *
     * @return int|null
     */
    public function getFavicon(): ?int {
        return $this->favicon ?? null;
    }

    /**
     * Return the favicon (Resource)
     *
     * @return ResourceModel|null
     */
    public function getFaviconResource(): ?ResourceModel {
        if(empty($this->favicon))
            return null;
        return ResourceModel::findAll("*", ["id" => $this->favicon])[0];
    }

    public function getFields(): array
    {
        $fields = parent::getFields();
        $fields["name"] = [
            "size" => "tw-w-full",
            "field" => Text::create()->validator()->required()->name("name")->label(__('admin.panel.pages.fields.label.name'))->value($this->name)
        ];
        $fields["seo_title"] = [
            "size" => "tw-w-full",
            "field" => Text::create()->name("seo_title")->label(__('admin.panel.pages.fields.label.seo_title'))->value($this->seo_title)
        ];
        $fields["seo_description"] = [
            "size" => "tw-w-full",
            "field" => TextArea::create()->name("seo_description")->label(__('admin.panel.pages.fields.label.seo_description'))->value($this->seo_description)
        ];
        $fields["seo_keywords"] = [
            "size" => "tw-w-full",
            "field" => Text::create()->name("seo_keywords")->label(__('admin.panel.pages.fields.label.seo_keywords'))->value($this->seo_keywords)
        ];
        $fields['favicon'] = [
            'size' => 'tw-w-full',
            "field" => ResourceViewer::create()
                ->multiple(false)
                ->name("favicon")
                ->label(__('admin.panel.pages.fields.label.favicon'))
                ->resources(empty($this->getFaviconResource()) ? [] : [
                    $this->getFaviconResource()
                ])
        ];
        $fields["slug"] = [
            "size" => "tw-w-full",
            "field" => Text::create()->validator()->required()->name("slug")->label(__('admin.panel.pages.fields.label.slug'))->value($this->slug)
        ];
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

Table::registerModel(PageModel::TABLE_NAME, PageModel::class);