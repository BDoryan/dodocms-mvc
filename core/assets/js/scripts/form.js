$(document).on('submit', 'form[novalidate]', function (e) {
    const form = $(this);
    if(!FormUtils.checkForm(form)) e.preventDefault();
});