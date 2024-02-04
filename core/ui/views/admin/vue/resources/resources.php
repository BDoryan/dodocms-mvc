<script defer type="module">
    Vue.component('resources', {
        props: ['resources'],
        template: '#resources-template',
        data() {
            return {
                localResources: this.resources ?? []
            }
        },
        methods: {
            addResource(resource) {
                resource.src = window.toRoot(resource.src);
                this.$refs['ref__resources_viewer'].addItem(resource);
            },
            openModal() {
                this.$root.openModal('upload-modal')
                console.log('open modal')
            }
        },
        mounted() {
            this.$root.$on('resourceUploaded', this.addResource);
        }
    });
</script>
<script type="text/x-template" id="resources-template">
    <div>
        <?php
        Header::create()
            ->template('/core/ui/views/admin/components')
            ->title(__('admin.panel.resources.title'))
            ->description(__('admin.panel.resources.description'))
            ->content(
                '<div class="tw-flex tw-flex-row">' .
                Button::create()
                    ->blue()
                    ->attribute('v-on:click', "openModal")
                    ->text('<i class="fa-solid fa-cloud-upload tw-me-1"></i> ' . __('admin.panel.dashboard.button.upload_file'))
                    ->html()
                . '</div>'
            )
            ->render();
        ?>
        <resource-viewer :multiple="true" :ref="`ref__resources_viewer`" :deletable="true" :editable="true"  :addable="false" :removable="false" :uploadable="false" :selectable="false"
                         :items="localResources"></resource-viewer>
    </div>
</script>