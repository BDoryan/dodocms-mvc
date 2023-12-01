import Toast from "../components/toast/Toast.js";

Application.get().addRunner(() => {
    const translations = DODOCMS_APPLICATION.getI18n();

    const CONTEXTS = {
        "any_files": translations.translate("admin.panel.resources.upload.any_files"),
        "files_count": translations.translate("admin.panel.resources.upload.files_count"),
        "upload_in_progress": translations.translate("admin.panel.resources.upload.upload_in_progress"),
        "finish": translations.translate("admin.panel.resources.upload.upload_finish"),
        "route_api_upload": DODOCMS_APPLICATION.toApi("/resources/upload")
    }

    let selected_files = [];

    const files = $("#files");
    const state = $("#state");
    const input = $("#dropzone-file");
    const dropzone = $("label[for='dropzone-file']");
    const start = $("#start");

    function disableStartButton() {
        start.prop("disabled", true);
        start.addClass("opacity-50 cursor-not-allowed hover:none")
    }

    function enableStartButton() {
        start.prop("disabled", false);
        start.removeClass("opacity-50 cursor-not-allowed hover:none")
    }

    function hideDropzone() {
        dropzone.addClass("hidden");
    }

    function showDropzone() {
        dropzone.removeClass("hidden");
    }

    async function sendFile(formData, onprogress) {
        return new Promise((resolve, reject) => {
            var xhr = new XMLHttpRequest();

            xhr.upload.onprogress = function (event) {
                if (event.lengthComputable) {
                    var percentComplete = (event.loaded / event.total) * 100;
                    onprogress(percentComplete);
                }
            };

            xhr.onload = function () {
                if (xhr.status === 200) {
                    resolve(JSON.parse(xhr.response));
                } else {
                    reject('Error uploading file: ' + xhr.status);
                }
            };

            xhr.open('POST', CONTEXTS.route_api_upload, true);
            xhr.send(formData);
        });
    }

    let uploading = false;

    async function startUpload() {

        if (uploading)
            return;
        uploading = true;
        state.text(CONTEXTS.upload_in_progress);
        // disable the start button
        disableStartButton();

        // disable the modification on media
        closeEditionOpened();
        hideAllActionBar();

        // hide the drag and drop
        hideDropzone();

        // copy array
        let selected_files_copy = Array.from(selected_files);

        // start upload
        for (let i = 0; i < selected_files_copy.length; i++) {
            const file = selected_files_copy[i].file;
            const element = selected_files_copy[i].element;
            const formData = new FormData();

            const alternativeText = $(files).find("input[name='alternativeText']").val();

            formData.append("file", file);
            formData.append("alternativeText", alternativeText);

            try {
                const progression = element.find(".progression");
                const progressBar = progression.find(".progress-bar");
                const progressText = progressBar.find(".progress-number");

                progression.removeClass("hidden");
                const result = await sendFile(formData, function (progress) {
                    progress = progress.toFixed(0);
                    progressBar.css("width", progress + "%");
                    progressText.text(progress);
                });
                if (result.status === "success") {
                    // element.remove();
                    removeFile(file);
                    $(document).trigger("resource:file_uploaded", result);
                } else {
                    $(document).trigger("resource:upload_failed", result);
                }
            } catch (e) {
                console.error(e)
            }
        }

        // finish
        showDropzone();
        clearImages();
        state.text(CONTEXTS.finish);
        let toast = new Toast(translations.translate('admin.panel.resources.title'), translations.translate('admin.panel.resources.upload.upload_with_success'), "success", 10000);
        toast.render();

        $(document).trigger("resource:uploaded");

        uploading = false;
        enableStartButton()
    }

    function clearImages() {
        files.empty();
        for (let i = 0; i < selected_files.length; i++) {
            removeFile(selected_files[i]);
        }
        update();
    }

    function hideAllActionBar() {
        $(files).children().each((index, element) => {
            let target = $(element);
            hideActionBar(target);
        })
    }

    function hideEdition(target) {
        let edition = target.find(".edition");

        edition.addClass("hidden");
    }

    function showEdition(target) {
        let edition = target.find(".edition");

        edition.removeClass("hidden");
    }

    function showActionBar(target) {
        let action_bar = target.find(".action-bar");

        action_bar.removeClass("hidden");
    }

    function hideActionBar(target) {
        let action_bar = target.find(".action-bar");

        action_bar.addClass("hidden");
    }

    function isToggled(target) {
        let edition = target.find(".edition");
        return !edition.hasClass("hidden");
    }

    function closeEditionOpened() {
        $(files).children().each((index, element) => {
            let target = $(element);
            if (isToggled(target)) {
                hideEdition(target);
                showActionBar(target);
            }
        })
    }

    function toggleEdition(target) {
        if (!isToggled(target)) {
            showEdition(target);
            hideActionBar(target);
        } else {
            hideEdition(target);
            showActionBar(target);
        }
    }

    function toggleEdition(target) {
        if (!isToggled(target)) {
            showEdition(target);
            hideActionBar(target);
        } else {
            hideEdition(target);
            showActionBar(target);
        }
    }

    function addFile(target_files) {
        for (let i = 0; i < target_files.length; i++) {

            let file = target_files[i];
            const url = URL.createObjectURL(file);

            let template = $("#image").html();
            let element = $(template);

            element.find("img").attr("src", url);
            element.find("img").attr("alt", file.name);
            element.find(".edit").on("click", function () {
                closeEditionOpened();
                toggleEdition(element)
            });
            element.find(".finish").on("click", function () {
                toggleEdition(element)
            });
            element.find(".delete").on("click", function () {
                element.remove();
                removeFile(file);
            });

            files.append(element);
            selected_files.push({element, file});
        }
        update();
    }

    function removeFile(target_file) {
        selected_files = selected_files.filter(item => item.file !== target_file);
        update();
    }

    function update() {
        if (uploading) {
            state.text(CONTEXTS.upload_in_progress.replace("{count}", selected_files.length + ""));
            return;
        }

        if (selected_files.length > 0) {
            state.text(CONTEXTS.files_count.replace("{count}", selected_files.length + ""));
            enableStartButton();
        } else {
            disableStartButton();
            state.text(CONTEXTS.any_files);
        }
    }

    $(document).ready(function () {
        update();

        start.on("click", function () {
            startUpload();
        });

        input.on("change", function (e) {
            addFile(e.target.files);
        });
    });

    // function updateTextCounter() {
    //     const resources = $(".resources-container");
    //     const text = $(".resources-text-count");
    //
    //     const numberOfChildren = $('.resources-items').children().length;
    //     text.text(translations.translate("admin.panel.resources.count", {'count': numberOfChildren}));
    // }

    function reloadResources() {
        // get the current page url and load the id #resources
        const url = new URL(window.location.href);
        const resources = $(".resources-container");
        resources.load(url.href + " .resources-container > *", () => {
            // updateTextCounter();
        });
    }

    $(document).on('resource:uploaded', () => {
        reloadResources();
    })

    $(document).on('resource:upload_failed', (event, data) => {
        console.log(data);
        let toast = new Toast(translations.translate('error.message'), data.message, "danger", 15000);
        toast.render();
    })


    $(document).on("click", ".resources-items .delete", (e) => {
        e.preventDefault();

        const delete_button = $(e.target);

        const element_media_list = delete_button.closest(".resource-item");
        const form = delete_button.closest("form");
        let id = form.find("input[name='id']").val();

        $.ajax({
            url: DODOCMS_APPLICATION.toApi("/resources/delete") + '/' + id,
            type: "DELETE",
            success: function (data) {
                if (data.status === "success") {
                    // element_media_list.remove();
                    let toast = new Toast(translations.translate('admin.panel.resources.title'), translations.translate('admin.panel.resources.deleted'), "success", 5000);
                    toast.render();
                    reloadResources();
                    // updateTextCounter();
                } else {
                    let toast = new Toast(translations.translate('error.message'), data.message, "danger", 15000);
                    toast.render();
                }
            }
        });
    });

    $(document).on("click", ".resources-items .save", (e) => {
        e.preventDefault();

        const edit_button = $(e.target);

        const form = edit_button.closest("form");

        let id = form.find("input[name='id']").val();
        let alternativeText = form.find("input[name='alternativeText']").val();

        $.ajax({
            url: DODOCMS_APPLICATION.toApi("/resources/edit") + '/' + id,
            type: "PUT",
            data: {
                alternativeText
            },
            success: function (data) {
                if (data.status === "success") {
                    let toast = new Toast(translations.translate('admin.panel.resources.title'), translations.translate('admin.panel.resources.edited'), "success", 5000);
                    toast.render();
                } else {
                    let toast = new Toast(translations.translate('error.message'), data.message, "danger", 15000);
                    toast.render();
                }
            }
        });
    });
})