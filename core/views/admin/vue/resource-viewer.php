<script type="text/x-template" id="resource-viewer-template">
    <div class="dodocms-my-3 dodocms-relative dodocms-group dodocms-w-full dodocms-bg-gray-700 dodocms-px-3 dodocms-py-2 dodocms-border dodocms-border-gray-500 dodocms-rounded-md dodocms-text-white dodocms-outline-none focus:dodocms-border-gray-400 dodocms-mb-1 dodocms-min-h-[400px] dodocms-flex dodocms-flex-col dodocms-overflow-hidden">
        <div class="dodocms-grid dodocms-grid-cols-3 dodocms-gap-4">
            <resource-item
                v-for="item in localItems"
                :key="item.id"
                :item="item"
                :selectable="true"
                :editable="true"
                :deletable="true"
                :src="'/dodocms-mvc/storage/resources/quote_2023-12-04_23-12-42.png'"
                :href="'google.com'"
                :alternativeText="'Test'"
                @toggle="selectItem($event)"
                @edit="editItem($event)"
                @delete="deleteItem($event)"
            >
            </resource-item>
        </div>
    </div>
</script>
