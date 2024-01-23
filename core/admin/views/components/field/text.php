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
        class="dodocms-w-full dodocms-px-3 dodocms-py-2 dodocms-border dodocms-rounded-md"
>
<?php if ($this->useValidator): ?>
    <span class="dodocms-text-red-700 dodocms-hidden" id="validation-message"></span>
<?php endif; ?>