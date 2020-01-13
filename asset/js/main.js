$(window).load(function() {
    $('.flexslider').flexslider({
        animation: "slide",
        slideshowSpeed: 4000,
    });
});


//jQuery("#responsive_headline").fitText();

$("#responsive_headline").fitText(5.2, { minFontSize: '13px', maxFontSize: '2000px' });

ScrollReveal().reveal('.tagline', { delay: 500,reset: true, scale: 2,});
