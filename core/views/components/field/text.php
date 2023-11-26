<input
        type="<?= $this->type ?>"
        id="<?= $this->id ?>"
    <?= $this->readonly ? "readonly" : "" ?>
    <?= $this->disabled ? "disabled" : "" ?>
        name="<?= $this->name ?>"
        value="<?= $this->value ?? "" ?>"
        <?= $this->required ? "required" : "" ?>
        placeholder="<?= $this->placeholder ?? "" ?> "
        class="w-full bg-gray-700 px-3 py-2 border border-gray-500 rounded-md text-white outline-none focus:border-gray-400 mb-1"
>
<?php if($this->useValidator): ?>
<span class="text-red-700 hidden" id="validation-message"></span>
<?php endif; ?>