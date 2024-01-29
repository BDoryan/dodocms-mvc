$(document).on("click", "[liveeditor-action]", function () {
    // save all blocks
    const blocks = $("[block-name]");
    blocks.each((index, block) => {
        const content = $(block).find("[block-content]");
        const page_block_structure_id = $(block).attr("page-structure-id");

        save(content, block, page_block_structure_id);
    });
});

const save = (content, block, page_block_structure_id) => {
    let data = {};

    // block edition
    const elements = content.find("[editable]");
    elements.each((index, element) => {
        const name = $(element).attr("editable");
        if (element.tagName === "IMG") {
            data[name] = $(element).attr("resource-id");
        } else {
            data[name] = element.innerHTML;
        }
    });

    if (elements.length > 0) {
        $.ajax({
            url: window.toApi("/pages/edit/") + page_block_structure_id,
            method: "POST",
            data,
            success: function (response) {
                window.showToast(new Toast(window.translate(`live-editor.block.update.toast.${response.status}`), window.translate(`live-editor.block.update.toast.${response.message}`), response.status, 2000))
            },
            error: function (response) {
                window.showToast(new Toast(window.translate(`live-editor.block.update.toast.${response.status}`), window.translate(`live-editor.block.update.toast.${response.message}`), response.status, 5000))
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

                    const elements = $(entry).find("[editable-model]");
                    elements.each((index, element) => {
                        const name = $(element).attr("editable-model");
                        data[name] = element.innerHTML;
                    });

                    $.ajax({
                        url: window.toApi("/entries/set/") + model_name + "/" + entity_id,
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

}

const loadLiveEditor = () => {
    const editableElements = $("[editable],[editable-model]");

    editableElements.each((index, element) => {
        if (element.tagName === "IMG") return;
        element.setAttribute('contenteditable', 'true');
        CKEDITOR.inline(element);
    });

    // remove the br tag added by firefox
    $('br[type=_moz]').remove();

    const models = $("[model-name]");
    // add html button to add new entry
    models.each((index, model) => {
        $(model).addClass("position-relative");
        const model_name = $(model).attr("model-name");

        const divNewEntry = document.createElement("div");
        const newEntryButton = document.createElement("button");

        // newEntryButton.innerHTML = window.translate('live-editor.entries.add');
        newEntryButton.setAttribute("model-action", "new");

        // get all entities
        const entities = $(model).find('[entity-id]');
        entities.each((index, entity) => {
            $(entity).addClass('position-relative');

            const actionBar = document.createElement("div");
            actionBar.setAttribute("entity-action-bar", "");

            const deleteEntryButton = document.createElement("button");
            deleteEntryButton.setAttribute("model-action", "delete");

            const editEntryButton = document.createElement("button");
            editEntryButton.setAttribute("model-action", "edit");

            $(actionBar).append(editEntryButton);
            $(actionBar).append(deleteEntryButton);

            $(entity).append(actionBar);
        });

        $(divNewEntry).append(newEntryButton)
        $(model).append(divNewEntry);
    });
}

$(document).ready(() => {
    loadLiveEditor();
});

$(document).on("click", "img[editable]", function () {
    const el = $(this);
    const resource_id = el.attr("resource-id") ?? null;

    openModalWithArguments('ref_set_resource_modal', (resource) => {
        // set resource id
        if(resource == null) {
            el.attr("src", "");
            el.attr("resource-id", "");
            return;
        }

        el.attr("src", resource.src);
        el.attr("resource-id", resource.id);
    }, resource_id);
});

$(document).on("click", "[model-action]", function () {
    const action = $(this).attr("model-action");
    const model = $(this).closest('[model-name]').attr("model-name");

    const entity_id = $(this).closest('[entity-id]').attr("entity-id");

    switch (action) {
        case "new":
            openModalWithArguments('ref_set_entry_modal', model);
            break;
        case "edit":
            openModalWithArguments('ref_set_entry_modal', model, entity_id);
            break;
        case "delete":
            // confirm delete
            const confirmDelete = confirm(window.translate('live-editor.entries.delete.confirm'));
            if (confirmDelete) {
                $.ajax({
                    url: window.toApi("/entries/delete/") + model + "/" + entity_id,
                    method: "POST",
                    success: function (response) {
                        reloadPage(() => {
                            window.showToast(new Toast(window.translate(`live-editor.entries.delete.toast.${response.status}`), window.translate(`live-editor.entries.delete.toast.${response.message}`), response.status, 5000))
                        })
                    }
                });
            }

            break;
        default:
            break;
    }
});

$(document).on("click", "[data-block-action]", function () {
    const action = $(this).attr("data-block-action");
    const block = $(this).closest('[block-name]');
    const content = block.find("[block-content]");

    console.log(action);

    const page_block_id = block.attr("page-structure-id");

    switch (action) {
        case "delete":
            const confirmDelete = confirm(window.translate('live-editor.block.delete.confirm'));
            if (confirmDelete) {
                $.ajax({
                    url: window.toApi("/pages/delete/") + page_block_id,
                    method: "POST",
                    success: function (response) {
                        reloadPage(() => {
                            window.showToast(new Toast(window.translate(`live-editor.block.move.toast.${response.status}`), window.translate(`live-editor.block.move.toast.${response.message}`), response.status, 5000))
                        });
                    },
                    error: function (response) {
                        window.showToast(new Toast(window.translate(`live-editor.block.move.toast.${response.status}`), window.translate(`live-editor.block.move.toast.${response.message}`), response.status, 5000))
                    }
                });
            }
            break;
        case "moveToUp":
            console.log(page_block_id);

            $.ajax({
                url: window.toApi("/pages/move/up/") + page_block_id,
                method: "POST",
                success: function (response) {
                    reloadPage(() => {
                        window.showToast(new Toast(window.translate(`live-editor.block.move.toast.${response.status}`), window.translate(`live-editor.block.move.toast.${response.message}`), response.status, 5000))
                    });
                },
                error: function (response) {
                    window.showToast(new Toast(window.translate(`live-editor.block.move.toast.${response.status}`), window.translate(`live-editor.block.move.toast.${response.message}`), response.status, 5000))
                }
            });
            break;
        case "moveToDown":
            console.log(page_block_id);

            $.ajax({
                url: window.toApi("/pages/move/down/") + page_block_id,
                method: "POST",
                success: function (response) {
                    reloadPage(() => {
                        window.showToast(new Toast(window.translate(`live-editor.block.move.toast.${response.status}`), window.translate(`live-editor.block.move.toast.${response.message}`), response.status, 5000))
                    });
                },
                error: function (response) {
                    window.showToast(new Toast(window.translate(`live-editor.block.move.toast.${response.status}`), window.translate(`live-editor.block.move.toast.${response.message}`), response.status, 5000))
                }
            });
            break;
        case "save":
            // const page_block_structure_id = block.attr("page-structure-id");
            //
            // let data = {};
            //
            // // block edition
            // const elements = content.find("[editable]");
            // elements.each((index, element) => {
            //     const name = $(element).attr("editable");
            //     data[name] = element.innerHTML;
            // });
            //
            // if (elements.length > 0) {
            //     $.ajax({
            //         url: window.toApi("/pages/edit/") + page_block_structure_id,
            //         method: "POST",
            //         data,
            //         success: function (response) {
            //             window.showToast(new Toast(window.translate(`live-editor.structure.update.toast.${response.status}`), window.translate(`live-editor.structure.update.toast.${response.message}`), response.status, 5000))
            //         }
            //     });
            // } else {
            //     console.log("No elements to save.")
            // }
            //
            // // edit entries entity
            // const models = content.find("[model-name]");
            // if (models.length > 0) {
            //     models.each((index, model) => {
            //         const model_name = $(model).attr("model-name");
            //
            //         const entries = $(model).find('[entity-id]');
            //         if (entries.length > 0) {
            //             entries.each((index, entry) => {
            //                 const entity_id = $(entry).attr("entity-id");
            //
            //                 let data = {};
            //
            //                 const elements = $(entry).find("[editable-model]");
            //                 elements.each((index, element) => {
            //                     const name = $(element).attr("editable-model");
            //                     data[name] = element.innerHTML;
            //                 });
            //
            //                 $.ajax({
            //                     url: window.toApi("/entries/set/") + model_name + "/" + entity_id,
            //                     method: "POST",
            //                     data,
            //                     success: function (response) {
            //                         console.log(response);
            //                     }
            //                 });
            //             })
            //         } else {
            //             console.log("No entries to save.")
            //         }
            //     });
            // } else {
            //     console.log("No models to save.")
            // }

            break;
    }
});

window.loadLiveEditor = loadLiveEditor;