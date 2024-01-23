<textarea
        type="<?= $this->type ?>"
        id="<?= $this->id ?>"
    <?= $this->readonly ? "readonly" : "" ?>
    <?= $this->disabled ? "disabled" : "" ?>
        name="<?= $this->name ?>"
        rows="<?= $this->rows ?? "3" ?>"
        <?= $this->required ? "required" : "" ?>
        placeholder="<?= $this->placeholder ?? "" ?> "
        class="ckeditor dodocms-w-full dodocms-bg-gray-700 dodocms-px-3 dodocms-py-2 dodocms-border dodocms-border-gray-500 dodocms-rounded-md dodocms-text-white dodocms-outline-none focus:dodocms-border-gray-400 dodocms-mb-1"
>
<?= $this->value ?? "" ?>
</textarea>
<?php if ($this->useValidator): ?>
    <span class="dodocms-text-red-700 dodocms-hidden" id="validation-message"></span>
<?php endif; ?>