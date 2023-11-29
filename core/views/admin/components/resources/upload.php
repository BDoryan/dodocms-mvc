<?php
if (!isset($var)) {
    echo "You must define a variable name for the modal !";
    Application::get()->getLogger()->error("You must define a variable name for the modal !");
    return;
}
?>
<div x-show="<?= $var ?>" @click.away="<?= $var ?> = false" class="fixed inset-0 bg-black opacity-50 z-1"></div>

<div id="file-upload" x-show="<?= $var ?>" class="fixed inset-0 flex items-center justify-center">
    <!-- Modal content -->
    <div @click.stop class="relative bg-white rounded-lg shadow dark:bg-gray-700 rounded-lg shadow-lg w-2/4 z-50" tabindex="-1" aria-hidden="true">
        <!-- Modal header -->
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                <i class="fa-solid fa-cloud-upload me-1"></i> <?= __('admin.panel.resources.upload.title') ?>
            </h3>
            <button type="button"
                    @click="<?= $var ?> = false"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
        </div>
        <!-- Modal body -->
        <div class="p-4 md:p-5 space-y-4">
            <div class="flex items-center justify-center w-full">
                <label for="dropzone-file"
                       class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                        </svg>
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold"><?= __("admin.panel.resources.upload.click_to_upload") ?></span>
                            <?= __("admin.panel.resources.upload.drag_and_drop") ?></p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">PDF, JPEG, PNG, JPG or GIF</p>
                    </div>
                    <input name="files[]" id="dropzone-file" type="file" multiple class="opacity-0"/>
                </label>
            </div>
            <div class="flex flex-row flex-wrap -m-1 pe-2" id="files"
                 style="max-height: 300px; overflow-y: auto;">
            </div>
        </div>
        <!-- Modal footer -->
        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
            <button @click="<?= $var ?> = false" type="button"
                    class="me-auto text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                <?= __("admin.panel.resources.upload.close") ?>
            </button>
            <div class="me-auto text-white opacity-75" id="state">
            </div>
            <button id="start"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <?= __("admin.panel.resources.upload.submit") ?>
            </button>
        </div>
    </div>
</div>
<?php view(Application::get()->toRoot('/core/views/admin/components/resources/resource_item.php')) ?>