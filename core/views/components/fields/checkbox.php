<label class="my-auto relative inline-flex items-center cursor-pointer  <?= ($this->disabled || $this->readonly) ? "opacity-50" : "" ?>">
    <input type="checkbox" name="<?= $this->name ?>"
           class="sr-only peer w-full h-full" <?= $this->readonly ? "onclick='return false;'" : "" ?> <?= $this->checked ? "checked" : "" ?> <?= $this->disabled ? "disabled" : "" ?>>
    <div class="w-11 h-6 bg-gray-200 rounded-full peer <?= (!$this->readonly) ? "peer-focus:ring-4" : "" ?> peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
    </div>
    <?php
    if (!empty($this->placeholder)) {
        echo('<span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">' . $this->placeholder . '</span>');
    }
    ?>
</label>
