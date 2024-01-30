<input
        type="<?= $this->type ?>"
        id="<?= $this->id ?>"
    <?= $this->readonly ? "readonly" : "" ?>
    <?= $this->disabled ? "disabled" : "" ?>
        name="<?= $this->name ?>"
    <?= !empty($this->value) ? 'value="' . $this->value . '"' : '' ?>
    <?= $this->required ? "required" : "" ?>
        placeholder="<?= $this->placeholder ?? "" ?> "
        <?= $this->attributes() ?>
        class="tw-w-full tw-px-3 tw-py-2 tw-border tw-rounded-md"
>
<?php if ($this->useValidator): ?>
    <span class="tw-text-red-700 tw-hidden" id="validation-message"></span>
<?php endif; ?>