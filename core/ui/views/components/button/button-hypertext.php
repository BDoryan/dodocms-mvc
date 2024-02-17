<a
    <?= !empty($this->target) ? 'target="'.$this->target.'"' : '' ?>
    <?= $this->confirmationAttributes() ?>
    href="<?= $this->disabled ? '#' : $this->href ?>"
    id="<?= $this->id ?>" <?= $this->attributes() ?>
    class="<?= $this->class ?> <?= $this->class ?>
    <?= $this->disabled ? 'tw-opacity-75 tw-pointer-events-none' : '' ?>">
    <?= $this->text ?>
</a>