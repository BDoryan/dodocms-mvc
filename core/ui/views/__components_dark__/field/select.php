<div class="tw-relative tw-inline-block tw-text-left tw-w-full select">
    <select id="<?= $this->id ?>" name="<?= $this->name ?>" class="tw-hidden">
        <?php if ($this->undefinable): ?>
            <option <?= empty($this->value) ? "selected" : "" ?> value=""><?= $this->placeholder ?></option>
        <?php endif; ?>
        <?php foreach ($this->options as $value => $text) { ?>
            <option value="<?= $value ?>" <?= $this->value == $value ? 'selected' : '' ?>><?= $text ?></option>;
        <?php } ?>
    </select>
    <button type="button"
            class="tw-inline-flex tw-justify-between tw-min-w-full tw-rounded-md tw-border tw-border-gray-500 tw-shadow-sm tw-px-3 tw-py-2 tw-bg-gray-700 tw-text-sm tw-leading-5 tw-font-medium tw-text-gray-200 hover:tw-text-white focus:tw-border-gray-400 focus:tw-outline-none focus:tw-shadow-outline-blue active:tw-bg-gray-700 tw-transition tw-ease-in-out tw-duration-150 select-button  <?= $this->disabled ? 'tw-opacity-50' : 'hover:tw-border-gray-400' ?>" <?= $this->disabled ? "disabled" : "" ?>>
        <span class="select-text">
            <?= (!empty($this->value) ? $this->value : ($this->placeholder ?? "")) ?>
        </span>
        <svg class="-tw-mr-1 tw-ml-2 tw-h-5 tw-w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" <?= $this->disabled ? "disabled" : '' ?>>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>
    <div class="origin-tw-top-left tw-absolute tw-left-0 tw-right-0 tw-mt-2 tw-border tw-border-gray-400 tw-rounded-md tw-shadow-lg tw-hidden tw-h-32 tw-overflow-y-auto tw-z-10 select-menu" <?= $this->disabled ? 'tw-disabled' : '' ?>>
        <div class="tw-rounded-md tw-bg-gray-700 tw-shadow-xs">
            <ul class="tw-py-1">
                <?php if ($this->undefinable) { ?>
                    <li data-value="">
                        <span class="tw-cursor-pointer tw-block tw-px-4 tw-py-2 tw-text-sm tw-leading-5 tw-text-gray-100 hover:tw-bg-gray-600 focus:tw-outline-none focus:tw-bg-gray-100"><?= $this->placeholder ?></span>
                    </li>
                <?php } ?>
                <?php foreach ($this->options as $value => $text) { ?>
                    <li data-value="<?= $value ?>" class="focus:tw-bg-gray-600 focus:tw-outline-none"><span class="tw-cursor-pointer tw-block tw-px-4 tw-py-2 tw-text-sm tw-leading-5 tw-text-gray-100 hover:tw-bg-gray-600 focus:tw-outline-none focus:tw-bg-gray-100"><?= $text ?></span></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>
