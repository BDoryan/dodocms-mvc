Vue.component('resource-viewer', {
    props: ['items'],
    template: '#resource-viewer-template',
    data() {
        return {
            localItems: this.items ? [...this.items] : [] // Copie de la prop items comme donnée locale
        };
    },
    methods: {
        editItem: (item) => {
            console.log('edit', item)
        },
        deleteItem(item) {
            console.log(this.localItems, item)
            const index = this.localItems.indexOf(item);
            console.log('delete', index)
            if (index > -1) {
                this.$delete(this.localItems, index);
                this.localItems = [...this.localItems];
            }
        }
    }
});