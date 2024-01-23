<div class="dodocms-relative dodocms-inline-block dodocms-text-left dodocms-w-full select">
    <select id="<?= $this->id ?>" name="<?= $this->name ?>" class="dodocms-hidden">
        <?php if ($this->undefinable): ?>
            <option <?= empty($this->value) ? "selected" : "" ?> value=""><?= $this->placeholder ?></option>
        <?php endif; ?>
        <?php foreach ($this->options as $value => $text) { ?>
            <option value="<?= $value ?>" <?= $this->value == $value ? 'selected' : '' ?>><?= $text ?></option>;
        <?php } ?>
    </select>
    <button type="button"
            class="dodocms-inline-flex dodocms-justify-between dodocms-min-w-full dodocms-rounded-md dodocms-border dodocms-border-gray-500 dodocms-shadow-sm dodocms-px-3 dodocms-py-2 dodocms-bg-gray-700 dodocms-text-sm dodocms-leading-5 dodocms-font-medium dodocms-text-gray-200 hover:dodocms-text-white focus:dodocms-border-gray-400 focus:dodocms-outline-none focus:dodocms-shadow-outline-blue active:dodocms-bg-gray-700 dodocms-transition dodocms-ease-in-out dodocms-duration-150 select-button  <?= $this->disabled ? 'dodocms-opacity-50' : 'hover:dodocms-border-gray-400' ?>" <?= $this->disabled ? "disabled" : "" ?>>
        <span class="select-text">
            <?= (!empty($this->value) ? $this->value : ($this->placeholder ?? "")) ?>
        </span>
        <svg class="-dodocms-mr-1 dodocms-ml-2 dodocms-h-5 dodocms-w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" <?= $this->disabled ? "disabled" : '' ?>>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>
    <div class="origin-dodocms-top-left dodocms-absolute dodocms-left-0 dodocms-right-0 dodocms-mt-2 dodocms-border dodocms-border-gray-400 dodocms-rounded-md dodocms-shadow-lg dodocms-hidden dodocms-h-32 dodocms-overflow-y-auto dodocms-z-10 select-menu" <?= $this->disabled ? 'dodocms-disabled' : '' ?>>
        <div class="dodocms-rounded-md dodocms-bg-gray-700 dodocms-shadow-xs">
            <ul class="dodocms-py-1">
                <?php if ($this->undefinable) { ?>
                    <li data-value="">
                        <span class="dodocms-cursor-pointer dodocms-block dodocms-px-4 dodocms-py-2 dodocms-text-sm dodocms-leading-5 dodocms-text-gray-100 hover:dodocms-bg-gray-600 focus:dodocms-outline-none focus:dodocms-bg-gray-100"><?= $this->placeholder ?></span>
                    </li>
                <?php } ?>
                <?php foreach ($this->options as $value => $text) { ?>
                    <li data-value="<?= $value ?>" class="focus:dodocms-bg-gray-600 focus:dodocms-outline-none"><span class="dodocms-cursor-pointer dodocms-block dodocms-px-4 dodocms-py-2 dodocms-text-sm dodocms-leading-5 dodocms-text-gray-100 hover:dodocms-bg-gray-600 focus:dodocms-outline-none focus:dodocms-bg-gray-100"><?= $text ?></span></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>
