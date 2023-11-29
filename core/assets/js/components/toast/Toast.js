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
            toast.removeClass('translate-x-0')
            // get toast width
            toast.addClass('translate-x-['+(toast.width() + 150)+'px]');
            setTimeout(() => {
                toast.remove()
            }, 750);
        }

        let toastContainer = $('.toast-container');

        toast.find('.toast-title').text(this.title);
        toast.find('.toast-message').text(this.message);
        toast.addClass(`bg-${bgColors[this.type]}-700`);
        toast.removeClass('hidden');
        toastContainer.append(toast);
        setTimeout(() => {
            toast.removeClass('opacity-0');
            toast.addClass('translate-x-0');
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