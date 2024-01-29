<label class="dodocms-my-auto dodocms-relative dodocms-inline-flex dodocms-items-center dodocms-cursor-pointer  <?= ($this->disabled || $this->readonly) ? "dodocms-dodocms-opacity-50" : "" ?>">
    <input type="checkbox" name="<?= $this->name ?>"
           class="dodocms-sr-only dodocms-peer dodocms-w-full dodocms-h-full" <?= $this->readonly ? "onclick='return false;'" : "" ?> <?= $this->checked ? "checked" : "" ?> <?= $this->disabled ? "disabled" : "" ?>>
    <div class="dodocms-w-11 dodocms-h-6 dodocms-bg-gray-200 dodocms-rounded-full dodocms-peer <?= (!$this->readonly) ? "peer-focus:ring-4" : "" ?> peer-focus:dodocms-ring-blue-300 dark:dodocms-peer-focus:ring-blue-800 dark:dodocms-bg-gray-700 peer-checked:after:dodocms-translate-x-full peer-checked:after:dodocms-border-white after:dodocms-content-[''] after:dodocms-absolute after:dodocms-top-0.5 after:dodocms-left-[2px] after:dodocms-bg-white after:dodocms-border-gray-300 after:dodocms-border after:dodocms-rounded-full after:dodocms-h-5 after:dodocms-w-5 after:dodocms-transition-all dark:dodocms-border-gray-600 peer-checked:dodocms-bg-blue-600 dodocms-border-[1px] ">
    </div>
    <?php
    if (!empty($this->placeholder)) {
        echo('<span class="dodocms-ml-3 dodocms-text-sm dodocms-font-medium dodocms-text-gray-900 dark:dodocms-text-gray-300">' . $this->placeholder . '</span>');
    }
    ?>
</label>
