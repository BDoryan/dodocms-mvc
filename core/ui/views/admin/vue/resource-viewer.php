<script type="text/x-template" id="resource-viewer-template">
    <div class="tw-relative tw-group tw-w-full tw-border-[1px] tw-border-gray-700 tw-border-opacity-25 tw-text-gray-600 tw-bg-white tw-rounded-lg tw-shadow-sm tw-outline-none focus:tw-border-gray-400 tw-mb-1 tw-min-h-[400px] tw-flex tw-flex-col tw-overflow-hidden"
         :class="{'tw-max-h-[400px]': scrollable}">
        <input type="hidden" :name="name" :value="ids()">
        <div class="tw-bg-gray-900 tw-bg-opacity-5 tw-px-4 tw-py-2 tw-localItems-center tw-border-b-[1px] tw-border-gray-300 tw-text-lg tw-flex tw-flex-row">
            {{ getTitle() }} <span v-show="selectable"
                    class="tw-my-auto tw-ps-2 tw-text-sm">({{ isMultiple() ? "vous pouvez en sélectionner plusieurs" : "vous pouvez en sélectionner uniquement une seule"}})</span>
            <div class="tw-ms-auto">
                <button v-if="addable" v-on:click="openResourcesSelectorModal()" type="button"
                        class="tw-text-white tw-bg-green-600 hover:tw-bg-green-700 tw-h-8 tw-w-8 tw-rounded-2xl">
                    <i class="fa-solid fa-plus"></i>
                </button>
                <button v-if="uploadable" v-on:click="openUploadModal()" type="button"
                        class="tw-text-white tw-bg-indigo-500 hover:tw-bg-indigo-600 tw-h-8 tw-w-8 tw-rounded-2xl  tw-text-sm">
                    <i class="fa-solid fa-cloud-upload"></i>
                </button>
            </div>
        </div>
        <!-- Single Item -->
        <div v-if="localItems.length === 1"
             class="tw-h-full tw-w-full tw-flex tw-flex-1 tw-localItems-center tw-justify-center tw-gap-4">
            <div class="tw-m-auto tw-w-[400px]">
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
             class="tw-p-4 tw-h-full tw-w-full tw-grid tw-grid-cols-3 tw-gap-4"
             :class="{ 'tw-overflow-y-auto': scrollable }">
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
              class="tw-text-gray-500 tw-mx-auto tw-m-auto tw-text-xl">
            <?= __('admin.panel.resources.empty') ?>
        </span>
        <!--        <div class="tw-justify-center tw-flex tw-flex-row tw-p-4">-->
        <!--            <div class="tw-flex tw-localItems-center tw-justify-center">-->
        <!--                <nav class="tw-flex tw-rounded-md tw-shadow-md tw-border tw-border-gray-400">-->
        <!--                    <a href="#" class="tw-px-3 tw-py-2 tw-bg-gray-600 hover:tw-bg-gray-500 tw-rounded-l-md">-->
        <!--                        Previous-->
        <!--                    </a>-->
        <!--                    <a href="#" class="tw-px-3 tw-py-2 tw-bg-gray-700 hover:tw-bg-gray-500">-->
        <!--                        1-->
        <!--                    </a>-->
        <!--                    <a href="#" class="tw-px-3 tw-py-2 tw-bg-gray-700 hover:tw-bg-gray-500">-->
        <!--                        2-->
        <!--                    </a>-->
        <!--                    <a href="#" class="tw-px-3 tw-py-2 tw-bg-gray-700 hover:tw-bg-gray-500">-->
        <!--                        3-->
        <!--                    </a>-->
        <!--                    <span class="tw-px-3 tw-py-2 tw-bg-gray-700">...</span>-->
        <!--                    <a href="#" class="tw-px-3 tw-py-2 tw-bg-gray-700 hover:tw-bg-gray-500">-->
        <!--                        10-->
        <!--                    </a>-->
        <!--                    <a href="#" class="tw-px-3 tw-py-2 tw-bg-gray-600 hover:tw-bg-gray-500 tw-rounded-r-md">-->
        <!--                        Next-->
        <!--                    </a>-->
        <!--                </nav>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--        <span v-if="localItems.length > 0" class="tw-text-gray-300 tw-pt-4 tw-mx-auto">{{ getStatus() }}</span>-->
    </div>
</script>