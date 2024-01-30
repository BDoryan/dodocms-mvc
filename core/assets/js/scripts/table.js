$(document).on("click", "#add-attribute", function (event) {
    const container = $("#attributes-container");

    const form = container.find("#attribute-form");

    console.log(form);

    const url = toRoot("/admin/tables/attribute");
    fetch(url)
        .then(response => response.text())
        .then(clonedForm => {
            container.append(clonedForm);
        })
        .catch(error => {
            console.error('Une erreur s\'est produite lors de la requête : ', error);
        });
});

$(document).on("click", "#remove-attribute", function (event) {
    const form = $(this).closest("#attribute-form");
    form.remove();
});

$(document).on("submit", "#table-form-delete", function (event) {
    if (!confirm("Êtes-vous sûr de vouloir supprimer ?")) {
        event.preventDefault();
    }
});

$(document).on("submit", "#table-form", function (event) {
    $("#confirm").addClass("tw-hidden");

    event.preventDefault();
    const container = $("#attributes-container");
    const form = $(this);

    if (!FormUtils.checkForm(form)) return;

    const data = form.serializeArray();
    const attributeForms = container.find("form[data-type=attribute]");

    let isValid = true;

    attributeForms.each(function (index, element) {
        const attributeForm = $(element);

        if (!FormUtils.checkForm(attributeForm)) {
            isValid = false;
            return;
        }
    });

    if (!isValid) return

    let attributes = [];
    const attributeNames = [];

    attributeForms.each(function (index, element) {
        const attributeForm = $(element);
        const data = attributeForm.serializeArray();
        const attributeData = data.reduce((accumulator, currentValue) => {
            if (currentValue.name === "attribute_association" && currentValue.value === "") return accumulator;
            if (currentValue.name === "attribute_default_value" && currentValue.value === "") return accumulator;
            if (currentValue.name === "attribute_length" && currentValue.value === "") return accumulator;
            if (currentValue.name === "attribute_auto_increment" || currentValue.name === "attribute_nullable" || currentValue.name === "attribute_primary_key") currentValue.value = currentValue.value === "on";

            accumulator[currentValue.name.replace("attribute_", "")] = currentValue.value;
            return accumulator;
        }, {});

        const attributeName = attributeData.name;
        const input = attributeForm.find('input[name=attribute_name]');
        if (attributeNames.includes(attributeName)) {
            FormUtils.validationMessage(input, "Le nom de l'attribut est en double")
            isValid = false;
            return;
        } else {
            FormUtils.clearValidationMessage(input);
        }

        attributeNames.push(attributeName); // Ajouter le nom à la liste des noms d'attributs
        attributes.push(attributeData);
    });

    if (!isValid) return

    if (data.find(element => element.name === "use_i18n")?.value === "on" || false) {
        attributes.push({
            name: "language",
            type: "varchar",
            length: 255,
            nullable: false
        });
    }

    attributes.unshift({
        name: "id",
        type: "int",
        primary_key: true,
        auto_increment: true,
        nullable: false
    });

    if (data.find(element => element.name === "use_default_attributes")?.value === "on" || false) {

        attributes.push({
            name: "createdAt",
            type: "datetime",
            nullable: false,
            default_value: "CURRENT_TIMESTAMP"
        });
        attributes.push({
            name: "updatedAt",
            type: "datetime",
            nullable: false,
            default_value: "CURRENT_TIMESTAMP"
        });
    }
    
    attributes.push({
        name: "active",
        type: "boolean",
        nullable: false,
        default_value: 0 // false
    });

    const table = {
        name: data.find(element => element.name === "table_name")?.value || "null",
        attributes
    };

    $("#confirm").find("input[name=table_json]").val(JSON.stringify(table, null, 4));

    $("#confirm").removeClass("tw-hidden");
    $("#json-content").val(JSON.stringify(table, null, 4));
});