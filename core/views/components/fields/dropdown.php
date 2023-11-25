<div class="relative inline-block text-left w-full dropdown">
    <select id="<?= $this->id ?>" name="<?= $this->name ?>" class="hidden">
        <?php if($this->undefinable): ?>
            <option <?= empty($this->value) ? "selected" : "" ?> value=""><?= $this->placeholder ?></option>
        <?php endif; ?>
        <?php
        foreach ($this->options as $value => $text) {
            echo('<option value="' . $value . '" '.($this->value == $value ? 'selected' : '').'>' . $text . '</option>');
        }
        ?>
    </select>
    <button type="button"
            class="leading-6 inline-flex justify-between min-w-full rounded-md border border-gray-500 shadow-sm px-3 py-2 bg-gray-700 text-sm leading-5 font-medium text-gray-200 hover:text-white focus:border-gray-400 focus:outline-none focus:shadow-outline-blue active:bg-gray-700 transition ease-in-out duration-150 dropdown-button  <?= $this->disabled ? 'opacity-50' : 'hover:border-gray-400' ?>" <?= $this->disabled ? "disabled" : "" ?>>
        <span class="dropdown-text">
            <?= (!empty($this->value) ? $this->value : ($this->placeholder ?? "")) ?>
        </span>
        <svg class="-mr-1 ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
             xmlns="http://www.w3.org/2000/svg" <?= $this->disabled ? 'disabled' : '' ?>>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>
    <div class="origin-top-left absolute left-0 right-0 mt-2 border border-gray-400 rounded-md shadow-lg hidden h-32 overflow-y-auto z-10 dropdown-menu" <?= $this->disabled ? 'disabled' : '' ?>>
        <div class="rounded-md bg-gray-700 shadow-xs">
            <ul class="py-1">
                <?php if($this->undefinable): ?>
                    <li data-value=""><span class="cursor-pointer block px-4 py-2 text-sm leading-5 text-gray-100 hover-bg-gray-600 focus:outline-none focus:bg-gray-100"><?= $this->placeholder ?></span></li>
                <?php endif; ?>
                <?php foreach ($this->options as $value => $text) {
                    echo('<li data-value="' . $value . '"><span class="cursor-pointer block px-4 py-2 text-sm leading-5 text-gray-100 hover-bg-gray-600 focus:outline-none focus:bg-gray-100">' . $text . '</span></li>');
                } ?>
            </ul>
        </div>
    </div>
</div>
