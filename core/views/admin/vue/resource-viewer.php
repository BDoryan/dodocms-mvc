<script type="text/x-template" id="resource-viewer-template">
    <div class="dodocms-relative dodocms-group dodocms-w-full dodocms-bg-gray-600 dodocms-rounded-xl dodocms-border-[1px] dodocms-border-gray-500 dodocms-shadow-lg dodocms-text-white dodocms-outline-none focus:dodocms-border-gray-400 dodocms-mb-1 dodocms-min-h-[400px] dodocms-flex dodocms-flex-col dodocms-overflow-hidden">
        <div class="dodocms-px-4 dodocms-py-2 dodocms-bg-gray-700 dodocms-border-b-[1px] dodocms-border-gray-500 dodocms-text-lg">
            {{ getTitle() }}
        </div>
        <div v-if="localItems.length > 0" class="dodocms-p-4 dodocms-h-full dodocms-w-full dodocms-grid dodocms-grid-cols-4 dodocms-gap-4">
            <resource-item
                    v-for="item in localItems"

                    :key="item.id"
                    :id="item.id"
                    :selectable="selectable"
                    :editable="editable"
                    :deletable="deletable"
                    :src="item.src"
                    :href="item.src"
                    :alternativeText="item.alternativeText"

                    @toggle="toggleItem($event)"
                    @edit="editItem($event)"
                    @delete="deleteItem($event)"
            >
            </resource-item>
        </div>
        <span v-if="localItems.length === 0"
          class="dodocms-text-gray-300 dodocms-mx-auto dodocms-m-auto dodocms-text-xl">
            <?= __('admin.panel.resources.empty') ?>
        </span>
<!--        <div class="dodocms-justify-center dodocms-flex dodocms-flex-row dodocms-p-4">-->
<!--            <div class="dodocms-flex dodocms-items-center dodocms-justify-center">-->
<!--                <nav class="dodocms-flex dodocms-rounded-md dodocms-shadow-md dodocms-border dodocms-border-gray-400">-->
<!--                    <a href="#" class="dodocms-px-3 dodocms-py-2 dodocms-bg-gray-600 hover:dodocms-bg-gray-500 dodocms-rounded-l-md">-->
<!--                        Previous-->
<!--                    </a>-->
<!--                    <a href="#" class="dodocms-px-3 dodocms-py-2 dodocms-bg-gray-700 hover:dodocms-bg-gray-500">-->
<!--                        1-->
<!--                    </a>-->
<!--                    <a href="#" class="dodocms-px-3 dodocms-py-2 dodocms-bg-gray-700 hover:dodocms-bg-gray-500">-->
<!--                        2-->
<!--                    </a>-->
<!--                    <a href="#" class="dodocms-px-3 dodocms-py-2 dodocms-bg-gray-700 hover:dodocms-bg-gray-500">-->
<!--                        3-->
<!--                    </a>-->
<!--                    <span class="dodocms-px-3 dodocms-py-2 dodocms-bg-gray-700">...</span>-->
<!--                    <a href="#" class="dodocms-px-3 dodocms-py-2 dodocms-bg-gray-700 hover:dodocms-bg-gray-500">-->
<!--                        10-->
<!--                    </a>-->
<!--                    <a href="#" class="dodocms-px-3 dodocms-py-2 dodocms-bg-gray-600 hover:dodocms-bg-gray-500 dodocms-rounded-r-md">-->
<!--                        Next-->
<!--                    </a>-->
<!--                </nav>-->
<!--            </div>-->
<!--        </div>-->
        <!--        <span v-if="localItems.length > 0" class="dodocms-text-gray-300 dodocms-pt-4 dodocms-mx-auto">{{ getStatus() }}</span>-->
    </div>
</script>