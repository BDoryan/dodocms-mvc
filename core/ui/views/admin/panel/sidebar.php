<?php


if (!isset($sidebar)) {
    echo "Sidebar not found";
    exit;
}
?>
<div class="tw-flex-shrink-0 tw-w-64 tw-bg-gray-800">
    <div class="tw-flex tw-flex-col tw-h-full">

        <div class="tw-flex tw-flex-col tw-items-center tw-justify-center tw-py-3 tw-bg-gray-900">
            <img width="60" height="60" src="<?= Application::get()->toURL("/core/assets/imgs/logo-animated.png") ?>"
                 alt="<?= __('admin.panel.dashboard') ?>">
            <span class="tw-text-white tw-text-xl tw-font-semibold"><?= __("admin.panel.dashboard") ?></span>
        </div>
        <nav class="tw-flex-1 tw-overflow-y-auto">
            <?php
            /** @var SidebarCategory $category */
            foreach ($sidebar->getCategories() as $category) {
                ?>
                <span class="tw-px-4 tw-flex tw-items-center tw-mt-4 tw-mb-1 tw-text-stone-300 tw-text-sm"><?= $category->getLabel() ?></span>
                <?php
                /** @var SidebarSection $section */
                if (!empty($category->getSections())) {
                    foreach ($category->getSections() as $section) {
                        ?>
                        <a href="<?= Application::get()->toURL($section->getHref()) ?>"
                           class="tw-mx-3 tw-my-[3px] tw-rounded-lg tw-gap-1 tw-flex tw-p-2 tw-items-center tw-py-2 tw-px-4 tw-text-gray-300 <?= $section->isActive() ? "tw-bg-gray-700 tw-shadow-xl" : "" ?> hover:tw-bg-gray-700 hover:tw-shadow-2xl hover:tw-text-white tw-font-semibold tw-text-base">
                            <i style="width: 20px;"
                               class="tw-flex tw-justify-center tw-items-center <?= $section->getIcon() ?>"></i>
                            <?= $section->getLabel() ?>
                        </a>
                    <?php } ?>
                <?php } else { ?>
                    <span class="tw-text-xs tw-italic tw-ml-2 tw-px-4 tw-flex tw-items-center tw-mt-4 tw-mb-1 tw-text-white tw-text-opacity-50">
                        <?= __("admin.panel.category_empty") ?>
                    </span>
                <?php } ?>
            <?php } ?>
        </nav>
        <?php
        ButtonHypertext::create()
            ->href(Application::get()->toURL("/?editor=true"))
            ->addClass("tw-mx-2 tw-mb-[10px]")
            ->green()
            ->target('_blank')
            ->text('<i class="tw-me-1 fa-solid fa-arrow-right"></i> ' . __("admin.panel.go_to_website"))
            ->render();
        ?>
        <div class="tw-text-white tw-px-3 tw-text-center italic tw-py-2 tw-text-md tw-font-semibold tw-bg-gray-900">
            <?= DodoCMS::VERSION ?>
        </div>
    </div>
</div>