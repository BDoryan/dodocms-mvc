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
            <i class='fa-solid fa-file-alt dodocms-me-1'></i> Définir une ressource à cet élément
        </template>
        <template v-slot:body>
            <p>Visualisez la resource actuellement appliqué, si rien de défini c'est celle par défaut qui est utilisé.</p>
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
                    class="close-upload-modal dodocms-me-auto dodocms-text-gray-500 dodocms-bg-white hover:dodocms-bg-gray-100 focus:ring-4 focus:dodocms-outline-none focus:ring-blue-300 dodocms-rounded-lg dodocms-border dodocms-border-gray-200 dodocms-text-sm dodocms-font-medium dodocms-px-5 dodocms-py-2.5 hover:dodocms-text-gray-900 focus:dodocms-z-10 dark:dodocms-bg-gray-700 dark:dodocms-text-gray-300 dark:dodocms-border-gray-500 dark:hover:dodocms-text-white dark:hover:dodocms-bg-gray-600 dark:focus:ring-gray-600">
                Cancel
            </button>
            <button v-on:click="submit()" class="dodocms-text-white dodocms-bg-blue-700 hover:dodocms-bg-blue-800 focus:ring-4 focus:dodocms-outline-none focus:ring-blue-300 dodocms-font-medium dodocms-rounded-lg dodocms-text-sm dodocms-px-5 dodocms-py-2.5 dodocms-text-center dark:dodocms-bg-blue-600 dark:hover:dodocms-bg-blue-700 dark:focus:ring-blue-800">
                Apply this resource
            </button>
        </template>
    </modal>
</script>