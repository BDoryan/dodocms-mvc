<?php

Autoloader::require("core/classes/database/model/Model.php");

class BlockModel extends Model
{
    public const TABLE_NAME = "Blocks";

    protected string $name;
    protected string $path;

    public function __construct(string $name = "", string $path = "")
    {
        parent::__construct(self::TABLE_NAME);
        $this->name = $name;
        $this->path = $path;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setPath(string $path)
    {
        $this->path = $path;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getCustom(int $page_id)
    {
        $block = Application::get()->getDatabase()->find('PagesStructures', '*', ['block_id' => $this->id]);
        $json = $block['block_json'];
        if(empty($json))
            return null;
        return json_decode($json, true);
    }

    public function getView(): ?string
    {
        $path = Application::get()->getTheme()->toRoot("/blocks/" . $this->getPath());
        if (!Tools::endsWith($path, ".php"))
            $path .= ".php";

        if (file_exists($path))
            return $path;
        return null;
    }

    public function getFields(): array
    {
        $fields = parent::getFields();
        $fields['name'] = [
            'size' => 'dodocms-w-full',
            "field" => Text::create()->name("name")->label(__('admin.panel.blocks.fields.label.name'))->value($this->name)
        ];
        $fields['path'] = [
            'size' => 'dodocms-w-full',
            "field" => Text::create()->name("path")->label(__('admin.panel.blocks.fields.label.path'))->value($this->path)
        ];
        return $fields;
    }

    public static function findAll(string $columns, array $conditions = [], $orderBy = ''): ?array
    {
        return (new BlockModel())->getAll($columns, $conditions, $orderBy);
    }
}

Table::$models[BlockModel::TABLE_NAME] = BlockModel::class;