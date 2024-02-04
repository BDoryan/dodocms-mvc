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
            <i class='fa-solid fa-cloud-upload tw-me-1'></i>
            {{ $root.translate("admin.panel.resources.selector.title") }}
        </template>
        <template v-slot:body>
            <div v-if="resources.length > 0"
                 class="tw-py-3 tw-pe-3 tw-flex tw-flex-col tw-gap-4">
                <p class="tw-text-gray-500 tw-m-auto tw-text-center">
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
<!--            <button type="button"-->
<!--                    v-on:click="close"-->
<!--                    class="close-upload-modal tw-me-auto tw-text-gray-500 tw-bg-white hover:tw-bg-gray-100 focus:ring-4 focus:tw-outline-none focus:ring-blue-300 tw-rounded-lg tw-border tw-border-gray-200 tw-text-sm tw-font-medium tw-px-5 tw-py-2.5 hover:tw-text-gray-900 focus:tw-z-10 dark:tw-bg-gray-700 dark:tw-text-gray-300 dark:tw-border-gray-500 dark:hover:tw-text-white dark:hover:tw-bg-gray-600 dark:focus:ring-gray-600">-->
<!--                --><?php //= __("admin.panel.resources.upload.close") ?>
<!--            </button>-->
            <?php
            Button::create()
                ->type('button')
                ->attribute('v-on:click', 'close')
                ->addClass('close-upload-modal')
                ->text(__('admin.panel.resources.upload.close'))
                ->render()
            ?>
            <div class="tw-me-auto tw-text-white tw-opacity-75" id="state">
            </div>
            <?php
            Button::create()
                ->type('finish')
                ->attribute('v-on:click', 'close')
                ->text(__('admin.panel.resources.selector.finish'))
                ->blue()
                ->render()
            ?>
        </template>
    </modal>
</script>