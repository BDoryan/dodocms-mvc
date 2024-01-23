<div class="modal-background dodocms-hidden dodocms-fixed dodocms-inset-0 dodocms-bg-black dodocms-opacity-50 dodocms-z-50"></div>
<div id="file-upload" class="modal-content dodocms-hidden dodocms-fixed dodocms-inset-0 dodocms-flex dodocms-items-center dodocms-justify-center dodocms-z-50">
    <!-- Modal content -->
    <div class="dodocms-relative dodocms-bg-white dodocms-rounded-lg dodocms-shadow dark:dodocms-bg-gray-700 dodocms-rounded-lg dodocms-shadow-lg dodocms-w-2/4" tabindex="-1"
         aria-hidden="true">
        <!-- Modal header -->
        <div class="dodocms-flex dodocms-items-center dodocms-justify-between dodocms-p-4 md:dodocms-p-5 dodocms-border-b dodocms-rounded-t dark:dodocms-border-gray-600">
            <h3 class="dodocms-text-xl dodocms-font-semibold dodocms-text-gray-900 dark:dodocms-text-white">
                <?= $title ?? 'Untitled' ?>
            </h3>
            <button type="button" class="close-upload-modal dodocms-text-gray-400 dodocms-bg-transparent hover:dodocms-bg-gray-200 hover:dodocms-text-gray-900 dodocms-rounded-lg dodocms-text-sm dodocms-w-8 dodocms-h-8 dodocms-ms-auto dodocms-inline-flex dodocms-justify-center dodocms-items-center dark:hover:dodocms-bg-gray-600 dark:hover:dodocms-text-white">
                <svg class="dodocms-w-3 dodocms-h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
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
<?php view(Application::get()->toRoot('/core/admin/views/components/resources/resource.template.php')) ?>