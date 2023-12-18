Vue.component('resource-viewer', {
    props: ['items', 'selectable', 'editable', 'deletable'],
    template: '#resource-viewer-template',
    data() {
        return {
            // localItems: this.items ? [...this.items] : [],
            localSelectable: this.selectable ?? false
        };
    },
    methods: {
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
        deleteItem(id) {
            const index = this.items.findIndex((el) => el.id === id);
            if (index > -1) {
                this.$delete(this.items, index);
                this.items = [...this.items];
            }
        }
    }
});