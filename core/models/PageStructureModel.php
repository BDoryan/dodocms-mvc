<?php

Autoloader::require("core/classes/database/model/Model.php");

class PageStructureModel extends Model
{
    public const TABLE_NAME = "PagesStructures";

    protected ?int $page_order;
    protected string $block_json;
    protected ?int $page_id;
    protected ?int $block_id;

    /**
     * @param int $page_order
     * @param string $block_json
     * @param ?int $page_id
     * @param ?int $block_id
     */
    public function __construct(int $page_order = null, string $block_json = "", ?int $page_id = null, ?int $block_id = null)
    {
        parent::__construct(self::TABLE_NAME);
        $this->page_order = $page_order;
        $this->block_json = $block_json;
        $this->page_id = $page_id;
        $this->block_id = $block_id;
    }

    public function getPageOrder(): int
    {
        return $this->page_order;
    }

    public function setPageOrder(?int $page_order): void
    {
        $this->page_order = $page_order;
    }

    public function getCustom()
    {
        if (empty($this->block_json))
            return null;
        return json_decode($this->block_json, true);
    }

    public function getBlockJson(): string
    {
        return $this->block_json;
    }

    public function setBlockJson(string $block_json): void
    {
        $this->block_json = $block_json;
    }

    public function getPageId(): ?int
    {
        return $this->page_id;
    }

    public function setPageId(?int $page_id): void
    {
        $this->page_id = $page_id;
    }

    public function getBlockId(): ?int
    {
        return $this->block_id;
    }

    public function setBlockId(?int $block_id): void
    {
        $this->block_id = $block_id;
    }

    /**
     * @throws Exception
     */
    public function getPage(): PageModel
    {
        $page = new PageModel();
        $page->id($this->page_id);
        $page->fetch();

        return $page;
    }

    /**
     * @throws Exception
     */
    public function getBlock(): BlockModel
    {
        $page = new BlockModel();
        $page->id($this->block_id);
        $page->fetch();

        return $page;
    }

    public static function findAll(string $columns, array $conditions = [], $orderBy = ''): ?array
    {
        return (new PageStructureModel())->getAll($columns, $conditions, $orderBy);
    }
}

Table::registerModel(BlockModel::TABLE_NAME, BlockModel::class);