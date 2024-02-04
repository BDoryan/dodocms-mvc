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
                    <button v-on:click="$root.addBlock(<?= $block->getId() ?>)" class="w-4/12 tw-p-3 tw-flex tw-flex-col tw-justify-center tw-rounded-lg tw-bg-white tw-border-1 tw-text-gray-700 tw-border-gray-400 hover:tw-bg-blue-600 hover:tw-text-white">
                        <span class="tw-text-2xl"><?= $block->getName() ?></span>
                        <span class="text-gray-200 tw-text-opacity-25 tw-italic"><?= $block->getPath() ?></span>
                    </button>
                <?php } ?>
            </div>
        </template>
        <template v-slot:footer>
            <?php
                Button::create()
                    ->type('button')
                    ->text(__('live-editor.page.structure.blocks.modal.close'))
                    ->attribute('v-on:click', 'close')
            ->render();
            ?>
<!--            <button type="button"-->
<!--                    v-on:click="close"-->
<!--                    class="close-upload-modal tw-me-auto tw-text-gray-500 tw-bg-white hover:tw-bg-gray-100 focus:ring-4 focus:tw-outline-none focus:ring-blue-300 tw-rounded-lg tw-border tw-border-gray-200 tw-text-sm tw-font-medium tw-px-5 tw-py-2.5 hover:tw-text-gray-900 focus:tw-z-10 dark:tw-bg-gray-700 dark:tw-text-gray-300 dark:tw-border-gray-500 dark:hover:tw-text-white dark:hover:tw-bg-gray-600 dark:focus:ring-gray-600">-->
<!--                --><?php //= __("admin.panel.resources.upload.close") ?>
<!--            </button>-->
        </template>
    </modal>
</script>