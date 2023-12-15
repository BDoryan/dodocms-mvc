Application.get().addRunner(() => {
    const translations = DODOCMS_APPLICATION.getI18n();


    let target_field = null;

    window.openSelectResourcesModal = (multiple = true, target = "") => {
        const elements = $('.modal-resources-selector-background, .modal-resources-selector-content');
        elements.removeClass('dodocms-hidden')

        // const input = $(elements).find('#dropzone-file');
        // input.prop('multiple', multiple);
        target_field = target;
        loadResources();
    }

    function hideEdition(target) {
        let edition = target.find(".edition");

        edition.addClass("dodocms-hidden");
    }

    function showEdition(target) {
        let edition = target.find(".edition");

        edition.removeClass("dodocms-hidden");
    }

    function showActionBar(target) {
        let action_bar = target.find(".action-bar");

        action_bar.removeClass("dodocms-hidden");
    }

    function hideActionBar(target) {
        let action_bar = target.find(".action-bar");

        action_bar.addClass("dodocms-hidden");
    }

    function isToggled(target) {
        let edition = target.find(".edition");
        return !edition.hasClass("dodocms-hidden");
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

    function closeEditionOpened() {
        const parent = $('#resources-selected');
        $(parent).children().each((index, element) => {
            let target = $(element);
            if (isToggled(target)) {
                hideEdition(target);
                showActionBar(target);
            }
        })
    }

    const appendResourceToModalToParent = (parent, resource) => {
        const src = DODOCMS_APPLICATION.toRoot(resource.src);

        let template = $("#resource-for-selector").html();
        let element = $(template);

        element.find("img").attr("src", src);
        element.find("img").attr("alt", resource.alternativeText);

        element.find("input[name='alternativeText']").attr("value", resource.alternativeText);
        element.find("input[name='id']").attr("value", resource.id);

        element.find(".edit").on("click", function () {
            closeEditionOpened();
            toggleEdition(element)
        });

        element.find(".save").on("click", function () {
            toggleEdition(element)
        });

        element.find(".remove").on("click", function () {
                    removeResourceSelected(resource.id);
            updateResourceSelection();
        });

        element.find(".add").on("click", function () {
            addResourceSelected(resource.id);
            updateResourceSelection();
        });


        parent.append(element);
        updateResourceSelection();
    }

    const appendResource = (parent, id) => {
        const url = DODOCMS_APPLICATION.toApi("/resources/html") + '/' + id;

        $.ajax({
            url,
            type: "GET",
            success: function (data) {
                parent.append(data);
            }
        });
    }

    const appendResourceToModal = (parent, id) => {
        const url = DODOCMS_APPLICATION.toApi("/resources/get") + '/' + id;

        $.ajax({
            url,
            type: "GET",
            success: function (data) {
                const resource = data.data;
                appendResourceToModalToParent(parent, resource);
            }
        });
    }

    const updateResourceSelection = () => {
        const parent = $('#resources-selected');
        const input = $("input[name='" + target_field + "']");
        let resources = getResourcesSelected();

        parent.children().each((index, element) => {
            const target = $(element);
            const add = target.find(".add");
            const remove = target.find(".remove");

            const id = target.find("input[name='id']").val();
            if (resources.includes(id)) {
                add.addClass('dodocms-hidden');
                remove.removeClass('dodocms-hidden');
            } else {
                add.removeClass('dodocms-hidden');
                remove.addClass('dodocms-hidden');
            }
        })
    }

    const getResourcesSelected = () => {
        const input = $('input[name="' + target_field + '"]')
        return input.val().split(',');
    }

    const updateResourceSelectionOfSelect = () => {
        const input = $('input[name="' + target_field + '"]')
        const resources = getResourcesSelected();
        const resource_items = input.parent().find(".resources-items");
        resource_items.empty();
        if(resources.length > 0) {
            resources.forEach((resource) => {
                appendResource(resource_items, resource);
            });
        }
    }

    const addResourceSelected = (id) => {
        const input = $('input[name="' + target_field + '"]')
        let resources = input.val().split(',');
        resources.push(id);
        input.val(resources.join(','));
        updateResourceSelectionOfSelect();
    }

    const removeResourceSelected = (id) => {
        const input = $('input[name="' + target_field + '"]')
        let resources = input.val().split(',');
        resources = resources.filter((resource) => {
            return resource != id;
        });
        input.val(resources.join(','));
        updateResourceSelectionOfSelect();
    }

    const loadResources = async () => {
        const resources = getResourcesSelected();
        const parent = $('#resources-selected');
        parent.empty();

        await resources.forEach((resource) => {
            appendResourceToModal(parent, resource);
        });

        const url = DODOCMS_APPLICATION.toApi("/resources");

        await $.ajax({
            url,
            type: "GET",
            success: function (data) {
                const all_resources = data.data;
                all_resources.forEach((resource) => {
                    if (!resources.includes(resource.id+"")) {
                        appendResourceToModalToParent(parent, resource);
                    }
                });
            }
        });
    }

    const closeSelectResourcesModal = () => {
        target_field = null;
        const elements = $('.modal-resources-selector-background, .modal-resources-selector-content');
        elements.addClass('dodocms-hidden')
    }
    window.closeSelectResourcesModal = closeSelectResourcesModal;

    $(document).on("click", ".close-resources-selector-modal", (e) => {
        closeSelectResourcesModal();
    })
})