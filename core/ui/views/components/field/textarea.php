<textarea
        type="<?= $this->type ?>"
        id="<?= $this->id ?>"
    <?= $this->readonly ? "readonly" : "" ?>
    <?= $this->disabled ? "disabled" : "" ?>
        name="<?= $this->name ?>"
        rows="<?= $this->rows ?? "3" ?>"
        <?= $this->required ? "required" : "" ?>
        placeholder="<?= $this->placeholder ?? "" ?> "
        class="tw-w-full tw-bg-gray-700 tw-px-3 tw-py-2 tw-border tw-border-gray-500 tw-rounded-md tw-text-white tw-outline-none focus:tw-border-gray-400 tw-mb-1"
>
<?= $this->value ?? "" ?>
</textarea>
<?php if ($this->useValidator): ?>
    <span class="tw-text-red-700 tw-hidden" id="validation-message"></span>
<?php endif; ?>