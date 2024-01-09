<script defer type="module">
    // const vm = new Vue();

    Vue.component('set-entry-modal', {
        props: ['name'],
        template: '#set-entry-modal-template',
        data() {
            return {
                entry_id: null,
                model_name: "",
                form: ""
            }
        },
        methods: {
            close() {
                this.entry_id = null;
                this.model_name = "";

                window.app.closeModal('set-entry-modal')
            },
            open(model_name, id = null) {
                const self = this;

                this.model_name = model_name
                this.entry_id = id;

                let data = {}
                if (id != null)
                    data = {
                        id: id
                    }

                $.ajax({
                    url: window.toApi("/entries/form/") + model_name,
                    method: "GET",
                    data,

                    success: function (response) {
                        self.renderComponent(response);
                    }
                });

                this.$root.openModal('set-entry-modal')
            },
            submit() {
                const self = this;

                const form = $('.form-content form');
                const formData = new FormData(form[0]);

                // fetch form data
                $.ajax({
                    url: window.toApi("/entries/set/") + this.model_name,
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,

                    success: function (response) {
                        reloadPage(() => {
                            self.close();
                            window.showToast(new Toast(window.translate(`live-editor.entries.new.toast.${response.status}`), window.translate(`live-editor.entries.new.toast.${response.message}`), response.status, 5000))
                        })
                    },
                    error: function (response) {
                        window.showToast(new Toast(window.translate(`live-editor.entries.new.toast.${response.status}`), window.translate(`live-editor.entries.new.toast.${response.message}`), response.status, 5000))
                    }
                });
            },
            async renderComponent(response) {
                $('.form-content').html(response);

                const root = this.$root;

                new Vue({
                    el: ".form-content",
                    methods: {
                        translate: window.translate,
                    },
                    data: root.$data,
                    mounted() {
                        root.listeners(this)
                    }
                })
            }
        }
    });
</script>
<script type="text/x-template" id="set-entry-modal-template">
    <modal name="set-entry-modal">
        <template v-slot:title>
            <i class='fa-solid fa-cloud-upload dodocms-me-1'></i> PREPARING
        </template>
        <template v-slot:body>
            <div class="form-content"></div>
            <!--            <div v-html="form"></div>-->
        </template>
        <template v-slot:footer>
            <button type="button"
                    v-on:click="close"
                    class="close-upload-modal dodocms-me-auto dodocms-text-gray-500 dodocms-bg-white hover:dodocms-bg-gray-100 focus:ring-4 focus:dodocms-outline-none focus:ring-blue-300 dodocms-rounded-lg dodocms-border dodocms-border-gray-200 dodocms-text-sm dodocms-font-medium dodocms-px-5 dodocms-py-2.5 hover:dodocms-text-gray-900 focus:dodocms-z-10 dark:dodocms-bg-gray-700 dark:dodocms-text-gray-300 dark:dodocms-border-gray-500 dark:hover:dodocms-text-white dark:hover:dodocms-bg-gray-600 dark:focus:ring-gray-600">
                Cancel
            </button>
            <button v-on:click="submit()"
                    class="dodocms-text-white dodocms-bg-blue-700 hover:dodocms-bg-blue-800 focus:ring-4 focus:dodocms-outline-none focus:ring-blue-300 dodocms-font-medium dodocms-rounded-lg dodocms-text-sm dodocms-px-5 dodocms-py-2.5 dodocms-text-center dark:dodocms-bg-blue-600 dark:hover:dodocms-bg-blue-700 dark:focus:ring-blue-800">
                Create new entry
            </button>
        </template>
    </modal>
</script>