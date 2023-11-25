<?php
$list_id = "";
foreach ($this->medias as $media) {
    $list_id .= empty($list_id) ? $media->getId() : "," . $media->getId();
}
?>
<input type="hidden" name="<?= $this->name ?>" value="<?= $list_id ?>">
<div class="w-full">
    <div class="max-w-screen-lg mx-auto bg-gray-700 border border-gray-500 rounded-md text-white outline-none focus:border-gray-400 mb-1">
        <div id="image-gallery" class="relative" x-data="{ imageTarget: null }">
            <div id="image-slider" class="flex overflow-x-auto">
                <?php if(empty($this->medias)) { ?>
                <div class="media relative w-full h-64 rounded-lg flex-shrink-0 shadow-lg flex group image-container hover:cursor-pointer">
                    <p class="text-lg m-auto    <">Ajouter du contenu</p>
                </div>
                <?php } ?>
                <?php foreach ($this->medias as $media): ?>
                <div class="media relative w-full h-64 rounded-lg flex-shrink-0 shadow-lg flex group image-container hover:cursor-pointer">
                    <img class="h-full object-contain mx-auto" src="<?= $media->getSrc() ?>"
                         alt="<?= $media->getAlternativeText() ?>"
                         style="background-size: contain; background: url('<?= Application::toURL("/admin/assets/imgs/transparent.jpg") ?>'); object-fit: contain; object-position: center;">
                    <div class="opacity-0 group-hover:opacity-100 absolute z-10 top-0 right-0 bottom-0 left-0 flex flex-col">
                        <div class="ms-auto me-3 mt-3 flex flex-row gap-2"
                             x-show="!(imageTarget != null && imageTarget === '<?= $media->getSrc() ?>')">
                            <a href="<?= Application::toURL($media->getDefaultSrc()) ?>"
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
                <?php endforeach; ?>
            </div>
            <button type="button" id="prev-button"
                    class="hover:bg-blue-700 z-20 text-lg h-10 w-10 bg-blue-600 rounded-full absolute top-1/2 left-2 transform -translate-y-1/2 text-white hover:text-gray-200">
                &larr;
            </button>
            <button type="button" id="next-button"
                    class="hover:bg-blue-700 z-20 text-lg h-10 w-10 bg-blue-600 rounded-full absolute top-1/2 right-2 transform -translate-y-1/2 text-white hover:text-gray-200">
                &rarr;
            </button>
        </div>
    </div>
</div>

<script>
    $(".media .save").on("click", function (e) {
        e.preventDefault();

        const form = $(this).closest("form");

        let id = form.find("input[name='id']").val();
        let alternativeText = form.find("input[name='alternativeText']").val();

        $.ajax({
            url: "<?= Application::toURL("/admin/api/media/edit") ?>/" + id,
            type: "PUT",
            data: {
                alternativeText
            },
            success: function (data) {
                if (data.status === "success") {
                    toast("Bibliothèque de média", "Le média sélectionné à bien été mis à jour.", "success", 5000);
                } else {
                    toast("Une erreur survenue lors de votre requête", data.message, "danger", 15000);
                }
            }
        });
    });

    $(".media .remove").on("click", function (e) {
        e.preventDefault();

        const media = $(this).closest(".media");
        const form = $(this).closest("form");
        let id = form.find("input[name='id']").val();

        const input = $("input[name='<?= $this->name ?>']");

        let ids = input.val().split(",");
        ids = ids.filter(function (value, index, arr) {
            return value !== id;
        });
        input.val(ids.join(","));
        media.remove();
    });

    $(document).ready(function () {
        const imageSlider = $('#image-slider');
        const prevButton = $('#prev-button');
        const nextButton = $('#next-button');

        // media button edit
        const editButton = $('.media .edit');

        let currentImageIndex = 0;

        function showImage(index) {
            const images = $('#image-slider > div');
            images.hide();
            images.eq(index).show();
        }

        function showPreviousImage() {
            if (currentImageIndex > 0) {
                currentImageIndex--;
                showImage(currentImageIndex);
            }
        }

        function showNextImage() {
            const images = $('#image-slider > div');
            if (currentImageIndex < images.length - 1) {
                currentImageIndex++;
                showImage(currentImageIndex);
            }
        }

        prevButton.on('click', showPreviousImage);
        nextButton.on('click', showNextImage);

        showImage(currentImageIndex);
    });
</script>