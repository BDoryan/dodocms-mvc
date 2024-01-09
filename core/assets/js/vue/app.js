const loadApplication = () => {
    $(document).ready(function () {
        $('.ckeditor').each(function () {
            CKEDITOR.replace($(this).attr('id'));
        });
    });

    const modals = window.app.modals ?? [];
    const toasts = window.app.toasts ?? [];
    const liveEditor = window.app.liveEditor ?? {
        position: null
    }
    const currentResourceViewer = window.app.currentResourceViewer ?? null;

    window.app = new Vue({
        el: '#app',
        data: {
            modals,
            toasts,
            liveEditor,
            currentResourceViewer,
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

                window.app.$refs.toastContainer.appendChild(toast.$el);
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
            listeners(component = null) {
                if(component == null)
                    component = this;

                component.$on('upload-modal-open', function (resourceViewer) {
                    this.currentResourceViewer = resourceViewer;
                    window.app.$refs['ref_upload_modal'].multiple = resourceViewer.multiple ?? false;
                    window.app.openModal('upload-modal');
                });

                component.$on('resources-selector-modal-open', function (resourceViewer) {
                    this.currentResourceViewer = resourceViewer;
                    const modal = window.app.$refs['ref_resources_selector_modal'];
                    console.log(resourceViewer.multiple)

                    modal.setMultiple(resourceViewer.multiple ?? false);
                    modal.open(resourceViewer.listItemsId())
                });

                component.$on('finish-resources-selection', function (resources) {
                    console.log('resources', resources)
                    this.currentResourceViewer.setItems(resources);
                    this.currentResourceViewer = null;
                });

                component.$on('resources-uploaded', function (resources) {
                    resources.forEach((resource) => {
                        resource.src = window.toRoot(resource.src);
                        this.currentResourceViewer.addItem(resource)
                    })
                    this.currentResourceViewer = null;
                });
            }
        },
        mounted() {
            this.listeners();

            window.showToast = this.showToast;
            window.openModal = this.openModal;

            window.openEntrySet = (ref, ...arguments) => {
                console.log(window.app.$refs[ref].open(...arguments))
            }
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