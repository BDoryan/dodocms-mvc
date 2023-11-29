<script type="text/template" id="image">
    <div class="p-1 w-4/12">
        <div class="relative h-full">
            <div class="h-full rounded-lg border-[1px] border-gray-300" style="height: 200px;">
                <img class="rounded-lg h-full w-full" alt="" src="" style="object-fit: contain; object-position: center;">
            </div>
            <div class="action-bar absolute top-2 right-2 space-x-1">
                <button type="button" class="edit text-white bg-blue-500 h-8 w-8 rounded-full hover:bg-blue-600">
                    <i class="text-sm fa-solid fa-edit"></i>
                </button>
                <button type="button" class="delete text-white bg-red-500 h-8 w-8 rounded-full hover:bg-red-600">
                    <i class="text-sm fa-solid fa-trash"></i>
                </button>
            </div>
            <div class="progression hidden p-2 flex flex-col absolute top-0 right-0 left-0 bottom-0 bg-black bg-opacity-50 rounded-lg">
                <div class="mt-auto w-full bg-gray-200 rounded-full">
                    <div class="progress-bar mt-auto bg-blue-500 rounded-full text-xs text-center text-white">
                        <span class="progress-number"></span>%
                    </div>
                </div>
            </div>
            <div class="edition hidden rounded-lg bg-gray-800 bg-opacity-75 p-3 absolute top-0 bottom-0 left-0 right-0 flex flex-col">
                <?= Text::create()->label(__('admin.panel.resources.edition.alternative_text'))->name("alternativeText")->render() ?>
                <div class="mt-auto flex flex-row">
                    <?php
                        Button::create()
                            ->text(__('admin.panel.resources.edition.finish'))
                            ->addClass("mt-auto ms-auto text-sm")
                    ->blue()
                    ->render();
                    ?>
                </div>
            </div>
        </div>
    </div>
</script>
