<div class="resources-selector" id="<?= $this->id ?>" x-data="{ resourceTarget: null }">
    <input class="resources-selector-entries" type="hidden" name="<?= $this->name ?>"
           value="<?= $this->resourcesToString() ?>">
    <div class="relative group w-full bg-gray-700 px-3 py-2 border border-gray-500 rounded-md text-white outline-none focus:border-gray-400 mb-1 h-[400px] flex flex-col overflow-hidden">
        <div class="opacity-0 group-hover:opacity-100 absolute top-0 left-0 w-full h-full flex flex-col">
            <div x-show="resourceTarget == null" class="flex flex-row mt-auto gap-2 p-4">
                <button type="button"
                        onclick="openUploadModal(<?= $this->multiple ? 'true' : 'false' ?>, '<?= $this->name ?>')"
                        class="z-10 flex flex-col text-center text-gray-300 text-opacity-75 hover:text-indigo-200 text-gray-100 bg-gray-800 bg-opacity-90 hover:bg-opacity-100 p-3 rounded-lg">
                    <i class="fa-solid fa-cloud text-xl"></i>
                    <?= __('admin.panel.resources.new') ?>
                </button>
                <button disabled type="button"
                        class="ms-auto z-10 flex flex-col text-center text-gray-300 text-opacity-75 hover:text-green-200 text-gray-100 bg-gray-800 bg-opacity-90 hover:bg-opacity-100 p-3 rounded-lg">
                    <i class="fa-solid fa-plus-circle text-xl"></i>
                    <?= __('admin.panel.resources.add') ?>
                </button>
            </div>
        </div>
        <div class="absolute top-0 left-0 w-full h-full flex flex-col overflow-y-auto">
            <div class="resources-items mx-auto gap-2 p-4 flex flex-col max-w-[60%]">
            </div>
        </div>
        <div class="resource-selector-empty m-auto text-gray-300 text-opacity-75">
            <?= __('admin.panel.resources.empty') ?>
        </div>
    </div>
</div>