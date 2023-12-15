<script type="text/template" id="resource">
    <div class="dodocms-p-1 dodocms-w-4/12">
        <div class="dodocms-relative dodocms-h-full">
            <div class="dodocms-h-full dodocms-rounded-lg dodocms-border-[1px] dodocms-border-gray-300" style="height: 200px;">
                <img class="dodocms-rounded-lg dodocms-h-full dodocms-w-full" alt="" src="" style="object-fit: contain; object-position: center;">
            </div>
            <div class="action-bar dodocms-absolute dodocms-top-2 dodocms-right-2 space-x-1">
                <button type="button" class="edit dodocms-text-white dodocms-bg-blue-500 dodocms-h-8 dodocms-w-8 dodocms-rounded-full hover:dodocms-bg-blue-600">
                    <i class="dodocms-text-sm fa-solid fa-edit"></i>
                </button>
                <button type="button" class="delete dodocms-text-white dodocms-bg-red-500 dodocms-h-8 dodocms-w-8 dodocms-rounded-full hover:dodocms-bg-red-600">
                    <i class="dodocms-text-sm fa-solid fa-trash"></i>
                </button>
            </div>
            <div class="progression dodocms-hidden dodocms-p-2 dodocms-flex dodocms-flex-col dodocms-absolute dodocms-top-0 dodocms-right-0 dodocms-left-0 dodocms-bottom-0 dodocms-bg-black dodocms-bg-opacity-50 dodocms-rounded-lg">
                <div class="dodocms-mt-auto dodocms-w-full dodocms-bg-gray-200 dodocms-rounded-full">
                    <div class="progress-bar dodocms-mt-auto dodocms-bg-blue-500 dodocms-rounded-full dodocms-text-xs dodocms-text-center dodocms-text-white">
                        <span class="progress-number"></span>%
                    </div>
                </div>
            </div>
            <div class="edition dodocms-hidden dodocms-rounded-lg dodocms-bg-gray-800 dodocms-bg-opacity-75 dodocms-p-3 dodocms-absolute dodocms-top-0 dodocms-bottom-0 dodocms-left-0 dodocms-right-0 dodocms-flex dodocms-flex-col">
                <?= Text::create()->label(__('admin.panel.resources.edition.alternative_text'))->name("alternativeText")->render() ?>
                <div class="dodocms-mt-auto dodocms-flex dodocms-flex-row">
                    <?php
                    Button::create()
                        ->text(__('admin.panel.resources.edition.finish'))
                        ->addClass("dodocms-mt-auto dodocms-ms-auto dodocms-text-sm")
                        ->blue()
                        ->render();
                    ?>
                </div>
            </div>
        </div>
    </div>
</script>
