<form data-type="attribute" id="attribute-form"
      class="tw-border-[1px] tw-border-gray-700 tw-border-opacity-20 tw-text-gray-600 tw-bg-white tw-bg-opacity-50 tw-shadow-lg tw-rounded-lg tw-flex tw-flex-row tw-flex-wrap tw-p-5 tw-p-2 tw-relative">
    <div class="tw-absolute tw-top-0 tw-right-0 transform translate-x-1/2 -translate-y-1/2">
        <button type="button" id="remove-attribute"
                class="tw-h-10 tw-w-10 tw-bg-red-700 hover:tw-bg-red-800 hover:tw-border hover:tw-border-red-700 tw-text-xl tw-rounded-full tw-flex tw-items-center tw-justify-center tw-text-white">
            <i class="fa-solid fa-trash"></i>
        </button>
    </div>
    <div class="tw-flex tw-flex-wrap tw-gap-y-3 -tw-mx-2 tw-w-full">
        <div class="tw-w-4/12 tw-px-2">
            <?php
            Text::create()
                ->label(__('admin.panel.tables.table.attribute.name'))
                ->readonly(!empty($table_name))
                ->value(!empty($attribute) ? $attribute->getName() : "")
                ->validator(true)
                ->required(true)
                ->name("attribute_name")
                ->placeholder("name")
                ->render();
            ?>
        </div>
        <div class="tw-w-4/12 tw-px-2">
            <?php Select::create()
                ->placeholder(__('admin.panel.tables.table.attribute.type_attribut'))
                ->selected(!empty($attribute) ? $attribute->getType() : "VARCHAR")
                ->label(__('admin.panel.tables.table.attribute.type_attribut'))
                ->name("attribute_type")
                ->required(true)
                ->options(Select::toCombine(TableAttribute::TYPES, function ($type) {
                    return $type;
                }))
                ->render() ?>
        </div>
        <div class="tw-w-4/12 tw-px-2">
            <?php Text::create()
                ->label(__('admin.panel.tables.table.attribute.length'))
                ->type("number")
                ->value(!empty($attribute) ? $attribute->getLength()."" : "")
                ->validator(true)
                ->name("attribute_length")
                ->placeholder("255")
                ->render(); ?>
        </div>
        <div class="tw-w-6/12 tw-px-2">
            <?php CheckBox::create()
                ->label(__('admin.panel.tables.table.attribute.allow_undefined_values'))
                ->checked(!empty($attribute) ? $attribute->isNullable() : false)
                ->name("attribute_nullable")
                ->placeholder("Activer les valeurs non définies")
                ->render() ?>
        </div>
        <div class="tw-w-6/12 tw-px-2">
            <?php CheckBox::create()
                ->label(__('admin.panel.tables.table.attribute.is_this_attribute_a_primary_key'))
                ->readonly(!empty($table_name) && !empty($table))
                ->checked(!empty($attribute) ? $attribute->isPrimaryKey() : false)
                ->name("attribute_primary_key")
                ->placeholder("Utiliser en tant que clé primaire")
                ->render() ?>
        </div>
        <div class="tw-w-6/12 tw-px-2">
            <?php CheckBox::create()
                ->label(__('admin.panel.tables.table.attribute.do_you_want_to_use_auto_increment'))
                ->readonly(!empty($attribute) && !$attribute->isPrimaryKey())
                ->checked(!empty($attribute) ? $attribute->isAutoIncrement() : false)
                ->name("attribute_auto_increment")
                ->placeholder("Activer l'auto-incrémentation")
                ->render() ?>
        </div>
        <div class="tw-w-6/12 tw-px-2">
            <?php Text::create()
                ->label(__('admin.panel.tables.table.attribute.default_value'))
                ->type("text")
                ->value(!empty($attribute) ? $attribute->getDefaultValue() : "")
                ->validator(true)
                ->name("attribute_default_value")
                ->placeholder("CURRENT_TIMESTAMP")
                ->render(); ?>
        </div>
        <div class="tw-w-full tw-px-2">
            <?php Select::create()
                ->placeholder(__('admin.panel.tables.table.attribute.select_a_table'))
                ->disabled(!empty($table_name) && !empty($table) && !empty($attribute->getAssociation()))
                ->undefinable(true)
                ->selected(!empty($attribute) ? $attribute->getAssociation() : "")
                ->label(__('admin.panel.tables.table.attribute.choose_an_association_to_another_table'))
                ->name("attribute_association")
                ->required(true)
                ->options(Select::toCombine(Table::listTablesName(), function ($option) {
                    return $option . "(id)";
                }))
                ->render() ?>
        </div>
    </div>
</form>
