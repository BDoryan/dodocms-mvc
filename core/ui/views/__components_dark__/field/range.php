<div class="tw-w-full tw-flex tw-gap-2 tw-h-100 tw-items-center">
    <input type="range" id="<?= $this->id ?>" name="<?= $this->name ?>" min="<?= $this->min ?>" max="<?= $this->max ?>" step="<?= $this->step ?>" value="<?= $this->value ?>"
           class="tw-w-full tw-mt-1 tw-bg-gray-500 tw-appearance-none tw-rounded-md tw-h-2.5"/>
    <span for="<?= $this->id ?>" class="tw-mt-2 tw-text-sm tw-text-gray-600"><?= $this->value ?>%</span>
</div>