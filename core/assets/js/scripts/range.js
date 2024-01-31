$(document).on('input', 'input[type="range"]', function () {
    const id = $(this).attr('id');
    const span = $('span[for="' + id + '"]');
    span.text($(this).val() + '%');
});