$(document).ready(() => {
    const editableElements = $("[editable]");

    editableElements.each((index, element) => {
        element.setAttribute('contenteditable', 'true');
        CKEDITOR.inline(element);
    });

    $('br[type=_moz]').remove();
});

$(document).on("click", "[data-block-action]", function () {
    const action = $(this).attr("data-block-action");
    const block = $(this).closest('[block-name]');
    const content = block.find("[block-content]");

    switch (action) {
        case "remove":

            break;
        case "save":
            const page_block_id = block.attr("page-structure-id");

            let data = {};

            elements = content.find("[editable]");
            elements.each((index, element) => {
                const name = $(element).attr("editable");
                const html = element.innerHTML;

                data[name] = html;
            });

            $.ajax({
                url: DODOCMS_APPLICATION.toApi("/pages/edit/") + page_block_id,
                method: "POST",
                data,
                success: function (response) {
                    console.log(response);
                }
            });
            break;
    }
});