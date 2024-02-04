<?php

if (!empty($table)) { ?>
    <script>
        const TABLE_DATA = JSON.parse('<?= $table->toJson() ?>');
    </script>
<?php } ?>
<?php
if (empty($title)) $title = "";
if (empty($description)) $description = "";

Header::create()
    ->template('/core/ui/views/admin/components')
    ->title($title)
    ->description($description)
    ->render();
?>
<?php
    if(!empty($sql)) {
        view(Application::get()->toRoot("/core/ui/views/sql.php"), ["sql" => $sql]);
    }
?>
<div class="tw-flex tw-flex-row tw-flex-wrap -tw-mx-2">
    <div class="tw-w-5/12 tw-px-2 tw-flex tw-flex-col tw-gap-y-5">
        <div class="tw-border-[1px] tw-border-gray-700 tw-border-opacity-25 tw-text-gray-600 tw-bg-white tw-bg-opacity-70 tw-drop-shadow-md tw-rounded-lg tw-flex tw-flex-row tw-flex-wrap tw-py-5 tw-px-3">
            <form class="tw-flex tw-flex-wrap tw-w-full tw-gap-y-5" action="" method="POST" id="table-form" novalidate>
                <div class="tw-w-full tw-px-2">
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
                <div class="tw-w-auto tw-px-2 tw-flex tw-flex-col">
                    <?php CheckBox::create()
                        ->name("use_i18n")
                        ->checked(!empty($table) ? $table->hasLanguageAttribute() : false)
                        ->label(__("admin.panel.tables.table.set.table.i18n"))
                        ->placeholder(__("admin.panel.tables.table.set.table.i18n.placeholder"))
                        ->render() ?>
                </div>
                <div class="tw-w-auto tw-px-2 tw-flex tw-flex-col">
                    <?php CheckBox::create()
                        ->name("use_default_attributes")
                        ->readonly(!empty($table))
                        ->checked(!empty($table) ? $table->hasAllDefaultAttributes() : false)
                        ->label(__("admin.panel.tables.table.set.table.default_attributes"))
                        ->checked(true)
                        ->placeholder(__("admin.panel.tables.table.set.table.default_attributes.placeholder"))
                        ->render() ?>
                </div>
                <div class="tw-w-full tw-px-2">
                    <?=
                    Button::create()
                        ->type("submit")
                        ->addClass("tw-w-full")
                        ->blue()
                        ->text('<i class="fa-solid fa-hammer tw-me-1"></i> ' . __("admin.panel.tables.table.set.table.submit"))
                        ->render()
                    ?>
                </div>
            </form>
        </div>
        <div class="tw-border-[1px] tw-border-gray-700 tw-border-opacity-25 tw-drop-shadow-md tw-text-gray-600 tw-bg-white tw-bg-opacity-70 tw-rounded-lg tw-flex tw-flex-row tw-flex-wrap tw-py-5 tw-px-3 tw-p-2 <?= empty($table_name) ? "tw-hidden" : "" ?>">
            <form class="tw-flex tw-flex-col tw-w-full tw-gap-y-2 tw-text-center" action="<?= DefaultRoutes::route(DefaultRoutes::ADMIN_TABLES_DELETE, ["table" => $table_name ?? '']) ?>" id="table-form-delete" method="POST">
                <h3 class="tw-text-4xl tw-text-red-600 tw-font-semibold tw-mb-2"><i class="tw-me-2 fa-solid fa-warning"></i><?= __('admin.panel.tables.table.delete.warning.title') ?> <i
                            class="ms-2 fa-solid fa-warning"></i></h3>
                <p class="tw-text-md"><?= __('admin.panel.tables.table.delete.warning.message') ?></p>
                <button type="submit"
                        class="tw-mt-5 tw-w-full tw-bg-red-700 hover:tw-bg-red-800 tw-text-white tw-font-semibold tw-py-2 tw-px-4 tw-rounded-md tw-shadow-lg">
                    <i class="fa-solid fa-trash tw-me-1"></i>
                    <?= __('admin.panel.tables.table.delete.submit') ?>
                </button>
            </form>
        </div>
        <form id="confirm" class="tw-bg-gray-800 tw-shadow-lg tw-rounded-lg tw-flex-col tw-flex-wrap tw-p-5 tw-gap-2 tw-hidden" action=""
              method="POST"
              novalidate>
            <h5 class="tw-text-lg tw-uppercase tw-font-bold"><?= __('admin.panel.tables.table.json') ?></h5>
            <textarea id="json-content" disabled rows="15" class="tw-text-white tw-w-full tw-bg-gray-800 tw-border-[0px]"
                      style="white-space: pre; font-family: monospace;">
            </textarea>
            <input type="hidden" name="table_json" value="<?= $post_table_json ?? '{}' ?>">
            <button type="submit"
                    class="tw-w-full tw-bg-green-600 hover:tw-bg-green-700 tw-text-white tw-font-semibold tw-py-2 tw-px-4 tw-rounded-md tw-shadow-lg">
                <i class="fa-solid fa-check tw-me-1"></i>
                <?= !empty($table) ? __('admin.panel.tables.table.edit_confirm') : __('admin.panel.tables.table.create_confirm') ?>
            </button>
        </form>
    </div>
    <div class="tw-w-7/12 tw-px-2 tw-flex tw-flex-col tw-gap-y-3">
        <div id="attributes-container" class="tw-flex tw-flex-col tw-gap-y-3">
            <?php if (!empty($table) && !empty($table->getAttributes())): ?>
                <?php foreach ($table->getAttributes() as $attribute):
                    /** @var TableAttribute $attribute */
                    if ($attribute->isDefaultAttribute() || $attribute->isLanguageAttribute()) continue;
                    view(Application::get()->toRoot("/core/ui/views/admin/panel/sections/table/attribute/attribute.php"), ["attribute" => $attribute]);
                endforeach; ?>
            <?php else: ?>
                <?php view(Application::get()->toRoot("/core/ui/views/admin/panel/sections/table/attribute/attribute.php")) ?>
            <?php endif; ?>
        </div>
        <div class="tw-w-full tw-flex tw-flex-col tw-items-center">
            <button type="button" id="add-attribute"
                    class="tw-bg-green-600 hover:tw-bg-green-700 tw-h-10 tw-w-10 tw-text-xl tw-rounded-full tw-flex tw-items-center tw-justify-center tw-text-white tw-shadow-lg">
                <i class="fa-solid fa-plus"></i>
            </button>
        </div>
    </div>
</div>