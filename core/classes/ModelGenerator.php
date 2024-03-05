<?php

class ModelGenerator
{

    public function __construct(string $tableName, array $attributes)
    {
        $filtered = array_filter($attributes, function ($value) {
            return $value !== 'id' && $value !== 'createdAt' && $value !== 'updatedAt' && $value != 'language' && $value != 'active';
        });
        $attributes = [...$filtered];

        {
            $className = ucwords($tableName) . 'Model';
            $fileName = Application::get()->toRoot('/models/' . $className . '.php');

            $classContent = "<?php\n\n";
            $classContent .= "Autoloader::require(\"core/classes/database/model/Model.php\");\n\n";
            $classContent .= "class $className extends Model\n{\n";
            $classContent .= "    public const TABLE_NAME = \"$tableName\";\n\n";

            foreach ($attributes as $value) {
                $classContent .= "    protected $" . $value . ";\n";
            }

            $classContent .= "    public function __construct(";
            foreach ($attributes as $index => $value) {
                $classContent .= '$' . $value .' = null';
                if ($index !== count($attributes) - 1) {
                    $classContent .= ', ';
                }
            }
            $classContent .= ")\n";
            $classContent .= "    {\n
        parent::__construct(self::TABLE_NAME);\n";
            foreach ($attributes as $value) {
                $classContent .= "        \$this->$value = $" . $value . ";\n";
            }
            $classContent .= "    }\n\n";

            foreach ($attributes as $value) {
                $propertyName = str_replace(' ', '', ucwords(str_replace('_', ' ', $value)));
                $setterName = 'set' . $propertyName;
                $getterName = 'get' . $propertyName;

                $classContent .= "    public function $setterName($" . $value . ")\n";
                $classContent .= "    {\n";
                $classContent .= "        \$this->$value = $" . $value . ";\n";
                $classContent .= "    }\n\n";
                $classContent .= "    public function $getterName()\n";
                $classContent .= "    {\n";
                $classContent .= "        return \$this->$value;\n";
                $classContent .= "    }\n";
            }
            $classContent .= "
    public static function findAll(string ".'$columns'.", array ".' $conditions'." = [], ".'$orderBy'." = ''): ?array
    {\n
        return (new ".$className."())->getAll(".'$columns'.", ".'$conditions'.", ".'$orderBy'.");\n
    }\n\n";

            $classContent .= "      /** Warning: if you want create or edit entries you need to create the form with a override of getFields(); */\n\n";

            $classContent .= "}\n\n";
            $classContent .= 'Table::registerModel(' . $className . '::TABLE_NAME,  ' . $className . '::class, Model::MODEL_TYPE_CUSTOM);';

            $dir = dirname($fileName);
            if (!file_exists($dir))
                mkdir($dir, 0770, true);

            file_put_contents($fileName, $classContent);
            chmod($fileName, 0660);
        }
    }
}