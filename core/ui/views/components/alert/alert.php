<div class="tw-my-0 tw-bg-<?= self::STYLES[$this->type] ?>-700 tw-border tw-border-<?= self::STYLES[$this->type] ?>-800 tw-text-white tw-px-3 tw-py-3 tw-rounded-lg tw-relative">
    <?php if (!empty($this->title)) { ?>
        <div class="tw-border-b-[1px] tw-border-gray-200 tw-border-opacity-25 tw-mb-4">
            <h1 class="tw-text-lg tw-font-bold tw-uppercase pb-2"><?= $this->title ?></h1>
        </div>
    <?php } ?>
    <span class='tw-block sm:inline'><?= $this->message ?></span>
</div>