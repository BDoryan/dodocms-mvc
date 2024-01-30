<label
        for="<?= $this->id ?>"
        class="tw-block tw-text-gray-700 tw-text-sm tw-font-semibold tw-mb-2">
    <?= $this->label ?> <span class="tw-text-red-700 tw-text-base"> <?= $this->required ? '*' : "" ?></span>
</label>