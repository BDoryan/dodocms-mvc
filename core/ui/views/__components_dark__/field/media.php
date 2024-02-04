<?php
/** @var MediaModel $media */



$media = $this->media;
?>
<div class="tw-relative tw-h-full" method="POST">
    <div class="tw-h-full tw-rounded-lg tw-border-gray-300 tw-border-opacity-25" style="height: 200px;">
        <img class="tw-rounded-lg tw-h-full tw-w-full"
             :class="{'tw-blur-sm tw-p-2': imageTarget === '<?= $media->getSrc() ?>'}"
             src="<?= $media->getSrc() ?>"
             alt="<?= $media->getAlternativeText() ?>"
             style="background-size: contain; background: url('<?= Application::toURL("/admin/assets/imgs/transparent.jpg") ?>'); object-fit: contain; object-position: center;">
        <a target="_blank" href="<?= $media->getDefaultSrc() ?>"
           class="tw-absolute tw-inset-0 tw-flex tw-items-center tw-justify-center tw-opacity-0 hover:tw-opacity-100 tw-transition tw-duration-300 tw-ease-in-out tw-bg-black tw-bg-opacity-25">
            <i class="fas fa-eye tw-text-5xl tw-text-white tw-text-tw-opacity-75 hover:tw-text-tw-opacity-90 tw-transition-colors"></i>
        </a>
    </div>
    <div class="tw-rounded-lg tw-bg-gray-800 tw-bg-opacity-75 tw-p-3 tw-absolute tw-top-0 tw-bottom-0 tw-left-0 tw-right-0 tw-flex tw-flex-col"
         x-show="imageTarget === '<?= $media->getSrc() ?>'" class="tw-mt-2">
        <input type="hidden" name="id" value="<?= $media->getId() ?>">
        <?= Text::create()->label("Texte alternatif")->value($media->getAlternativeText())->name("alternativeText")->render() ?>
        <div class="tw-mt-auto tw-flex tw-flex-row">
            <button type="button"
                    class="tw-bg-gray-700 tw-bg-opacity-50 hover:tw-bg-opacity-100 tw-border-[1px] tw-border-gray-300 tw-border-opacity-50 hover:tw-border-opacity-75 tw-py-2 tw-px-3 tw-rounded-md tw-mt-auto"
                    v-on:click="imageTarget=null">Annuler
            </button>
            <button type="submit"
                    name="action"
                    value="save"
                    class="tw-bg-blue-700 hover:tw-bg-blue-800 tw-py-2 tw-px-3 tw-rounded-md tw-mt-auto tw-ms-auto"
                    v-on:click="imageTarget=null">Enregistrer
            </button>
        </div>
    </div>
    <div x-show="!(imageTarget != null && imageTarget === '<?= $media->getSrc() ?>')"
         class="tw-absolute tw-top-2 tw-right-2 space-x-1">
        <button type="button" v-on:click="imageTarget='<?= $media->getSrc() ?>'"
                class="tw-text-white tw-bg-blue-500 tw-h-8 tw-w-8 tw-rounded-full hover:tw-bg-blue-600">
            <i class="tw-text-sm fa-solid fa-edit"></i>
        </button>
        <button type="button"
                class="delete tw-text-white tw-bg-red-500 tw-h-8 tw-w-8 tw-rounded-full hover:tw-bg-red-600">
            <i class="tw-text-sm fa-solid fa-trash"></i>
        </button>
    </div>
</div>
