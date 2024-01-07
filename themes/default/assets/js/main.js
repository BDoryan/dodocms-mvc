// if scroll is greater than 50px, add the "sticky" class to the header tag
$(window).scroll(function() {
    if ($(this).scrollTop() > 50) {
        $('header').addClass('scrolled shadow');
    } else {
        $('header').removeClass('scrolled shadow');
    }
});