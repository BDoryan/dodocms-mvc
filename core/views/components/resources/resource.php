<form class="relative h-full" method="POST">
<form class="relative h-full" method="POST">
    <div class="h-full rounded-lg border-gray-300 border-opacity-25" style="height: 200px;">
        <img class="rounded-lg h-full w-full"
             :class="{'blur-sm p-2': imageTarget === '<?= $resource->getSrc() ?>'}"
             src="<?= $resource->getSrc() ?>"
             alt="<?= $resource->getAlternativeText() ?>"
             style="background-size: contain; background: url('<?= Application::get()->toURL("/core/assets/imgs/transparent.jpg") ?>'); object-fit: contain; object-position: center;">
        <a target="_blank" href="<?= $resource->getURL() ?>"
           class="absolute inset-0 flex items-center justify-center opacity-0 hover:opacity-100 transition duration-300 ease-in-out bg-black bg-opacity-25">
            <i class="fas fa-eye text-5xl text-white text-opacity-75 hover:text-opacity-90 transition-colors"></i>
        </a>
    </div>
    <div class="rounded-lg bg-gray-800 bg-opacity-75 p-3 absolute top-0 bottom-0 left-0 right-0 flex flex-col"
         x-cloak x-show="imageTarget === '<?= $resource->getSrc() ?>'" class="mt-2">
        <input type="hidden" name="id" value="<?= $resource->getid() ?>">
        <?= Text::create()
            ->label("Texte alternatif")
            ->value($resource->getAlternativeText())
            ->name("alternativeText")
            ->render() ?>
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
    <div x-cloak x-show="!(imageTarget != null && imageTarget === '<?= $resource->getSrc() ?>')"
         class="absolute top-2 right-2 space-x-1">
        <button type="button" @click="imageTarget='<?= $resource->getSrc() ?>'"
                class="text-white bg-blue-500 h-8 w-8 rounded-full hover:bg-blue-600">
            <i class="text-sm fa-solid fa-edit"></i>
        </button>
        <button type="button"
                class="delete text-white bg-red-500 h-8 w-8 rounded-full hover:bg-red-600">
            <i class="text-sm fa-solid fa-trash"></i>
        </button>
    </div>
</form>
