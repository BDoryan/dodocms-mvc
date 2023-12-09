<?php

class ModelGenerator
{

    public function __construct(string $tableName, array $attributes)
    {
        $filtered = array_filter($attributes, function ($value) {
            return $value !== 'id' && $value !== 'createdAt' && $value !== 'updatedAt' && $value != 'language';
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
                $classContent .= '$' . $value;
                if ($index !== count($attributes) - 1) {
                    $classContent .= ', ';
                }
            }
            $classContent .= ")\n";
            $classContent .= "    {\n";
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
                $classContent .= "    }\n\n";
            }
            $classContent .= "    public static function findAll(string ".'$columns'.", array ".'r $conditions'." = [], ".'$orderBy'." = ''): ?array \n{\n
        return (new ".$className."())->getAll(".'$columns'.", ".'$conditions'.", ".'$orderBy'.");\n
        }\n\n";

            $classContent .= "/** Warning: if you want create or edit entries you need to create the form with a override of getFields(); */\n\n";

            $classContent .= "}\n\n";
            $classContent .= 'Table::$models[' . $className . '::TABLE_NAME] = ' . $className . '::class;';

            file_put_contents($fileName, $classContent);
        }
    }
}