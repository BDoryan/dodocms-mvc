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
                resource.src = DODOCMS_APPLICATION.toRoot(resource.src);
                // push to top of array
                this.localResources = [resource, ...this.localResources];
                console.log('add resources', this.localResources)
            },
            openModal() {
                this.$root.openModal('upload-modal')
            }
        }
    });
</script>
<script type="text/x-template" id="resources-template">
    <div>
        <?php
        Header::create()
            ->template('/core/views/admin/components')
            ->title(__('admin.panel.resources.title'))
            ->description(__('admin.panel.resources.description'))
            ->content(
                '<div class="dodocms-flex dodocms-flex-row">' .
                Button::create()
                    ->blue()
                    ->attribute('@click', "openModal")
                    ->text('<i class="fa-solid fa-cloud-upload dodocms-me-1"></i> ' . __('admin.panel.dashboard.button.upload_file'))
                    ->html()
                . '</div>'
            )
            ->render();
        ?>
        <resource-viewer :deletable="true" :editable="true" :selectable="false"
                         :items="localResources"></resource-viewer>
        <modal-upload @resourceUploaded="addResource" @finishUpload="" :multiple="true"></modal-upload>
    </div>
</script>