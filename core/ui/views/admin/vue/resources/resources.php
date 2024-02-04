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
        <resource-viewer :deletable="true" :editable="true"  :addable="false" :removable="false" :uploadable="false" :selectable="false"
                         :items="localResources"></resource-viewer>
        <modal-upload @resourceUploaded="addResource" @finishUpload="" :multiple="true"></modal-upload>
    </div>
</script>