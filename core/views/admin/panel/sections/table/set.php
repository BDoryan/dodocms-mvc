<?php if (!empty($table)) { ?>
    <script>
        const TABLE_DATA = JSON.parse('<?= $table->toJson() ?>');
    </script>
<?php } ?>
<?php
if (empty($title)) $title = "";
if (empty($description)) $description = "";

Header::create()
    ->template('/core/views/admin/components')
    ->title($title)
    ->description($description)
    ->render();
?>
<?php
    if(!empty($sql)) {
        view(Application::get()->toRoot("/core/views/sql.php"), ["sql" => $sql]);
    }
?>
<div class="dodocms-flex dodocms-flex-row dodocms-flex-wrap -dodocms-mx-2">
    <div class="dodocms-w-5/12 dodocms-px-2 dodocms-flex dodocms-flex-col dodocms-gap-y-5">
        <div class=" dodocms-bg-gray-800 dodocms-shadow-lg dodocms-rounded-xl dodocms-flex dodocms-flex-row dodocms-flex-wrap dodocms-py-5 dodocms-px-3 dodocms-p-2">
            <form class="dodocms-flex dodocms-flex-wrap dodocms-w-full dodocms-gap-y-5" action="" method="POST" id="table-form" novalidate>
                <div class="dodocms-w-full dodocms-px-2">
                    <?php Text::create()
                        ->label(__("admin.panel.tables.table.set.table.name"))
                        ->value(!empty($table) ? $table->getName() : "")
                        ->validator(true)
                        ->type("text")
                        ->required(true)
                        ->name("table_name")
                        ->placeholder(__("admin.panel.tables.table.set.table.name.placeholder"))
                        ->render() ?>
                </div>
                <div class="dodocms-w-auto dodocms-px-2 dodocms-flex dodocms-flex-col">
                    <?php CheckBox::create()
                        ->name("use_i18n")
                        ->checked(!empty($table) ? $table->hasLanguageAttribute() : false)
                        ->label(__("admin.panel.tables.table.set.table.i18n"))
                        ->placeholder(__("admin.panel.tables.table.set.table.i18n.placeholder"))
                        ->render() ?>
                </div>
                <div class="dodocms-w-auto dodocms-px-2 dodocms-flex dodocms-flex-col">
                    <?php CheckBox::create()
                        ->name("use_default_attributes")
                        ->readonly(!empty($table))
                        ->checked(!empty($table) ? $table->hasAllDefaultAttributes() : false)
                        ->label(__("admin.panel.tables.table.set.table.default_attributes"))
                        ->checked(true)
                        ->placeholder(__("admin.panel.tables.table.set.table.default_attributes.placeholder"))
                        ->render() ?>
                </div>
                <div class="dodocms-w-full dodocms-px-2">
                    <?=
                    Button::create()
                        ->type("submit")
                        ->addClass("dodocms-w-full")
                        ->blue()
                        ->text('<i class="fa-solid fa-hammer dodocms-me-1"></i> ' . __("admin.panel.tables.table.set.table.submit"))
                        ->render()
                    ?>
                </div>
            </form>
        </div>
        <div class=" dodocms-bg-gray-800 dodocms-shadow-lg dodocms-rounded-xl dodocms-flex dodocms-flex-row dodocms-flex-wrap dodocms-py-5 dodocms-px-3 dodocms-p-2 <?= empty($table_name) ? "dodocms-hidden" : "" ?>">
            <form class="dodocms-flex dodocms-flex-col dodocms-w-full dodocms-gap-y-2 dodocms-text-center" action="<?= Routes::route(Routes::ADMIN_TABLES_DELETE, ["table" => $table_name ?? '']) ?>" id="table-form-delete" method="POST">
                <h3 class="dodocms-text-4xl dodocms-text-orange-300 dodocms-font-semibold dodocms-mb-2"><i class="dodocms-me-2 fa-solid fa-warning"></i><?= __('admin.panel.tables.table.delete.warning.title') ?><i
                            class="ms-2 fa-solid fa-warning"></i></h3>
                <p class="dodocms-text-md"><?= __('admin.panel.tables.table.delete.warning.message') ?></p>
                <button type="submit"
                        class="dodocms-mt-5 dodocms-w-full dodocms-bg-red-700 hover:dodocms-bg-red-800 dodocms-text-white dodocms-font-semibold dodocms-py-2 dodocms-px-4 dodocms-rounded-md dodocms-shadow-lg">
                    <i class="fa-solid fa-trash dodocms-me-1"></i>
                    <?= __('admin.panel.tables.table.delete.submit') ?>
                </button>
            </form>
        </div>
        <form id="confirm" class="dodocms-bg-gray-800 dodocms-shadow-lg dodocms-rounded-xl dodocms-flex-col dodocms-flex-wrap dodocms-p-5 dodocms-gap-2 dodocms-hidden" action=""
              method="POST"
              novalidate>
            <h5 class="dodocms-text-lg dodocms-uppercase dodocms-font-bold"><?= __('admin.panel.tables.table.json') ?></h5>
            <textarea id="json-content" disabled rows="15" class="dodocms-text-white dodocms-w-full dodocms-bg-gray-800 dodocms-border-[0px]"
                      style="white-space: pre; font-family: monospace;">
            </textarea>
            <input type="hidden" name="table_json" value="<?= $post_table_json ?? '{}' ?>">
            <button type="submit"
                    class="dodocms-w-full dodocms-bg-green-600 hover:dodocms-bg-green-700 dodocms-text-white dodocms-font-semibold dodocms-py-2 dodocms-px-4 dodocms-rounded-md dodocms-shadow-lg">
                <i class="fa-solid fa-check dodocms-me-1"></i>
                <?= !empty($table) ? __('admin.panel.tables.table.edit_confirm') : __('admin.panel.tables.table.create_confirm') ?>
            </button>
        </form>
    </div>
    <div class="dodocms-w-7/12 dodocms-px-2 dodocms-flex dodocms-flex-col dodocms-gap-y-3">
        <div id="attributes-container" class="dodocms-flex dodocms-flex-col dodocms-gap-y-3">
            <?php if (!empty($table) && !empty($table->getAttributes())): ?>
                <?php foreach ($table->getAttributes() as $attribute):
                    /** @var TableAttribute $attribute */
                    if ($attribute->isDefaultAttribute() || $attribute->isLanguageAttribute()) continue;
                    view(Application::get()->toRoot("/core/views/admin/panel/sections/table/attribute/attribute.php"), ["attribute" => $attribute]);
                endforeach; ?>
            <?php else: ?>
                <?php view(Application::get()->toRoot("/core/views/admin/panel/sections/table/attribute/attribute.php")) ?>
            <?php endif; ?>
        </div>
        <div class="dodocms-w-full dodocms-flex dodocms-flex-col dodocms-items-center">
            <button type="button" id="add-attribute"
                    class="dodocms-bg-green-600 hover:dodocms-bg-green-700 dodocms-h-10 dodocms-w-10 dodocms-text-xl dodocms-rounded-full dodocms-flex dodocms-items-center dodocms-justify-center dodocms-text-white dodocms-shadow-lg">
                <i class="fa-solid fa-plus"></i>
            </button>
        </div>
    </div>
