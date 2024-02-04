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
        class="tw-w-full tw-bg-white tw-px-3 tw-py-2 tw-border tw-border-gray-300 tw-rounded-md tw-text-gray-800 tw-outline-none focus:tw-border-gray-400 tw-mb-1"
>
<?php if ($this->useValidator): ?>
    <span class="tw-text-red-700 tw-hidden dodocms-validation-message"></span>
<?php endif; ?>