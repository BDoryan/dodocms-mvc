<?php
$list_id = "";
foreach ($this->medias as $media) {
    $list_id .= empty($list_id) ? $media->getId() : "," . $media->getId();
}
?>
<input type="hidden" name="<?= $this->name ?>" value="<?= $list_id ?>">
<div class="dodocms-w-full">
    <div class="dodocms-max-dodocms-w-screen-lg dodocms-mx-auto dodocms-bg-gray-700 dodocms-border dodocms-border-gray-500 dodocms-rounded-md dodocms-text-white dodocms-outline-none focus:dodocms-border-gray-400 dodocms-mb-1">
        <div id="image-gallery" class="dodocms-relative" x-data="{ imageTarget: null }">
            <div id="image-slider" class="dodocms-flex dodocms-overflow-x-auto">
                <?php if(empty($this->medias)) { ?>
                <div class="media dodocms-relative dodocms-w-full dodocms-h-64 dodocms-rounded-lg dodocms-flex-shrink-0 dodocms-shadow-lg dodocms-flex group image-container hover:cursor-pointer">
                    <p class="dodocms-text-lg dodocms-m-auto    <">Ajouter du contenu</p>
                </div>
                <?php } ?>
                <?php foreach ($this->medias as $media): ?>
                <div class="media dodocms-relative dodocms-w-full dodocms-h-64 dodocms-rounded-lg dodocms-flex-shrink-0 dodocms-shadow-lg dodocms-flex group image-container hover:cursor-pointer">
                    <img class="dodocms-h-full object-contain dodocms-mx-auto" src="<?= $media->getSrc() ?>"
                         alt="<?= $media->getAlternativeText() ?>"
                         style="background-size: contain; background: url('<?= Application::toURL("/admin/assets/imgs/transparent.jpg") ?>'); object-fit: contain; object-position: center;">
                    <div class="dodocms-opacity-0 dodocms-group-p-hover:dodocms-opacity-100 dodocms-absolute dodocms-z-10 dodocms-top-0 dodocms-right-0 dodocms-bottom-0 dodocms-left-0 dodocms-flex dodocms-flex-col">
                        <div class="dodocms-ms-auto dodocms-me-3 dodocms-mt-3 dodocms-flex dodocms-flex-row dodocms-p-2"
                             x-show="!(imageTarget != null && imageTarget === '<?= $media->getSrc() ?>')">
                            <a href="<?= Application::toURL($media->getDefaultSrc()) ?>"
                               class="dodocms-text-white dodocms-bg-blue-500 dodocms-h-8 dodocms-w-8 dodocms-rounded-full hover:dodocms-bg-blue-600 dodocms-flex">
                                <i class="dodocms-text-sm fa-solid fa-eye dodocms-m-auto"></i>
                            </a>
                            <button type="button" @click="imageTarget='<?= $media->getSrc() ?>'"
                                    class="dodocms-text-white dodocms-bg-blue-500 dodocms-h-8 dodocms-w-8 dodocms-rounded-full hover:dodocms-bg-blue-600">
                                <i class="dodocms-text-sm fa-solid fa-edit"></i>
                            </button>
                            <button type="button"
                                    class="remove dodocms-text-white dodocms-bg-red-500 dodocms-h-8 dodocms-w-8 dodocms-rounded-full hover:dodocms-bg-red-600">
                                <i class="dodocms-text-sm fa-solid fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="dodocms-z-30 dodocms-rounded-lg dodocms-bg-gray-800 dodocms-bg-opacity-75 dodocms-p-3 dodocms-absolute dodocms-top-0 dodocms-bottom-0 dodocms-left-0 dodocms-right-0 dodocms-flex dodocms-flex-col"
                         x-show="imageTarget === '<?= $media->getSrc() ?>'" class="dodocms-mt-2">
                        <input type="hidden" name="id" value="<?= $media->getId() ?>">
                        <?= Text::create()->label("Texte alternatif")->value($media->getAlternativeText())->name("alternativeText")->render() ?>
                        <div class="dodocms-mt-auto dodocms-flex dodocms-flex-row">
                            <button type="button"
                                    class="dodocms-bg-gray-700 dodocms-bg-opacity-50 hover:dodocms-bg-opacity-100 dodocms-border-[1px] dodocms-border-gray-300 dodocms-border-opacity-50 hover:dodocms-border-opacity-75 dodocms-py-2 dodocms-px-3 dodocms-rounded-md dodocms-mt-auto"
                                    @click="imageTarget=null">Annuler
                            </button>
                            <button type="button"
                                    class="save dodocms-bg-blue-700 hover:dodocms-bg-blue-800 dodocms-py-2 dodocms-px-3 dodocms-rounded-md dodocms-mt-auto dodocms-ms-auto"
                                    @click="imageTarget=null">Enregistrer
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <button type="button" id="prev-button"
                    class="hover:dodocms-bg-blue-700 dodocms-z-20 dodocms-text-lg dodocms-h-10 dodocms-w-10 dodocms-bg-blue-600 dodocms-rounded-full dodocms-absolute dodocms-top-1/2 dodocms-left-2 transform -translate-y-1/2 dodocms-text-white hover:dodocms-text-gray-200">
                &larr;
            </button>
            <button type="button" id="next-button"
                    class="hover:dodocms-bg-blue-700 dodocms-z-20 dodocms-text-lg dodocms-h-10 dodocms-w-10 dodocms-bg-blue-600 dodocms-rounded-full dodocms-absolute dodocms-top-1/2 dodocms-right-2 transform -translate-y-1/2 dodocms-text-white hover:dodocms-text-gray-200">
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