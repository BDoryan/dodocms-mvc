function replaceCkEditor() {
    // V5
    // ClassicEditor
    //     .create(document.querySelector('.ckeditor_v5'))
    //     .then(editor => {
    //         $(editor.sourceElement).removeClass('ckeditor_v5');
    //         console.log(editor);
    //     })
    //     .catch(error => {
    //         console.error(error);
    //     });

    $('.__ckeditor__').each(function () {
        $(this).removeClass('__ckeditor__');
        CKEDITOR.replace($(this).attr('id'), {
            extraPlugins: 'uploadimage,image',
            filebrowserUploadUrl: '/votre-url-d-upload',
            filebrowserUploadMethod: 'form',
            toolbar: [
                { name: 'clipboard', items: ['Cut', 'Copy', 'Paste'] },
                { name: 'editing', items: ['Undo', 'Redo'] },
                { name: 'links', items: ['Link', 'Unlink', 'Anchor'] },
                // { name: 'insert', items: ['Image', 'Table'] },
                // '/',
                // { name: 'styles', items: ['Styles', 'Format'] },
                { name: 'basicstyles', items: ['Bold', 'Italic', 'Strike', 'RemoveFormat'] },
                { name: 'paragraph', items: ['NumberedList', 'BulletedList', 'Blockquote'] },
                { name: 'document', items: ['Source'] }
            ]
        });
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