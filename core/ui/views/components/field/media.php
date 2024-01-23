<?php
/** @var MediaModel $media */



$media = $this->media;
?>
<div class="dodocms-relative dodocms-h-full" method="POST">
    <div class="dodocms-h-full dodocms-rounded-lg dodocms-border-gray-300 dodocms-border-opacity-25" style="height: 200px;">
        <img class="dodocms-rounded-lg dodocms-h-full dodocms-w-full"
             :class="{'dodocms-blur-sm dodocms-p-2': imageTarget === '<?= $media->getSrc() ?>'}"
             src="<?= $media->getSrc() ?>"
             alt="<?= $media->getAlternativeText() ?>"
             style="background-size: contain; background: url('<?= Application::toURL("/admin/assets/imgs/transparent.jpg") ?>'); object-fit: contain; object-position: center;">
        <a target="_blank" href="<?= $media->getDefaultSrc() ?>"
           class="dodocms-absolute dodocms-inset-0 dodocms-flex dodocms-items-center dodocms-justify-center dodocms-opacity-0 hover:dodocms-opacity-100 dodocms-transition dodocms-duration-300 dodocms-ease-in-out dodocms-bg-black dodocms-bg-opacity-25">
            <i class="fas fa-eye dodocms-text-5xl dodocms-text-white dodocms-text-dodocms-opacity-75 hover:dodocms-text-dodocms-opacity-90 dodocms-transition-colors"></i>
        </a>
    </div>
    <div class="dodocms-rounded-lg dodocms-bg-gray-800 dodocms-bg-opacity-75 dodocms-p-3 dodocms-absolute dodocms-top-0 dodocms-bottom-0 dodocms-left-0 dodocms-right-0 dodocms-flex dodocms-flex-col"
         x-show="imageTarget === '<?= $media->getSrc() ?>'" class="dodocms-mt-2">
        <input type="hidden" name="id" value="<?= $media->getId() ?>">
        <?= Text::create()->label("Texte alternatif")->value($media->getAlternativeText())->name("alternativeText")->render() ?>
        <div class="dodocms-mt-auto dodocms-flex dodocms-flex-row">
            <button type="button"
                    class="dodocms-bg-gray-700 dodocms-bg-opacity-50 hover:dodocms-bg-opacity-100 dodocms-border-[1px] dodocms-border-gray-300 dodocms-border-opacity-50 hover:dodocms-border-opacity-75 dodocms-py-2 dodocms-px-3 dodocms-rounded-md dodocms-mt-auto"
                    v-on:click="imageTarget=null">Annuler
            </button>
            <button type="submit"
                    name="action"
                    value="save"
                    class="dodocms-bg-blue-700 hover:dodocms-bg-blue-800 dodocms-py-2 dodocms-px-3 dodocms-rounded-md dodocms-mt-auto dodocms-ms-auto"
                    v-on:click="imageTarget=null">Enregistrer
            </button>
        </div>
    </div>
    <div x-show="!(imageTarget != null && imageTarget === '<?= $media->getSrc() ?>')"
         class="dodocms-absolute dodocms-top-2 dodocms-right-2 space-x-1">
        <button type="button" v-on:click="imageTarget='<?= $media->getSrc() ?>'"
                class="dodocms-text-white dodocms-bg-blue-500 dodocms-h-8 dodocms-w-8 dodocms-rounded-full hover:dodocms-bg-blue-600">
            <i class="dodocms-text-sm fa-solid fa-edit"></i>
        </button>
        <button type="button"
                class="delete dodocms-text-white dodocms-bg-red-500 dodocms-h-8 dodocms-w-8 dodocms-rounded-full hover:dodocms-bg-red-600">
            <i class="dodocms-text-sm fa-solid fa-trash"></i>
        </button>
    </div>
</div>
