const loadApplication = () => {
    $(document).ready(function () {
        $('.ckeditor').each(function () {
            CKEDITOR.replace($(this).attr('id'));
        });
    });

    new Vue({
        el: '#app',
        data: {
            modals: [],
            toasts: [],
            liveEditor: {
                position: null
            },
            currentResourceViewer: null
        },
        methods: {
            showBlocksModal(position) {
                this.setPosition(position);
                this.openModal('blocks-modal');
            },
            setPosition(position) {
                this.liveEditor.position = position;
            },
            addBlock(block_id) {
                const page_id = $(this.$root.$el).attr('page-id')

                console.log('liveEditor.position', this.liveEditor.position)
                console.log('page_id', page_id)
                console.log('add block', block_id);

                const data = {
                    block_id,
                    block_position: this.liveEditor.position,
                    page_id
                }

                $.ajax({
                    url: window.toApi("/pages/add/"),
                    method: "POST",
                    data,
                    success: function (response) {
                        reloadPage(() => {
                            window.showToast(new Toast(window.translate(`live-editor.structure.add.toast.${response.status}`), window.translate(`live-editor.structure.add.toast.${response.message}`), response.status, 5000))
                        });
                    },
                    error: function (response) {
                        window.showToast(new Toast(window.translate(`live-editor.structure.add.toast.${response.status}`), window.translate(`live-editor.structure.add.toast.${response.message}`), response.status, 5000))
                       }
                });
            },
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
                this.modals = [...this.modals, name]
            },
            closeModal(name) {
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
}

loadApplication();

window.reloadPage = async (callback) => {
    $(document.body).load(location.href + " #app", () => {
        loadApplication()
        loadLiveEditor();
        callback();
    });
};
