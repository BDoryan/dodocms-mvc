<div class='my-0 bg-<?= self::STYLES[$this->type]?>-700 border border-<?= self::STYLES[$this->type]?>-800 text-<?= self::STYLES[$this->type]?>-50 px-3 py-3 rounded relative' role='alert'>
    <h1 class="text-lg font-bold uppercase"><?php $this->title ?></h1>
    <span class='block sm:inline'><?= $this->message ?></span>
</div>