<?php
$list_id = "";
foreach ($this->medias as $media) {
    $list_id .= empty($list_id) ? $media->getId() : "," . $media->getId();
}
?>
<input type="hidden" class="text-black" name="<?= $this->name ?>" value="<?= $list_id ?>">
<div class="w-full relative">
    <div class="top-2 left-2 absolute flex flex-col gap-2 z-50">
        <button data-modal-target="file-upload" data-modal-toggle="file-upload" type="button"
                class="hidden z-50 text-white bg-green-600 h-10 w-10 rounded-full hover:bg-green-700 mx-auto mt-auto">
            <i class="text-lg fa-solid fa-plus"></i>
        </button>
        <button data-modal-target="file-upload" data-modal-toggle="file-upload" type="button"
                class="z-50 text-white bg-indigo-500 h-10 w-10 rounded-full hover:bg-indigo-600 mx-auto mt-auto">
            <i class="text-lg fa-solid fa-upload"></i>
        </button>
    </div>
    <div class="media-list mx-auto relative bg-gray-700 border border-gray-500 rounded-md text-white outline-none focus:border-gray-400 mb-1 h-80 flex flex-col gap-y-4 p-4 overflow-y-auto"
         x-data="{ imageTarget: null }">
        <?php foreach ($this->medias as $media) {
            include "media-selector-item.php";
        } ?>
    </div>
</div>
<script>
    $(document).ready(() => {
        $(document).on("click", ".media .save", function (e) {
            e.preventDefault();

            const form = $(this).closest(".media");

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

        $(document).on("click", ".media .remove", function (e) {
            e.preventDefault();

            const media = $(this).closest(".media");
            let id = media.find("input[name='id']").val();

            const input = $("input[name='<?= $this->name ?>']");

            let ids = input.val().split(",");
            ids = ids.filter(function (value, index, arr) {
                return value !== id;
            });
            input.val(ids.join(","));
            media.remove();
        });
    })

    $(document).on('media:file_uploaded', (event, data) => {
        console.log(data);
        const media_id = data.id;
        const input = document.querySelector('input[name="<?= $this->name ?>"]');
        const value = input.value;
        const values = value.split(',');
        values.push(media_id);
        input.value = values.join(',');

        // add to list of medias
        const media_list = document.querySelector('.media-list');
        const url = '<?= Application::toURL("/admin/medias/upload/media-item"); ?>/' + media_id;
        fetch(url)
            .then(response => response.text())
            .then(data => {
                media_list.innerHTML += data;
            });
    })
</script>