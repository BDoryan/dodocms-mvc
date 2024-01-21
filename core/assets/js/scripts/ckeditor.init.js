function replaceCkEditor() {
    $('.ckeditor').each(function () {
        CKEDITOR.replace($(this).attr('id'));
    });
}

function initCkEditor() {
    CKEDITOR.dtd.$editable.span = 1
    CKEDITOR.dtd.$editable.a = 1

    replaceCkEditor();
}

$(document).ready(function () {
    initCkEditor();
});