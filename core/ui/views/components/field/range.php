<div class="dodocms-w-full dodocms-flex dodocms-gap-2 dodocms-h-100 dodocms-items-center">
    <input type="range" id="<?= $this->id ?>" name="<?= $this->name ?>" min="<?= $this->min ?>" max="<?= $this->max ?>" step="<?= $this->step ?>" value="<?= $this->value ?>"
           class="dodocms-w-full dodocms-mt-1 dodocms-bg-gray-500 dodocms-appearance-none dodocms-rounded-md dodocms-h-2.5"/>
    <span for="<?= $this->id ?>" class="dodocms-mt-2 dodocms-text-sm dodocms-text-gray-600"><?= $this->value ?>%</span>
</div>