new Vue({
    el: '#app',
    data: {
        modals: []
    },
    methods: {
        openModal(name) {
            this.modals = [...this.modals, name]
            console.log('open', name)
        },
        closeModal(name) {
            this.modals = this.modals.filter(modal => modal !== name);
            console.log('close', name)
        },
        modalIsOpen(name) {
            return this.modals.includes(name);
        }
    }
});