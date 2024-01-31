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
            <i class='fa-solid fa-cloud-upload tw-me-1'></i> <?= __('live-editor.page.structure.blocks.modal.title') ?>
        </template>
        <template v-slot:body>
            <div class="tw-grid tw-grid-cols-3 tw-gap-2">
                <?php
                    /** @var BlockModel $block */
                    foreach (BlockModel::findAll('*') as $block) {
                ?>
                    <button v-on:click="$root.addBlock(<?= $block->getId() ?>)" class="w-4/12 tw-p-3 tw-flex tw-flex-col tw-justify-center tw-rounded-lg tw-bg-gray-800 tw-border-1 tw-border-gray-700 hover:tw-bg-blue-600">
                        <span class="tw-text-2xl"><?= $block->getName() ?></span>
                        <span class="text-gray-200 tw-text-opacity-25 tw-italic"><?= $block->getPath() ?>.php</span>
                    </button>
                <?php } ?>
            </div>
        </template>
        <template v-slot:footer>
            <button type="button"
                    v-on:click="close"
                    class="close-upload-modal tw-me-auto tw-text-gray-500 tw-bg-white hover:tw-bg-gray-100 focus:ring-4 focus:tw-outline-none focus:ring-blue-300 tw-rounded-lg tw-border tw-border-gray-200 tw-text-sm tw-font-medium tw-px-5 tw-py-2.5 hover:tw-text-gray-900 focus:tw-z-10 dark:tw-bg-gray-700 dark:tw-text-gray-300 dark:tw-border-gray-500 dark:hover:tw-text-white dark:hover:tw-bg-gray-600 dark:focus:ring-gray-600">
                <?= __("admin.panel.resources.upload.close") ?>
            </button>
<!--            <button class="tw-text-white tw-bg-blue-700 hover:tw-bg-blue-800 focus:ring-4 focus:tw-outline-none focus:ring-blue-300 tw-font-medium tw-rounded-lg tw-text-sm tw-px-5 tw-py-2.5 tw-text-center dark:tw-bg-blue-600 dark:hover:tw-bg-blue-700 dark:focus:ring-blue-800">-->
<!--                --><?php //= __("live-editor.page.structure.blocks.finish") ?>
<!--            </button>-->
        </template>
    </modal>
</script>