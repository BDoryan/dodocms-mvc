<?php



$list_id = "";
foreach ($this->medias as $media) {
    $list_id .= empty($list_id) ? $media->getId() : "," . $media->getId();
}
?>
<input type="hidden" name="<?= $this->name ?>" value="<?= $list_id ?>">
<div class="tw-w-full">
    <div class="tw-max-tw-w-screen-lg tw-mx-auto tw-bg-gray-700 tw-border tw-border-gray-500 tw-rounded-md tw-text-white tw-outline-none focus:tw-border-gray-400 tw-mb-1">
        <div id="image-gallery" class="tw-relative" x-data="{ imageTarget: null }">
            <div id="image-slider" class="tw-flex tw-overflow-x-auto">
                <?php if(empty($this->medias)) { ?>
                <div class="media tw-relative tw-w-full tw-h-64 tw-rounded-lg tw-flex-shrink-0 tw-shadow-lg tw-flex group image-container hover:cursor-pointer">
                    <p class="tw-text-lg tw-m-auto    <">Ajouter du contenu</p>
                </div>
                <?php } ?>
                <?php foreach ($this->medias as $media): ?>
                <div class="media tw-relative tw-w-full tw-h-64 tw-rounded-lg tw-flex-shrink-0 tw-shadow-lg tw-flex group image-container hover:cursor-pointer">
                    <img class="tw-h-full object-contain tw-mx-auto" src="<?= $media->getSrc() ?>"
                         alt="<?= $media->getAlternativeText() ?>"
                         style="background-size: contain; background: url('<?= Application::toURL("/admin/assets/imgs/transparent.jpg") ?>'); object-fit: contain; object-position: center;">
                    <div class="tw-opacity-0 tw-group-p-hover:tw-opacity-100 tw-absolute tw-z-10 tw-top-0 tw-right-0 tw-bottom-0 tw-left-0 tw-flex tw-flex-col">
                        <div class="tw-ms-auto tw-me-3 tw-mt-3 tw-flex tw-flex-row tw-p-2"
                             x-show="!(imageTarget != null && imageTarget === '<?= $media->getSrc() ?>')">
                            <a href="<?= Application::toURL($media->getDefaultSrc()) ?>"
                               class="tw-text-white tw-bg-blue-500 tw-h-8 tw-w-8 tw-rounded-full hover:tw-bg-blue-600 tw-flex">
                                <i class="tw-text-sm fa-solid fa-eye tw-m-auto"></i>
                            </a>
                            <button type="button" v-on:click="imageTarget='<?= $media->getSrc() ?>'"
                                    class="tw-text-white tw-bg-blue-500 tw-h-8 tw-w-8 tw-rounded-full hover:tw-bg-blue-600">
                                <i class="tw-text-sm fa-solid fa-edit"></i>
                            </button>
                            <button type="button"
                                    class="remove tw-text-white tw-bg-red-500 tw-h-8 tw-w-8 tw-rounded-full hover:tw-bg-red-600">
                                <i class="tw-text-sm fa-solid fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="tw-z-30 tw-rounded-lg tw-bg-gray-800 tw-bg-opacity-75 tw-p-3 tw-absolute tw-top-0 tw-bottom-0 tw-left-0 tw-right-0 tw-flex tw-flex-col"
                         x-show="imageTarget === '<?= $media->getSrc() ?>'" class="tw-mt-2">
                        <input type="hidden" name="id" value="<?= $media->getId() ?>">
                        <?= Text::create()->label("Texte alternatif")->value($media->getAlternativeText())->name("alternativeText")->render() ?>
                        <div class="tw-mt-auto tw-flex tw-flex-row">
                            <button type="button"
                                    class="tw-bg-gray-700 tw-bg-opacity-50 hover:tw-bg-opacity-100 tw-border-[1px] tw-border-gray-300 tw-border-opacity-50 hover:tw-border-opacity-75 tw-py-2 tw-px-3 tw-rounded-md tw-mt-auto"
                                    v-on:click="imageTarget=null">Annuler
                            </button>
                            <button type="button"
                                    class="save tw-bg-blue-700 hover:tw-bg-blue-800 tw-py-2 tw-px-3 tw-rounded-md tw-mt-auto tw-ms-auto"
                                    v-on:click="imageTarget=null">Enregistrer
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <button type="button" id="prev-button"
                    class="hover:tw-bg-blue-700 tw-z-20 tw-text-lg tw-h-10 tw-w-10 tw-bg-blue-600 tw-rounded-full tw-absolute tw-top-1/2 tw-left-2 transform -translate-y-1/2 tw-text-white hover:tw-text-gray-200">
                &larr;
            </button>
            <button type="button" id="next-button"
                    class="hover:tw-bg-blue-700 tw-z-20 tw-text-lg tw-h-10 tw-w-10 tw-bg-blue-600 tw-rounded-full tw-absolute tw-top-1/2 tw-right-2 transform -translate-y-1/2 tw-text-white hover:tw-text-gray-200">
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
        const imageSlider = $('#resource-slider');
        const prevButton = $('#prev-button');
        const nextButton = $('#next-button');

        // media button edit
        const editButton = $('.media .edit');

        let currentImageIndex = 0;

        function showImage(index) {
            const images = $('#resource-slider > div');
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
            const images = $('#resource-slider > div');
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