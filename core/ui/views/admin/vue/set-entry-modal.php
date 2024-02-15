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

                // get instance of ckeditor 5
                const instance = $('.__ckeditor__ form textarea').attr('id');
                if(instance != null)
                    CKEDITOR.instances[instance].updateElement();

                const form = $('.form-content form');
                const formData = new FormData(form[0]);

                // fetch form data
                $.ajax({
                    url: window.toApi("/entries/set/") + this.model_name + (this.entry_id != null ? `/${this.entry_id}` : ""),
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
                        root.listeners(this);
                        replaceCkEditor();
                    }
                })
            }
        }
    });
</script>
<script type="text/x-template" id="set-entry-modal-template">
    <modal name="set-entry-modal">
        <template v-slot:title>
                <i :class="{ 'fa-plus-circle': entry_id == null, 'fa-pen-to-square': entry_id != null }" class='fa-solid tw-me-1'></i> {{ entry_id != null ? $root.translate('live-editor.entries.edit.title') :  $root.translate('live-editor.entries.new.title') }}
        </template>
        <template v-slot:body>
            <div class="form-content"></div>
        </template>
        <template v-slot:footer>
            <button type="button"
                    v-on:click="close"
                    class="close-upload-modal tw-me-auto tw-text-gray-500 tw-bg-white hover:tw-bg-gray-100 focus:ring-4 focus:tw-outline-none focus:ring-blue-300 tw-rounded-lg tw-border tw-border-gray-200 tw-text-sm tw-font-medium tw-px-5 tw-py-2.5 hover:tw-text-gray-900 focus:tw-z-10 dark:tw-bg-gray-700 dark:tw-text-gray-300 dark:tw-border-gray-500 dark:hover:tw-text-white dark:hover:tw-bg-gray-600 dark:focus:ring-gray-600">
                {{ $root.translate('live-editor.entries.set.cancel') }}
            </button>
            <button v-on:click="submit()"
                    class="tw-text-white tw-bg-blue-700 hover:tw-bg-blue-800 focus:ring-4 focus:tw-outline-none focus:ring-blue-300 tw-font-medium tw-rounded-lg tw-text-sm tw-px-5 tw-py-2.5 tw-text-center dark:tw-bg-blue-600 dark:hover:tw-bg-blue-700 dark:focus:ring-blue-800">
                {{ entry_id != null ? $root.translate('live-editor.entries.edit') : $root.translate('live-editor.entries.new') }}
            </button>
        </template>
    </modal>
</script>