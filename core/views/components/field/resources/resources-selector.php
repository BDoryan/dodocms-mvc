<div class="resources-selector" id="<?= $this->id ?>" x-data="{ resourceTarget: null }">
    <input class="resources-selector-entries" type="hidden" name="<?= $this->name ?>"
           value="<?= $this->resourcesToString() ?>">
    <div class="dodocms-relative dodocms-group dodocms-w-full dodocms-bg-gray-700 dodocms-px-3 dodocms-py-2 dodocms-border dodocms-border-gray-500 dodocms-rounded-md dodocms-text-white dodocms-outline-none focus:dodocms-border-gray-400 dodocms-mb-1 dodocms-min-h-[400px] dodocms-flex dodocms-flex-col dodocms-overflow-dodocms-hidden">
        <div class="dodocms-opacity-0 group-hover:dodocms-opacity-100 dodocms-absolute dodocms-top-0 dodocms-left-0 dodocms-w-full dodocms-h-full dodocms-flex dodocms-flex-col">
            <div x-show="resourceTarget == null" class="dodocms-flex dodocms-flex-row dodocms-mt-auto dodocms-p-2 dodocms-gap-4">
                <button type="button"
                        onclick="openUploadModal(<?= $this->multiple ? 'true' : 'false' ?>, '<?= $this->name ?>')"
                        class="dodocms-z-10 dodocms-flex dodocms-flex-col dodocms-text-center dodocms-text-dodocms-opacity-75 hover:dodocms-text-indigo-200 dodocms-text-gray-100 dodocms-bg-gray-800 dodocms-bg-opacity-90 hover:dodocms-bg-opacity-100 dodocms-p-3 dodocms-rounded-lg">
                    <i class="fa-solid fa-cloud dodocms-text-xl"></i>
                    <?= __('admin.panel.resources.new') ?>
                </button>
                <button type="button"
                        onclick="openSelectResourcesModal(<?= $this->multiple ? 'true' : 'false' ?>, '<?= $this->name ?>')"
                        class="dodocms-ms-auto dodocms-z-10 dodocms-flex dodocms-flex-col dodocms-text-center dodocms-text-dodocms-opacity-75 hover:dodocms-text-green-200 dodocms-text-gray-100 dodocms-bg-gray-800 dodocms-bg-opacity-90 hover:dodocms-bg-opacity-100 dodocms-p-3 dodocms-rounded-lg">
                    <i class="fa-solid fa-plus-circle dodocms-text-xl"></i>
                    <?= __('admin.panel.resources.select') ?>
                </button>
            </div>
        </div>
        <div class="dodocms-absolute dodocms-top-0 dodocms-left-0 dodocms-w-full dodocms-h-full dodocms-flex dodocms-flex-col dodocms-overflow-y-auto">
            <div class="resources-items dodocms-mx-auto dodocms-p-2 dodocms-gap-4 dodocms-flex dodocms-flex-col dodocms-max-w-[60%]">
            </div>
        </div>
        <div class="resource-selector-empty dodocms-m-auto dodocms-text-gray-300 dodocms-text-opacity-75">
            <?= __('admin.panel.resources.empty') ?>
        </div>
    </div>
</div>