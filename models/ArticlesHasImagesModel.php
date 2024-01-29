<?php

Autoloader::require("core/classes/database/model/Model.php");

class ArticlesHasImagesModel extends Model
{
    public const TABLE_NAME = "ArticlesHasImages";

    protected int $article_id;
    protected int $resource_id;

    public function __construct($article_id = 0, $resource_id = 0)
    {

        parent::__construct(self::TABLE_NAME);
        $this->article_id = $article_id;
        $this->resource_id = $resource_id;
    }

    public function setArticleId($article_id)
    {
        $this->article_id = $article_id;
    }

    public function getArticleId()
    {
        return $this->article_id;
    }

    public function setResourceId($resource_id)
    {
        $this->resource_id = $resource_id;
    }

    public function getResourceId()
    {
        return $this->resource_id;
    }

    public static function findAll(string $columns, array $conditions = [], $orderBy = ''): ?array
    {
        return (new ArticlesHasImagesModel())->getAll($columns, $conditions, $orderBy);
    }
}

Table::$models[ArticlesHasImagesModel::TABLE_NAME] = ArticlesHasImagesModel::class;