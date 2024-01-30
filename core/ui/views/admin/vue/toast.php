<script defer type="module">

    const INFO = 'tw-toast-info';
    const SUCCESS = 'tw-toast-success';
    const WARNING = 'tw-toast-warning';
    const ERROR = 'tw-toast-error';

    Vue.component('toast', {
        props: ['title', 'message', 'duration', 'type'],
        template: '#toast-template',
        data() {
            return {
                localTitle: this.title ?? 'untitled',
                localMessage: this.message ?? 'no message',
                localType: this.type ?? 'info',
                localDuration: this.duration ?? 5000
            }
        },
        methods: {
            close() {
                const self = this;
                const element = self.$el;
                element.classList.add(`tw-translate-x-full`);
                element.classList.add('tw-opacity-0');

                setTimeout(() => {
                    element.remove()
                    self.$emit('close');
                }, 500);
            }
        },
        mounted() {
            const self = this;

            setTimeout(() => {
                this.$el.classList.remove(`tw-translate-x-full`);
                this.$el.classList.remove('tw-opacity-0')
            }, 100);

            setTimeout(() => {
                self.close();
            }, self.localDuration);
        }
    });
</script>
<script type="text/x-template" id="toast-template">
    <div
            :class="`tw-toast-${localType}`"
            class="tw-opacity-0 tw-bg-pink-500 tw-translate-x-full tw-text-white tw-border tw-p-2 tw-rounded-lg tw-shadow-lg tw-transition tw-duration-500">
        <div class="tw-flex tw-flex-row tw-items-center tw-justify-center tw-mb-2">
            <h1 class="tw-me-3 tw-uppercase tw-text-lg tw-font-bold">{{ localTitle }}</h1>
            <button v-on:click="close" type="button"
                    class="tw-ms-auto tw-text-sm tw-text-white underline focus:tw-outline-none tw-my-auto hover:tw-text-gray-400">
                <i class="fa-solid fa-close"></i>
            </button>
        </div>
        <p class="tw-text-sm">{{ localMessage }}</p>
    </div>
</script>