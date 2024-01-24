<script type="text/x-template" id="resource-viewer-template">
    <div class="dodocms-relative dodocms-group dodocms-w-full dodocms-bg-gray-700 dodocms-rounded-xl dodocms-border-[1px] dodocms-border-gray-500 dodocms-shadow-lg dodocms-text-white dodocms-outline-none focus:dodocms-border-gray-400 dodocms-mb-1 dodocms-min-h-[400px] dodocms-flex dodocms-flex-col dodocms-overflow-hidden"
         :class="{'dodocms-max-h-[400px]': scrollable}">
        <input type="hidden" :name="name" :value="ids()">
        <div class="dodocms-px-4 dodocms-py-2 dodocms-bg-gray-800 dodocms-localItems-center dodocms-border-b-[1px] dodocms-border-gray-500 dodocms-text-lg dodocms-flex dodocms-flex-row">
            {{ getTitle() }} <span v-show="selectable"
                    class="dodocms-my-auto dodocms-ps-2 dodocms-text-gray-400 dodocms-text-sm">({{ isMultiple() ? "vous pouvez en sélectionner plusieurs" : "vous pouvez en sélectionner uniquement une seule"}})</span>
            <div class="dodocms-ms-auto">
                <button v-if="addable" v-on:click="openResourcesSelectorModal()" type="button"
                        class="dodocms-text-white dodocms-bg-green-600 hover:dodocms-bg-green-700 dodocms-h-8 dodocms-w-8 dodocms-rounded-2xl">
                    <i class="fa-solid fa-plus"></i>
                </button>
                <button v-if="uploadable" v-on:click="openUploadModal()" type="button"
                        class="dodocms-text-white dodocms-bg-indigo-500 hover:dodocms-bg-indigo-600 dodocms-h-8 dodocms-w-8 dodocms-rounded-2xl  dodocms-text-sm">
                    <i class="fa-solid fa-cloud-upload"></i>
                </button>
            </div>
        </div>
        <!-- Single Item -->
        <div v-if="localItems.length === 1"
             class="dodocms-h-full dodocms-w-full dodocms-flex dodocms-flex-1 dodocms-localItems-center dodocms-justify-center dodocms-gap-4">
            <div class="dodocms-m-auto dodocms-w-[400px]">
                <resource-item
                        :key="localItems[0].id"
                        :id="localItems[0].id"
                        :selectable="selectable"
                        :editable="editable"
                        :deletable="deletable"
                        :removable="removable"
                        :src="localItems[0].src"
                        :selected="isSelected(localItems[0])"
                        :href="localItems[0].src"
                        :alternativeText="localItems[0].alternativeText"

                        @toggle="toggleItem($event)"
                        @edit="editItem($event)"
                        @remove="deleteItem($event)"
                        @delete="deleteItem($event)"
                >
                </resource-item>
            </div>
        </div>
        <!-- Multi Items -->
        <div v-if="localItems.length > 1"
             class="dodocms-p-4 dodocms-h-full dodocms-w-full dodocms-grid dodocms-grid-cols-3 dodocms-gap-4"
             :class="{ 'dodocms-overflow-y-auto': scrollable }">
            <resource-item
                    v-for="item in localItems"

                    :key="item.id"
                    :id="item.id"
                    :selectable="selectable"
                    :selected="isSelected(item)"
                    :editable="editable"
                    :deletable="deletable"
                    :removable="removable"
                    :src="item.src"
                    :href="item.src"
                    :alternativeText="item.alternativeText"

                    @toggleSelection="toggleItem"
                    @edit="editItem($event)"
                    @remove="deleteItem($event)"
                    @delete="deleteItem($event)"
            >
            </resource-item>
        </div>
        <span v-if="localItems.length === 0"
              class="dodocms-text-gray-300 dodocms-mx-auto dodocms-m-auto dodocms-text-xl">
            <?= __('admin.panel.resources.empty') ?>
        </span>
        <!--        <div class="dodocms-justify-center dodocms-flex dodocms-flex-row dodocms-p-4">-->
        <!--            <div class="dodocms-flex dodocms-localItems-center dodocms-justify-center">-->
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