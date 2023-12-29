import Component from "../Component.js";

class Toast extends Component {

    constructor(title = '', message = '', type = '', duration = 5000) {
        super("toast");
        this.title = title;
        this.message = message;
        this.type = type;
        this.duration = duration;
    }

    render() {
        window.showToast(this);
    }
}

export default Toast;