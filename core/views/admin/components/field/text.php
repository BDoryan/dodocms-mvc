<input
        type="<?= $this->type ?>"
        id="<?= $this->id ?>"
    <?= $this->readonly ? "readonly" : "" ?>
    <?= $this->disabled ? "disabled" : "" ?>
        name="<?= $this->name ?>"
        value="<?= $this->value ?? "" ?>"
        <?= $this->required ? "required" : "" ?>
        placeholder="<?= $this->placeholder ?? "" ?> "
        class="w-full px-3 py-2 border rounded-md"
>
<?php if($this->useValidator): ?>
<span class="text-red-700 hidden" id="validation-message"></span>
<?php endif; ?>