</div>
<script>
    const container = $("#attributes-container");

    $(document).on("click", "#add-attribute", function (event) {
        const form = container.find("#attribute-form");

        const url = '<?= Routes::route(Routes::ADMIN_TABLES_TABLE_ATTRIBUTE) ?>';
        const clonedForm = $.ajax({
            url: url,
            method: "GET",
            async: false
        }).responseText;

        container.append(clonedForm);
    });

    $(document).on("click", "#remove-attribute", function (event) {
        const form = $(this).closest("#attribute-form");
        form.remove();
    });

    $(document).on("submit", "#table-form-delete", function (event) {
        if (!confirm("Êtes-vous sûr de vouloir supprimer ?")) {
            event.preventDefault();
        }
    });

    $(document).on("submit", "#table-form", function (event) {
        $("#confirm").addClass("dodocms-hidden");

        event.preventDefault();
        const container = $("#attributes-container");
        const form = $(this);

        if (!FormUtils.checkForm(form)) return;

        const data = form.serializeArray();
        const attributeForms = container.find("form[data-type=attribute]");

        let isValid = true;

        attributeForms.each(function (index, element) {
            const attributeForm = $(element);

            if (!FormUtils.checkForm(attributeForm)) {
                isValid = false;
                return;
            }
        });

        if (!isValid) return

        let attributes = [];
        const attributeNames = [];

        attributeForms.each(function (index, element) {
            const attributeForm = $(element);
            const data = attributeForm.serializeArray();
            const attributeData = data.reduce((accumulator, currentValue) => {
                if (currentValue.name === "attribute_association" && currentValue.value === "") return accumulator;
                if (currentValue.name === "attribute_default_value" && currentValue.value === "") return accumulator;
                if (currentValue.name === "attribute_length" && currentValue.value === "") return accumulator;
                if (currentValue.name === "attribute_auto_increment" || currentValue.name === "attribute_nullable" || currentValue.name === "attribute_primary_key") currentValue.value = currentValue.value === "on";

                accumulator[currentValue.name.replace("attribute_", "")] = currentValue.value;
                return accumulator;
            }, {});

            const attributeName = attributeData.name;
            const input = attributeForm.find('input[name=attribute_name]');
            if (attributeNames.includes(attributeName)) {
                FormUtils.validationMessage(input, "Le nom de l'attribut est en double")
                isValid = false;
                return;
            } else {
                FormUtils.clearValidationMessage(input);
            }

            attributeNames.push(attributeName); // Ajouter le nom à la liste des noms d'attributs
            attributes.push(attributeData);
        });

        if (!isValid) return

        if (data.find(element => element.name === "use_i18n")?.value === "on" || false) {
            attributes.push({
                name: "language",
                type: "varchar",
                length: 255,
                nullable: false
            });
        }

        attributes.unshift({
            name: "id",
            type: "int",
            primary_key: true,
            auto_increment: true,
            nullable: false
        });

        if (data.find(element => element.name === "use_default_attributes")?.value === "on" || false) {

            attributes.push({
                name: "createdAt",
                type: "datetime",
                nullable: false,
                default_value: "CURRENT_TIMESTAMP"
            });
            attributes.push({
                name: "updatedAt",
                type: "datetime",
                nullable: false,
                default_value: "CURRENT_TIMESTAMP"
            });
        }

        const table = {
            name: data.find(element => element.name === "table_name")?.value || "null",
            attributes
        };

        $("#confirm").find("input[name=table_json]").val(JSON.stringify(table, null, 4));

        $("#confirm").removeClass("dodocms-hidden");
        $("#json-content").val(JSON.stringify(table, null, 4));
    });
</script>