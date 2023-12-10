$(document).ready(() => {
    const editableElements = $("[editable]");

    editableElements.each((index, element) => {
        element.setAttribute('contenteditable', 'true');
        CKEDITOR.inline(element);
    });
});

$(document).on("click", "[data-block-action]", function () {
    const action = $(this).attr("data-block-action");
    const block = $(this).closest('[block-name]');
    const content = block.find("[block-content]");

    switch (action) {
        case "remove":

            break;
        case "save":
            elements = content.find("[editable]");
            elements.each((index, element) => {
                const page_block_id = block.getAttribute("page-block-id");
                const name = element.getAttribute("editable");
                const html = element.innerHTML;
            });
            break;
    }
});