<div class="modal-background hidden fixed inset-0 bg-black opacity-50 z-50"></div>
<div id="file-upload" class="modal-content hidden fixed inset-0 flex items-center justify-center z-50">
    <!-- Modal content -->
    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700 rounded-lg shadow-lg w-2/4" tabindex="-1"
         aria-hidden="true">
        <!-- Modal header -->
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                <?= $title ?? 'Untitled' ?>
            </h3>
            <button type="button" class="close-upload-modal text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
        </div>
        <?=
            $body ?? 'no_footer'
        ?>
        <?=
            $footer ?? 'no_footer'
        ?>
    </div>
</div>
<?php view(Application::get()->toRoot('/core/views/admin/components/resources/resource.template.php')) ?>