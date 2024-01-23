<form data-type="attribute" id="attribute-form"
      class="dodocms-bg-gray-800 dodocms-shadow-lg dodocms-rounded-xl dodocms-flex dodocms-flex-row dodocms-flex-wrap dodocms-p-5 dodocms-p-2 dodocms-relative">
    <div class="dodocms-absolute dodocms-top-0 dodocms-right-0 transform translate-x-1/2 -translate-y-1/2">
        <button type="button" id="remove-attribute"
                class="dodocms-h-10 dodocms-w-10 dodocms-bg-red-700 hover:dodocms-bg-red-800 hover:dodocms-border hover:dodocms-border-red-700 dodocms-text-xl dodocms-rounded-full dodocms-flex dodocms-items-center dodocms-justify-center dodocms-text-white">
            <i class="fa-solid fa-trash"></i>
        </button>
    </div>
    <div class="dodocms-flex dodocms-flex-wrap dodocms-gap-y-3 -dodocms-mx-2 dodocms-w-full">
        <div class="dodocms-w-4/12 dodocms-px-2">
            <?php

            Text::create()
                ->label(__('admin.panel.tables.table.attribute.name'))
                ->readonly(!empty($table_name))
                ->value(!empty($attribute) ? $attribute->getName() : "")
                ->validator(true)
                ->required(true)
                ->name("attribute_name")
                ->placeholder("name")
                ->render(); ?>
        </div>
        <div class="dodocms-w-4/12 dodocms-px-2">
            <?php Select::create()
                ->placeholder(__('admin.panel.tables.table.attribute.type_attribut'))
                ->selected(!empty($attribute) ? $attribute->getType() : "VARCHAR")
                ->label(__('admin.panel.tables.table.attribute.type_attribut'))
                ->name("attribute_type")
                ->required(true)
                ->options(Select::toCombine(TableAttribute::TYPES, function ($type) { return $type; } ))
                ->render() ?>
        </div>
        <div class="dodocms-w-4/12 dodocms-px-2">
            <?php Text::create()
                ->label(__('admin.panel.tables.table.attribute.length'))
                ->type("number")
                ->value(!empty($attribute) ? $attribute->getLength() . "attribute.php" : "")
                ->validator(true)
                ->name("attribute_length")
                ->placeholder("255")
                ->render(); ?>
        </div>
        <div class="dodocms-w-6/12 dodocms-px-2">
            <?php CheckBox::create()
                ->label(__('admin.panel.tables.table.attribute.allow_undefined_values'))
                ->checked(!empty($attribute) ? $attribute->isNullable() : false)
                ->name("attribute_nullable")
                ->placeholder("Activer les valeurs non définies")
                ->render() ?>
        </div>
        <div class="dodocms-w-6/12 dodocms-px-2">
            <?php CheckBox::create()
                ->label(__('admin.panel.tables.table.attribute.is_this_attribute_a_primary_key'))
                ->readonly(!empty($table_name) && !empty($table))
                ->checked(!empty($attribute) ? $attribute->isPrimaryKey() : false)
                ->name("attribute_primary_key")
                ->placeholder("Utiliser en tant que clé primaire")
                ->render() ?>
        </div>
        <div class="dodocms-w-6/12 dodocms-px-2">
            <?php CheckBox::create()
                ->label(__('admin.panel.tables.table.attribute.do_you_want_to_use_auto_increment'))
                ->readonly(!empty($attribute) && !$attribute->isPrimaryKey())
                ->checked(!empty($attribute) ? $attribute->isAutoIncrement() : false)
                ->name("attribute_auto_increment")
                ->placeholder("Activer l'auto-incrémentation")
                ->render() ?>
        </div>
        <div class="dodocms-w-6/12 dodocms-px-2">
            <?php Text::create()
                ->label(__('admin.panel.tables.table.attribute.default_value'))
                ->type("text")
                ->value(!empty($attribute) ? $attribute->getDefaultValue() : "")
                ->validator(true)
                ->name("attribute_default_value")
                ->placeholder("CURRENT_TIMESTAMP")
                ->render(); ?>
        </div>
        <div class="dodocms-w-full dodocms-px-2">
            <?php Select::create()
                ->placeholder(__('admin.panel.tables.table.attribute.select_a_table'))
                ->disabled(!empty($table_name) && !empty($table) && !empty($attribute->getAssociation()))
                ->undefinable(true)
                ->selected(!empty($attribute) ? $attribute->getAssociation() : "")
                ->label(__('admin.panel.tables.table.attribute.choose_an_association_to_another_table'))
                ->name("attribute_association")
                ->required(true)
                ->options(Select::toCombine(Table::listTablesName(), function ($option) { return $option."(id)"; }))
                ->render() ?>
        </div>
    </div>
</form>
