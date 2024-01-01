Vue.component('resource-item', {
    props: ['id', 'src', 'href', 'alternativeText', 'selectable', 'selected', 'deletable', 'editable', 'removable'],
    template: '#resource-item-template',
    data() {
        return {
            originalAlternativeText: '',
            localAlternativeText: this.alternativeText ?? '',
            inEdition: false,
            uploadProgression: null
        };
    },
    methods: {
        isSelected() {
            return this.selected ?? false;
        },
        selectItem() {
            if (this.selectable) {
                this.$emit('toggleSelection', true, this);
            }
        },
        deselectItem() {
            if (this.selectable) {
                this.$emit('toggleSelection', false, this);
            }
        },
        removeItem() {
            const resourceItem = this;
            resourceItem.$emit('remove', resourceItem.id);
        },
        deleteItem() {
            const id = this.id;
            const resourceItem = this;

            if (id) {
                $.ajax({
                    url: window.toApi("/resources/delete") + '/' + id,
                    type: "DELETE",
                    success: function (data) {
                        if (data.status === "success") {
                            let toast = new Toast(window.translate('admin.panel.resources.title'), window.translate('admin.panel.resources.deleted'), "success", 5000);
                            toast.render();
                            resourceItem.$emit('delete', resourceItem.id);
                        } else {
                            let toast = new Toast(window.translate('error.message'), window.translate('admin.panel.resources.delete.error.' + data.message, {'file_name': data.data.file_name}), "error", 15000);
                            toast.render();
                        }
                    }
                });
            } else {
                resourceItem.$emit('delete', resourceItem.id);
            }
        },
        inUploading() {
            return this.uploadProgression != null;
        },
        updateProgression(progress) {
            this.uploadProgression = progress;
        },
        showEdition() {
            this.inEdition = true;
            this.originalAlternativeText = this.localAlternativeText;
        },
        hideEdition() {
            this.inEdition = false;
        },
        cancelEdition() {
            this.hideEdition();

            this.localAlternativeText = this.originalAlternativeText;
            this.originalAlternativeText = '';
        },
        applyEdition() {
            this.hideEdition();

            const alternativeText = this.localAlternativeText;

            const id = this.id;

            if (id) {
                $.ajax({
                    url: window.toApi("/resources/edit") + '/' + id,
                    type: "PUT",
                    data: {
                        alternativeText
                    },
                    success: function (data) {
                        if (data.status === "success") {
                            let toast = new Toast(window.translate('admin.panel.resources.title'), window.translate('admin.panel.resources.edited'), "success", 5000);
                            toast.render();
                        } else {
                            let toast = new Toast(window.translate('error.message'), data.message, "error", 15000);
                            toast.render();
                        }
                    }
                });
            } else {
                this.$emit('alternativeTextChange', alternativeText);
            }
        }
    },
});
