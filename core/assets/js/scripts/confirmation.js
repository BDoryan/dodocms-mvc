$(document).ready(function () {
    $('[data-need-confirmation="true"]').on('click', function (e) {
        const confirmation_message = $(this).data('confirmation-message');

        if (confirmation_message) {
            e.preventDefault();
            e.stopPropagation();

            const href = $(this).attr('href');
            const form = $(this).closest('form');
            const submit = $(this).attr('type') === 'submit';
            const confirmation = confirm(confirmation_message);
            if (confirmation) {
                if (submit) {
                    form.submit();
                } else {
                    window.location.href = href;
                }
            }
        }
    });
});