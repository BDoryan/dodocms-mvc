<div class='my-0 bg-<?= self::STYLES[$this->type] ?>-700 border border-<?= self::STYLES[$this->type] ?>-800 text-<?= self::STYLES[$this->type] ?>-50 px-3 py-3 rounded relative'
     role='alert'>
    <?php if (!empty($this->title)) { ?>
        <div class="border-b-[1px] border-gray-200 border-opacity-25 mb-4">
            <h1 class="text-lg font-bold uppercase pb-2"><?= $this->title ?></h1>
        </div>
    <?php } ?>
    <span class='block sm:inline'><?= $this->message ?></span>
</div>