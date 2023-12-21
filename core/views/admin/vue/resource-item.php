<script type="text/x-template" id="resource-item-template">
    <div class="dodocms-w-full dodocms-rounded-lg dodocms-border-[1px] dodocms-border-gray-300 dodocms-relative dodocms-overflow-hidden"
         style="height: 200px;"
         :class="{'dodocms-order-1': selected,'dodocms-order-2': !selected}"
    >
        <img
                class="dodocms-w-full dodocms-h-full"
                :src="src"
                :alt="alternativeText"
                style="background-size: contain; background: url('<?= Application::get()->toURL("/core/assets/imgs/transparent.jpg") ?>'); object-fit: contain; object-position: center;"
        />
        <a v-if="href && href.length > 0" target="_blank" :href="href"
           class="dodocms-absolute dodocms-inset-0 dodocms-flex dodocms-items-center dodocms-justify-center dodocms-opacity-0 hover:dodocms-opacity-100 dodocms-transition dodocms-duration-300 dodocms-ease-in-out dodocms-bg-black dodocms-bg-opacity-25">
            <i class="fas fa-eye dodocms-text-5xl dodocms-text-white dodocms-text-dodocms-opacity-75 hover:dodocms-text-dodocms-opacity-90 dodocms-transition-colors"></i>
        </a>
        <div v-if="(!inEdition && !inUploading())"
             class="dodocms-absolute dodocms-top-0 dodocms-flex dodocms-flex-row dodocms-space-x-1 dodocms-w-full dodocms-p-2">
            <div class="dodocms-me-auto">
                <button
                        v-if="selectable && isSelected()"
                        v-on:click="deselectItem"
                        type="button"
                        class="dodocms-border dodocms-border-white dodocms-border-opacity-75 dodocms-h-8 dodocms-w-8 dodocms-rounded-full dodocms-text-white dodocms-bg-gray-800">
                    <i class="dodocms-text-md fa-solid fa-check"></i>
                </button>
                <button v-else-if="selectable && !isSelected()"
                        v-on:click="selectItem"
                        type="button"
                        class="dodocms-border dodocms-border-white dodocms-border-opacity-60 dodocms-bg-opacity-75 dodocms-text-opacity-75 hover:dodocms-bg-opacity-100 hover:dodocms-text-opacity-100 dodocms-h-8 dodocms-w-8 dodocms-rounded-full dodocms-text-white dodocms-bg-gray-600 hover:dodocms-bg-gray-700">
                    <i class="dodocms-text-md fa-solid fa-check"></i>
                </button>
            </div>
            <button v-if="editable"
                    v-on:click="showEdition"
                    type="button"
                    class="dodocms-text-white dodocms-bg-blue-500 dodocms-h-8 dodocms-w-8 dodocms-rounded-full hover:dodocms-bg-blue-600">
                <i class="dodocms-text-sm fa-solid fa-edit"></i>
            </button>
            <button v-if="deletable"
                    v-on:click="deleteItem"
                    type="button"
                    class="dodocms-text-white dodocms-bg-red-500 dodocms-h-8 dodocms-w-8 dodocms-rounded-full hover:dodocms-bg-red-600">
                <i class="dodocms-text-sm fa-solid fa-trash"></i>
            </button>
            <button v-if="removable"
                    v-on:click="removeItem"
                    type="button"
                    class="dodocms-text-white dodocms-bg-red-500 dodocms-h-8 dodocms-w-8 dodocms-rounded-full hover:dodocms-bg-red-600">
                <i class="dodocms-text-sm fa-solid fa-minus"></i>
            </button>
        </div>
        <div v-if="(inEdition || inUploading())"
             class="dodocms-absolute dodocms-top-0 dodocms-h-full dodocms-flex dodocms-w-full dodocms-bg-opacity-50 dodocms-bg-gray-800 dodocms-backdrop-blur-sm">
        </div>
        <div v-if="(inEdition && !inUploading())"
             class="dodocms-absolute dodocms-top-0 dodocms-h-full dodocms-flex dodocms-w-full dodocms-p-2">
            <div class="dodocms-flex dodocms-flex-col dodocms-mt-auto dodocms-w-full dodocms-h-full">
                <?php Text::create()
                    ->label(__('panel.admin.resource.item.edit.alternativeText') . ' :')
                    ->attribute('v-model', "localAlternativeText")
                    ->name("alternativeText")
                    ->render() ?>
                <div class="dodocms-mt-auto dodocms-flex dodocms-flex-row dodocms-gap-2">
                    <?php
                    Button::create()
                        ->addClass("dodocms-text-sm")
                        ->gray()
                        ->text(__('panel.admin.resource.item.edit.cancel'))
                        ->attribute("v-on:click", 'cancelEdition')
                        ->render()
                    ?>
                    <?php
                    Button::create()
                        ->addClass("dodocms-text-sm dodocms-ms-auto")
                        ->blue()
                        ->text(__('panel.admin.resource.item.edit.save'))
                        ->attribute("v-on:click", 'applyEdition')
                        ->render()
                    ?>
                </div>
            </div>
        </div>
        <div v-if="(!inEdition && inUploading())"
             class="dodocms-absolute dodocms-top-0 dodocms-h-full dodocms-flex dodocms-w-full dodocms-p-2">
            <div class="dodocms-p-2 dodocms-flex dodocms-flex-col dodocms-absolute dodocms-top-0 dodocms-right-0 dodocms-left-0 dodocms-bottom-0 dodocms-bg-black dodocms-bg-opacity-50 dodocms-rounded-lg">
                <div class="dodocms-mt-auto dodocms-w-full dodocms-bg-gray-200 dodocms-rounded-full">
                    <div :style="{ width: uploadProgression + '%' }" class="dodocms-mt-auto dodocms-bg-blue-500 dodocms-rounded-full dodocms-text-xs dodocms-text-center dodocms-text-white">
                        <span class="progress-number">{{ uploadProgression }}</span>%
                    </div>
                </div>
            </div>
        </div>
    </div>
</script>
