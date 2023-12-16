import Toast from "../components/toast/Toast.js";

Vue.component('resource-item', {
    props: ['item', 'id', 'src', 'href', 'alternativeText', 'selectable', 'selected', 'deletable', 'editable'],
    template: '#resource-item-template',
    data() {
        return {
            originalAlternativeText: '',
            localAlternativeText: this.alternativeText ?? '',
            isSelected: this.selected || false,
            inEdition: false
        };
    },
    methods: {
        selectItem() {
            if (this.selectable) {
                this.$emit('toggle', true, this);
                this.isSelected = true;
            }
        },
        deselectItem() {
            if (this.selectable) {
                this.$emit('toggle', false, this);
                this.isSelected = false;
            }
        },
        deleteItem() {
            const translations = DODOCMS_APPLICATION.getI18n();
            const id = this.id;
            const resourceItem = this;

            $.ajax({
                url: DODOCMS_APPLICATION.toApi("/resources/delete") + '/' + id,
                type: "DELETE",
                success: function (data) {
                    if (data.status === "success") {
                        let toast = new Toast(translations.translate('admin.panel.resources.title'), translations.translate('admin.panel.resources.deleted'), "success", 5000);
                        toast.render();
                        resourceItem.$emit('delete', resourceItem.id);
                    } else {
                        let toast = new Toast(translations.translate('error.message'), translations.translate('admin.panel.resources.delete.error.' + data.message, {'file_name': data.data.file_name}), "danger", 15000);
                        toast.render();
                    }
                }
            });
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

            const translations = DODOCMS_APPLICATION.getI18n();
            const alternativeText = this.localAlternativeText;

            const id = this.id;

            $.ajax({
                url: DODOCMS_APPLICATION.toApi("/resources/edit") + '/' + id,
                type: "PUT",
                data: {
                    alternativeText
                },
                success: function (data) {
                    if (data.status === "success") {
                        let toast = new Toast(translations.translate('admin.panel.resources.title'), translations.translate('admin.panel.resources.edited'), "success", 5000);
                        toast.render();
                    } else {
                        let toast = new Toast(translations.translate('error.message'), data.message, "danger", 15000);
                        toast.render();
                    }
                }
            });
        }
    },
    watch: {
        selected(newVal) {
            this.isSelected = newVal || false; // Update local data when prop changes
        }
    }
});
