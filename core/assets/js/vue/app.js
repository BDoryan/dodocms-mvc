console.log('app.js loaded');

new Vue({
    el: '#app',
    data: {
        modals: [],
        toasts: [],
        currentResourceViewer: null
    },
    methods: {
        showToast(toast) {
            this.toasts = [...this.toasts, toast]
            console.log('toast', toast)
        },
        resourcesSelect(resources) {
            console.log('resourcesSelect', resources)
        },
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
    },
    mounted() {
        // this.$on('*', (eventName, eventData) => {
        //     console.log(`Événement capturé : ${eventName}`);
        //     console.log('Données de l\'événement :', eventData);
        // });
        //
        // console.log('mounted')
        // this.$on('resources-uploaded', function (resources) {
        //     console.log('send')
        // });
    }
});

