$(document).ready(function () {
    console.log('CKEDITOR INIT')
    $('.ckeditor').each(function () {
        CKEDITOR.replace($(this).attr('id'));
    });
});