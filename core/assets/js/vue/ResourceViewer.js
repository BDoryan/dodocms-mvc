Vue.component('resource-viewer', {
    props: ['name', 'items', 'selectable', 'editable', 'deletable', 'removable', 'addable', 'scrollable', 'uploadable'],
    template: '#resource-viewer-template',
    data() {
        return {
            // localItems: this.items ? [...this.items] : [],
            localSelectable: this.selectable ?? false
        };
    },
    methods: {
        openUploadModal() {
            this.$root.openModal('upload-modal');
            console.log('open upload modal', this);
            this.$emit('upload-modal-open', this);
        },
        ids() {
            const ids = this.items.map((el) => el.id);
            return ids.join(',');
        },
        toggleItem(item, toggled) {
            console.log('toggleItem', item, toggled)
        },
        editItem(item) {
            console.log('edit', item)
        },
        getStatus() {
            return "Aucun status défini";
        },
        getTitle() {
            return translate('admin.panel.resources.count', {'count': this.items.length});
        },
        addItem(item) {
            this.items = [...this.items, item];
        },
        deleteItem(id) {
            const index = this.items.findIndex((el) => el.id === id);
            if (index > -1) {
                this.$delete(this.items, index);
                this.items = [...this.items];
            }
        }
    }
});