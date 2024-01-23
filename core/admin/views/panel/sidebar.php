<?php



if (!isset($sidebar)) {
    echo "Sidebar not found";
    exit;
}
?>
<div class="dodocms-flex-shrink-0 dodocms-w-64 dodocms-bg-gray-800">
    <div class="dodocms-flex dodocms-flex-col dodocms-h-full">

        <div class="dodocms-flex dodocms-flex-col dodocms-items-center dodocms-justify-center dodocms-py-3 dodocms-bg-gray-900">
            <img width="60" height="60" src="<?= Application::get()->toURL("/core/assets/imgs/logo-animated.png") ?>"
                 alt="<?= __('admin.panel.dashboard') ?>">
            <span class="dodocms-text-white dodocms-text-xl dodocms-font-semibold"><?= __("admin.panel.dashboard") ?></span>
        </div>
        <nav class="dodocms-flex-1 dodocms-overflow-y-auto">
            <?php
            /** @var SidebarCategory $category */
            foreach ($sidebar->getCategories() as $category):
                ?>
                <span class="dodocms-px-4 dodocms-flex dodocms-items-center dodocms-mt-4 dodocms-mb-1 dodocms-text-stone-300 dodocms-text-sm"><?= $category->getLabel() ?></span>
                <?php
                /** @var SidebarSection $section */
                foreach ($category->getSections() as $section):
                    ?>
                    <a href="<?= Application::get()->toURL($section->getHref()) ?>"
                       class="dodocms-gap-1 dodocms-flex dodocms-p-2 dodocms-items-center dodocms-py-2 dodocms-px-4 dodocms-text-gray-300 <?= $section->isActive() ? "dodocms-bg-gray-700 dodocms-shadow-xl" : "" ?> hover:dodocms-bg-gray-700 hover:dodocms-shadow-2xl hover:dodocms-text-white dodocms-font-semibold dodocms-text-base">
                        <i style="width: 20px;"
                           class="dodocms-flex dodocms-justify-center dodocms-items-center <?= $section->getIcon() ?>"></i>
                        <?= $section->getLabel() ?>
                    </a>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </nav>
        <?php
        ButtonHypertext::create()
            ->href(Application::get()->toURL("/?editor=true"))
            ->addClass("dodocms-mx-2 dodocms-mb-[10px]")
                ->green()
            ->target('_blank')
            ->text('<i class="dodocms-me-1 fa-solid fa-arrow-right"></i> ' . __("admin.panel.go_to_website"))
            ->render();
        ?>
        <div class="dodocms-text-white dodocms-px-3 dodocms-text-center italic dodocms-py-2 dodocms-text-md dodocms-font-semibold dodocms-bg-gray-900">
            <?= DodoCMS::VERSION ?>
        </div>
    </div>
</div>