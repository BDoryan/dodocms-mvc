<div class="dodocms-my-0 dodocms-bg-<?= self::STYLES[$this->type] ?>-700 dodocms-border dodocms-border-<?= self::STYLES[$this->type] ?>-800 dodocms-text-<?= self::STYLES[$this->type] ?>-50 dodocms-px-3 dodocms-py-3 dodocms-rounded dodocms-relative">
    <?php if (!empty($this->title)) { ?>
        <div class="dodocms-border-b-[1px] dodocms-border-gray-200 dodocms-border-opacity-25 dodocms-mb-4">
            <h1 class="dodocms-text-lg dodocms-font-bold dodocms-uppercase pb-2"><?= $this->title ?></h1>
        </div>
    <?php } ?>
    <span class='dodocms-block sm:inline'><?= $this->message ?></span>
</div>