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
            ->template('/core/ui/views/admin/components')
            ->title(__('admin.panel.resources.title'))
            ->description(__('admin.panel.resources.description'))
            ->content(
                '<div class="dodocms-flex dodocms-flex-row">' .
                Button::create()
                    ->blue()
                    ->attribute('v-on:click', "openModal")
                    ->text('<i class="fa-solid fa-cloud-upload dodocms-me-1"></i> ' . __('admin.panel.dashboard.button.upload_file'))
                    ->html()
                . '</div>'
            )
            ->render();
        ?>
        <resource-viewer :deletable="true" :editable="true"  :addable="false" :removable="false" :uploadable="false" :selectable="false"
                         :items="localResources"></resource-viewer>
        <modal-upload @resourceUploaded="addResource" @finishUpload="" :multiple="true"></modal-upload>
    </div>
</script>