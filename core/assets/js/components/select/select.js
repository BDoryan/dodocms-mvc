$(document).on("keydown", ".select", function (e) {
    const dropdown = $(this).find(".select-menu");

    if (e.keyCode === 38 || e.keyCode === 40) {
        const options = dropdown.find("li");
        const current = dropdown.find("li:focus");

        let next;
        if (e.keyCode === 38) {
            next = current.prev().length ? current.prev() : options.last();
        } else if (e.keyCode === 40) {
            next = current.next().length ? current.next() : options.first();
        }

        current.removeAttr("tabindex");
        next.attr("tabindex", "0").focus();
        return false;
    }

    if (e.keyCode === 13) {
        const selected = dropdown.find("li:focus");
        if (selected.length) {
            const value = selected.data("value");
            const text = selected.text();

            const select = $(this).find("select");
            select.val(value);

            const textDisplay = $(this).find(".select-text");
            textDisplay.text(text);

            dropdown.addClass("hidden");
        }
    }
});

$(document).on("click", ".select-button", function () {
    $(this).closest(".select").find(".select-menu").toggleClass("hidden");
});

$(document).on("click", ".select-menu li", function () {
    const dropmenu = $(this).closest(".select-menu");
    dropmenu.toggleClass("hidden");

    const select = $(this).closest(".select").find("select");
    const value = $(this).data("value");

    select.val(value);

    const text = $(this).closest(".select").find(".select-text");
    text.text($(this).text());
});

$(document).on("click", function (e) {
    if (!$(e.target).closest(".select-button").length) {
        $(".select-menu").addClass("hidden");
    }
});