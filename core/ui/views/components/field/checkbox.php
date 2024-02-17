<label class="tw-my-auto tw-relative tw-inline-flex tw-items-center tw-cursor-pointer  <?= ($this->disabled || $this->readonly) ? "tw-tw-opacity-50" : "" ?>">
    <input type="hidden" name="<?= $this->name ?>"  value="off" />
    <input type="checkbox" name="<?= $this->name ?>"
           class="tw-sr-only tw-peer tw-w-full tw-h-full" <?= $this->readonly ? "onclick='return false;'" : "" ?> <?= $this->checked ? "checked" : "" ?> <?= $this->disabled ? "disabled" : "" ?>>
    <div class="tw-w-11 tw-h-6 tw-bg-gray-400 tw-bg-opacity-50 tw-rounded-full tw-peer <?= (!$this->readonly) ? "peer-focus:ring-4" : "" ?> peer-focus:tw-ring-blue-300 dark:tw-peer-focus:ring-blue-800 peer-checked:after:tw-translate-x-full peer-checked:after:tw-border-white after:tw-content-[''] after:tw-absolute after:tw-top-0.5 after:tw-left-[2px] after:tw-bg-white after:tw-border-gray-300 after:tw-border after:tw-rounded-full after:tw-h-5 after:tw-w-5 after:tw-transition-all peer-checked:tw-bg-blue-600 tw-border-[1px] ">
    </div>
    <?php
    if (!empty($this->placeholder)) {
        echo('<span class="tw-ml-3 tw-text-sm tw-font-medium tw-text-gray-700">' . $this->placeholder . '</span>');
    }
    ?>
</label>
