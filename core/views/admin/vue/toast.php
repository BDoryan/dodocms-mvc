<script defer type="module">
    Vue.component('toast', {
        props: ['title', 'message'],
        template: '#toast-template',
        data() {
        },
        methods: {
        }
    });
</script>
<script type="text/x-template" id="toast-template">
    <div class="toast dodocms-opacity-0 dodocms-w-lg dodocms-hidden dodocms-text-white dodocms-border-[1px] dodocms-border-gray-800 dodocms-border-opacity-25 dodocms-font-medium dodocms-py-3 dodocms-px-5 dodocms-rounded-lg dodocms-shadow-lg dodocms-transform dodocms-transition dodocms-duration-500 dodocms-translate-x-full">
        <div class="dodocms-flex dodocms-flex-row">
            <h3 class="dodocms-my-auto dodocms-me-3 dodocms-text-md dodocms-uppercase lh-1 dodocms-font-bold">{{ title }}</h3>
            <button type="button" class="close-toast dodocms-ms-auto dodocms-text-sm dodocms-text-white underline focus:dodocms-outline-none dodocms-my-auto hover:dodocms-text-gray-400">
                <i class="dodocms-me-1 fa-solid fa-close"></i></button>
        </div>
        <hr class="dodocms-my-2 dodocms-border-t-[1px] dodocms-border-gray-300 dodocms-border-opacity-25">
        <p class="dodocms-text-sm">{{ message }}</p>
    </div>
</script>