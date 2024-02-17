<button
    <?= $this->confirmationAttributes() ?>
    <?= $this->disabled ? 'disabled' : '' ?>
    type="<?= $this->type ?>" id="<?= $this->id ?>"
    <?= $this->attributes() ?>
    class="<?= $this->class ?>
    <?= $this->disabled ? 'tw-opacity-75 tw-pointer-events-none' : '' ?>">
    <?= $this->text ?>
</button>