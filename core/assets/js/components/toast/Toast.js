import Component from "../Component.js";

class Toast extends Component {

    constructor(title = '', message = '', type = '', timeout = 5000) {
        super("toast");
        this.title = title;
        this.message = message;
        this.type = type;
        this.timeout = timeout;
    }

    render() {
        const template = $("#toast-template").html();
        const toast = $(template);

        const bgColors = {
            'success': 'green',
            'danger': 'red',
            'warning': 'orange',
        }

        const close = (toast) => {
            toast.addClass('dodocms-translate-x-full');
            // get toast width
            setTimeout(() => {
                toast.remove()
            }, 750);
        }

        let toastContainer = $('.toast-container');

        toast.find('.toast-title').text(this.title);
        toast.find('.toast-message').text(this.message);
        toast.addClass(`dodocms-bg-${bgColors[this.type]}-700`);
        toast.removeClass('dodocms-hidden');
        toastContainer.append(toast);
        setTimeout(() => {
            toast.removeClass('dodocms-opacity-0');
            toast.removeClass('dodocms-translate-x-full');
            setTimeout(() => {
                close(toast);
            }, this.timeout);
        }, 250);


        toast.find('.close-toast').click(function () {
            close($(this).closest('.toast'));
        });
    }
}

export default Toast;