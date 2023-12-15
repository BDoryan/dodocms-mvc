<script type="text/x-template" id="resource-item-template">
    <div class="dodocms-w-full dodocms-rounded-lg dodocms-border-[1px] dodocms-border-gray-300 dodocms-relative dodocms-overflow-hidden"
         style="height: 200px;">
        <img
                class="dodocms-w-full dodocms-h-full"
                :src="src"
                :alt="alternativeText"
                style="background-size: contain; background: url('<?= Application::get()->toURL("/core/assets/imgs/transparent.jpg") ?>'); object-fit: contain; object-position: center;"
        />
        <a target="_blank" :href="href"
           class="dodocms-absolute dodocms-inset-0 dodocms-flex dodocms-items-center dodocms-justify-center dodocms-opacity-0 hover:dodocms-opacity-100 dodocms-transition dodocms-duration-300 dodocms-ease-in-out dodocms-bg-black dodocms-bg-opacity-25">
            <i class="fas fa-eye dodocms-text-5xl dodocms-text-white dodocms-text-dodocms-opacity-75 hover:dodocms-text-dodocms-opacity-90 dodocms-transition-colors"></i>
        </a>
        <div class="dodocms-absolute dodocms-top-0 dodocms-flex dodocms-flex-row dodocms-space-x-1 dodocms-w-full dodocms-p-2">
            <div class="dodocms-me-auto">
                <button
                        v-if="selectable && isSelected"
                        @click="deselectItem"
                        type="button"
                        class="dodocms-border dodocms-border-white dodocms-border-opacity-75 dodocms-h-8 dodocms-w-8 dodocms-rounded-full dodocms-text-white dodocms-bg-gray-800">
                    <i class="dodocms-text-md fa-solid fa-check"></i>
                </button>
                <button v-else-if="selectable && !isSelected"
                        @click="selectItem"
                        type="button"
                        class="dodocms-border dodocms-border-white dodocms-border-opacity-60 dodocms-h-8 dodocms-w-8 dodocms-rounded-full dodocms-text-white dodocms-bg-gray-800 dodocms-bg-opacity-60 hover:dodocms-bg-opacity-70">
                    <i class="dodocms-text-md fa-solid fa-check"></i>
                </button>
            </div>
            <button v-if="editable"
                    @click="editItem"
                    type="button"
                    class="dodocms-text-white dodocms-bg-blue-500 dodocms-h-8 dodocms-w-8 dodocms-rounded-full hover:dodocms-bg-blue-600">
                <i class="dodocms-text-sm fa-solid fa-edit"></i>
            </button>
            <button v-if="deletable"
                    @click="deleteItem"
                    type="button"
                    class="delete dodocms-text-white dodocms-bg-red-500 dodocms-h-8 dodocms-w-8 dodocms-rounded-full hover:dodocms-bg-red-600">
                <i class="dodocms-text-sm fa-solid fa-trash"></i>
            </button>
        </div>
    </div>
</script>