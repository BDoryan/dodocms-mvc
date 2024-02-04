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
    <div v-if="isOpen()" class="tw-z-50 tw-fixed tw-top-0 tw-bottom-0 tw-right-0 tw-left-0 tw-bg-black tw-bg-opacity-40 tw-backdrop-blur-sm tw-flex tw-flex-col">
        <div class="tw-m-auto tw-w-2/4">
            <div class="tw-backdrop-filter tw-backdrop-blur-lg tw-bg-opacity-90 tw-border tw-border-black tw-border-opacity-20 tw-bg-white  tw-rounded-lg tw-shadow-lg">
                <!-- Modal header -->
                <div class="tw-flex tw-items-center tw-justify-between tw-p-4 md:tw-p-5 tw-border-gray-300 tw-border-b tw-rounded-t">
                    <h3 class="tw-text-xl tw-font-semibold tw-text-gray-900">
                        <slot name="title"></slot>
                    </h3>
                    <button type="button"
                            v-on:click="close()"
                            class="tw-text-gray-400 tw-bg-transparent hover:tw-bg-gray-200 hover:tw-text-gray-900 tw-rounded-lg tw-text-sm tw-w-8 tw-h-8 tw-ms-auto tw-inline-flex tw-justify-center tw-items-center">
                        <svg class="tw-w-3 tw-h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="tw-sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="tw-p-4 md:tw-p-5 space-y-4 tw-max-h-[74vh] tw-overflow-y-auto">
                    <slot name="body"></slot>
                </div>
                <!-- Modal footer -->
                <div class="tw-flex tw-items-center tw-p-4 md:tw-p-5 tw-border-t tw-border-gray-300 tw-rounded-b ">
                    <slot name="footer"></slot>
                </div>
            </div>
        </div>
    </div>
</script>