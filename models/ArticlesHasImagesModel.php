<?php

Autoloader::require("core/classes/database/model/Model.php");

class ArticlesHasImagesModel extends Model
{
    public const TABLE_NAME = "ArticlesHasImages";

    protected $article_id;
    protected $resource_id;
    public function __construct($article_id, $resource_id)
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

    public static function findAll(string $columns, array  $conditions = [], $orderBy = ''): ?array 
{

        return (new ArticlesHasImagesModel())->getAll($columns, $conditions, $orderBy);

        }

/** Warning: if you want create or edit entries you need to create the form with a override of getFields(); */

}

Table::$models[ArticlesHasImagesModel::TABLE_NAME] = ArticlesHasImagesModel::class;