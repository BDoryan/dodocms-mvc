const loadLiveEditor = () => {
    const editableElements = $("[editable],[editable-model-data]");

    editableElements.each((index, element) => {
        if (element.tagName === "IMG") return;
        element.setAttribute('contenteditable', 'true');
        CKEDITOR.inline(element);
    });

    $('br[type=_moz]').remove();

    const models = $("[model-name]");
    // add html button to add new entry
    models.each((index, model) => {
        $(model).addClass("position-relative");

        const button = document.createElement("button");
        button.innerHTML = window.translate('live-editor.entries.add');

        button.setAttribute("model-name", $(model).attr("model-name"));
        button.setAttribute("model-action", "new");

        $(model).append(button);
    });
}

$(document).ready(() => {
    loadLiveEditor();
});

$(document).on("click", "[data-block-action]", function () {
    const action = $(this).attr("data-block-action");
    const block = $(this).closest('[block-name]');
    const content = block.find("[block-content]");

    console.log(action);

    switch (action) {
        case "delete":
            const page_block_id = block.attr("page-structure-id");
            console.log(page_block_id);

            $.ajax({
                url: window.toApi("/pages/delete/") + page_block_id,
                method: "POST",
                success: function (response) {
                    reloadPage(() => {
                        window.showToast(new Toast(window.translate(`live-editor.structure.delete.toast.${response.status}`), window.translate(`live-editor.structure.delete.toast.${response.message}`), response.status, 5000))
                    });
                },
                error: function (response) {
                    window.showToast(new Toast(window.translate(`live-editor.structure.delete.toast.${response.status}`), window.translate(`live-editor.structure.delete.toast.${response.message}`), response.status, 5000))
                }
            });
            break;
        case "save":
            const page_block_structure_id = block.attr("page-structure-id");

            let data = {};

            // block edition
            const elements = content.find("[editable]");
            elements.each((index, element) => {
                const name = $(element).attr("editable");
                data[name] = element.innerHTML;
            });

            if (elements.length > 0) {
                $.ajax({
                    url: window.toApi("/pages/edit/") + page_block_structure_id,
                    method: "POST",
                    data,
                    success: function (response) {
                        window.showToast(new Toast(window.translate(`live-editor.structure.update.toast.${response.status}`), window.translate(`live-editor.structure.update.toast.${response.message}`), response.status, 5000))
                    }
                });
            } else {
                console.log("No elements to save.")
            }

            // edit entries entity
            const models = content.find("[model-name]");
            if (models.length > 0) {
                models.each((index, model) => {
                    const model_name = $(model).attr("model-name");

                    const entries = $(model).find('[entity-id]');
                    if (entries.length > 0) {

                        entries.each((index, entry) => {
                            const entity_id = $(entry).attr("entity-id");

                            let data = {};

                            const elements = $(entry).find("[editable-model-data]");
                            elements.each((index, element) => {
                                const name = $(element).attr("editable-model-data");
                                data[name] = element.innerHTML;
                            });

                            $.ajax({
                                url: window.toApi("/entries/update/") + model_name + "/" + entity_id,
                                method: "POST",
                                data,
                                success: function (response) {
                                    console.log(response);
                                }
                            });
                        })
                    } else {
                        console.log("No entries to save.")
                    }
                });
            } else {
                console.log("No models to save.")
            }

            break;
    }
});

window.loadLiveEditor = loadLiveEditor;