<?php
    if (!isset($sidebar)) {
        echo "Sidebar not found";
        exit;
    }
?>
<div class="tw-flex-shrink-0 tw-w-64 tw-backdrop-filter tw-backdrop-blur-lg tw-bg-opacity-50 tw-border tw-border-black tw-border-opacity-20 tw-bg-white tw-rounded-2xl tw-overflow-hidden  tw-shadow-sm">
    <div class="tw-flex tw-flex-col tw-h-full">
        <div class="tw-px-6 tw-flex tw-items-center tw-justify-between tw-py-3 tw-bg-white tw-bg-opacity-50 tw-shadow-sm tw-text-gray-700">
            <img width="60" height="60" src="<?= Application::get()->toURL("/core/assets/imgs/logo-animated.png") ?>"
                 alt="<?= __('admin.panel.title') ?>">
            <div class="tw-text-lg tw-flex tw-flex-col"><span class="tw-text-2xl tw-font-bold">DodoCMS</span><?= __("admin.panel.title") ?></div>
        </div>
        <nav class="tw-flex-1 tw-overflow-y-auto">
            <?php
            /** @var SidebarCategory $category */
            foreach ($sidebar->getCategories() as $category) {
                ?>
                <span class="tw-px-4 tw-flex tw-items-center tw-mt-4 tw-mb-1 tw-text-gray-700 tw-text-sm"><?= $category->getLabel() ?></span>
                <?php
                /** @var SidebarSection $section */
                if (!empty($category->getSections())) {
                    foreach ($category->getSections() as $section) {
                        ?>
                        <a href="<?= Application::get()->toURL($section->getHref()) ?>"
                           class="tw-mt-2 tw-mx-3 tw-my-[3px] tw-rounded-lg tw-gap-1 tw-flex tw-p-2 tw-items-center tw-py-2 tw-px-4 tw-bg-white tw-text-gray-700 tw-shadow-sm tw-border-[1px] <?= $section->isActive() ? "tw-bg-opacity-100 tw-border-gray-300" : "tw-bg-opacity-55 tw-border-gray-200" ?> hover:tw-bg-opacity-100 hover:tw-border-gray-300 hover:tw-text-gray-800 tw-font-semibold tw-text-base">
                            <i style="width: 20px;"
                               class="tw-flex tw-justify-center tw-items-center <?= $section->getIcon() ?>"></i>
                            <?= $section->getLabel() ?>
                        </a>
                    <?php } ?>
                <?php } else { ?>
                    <span class="tw-text-xs tw-italic tw-ml-2 tw-px-4 tw-flex tw-items-center tw-mt-4 tw-mb-1 tw-text-gray-600 tw-text-opacity-50">
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
        <div class="tw-px-3 tw-text-center italic tw-py-2 tw-text-md tw-font-semibold tw-bg-white tw-bg-opacity-50 tw-shadow-sm tw-text-gray-700">
            <?= DodoCMS::VERSION ?>
        </div>
    </div>
</div>