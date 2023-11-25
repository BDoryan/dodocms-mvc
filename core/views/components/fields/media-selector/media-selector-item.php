<div class="media relative w-full h-64 rounded-lg flex-shrink-0 shadow-lg flex group image-container hover:cursor-pointer bg-gray-500 bg-opacity-25">
    <img class="h-full object-contain mx-auto" src="<?= $media->getSrc() ?>"
         alt="<?= $media->getAlternativeText() ?>"
         style="background-size: contain; background: url('<?= Application::toURL("/admin/assets/imgs/transparent.jpg") ?>'); object-fit: contain; object-position: center;">
    <div class="opacity-0 group-hover:opacity-100 absolute z-10 top-0 right-0 bottom-0 left-0 flex flex-col">
        <div class="ms-auto me-3 mt-3 flex flex-row gap-2"
             x-show="!(imageTarget != null && imageTarget === '<?= $media->getSrc() ?>')">
            <a target="_blank" href="<?= Application::toURL($media->getDefaultSrc()) ?>"
               class="text-white bg-blue-500 h-8 w-8 rounded-full hover:bg-blue-600 flex">
                <i class="text-sm fa-solid fa-eye m-auto"></i>
            </a>
            <button type="button" @click="imageTarget='<?= $media->getSrc() ?>'"
                    class="text-white bg-blue-500 h-8 w-8 rounded-full hover:bg-blue-600">
                <i class="text-sm fa-solid fa-edit"></i>
            </button>
            <button type="button"
                    class="remove text-white bg-red-500 h-8 w-8 rounded-full hover:bg-red-600">
                <i class="text-sm fa-solid fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="z-30 rounded-lg bg-gray-800 bg-opacity-75 p-3 absolute top-0 bottom-0 left-0 right-0 flex flex-col"
         x-show="imageTarget === '<?= $media->getSrc() ?>'" class="mt-2">
        <input type="hidden" name="id" value="<?= $media->getId() ?>">
        <?= Text::create()->label("Texte alternatif")->value($media->getAlternativeText())->name("alternativeText")->render() ?>
        <div class="mt-auto flex flex-row">
            <button type="button"
                    class="bg-gray-700 bg-opacity-50 hover:bg-opacity-100 border-[1px] border-gray-300 border-opacity-50 hover:border-opacity-75 py-2 px-3 rounded-md mt-auto"
                    @click="imageTarget=null">Annuler
            </button>
            <button type="button"
                    class="save bg-blue-700 hover:bg-blue-800 py-2 px-3 rounded-md mt-auto ms-auto"
                    @click="imageTarget=null">Enregistrer
            </button>
        </div>
    </div>
</div>