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
            this.localItems = items;
        },
        getItems() {
            return this.localItems;
        },
        getItemById(id) {
            return this.localItems.find((el) => el.id === id);
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
        },
        getStatus() {
            return "Aucun status défini";
        },
        getTitle() {
            return this.$root.translate('admin.panel.resources.count', {'count': this.localItems.length});
        },
        addItem(item, prepend = false) {
            if (!this.multiple)
                this.localItems = [];

            if(prepend)
                this.localItems = [...this.localItems, item];
            else
                this.localItems = [item, ...this.localItems];
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