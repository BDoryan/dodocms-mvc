<?php
    if (!isset($sidebar))
    {
        echo "Sidebar not found";
        exit;
    }
?>
<div class="flex-shrink-0 w-64 bg-gray-800">
    <div class="flex flex-col h-full">

        <div class="flex flex-col items-center justify-center py-3 bg-gray-900">
            <img width="60" height="60" src="<?= Application::get()->toURL("/core/assets/imgs/logo.png") ?>">
            <span class="text-white text-xl font-semibold"><?= __("dashboard") ?></span>
        </div>
        <nav class="flex-1 overflow-y-auto">
            <?php
            /** @var SidebarCategory $category */
            foreach ($sidebar->getCategories() as $category):
                ?>
                <span class="px-4 flex items-center mt-4 mb-1 text-stone-300 text-sm"><?= $category->getLabel() ?></span>
                <?php
                /** @var SidebarSection $section */
                foreach ($category->getSections() as $section):
                    ?>
                    <a href="<?= Application::get()->toURL($section->getHref()) ?>"
                       class="flex gap-2 items-center py-2 px-4 text-gray-300 <?= $section->isActive() ? "bg-gray-700" :"" ?> hover:bg-gray-700 hover:text-white font-semibold text-base">
                        <i style="width: 20px;" class="flex justify-center items-center <?= $section->getIcon() ?>"></i>
                        <?= $section->getLabel() ?>
                    </a>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </nav>
        <div class="text-white px-3 text-center italic py-2 text-md font-semibold bg-gray-900">
            <?= DodoCMS::VERSION ?>
        </div>
    </div>
</div>