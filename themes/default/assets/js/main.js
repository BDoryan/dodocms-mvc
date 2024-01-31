// if scroll is greater than 50px, add the "sticky" class to the header tag
$(window).scroll(function() {
    if ($(this).scrollTop() > 50) {
        $('header').addClass('scrolled shadow');
    } else {
        $('header').removeClass('scrolled shadow');
    }
});

const check = (scrollTop) => {
    var $nav = $(".navbar");
    $nav.toggleClass('scrolled shadow', scrollTop > /*$nav.height()*/ 1);
}

$(function () {
    $(document).scroll(function (e) {
        reveal();
        check($(this).scrollTop());
    });
});

const reveal = () => {
    var reveals = document.querySelectorAll(".animate__animated");

    for (var i = 0; i < reveals.length; i++) {
        const component = reveals[i];
        var windowHeight = window.innerHeight;
        var elementTop = component.getBoundingClientRect().top;
        var elementVisible = 150;

        if (elementTop < windowHeight - elementVisible) {
            if (!component.classList.contains("ignore")) {
                const animation = component.getAttribute("animation");

                console.log(component, animation)

                component.classList.add("active");
                component.classList.add(animation);
            }
        }
    }
}

setTimeout(() => {
    check(window.scrollY)
    reveal();
}, 100)