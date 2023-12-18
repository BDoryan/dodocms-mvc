<script defer type="module">
    Vue.component('modal', {
        props: ['name'],
        template: '#modal-template',
        data() {
            return {
            };
        },
        methods: {
            open() {
                this.$root.openModal(this.name);
            },
            close() {
                this.$root.closeModal(this.name);
            },
            isOpen() {
                return this.$root.modalIsOpen(this.name);
            }
        }
    });
</script>
<script type="text/x-template" id="modal-template">
    <div v-if="isOpen()" class="z-50 dodocms-absolute dodocms-top-0 dodocms-bottom-0 dodocms-right-0 dodocms-left-0 dodocms-bg-black dodocms-bg-opacity-50 dodocms-backdrop-blur-lg dodocms-flex dodocms-flex-col">
        <div class="dodocms-m-auto dodocms-w-2/4">
            <div class="dodocms-bg-gray-700 dodocms-rounded-lg dodocms-shadow-lg">
                <!-- Modal header -->
                <div class="dodocms-flex dodocms-items-center dodocms-justify-between dodocms-p-4 md:dodocms-p-5 dodocms-border-b dodocms-rounded-t dark:dodocms-border-gray-600">
                    <h3 class="dodocms-text-xl dodocms-font-semibold dodocms-text-gray-900 dark:dodocms-text-white">
                        <slot name="title"></slot>
                    </h3>
                    <button type="button"
                            @click="close()"
                            class="dodocms-text-gray-400 dodocms-bg-transparent hover:dodocms-bg-gray-200 hover:dodocms-text-gray-900 dodocms-rounded-lg dodocms-text-sm dodocms-w-8 dodocms-h-8 dodocms-ms-auto dodocms-inline-flex dodocms-justify-center dodocms-items-center dark:hover:dodocms-bg-gray-600 dark:hover:dodocms-text-white">
                        <svg class="dodocms-w-3 dodocms-h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="dodocms-p-4 md:dodocms-p-5 space-y-4">
                    <slot name="body"></slot>
                </div>
                <!-- Modal footer -->
                <div class="dodocms-flex dodocms-items-center dodocms-p-4 md:dodocms-p-5 dodocms-border-t dodocms-border-gray-200 dodocms-rounded-b dark:dodocms-border-gray-600">
                    <slot name="footer"></slot>
                </div>
            </div>
        </div>
    </div>
</script>