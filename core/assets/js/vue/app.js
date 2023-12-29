new Vue({
    el: '#app',
    data: {
        modals: [],
        toasts: [],
        currentResourceViewer: null
    },
    methods: {
        showToast(data) {
            const toast = new Vue({
                el: document.createElement('div'),
                data() {
                    return data;
                },
                template: `
                  <toast
                      :title="title"
                      :message="message"
                      :duration="duration"
                      :type="type"
                  ></toast>
                `,
            });

            this.$refs.toastContainer.appendChild(toast.$el);
        },
        openModal(name) {
            console.log(this.modals, name)
            this.modals = [...this.modals, name]
        },
        closeModal(name) {
            console.log(this.modals, name)
            this.modals = this.modals.filter(modal => modal !== name);
        },
        modalIsOpen(name) {
            return this.modals.includes(name);
        },
        translate(key, replaces) {
            return window.translate(key, replaces);
        },
    },
    mounted() {
        this.$on('upload-modal-open', function (resourceViewer) {
            this.currentResourceViewer = resourceViewer;
            this.$refs['ref_upload_modal'].multiple = resourceViewer.multiple ?? false;
            this.$root.openModal('upload-modal');
        });

        this.$on('resources-selector-modal-open', function (resourceViewer) {
            this.currentResourceViewer = resourceViewer;
            const modal = this.$refs['ref_resources_selector_modal'];
            console.log(resourceViewer.multiple)

            modal.setMultiple(resourceViewer.multiple ?? false);
            modal.open(resourceViewer.listItemsId())
        });

        this.$on('finish-resources-selection', function (resources) {
            console.log('resources', resources)
            this.currentResourceViewer.setItems(resources);
            this.currentResourceViewer = null;
        });

        this.$on('resources-uploaded', function (resources) {
            resources.forEach((resource) => {
                resource.src = window.toRoot(resource.src);
                this.currentResourceViewer.addItem(resource)
            })
            this.currentResourceViewer = null;
        });

        window.showToast = this.showToast;
    }
});

