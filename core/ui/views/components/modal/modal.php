<div class="modal-background tw-hidden tw-fixed tw-inset-0 tw-bg-black tw-opacity-50 tw-z-50"></div>
<div id="file-upload" class="modal-content tw-hidden tw-fixed tw-inset-0 tw-flex tw-items-center tw-justify-center tw-z-50">
    <!-- Modal content -->
    <div class="tw-relative tw-bg-white tw-rounded-lg tw-shadow dark:tw-bg-gray-700 tw-rounded-lg tw-shadow-lg tw-w-2/4" tabindex="-1"
         aria-hidden="true">
        <!-- Modal header -->
        <div class="tw-flex tw-items-center tw-justify-between tw-p-4 md:tw-p-5 tw-border-b tw-rounded-t dark:tw-border-gray-600">
            <h3 class="tw-text-xl tw-font-semibold tw-text-gray-900 dark:tw-text-white">
                <?= $title ?? 'Untitled' ?>
            </h3>
            <button type="button" class="close-upload-modal tw-text-gray-400 tw-bg-transparent hover:tw-bg-gray-200 hover:tw-text-gray-900 tw-rounded-lg tw-text-sm tw-w-8 tw-h-8 tw-ms-auto tw-inline-flex tw-justify-center tw-items-center dark:hover:tw-bg-gray-600 dark:hover:tw-text-white">
                <svg class="tw-w-3 tw-h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
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
<?php view(Application::get()->toRoot('/core/ui/views/admin/components/resources/resource.template.php')) ?>