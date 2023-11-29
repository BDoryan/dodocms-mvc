Application.get().addRunner(() => {
    const translations = DODOCMS_APPLICATION.getI18n();
    console.log("getTranslation:")
    console.log(translations.translate("admin.panel.resources.upload.any_files"));

    const CONTEXTS = {
        "any_files": translations.translate("admin.panel.resources.upload.any_files"),
        "files_count": translations.translate("admin.panel.resources.upload.files_count"),
        "upload_in_progress": translations.translate("admin.panel.resources.upload.upload_in_progress"),
        "finish": translations.translate("admin.panel.resources.upload.upload_finish"),
        "route_api_upload": "/resources/upload"
    }

    console.log(CONTEXTS);

    let selected_files = [];

    const files = $("#files");
    const state = $("#state");
    const input = $("#dropzone-file");
    const dropzone = $("label[for='dropzone-file']");
    const start = $("#start");

    function disableStartButton() {
        start.prop("disabled", true);
        start.addClass("opacity-50 cursor-not-allowed")
    }

    function enableStartButton() {
        start.prop("disabled", false);
        start.removeClass("opacity-50 cursor-not-allowed")
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

            console.log(file, i)

            const alternativeText = $(files).find("input[name='alternativeText']").val();

            formData.append("file", file);
            formData.append("alternativeText", alternativeText);
            console.log(formData);

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
                    $(document).trigger("media:file_uploaded", result.data);
                } else {
                    console.error("Erreur lors de l'envoie du fichier");
                }
            } catch (e) {
                console.error(e)
            }
        }

        // finish
        showDropzone();
        clearImages();
        state.text(CONTEXTS.finish);
        toast("Bibliothèque de média", "Les médias sélectionnés ont bien été mis en ligne.", "success", 5000)

        $(document).trigger("media:uploaded");

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
            console.log(index, element)
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
            console.log("show edition")
        } else {
            hideEdition(target);
            showActionBar(target);
            console.log("hide edition")
        }
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
            console.log(index, element)
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
            console.log("show edition")
        } else {
            hideEdition(target);
            showActionBar(target);
            console.log("hide edition")
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
            console.log(selected_files)
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

})