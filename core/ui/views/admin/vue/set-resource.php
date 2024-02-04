<script defer type="module">
    Vue.component('set-resource-modal', {
        props: ['name'],
        template: '#set-resource-modal-template',
        data() {
            return {
                resources: [],
                callback: (resource) => {}
            }
        },
        methods: {
            setResourceId(resource_id) {
                if(resource_id == null) {
                    this.resources = [];
                    return;
                }

                const resource = window.app.$refs['ref_resources_selector_modal'].getResourceById(resource_id);
                this.resources = [resource];
            },
            close() {
                window.app.closeModal('set-resource-modal')
                this.setResourceId(null)
            },
            submit() {
                const resourceViewer = this.$refs['ref_ResourceViewerOfSetResource'];

                const resource_id = resourceViewer.getItems()[0];
                console.log('resource_id', resource_id)
                this.callback(resource_id);

                this.close();
            },
            open(callback = null, resource_id = null) {
                this.setResourceId(resource_id)
                this.callback = callback;
                this.$root.openModal('set-resource-modal')
            }
        },
        mounted() {
            this.resources = this.resources.map((resource) => {
                resource.src = window.toRoot(resource.src);
                return resource;
            });
        }
    });
</script>
<script type="text/x-template" id="set-resource-modal-template">
    <modal name="set-resource-modal">
        <template v-slot:title>
            <i class='fa-solid fa-file-alt tw-me-1'></i> <?= __('admin.panel.set.resource.title') ?>
        </template>
        <template v-slot:body>
            <p><?= __('admin.panel.resources.set.resource.text') ?></p>
            <resource-viewer :ref="`ref_ResourceViewerOfSetResource`" :items="resources"
                             :itemsSelected="resourcesSelected"
                             :selectable="false"
                             :editable="true"
                             :multiple="false"
                             :uploadable="true"
                             :deletable="false"
                             :addable="true"
                             :removable="true"
                             :scrollable="true">
            </resource-viewer>
        </template>
        <template v-slot:footer>
            <button type="button"
                    v-on:click="close"
                    class="close-upload-modal tw-me-auto tw-text-gray-500 tw-bg-white hover:tw-bg-gray-100 focus:ring-4 focus:tw-outline-none focus:ring-blue-300 tw-rounded-lg tw-border tw-border-gray-200 tw-text-sm tw-font-medium tw-px-5 tw-py-2.5 hover:tw-text-gray-900 focus:tw-z-10 dark:tw-bg-gray-700 dark:tw-text-gray-300 dark:tw-border-gray-500 dark:hover:tw-text-white dark:hover:tw-bg-gray-600 dark:focus:ring-gray-600">
                <?= __('admin.panel.set.resource.cancel') ?>
            </button>
            <button v-on:click="submit()" class="tw-text-white tw-bg-blue-700 hover:tw-bg-blue-800 focus:ring-4 focus:tw-outline-none focus:ring-blue-300 tw-font-medium tw-rounded-lg tw-text-sm tw-px-5 tw-py-2.5 tw-text-center dark:tw-bg-blue-600 dark:hover:tw-bg-blue-700 dark:focus:ring-blue-800">
                <?= __('admin.panel.set.resource.apply') ?>
            </button>
        </template>
    </modal>
</script>