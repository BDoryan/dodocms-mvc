<script type="text/x-template" id="resource-item-template">
    <div class="tw-w-full tw-rounded-lg tw-border-[1px] tw-border-gray-300 tw-relative tw-overflow-hidden"
         style="height: 200px;"
         :class="{'tw-order-1': selected,'tw-order-2': !selected}"
    >
        <img
                class="tw-w-full tw-h-full"
                :src="src"
                :alt="alternativeText"
                style="background-size: contain; background: url('<?= Application::get()->toURL("/core/assets/imgs/transparent.jpg") ?>'); object-fit: contain; object-position: center;"
        />
        <a v-if="href && href.length > 0" target="_blank" :href="href"
           class="tw-absolute tw-inset-0 tw-flex tw-items-center tw-justify-center tw-opacity-0 hover:tw-opacity-100 tw-transition tw-duration-300 tw-ease-in-out tw-bg-black tw-bg-opacity-25">
            <i class="fas fa-eye tw-text-5xl tw-text-white tw-text-tw-opacity-75 hover:tw-text-tw-opacity-90 tw-transition-colors"></i>
        </a>
        <div v-if="(!inEdition && !inUploading())"
             class="tw-absolute tw-top-0 tw-flex tw-flex-row tw-space-x-1 tw-w-full tw-p-2">
            <div class="tw-me-auto">
                <button
                        v-if="selectable && isSelected()"
                        v-on:click="deselectItem"
                        type="button"
                        class="tw-border tw-border-white tw-border-opacity-75 tw-h-8 tw-w-8 tw-rounded-full tw-text-white tw-bg-gray-800">
                    <i class="tw-text-md fa-solid fa-check"></i>
                </button>
                <button v-else-if="selectable && !isSelected()"
                        v-on:click="selectItem"
                        type="button"
                        class="tw-border tw-border-white tw-border-opacity-60 tw-bg-opacity-75 tw-text-opacity-75 hover:tw-bg-opacity-100 hover:tw-text-opacity-100 tw-h-8 tw-w-8 tw-rounded-full tw-text-white tw-bg-gray-600 hover:tw-bg-gray-700">
                    <i class="tw-text-md fa-solid fa-check"></i>
                </button>
            </div>
            <button v-if="editable"
                    v-on:click="showEdition"
                    type="button"
                    class="tw-text-white tw-bg-blue-500 tw-h-8 tw-w-8 tw-rounded-full hover:tw-bg-blue-600">
                <i class="tw-text-sm fa-solid fa-edit"></i>
            </button>
            <button v-if="deletable"
                    v-on:click="deleteItem"
                    type="button"
                    class="tw-text-white tw-bg-red-500 tw-h-8 tw-w-8 tw-rounded-full hover:tw-bg-red-600">
                <i class="tw-text-sm fa-solid fa-trash"></i>
            </button>
            <button v-if="removable"
                    v-on:click="removeItem"
                    type="button"
                    class="tw-text-white tw-bg-red-500 tw-h-8 tw-w-8 tw-rounded-full hover:tw-bg-red-600">
                <i class="tw-text-sm fa-solid fa-minus"></i>
            </button>
        </div>
        <div v-if="(inEdition || inUploading())"
             class="tw-absolute tw-top-0 tw-h-full tw-flex tw-w-full tw-bg-opacity-50 tw-bg-gray-800 tw-backdrop-blur-sm">
        </div>
        <div v-if="(inEdition && !inUploading())"
             class="tw-absolute tw-top-0 tw-h-full tw-flex tw-w-full tw-p-2">
            <div class="tw-flex tw-flex-col tw-mt-auto tw-w-full tw-h-full">
                <?php Text::create()
                    ->label(__('panel.admin.resource.item.edit.alternativeText') . ' :')
                    ->attribute('v-model', "localAlternativeText")
                    ->name("alternativeText")
                    ->render() ?>
                <div class="tw-mt-auto tw-flex tw-flex-row tw-gap-2">
                    <?php
                    Button::create()
                        ->addClass("tw-text-sm")
                        ->gray()
                        ->text(__('panel.admin.resource.item.edit.cancel'))
                        ->attribute("v-on:click", 'cancelEdition')
                        ->render()
                    ?>
                    <?php
                    Button::create()
                        ->addClass("tw-text-sm tw-ms-auto")
                        ->blue()
                        ->text(__('panel.admin.resource.item.edit.save'))
                        ->attribute("v-on:click", 'applyEdition')
                        ->render()
                    ?>
                </div>
            </div>
        </div>
        <div v-if="(!inEdition && inUploading())"
             class="tw-absolute tw-top-0 tw-h-full tw-flex tw-w-full tw-p-2">
            <div class="tw-p-2 tw-flex tw-flex-col tw-absolute tw-top-0 tw-right-0 tw-left-0 tw-bottom-0 tw-bg-black tw-bg-opacity-50 tw-rounded-lg">
                <div class="tw-mt-auto tw-w-full tw-bg-gray-200 tw-rounded-full">
                    <div :style="{ width: uploadProgression + '%' }" class="tw-mt-auto tw-bg-blue-500 tw-rounded-full tw-text-xs tw-text-center tw-text-white">
                        <span class="progress-number">{{ uploadProgression }}</span>%
                    </div>
                </div>
            </div>
        </div>
    </div>
</script>
