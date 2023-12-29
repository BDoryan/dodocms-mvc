<script defer type="module">

    const INFO = 'dodocms-toast-info';
    const SUCCESS = 'dodocms-toast-success';
    const WARNING = 'dodocms-toast-warning';
    const ERROR = 'dodocms-toast-error';

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
                element.classList.add(`dodocms-translate-x-full`);
                element.classList.add('dodocms-opacity-0');

                setTimeout(() => {
                    element.remove()
                    self.$emit('close');
                }, 500);
            }
        },
        mounted() {
            const self = this;

            setTimeout(() => {
                this.$el.classList.remove(`dodocms-translate-x-full`);
                this.$el.classList.remove('dodocms-opacity-0')
            }, 100);

            setTimeout(() => {
                self.close();
            }, self.localDuration);
        }
    });
</script>
<script type="text/x-template" id="toast-template">
    <div
            :class="`dodocms-toast-${localType}`"
            class="dodocms-opacity-0 dodocms-bg-pink-500 dodocms-translate-x-full dodocms-text-white dodocms-border dodocms-p-2 dodocms-rounded-lg dodocms-shadow-lg dodocms-transition dodocms-duration-500">
        <div class="dodocms-flex dodocms-flex-row dodocms-items-center dodocms-justify-center dodocms-mb-2">
            <h1 class="dodocms-me-3 dodocms-uppercase dodocms-text-lg dodocms-font-bold">{{ localTitle }}</h1>
            <button v-on:click="close" type="button"
                    class="dodocms-ms-auto dodocms-text-sm dodocms-text-white underline focus:dodocms-outline-none dodocms-my-auto hover:dodocms-text-gray-400">
                <i class="fa-solid fa-close"></i>
            </button>
        </div>
        <p class="dodocms-text-sm">{{ localMessage }}</p>
    </div>
</script>