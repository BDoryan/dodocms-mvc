<script defer type="module">
    Vue.component('blocks-modal', {
        props: ['name'],
        template: '#blocks-modal-template',
        data() {
            return {}
        },
        methods: {
            close() {
                this.$root.closeModal('blocks-modal')
            }
        }
    });
</script>
<script type="text/x-template" id="blocks-modal-template">
    <modal name="blocks-modal">
        <template v-slot:title>
            <i class='fa-solid fa-cloud-upload dodocms-me-1'></i> <?= __('live-editor.page.structure.blocks.modal.title') ?>
        </template>
        <template v-slot:body>
            <div class="dodocms-grid dodocms-grid-cols-3 dodocms-gap-2">
                <?php
                    /** @var BlockModel $block */
                    foreach (BlockModel::findAll('*') as $block) {
                ?>
                    <button v-on:click="$root.addBlock(<?= $block->getId() ?>)" class="w-4/12 dodocms-p-3 dodocms-flex dodocms-flex-col dodocms-justify-center dodocms-rounded-lg dodocms-bg-gray-800 dodocms-border-1 dodocms-border-gray-700 hover:dodocms-bg-blue-600">
                        <span class="dodocms-text-2xl"><?= $block->getName() ?></span>
                        <span class="text-gray-200 dodocms-text-opacity-25 dodocms-italic"><?= $block->getPath() ?>.php</span>
                    </button>
                <?php } ?>
            </div>
        </template>
        <template v-slot:footer>
            <button type="button"
                    v-on:click="close"
                    class="close-upload-modal dodocms-me-auto dodocms-text-gray-500 dodocms-bg-white hover:dodocms-bg-gray-100 focus:ring-4 focus:dodocms-outline-none focus:ring-blue-300 dodocms-rounded-lg dodocms-border dodocms-border-gray-200 dodocms-text-sm dodocms-font-medium dodocms-px-5 dodocms-py-2.5 hover:dodocms-text-gray-900 focus:dodocms-z-10 dark:dodocms-bg-gray-700 dark:dodocms-text-gray-300 dark:dodocms-border-gray-500 dark:hover:dodocms-text-white dark:hover:dodocms-bg-gray-600 dark:focus:ring-gray-600">
                <?= __("admin.panel.resources.upload.close") ?>
            </button>
<!--            <button class="dodocms-text-white dodocms-bg-blue-700 hover:dodocms-bg-blue-800 focus:ring-4 focus:dodocms-outline-none focus:ring-blue-300 dodocms-font-medium dodocms-rounded-lg dodocms-text-sm dodocms-px-5 dodocms-py-2.5 dodocms-text-center dark:dodocms-bg-blue-600 dark:hover:dodocms-bg-blue-700 dark:focus:ring-blue-800">-->
<!--                --><?php //= __("live-editor.page.structure.blocks.finish") ?>
<!--            </button>-->
        </template>
    </modal>
</script>