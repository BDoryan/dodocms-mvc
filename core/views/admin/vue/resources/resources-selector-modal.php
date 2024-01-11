<script defer type="module">
    Vue.component('resources-selector-modal', {
        props: ['resources', 'defaultResourcesSelected'],
        template: '#modal-resources-selector',
        data() {
            return {
                multiple: true,
                resourcesSelected: [],
                name: "resources-selector-modal"
            }
        },
        methods: {
            setMultiple(multiple) {
                this.multiple = multiple;
            },
            open(resourcesSelected) {
                this.resourcesSelected = resourcesSelected ?? [];
                this.$root.openModal(this.name);
            },
            close() {
                console.log('close')
                this.$root.closeModal(this.name);
            },
            getResources() {
                return this.resources;
            },
            getResourceById(id) {
                return this.getResources().find((resource) => resource.id == id);
            },
            getSrc(resource) {
                return window.toRoot(resource.src);
            },
            finish() {
                this.close();
                const resources = this.getResources();
                const resourcesFiltered = resources.filter((resource) => this.$refs['ref_ResourceViewerOfResourcesSelector'].isSelected(resource));

                this.$root.$emit("finish-resources-selection", resourcesFiltered);
            },
            toggleSelection(resource, value, component) {
                if (value) {
                    if (!this.multiple)
                        this.resourcesSelected = [resource.id];
                    else
                        this.resourcesSelected.push(resource.id);
                } else {
                    this.resourcesSelected.splice(this.resourcesSelected.indexOf(resource.id), 1);
                }
            }
        },
        mounted() {
            this.resources = this.resources.map((resource) => {
                resource.src = window.toRoot(resource.src);
                return resource;
            });
        }
    })
    ;
</script>
<script type="text/x-template" id="modal-resources-selector">
    <modal name="resources-selector-modal">
        <template v-slot:title>
            <i class='fa-solid fa-cloud-upload dodocms-me-1'></i>
            {{ $root.translate("admin.panel.resources.selector.title") }}
        </template>
        <template v-slot:body>
            <div v-if="resources.length > 0"
                 class="dodocms-py-3 dodocms-pe-3 dodocms-flex dodocms-flex-col dodocms-gap-4">
                <p class="dodocms-text-gray-300 dodocms-m-auto dodocms-text-center">
                    Retrouvez les ressources que vous avez déjà uploadées sur votre serveur. Les resources cochées
                    seront ajoutées à votre contenu.
                </p>
                <resource-viewer :ref="`ref_ResourceViewerOfResourcesSelector`" :items="getResources()"
                                 :itemsSelected="resourcesSelected" :selectable="true" :editable="true"
                                 :multiple="multiple"
                                 :uploadable="false" :deletable="false" :addable="false" :removable="false"
                                 :scrollable="true">
                </resource-viewer>
            </div>
        </template>
        <template v-slot:footer>
            <button type="button"
                    v-on:click="close"
                    class="close-upload-modal dodocms-me-auto dodocms-text-gray-500 dodocms-bg-white hover:dodocms-bg-gray-100 focus:ring-4 focus:dodocms-outline-none focus:ring-blue-300 dodocms-rounded-lg dodocms-border dodocms-border-gray-200 dodocms-text-sm dodocms-font-medium dodocms-px-5 dodocms-py-2.5 hover:dodocms-text-gray-900 focus:dodocms-z-10 dark:dodocms-bg-gray-700 dark:dodocms-text-gray-300 dark:dodocms-border-gray-500 dark:hover:dodocms-text-white dark:hover:dodocms-bg-gray-600 dark:focus:ring-gray-600">
                <?= __("admin.panel.resources.upload.close") ?>
            </button>
            <div class="dodocms-me-auto dodocms-text-white dodocms-opacity-75" id="state">
            </div>
            <button v-on:click="finish"
                    class="dodocms-text-white dodocms-bg-blue-700 hover:dodocms-bg-blue-800 focus:ring-4 focus:dodocms-outline-none focus:ring-blue-300 dodocms-font-medium dodocms-rounded-lg dodocms-text-sm dodocms-px-5 dodocms-py-2.5 dodocms-text-center dark:dodocms-bg-blue-600 dark:hover:dodocms-bg-blue-700 dark:focus:ring-blue-800">
                {{ $root.translate("admin.panel.resources.selector.finish") }}
            </button>
        </template>
    </modal>
</script>