class FormUtils {

    static validationMessage(input, message) {
        const validationMessage = $(input).parent().find('#validation-message');
        if (validationMessage.length > 0) {
            validationMessage.text(message);
            validationMessage.show();

            $(input).addClass("tw-border-red-700")
        }
    }

    static clearValidationMessage(input) {
        const validationMessage = $(input).parent().find('#validation-message');
        validationMessage.hide();
        $(input).removeClass("tw-border-red-700")
    }

    /**
     * Text Field validator
     * (peut-être optimiser en utilisant les fonctions du dessus)
     */
    static checkForm(form) {
        let success = true;
        $(form).find('input').each(function () {
            const input = $(this)[0];
            const validationMessage = $(input).parent().find('#validation-message');

            if (!input.checkValidity()) {
                if (validationMessage.length > 0) {
                    validationMessage.text(input.validationMessage);
                    validationMessage.show();

                    $(input).addClass("tw-border-red-700")
                    success = false;
                } else {
                    input.reportValidity();
                }
            } else {
                validationMessage.hide();
                $(input).removeClass("tw-border-red-700")
            }
        });
        return success;
    }
}
