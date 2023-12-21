Vue.component('resource-viewer', {
    props: ['name', 'items', 'selectable', 'editable', 'deletable', 'removable', 'addable', 'scrollable', 'uploadable', 'multiple', 'itemsSelected'],
    template: '#resource-viewer-template',
    data() {
        return {
            // localItems: this.items ? [...this.items] : [],
            localSelectable: this.selectable ?? false,
            localItemsSelected: this.itemsSelected ?? [],
            localItems: this.items ?? [],
        };
    },
    methods: {
        getItemsSelected() {
            return this.localItemsSelected;
        },
        isSelected(item) {
            return this.getItemsSelected().includes(item.id);
        },
        isMultiple() {
            return this.multiple ?? true;
        },
        openUploadModal() {
            this.$root.$emit('upload-modal-open', this);
        },
        openResourcesSelectorModal() {
            this.$root.$emit('resources-selector-modal-open', this);
        },
        setItems(items) {
            console.log("before", this.localItems)
            this.localItems = items;
            console.log("after", this.localItems)
        },
        listItemsId() {
            return this.localItems.map((el) => el.id);
        },
        ids() {
            return this.listItemsId().join(',');
        },
        toggleItem(toggled, item) {
            if (!this.isMultiple()) {
                this.localItemsSelected = [];
            }

            if (toggled) {
                this.localItemsSelected = [...this.getItemsSelected(), item.id];
            } else {
                this.localItemsSelected = this.getItemsSelected().filter((el) => el !== item.id);
            }
        },
        editItem(item) {
            console.log('edit', item)
        },
        getStatus() {
            return "Aucun status défini";
        },
        getTitle() {
            return this.$root.translate('admin.panel.resources.count', {'count': this.localItems.length});
        },
        addItem(item) {
            if (!this.multiple)
                this.localItems = [];

            this.localItems = [...this.localItems, item];
        },
        deleteItem(id) {
            const index = this.localItems.findIndex((el) => el.id === id);
            if (index > -1) {
                this.$delete(this.localItems, index);
                this.localItems = [...this.localItems];
            }
        }
    }
});