class Toast  {

    constructor(title = '', message = '', type = '', duration = 5000) {
        this.title = title;
        this.message = message;
        this.type = type;
        this.duration = duration;
    }

    render() {
        window.showToast(this);
    }
}