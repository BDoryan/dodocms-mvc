Vue.component('resource-item', {
    props: ['item', 'src', 'href', 'alternativeText', 'selectable', 'selected', 'deletable', 'editable'],
    template: '#resource-item-template',
    data() {
        return {
            isSelected: this.selected || false // Use local data property
        };
    },
    methods: {
        selectItem() {
            if (this.selectable) {
                console.log("selected", this)
                this.$emit('toggle', true, this);
                this.isSelected = true; // Update local data property
            }
        },
        deselectItem() {
            if (this.selectable) {
                console.log("selected", this)
                this.$emit('toggle', false, this);
                this.isSelected = false; // Update local data property
            }
        },
        deleteItem() {
            console.log("delete", this.item)
            this.$emit('delete', this.item);
        },
        editItem() {
            console.log("edit", this.item)
            this.$emit('edit', this.item);
        }
    },
    watch: {
        selected(newVal) {
            this.isSelected = newVal || false; // Update local data when prop changes
        }
    }
});
