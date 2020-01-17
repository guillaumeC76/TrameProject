$(window).load(function() {
    $('.flexslider').flexslider({
        animation: "slide",
        slideshowSpeed: 4000,
    });



});


//jQuery("#responsive_headline").fitText();

$(document).ready(function() {

    window.addEventListener('load', function () {
        setTimeout( () => {
            ScrollReveal().reveal('.tagline', {reset: true, scale: 2, duration: 1000});

            ScrollReveal().reveal('.headline',{reset: true, scale: 2, duration: 1000});

            ScrollReveal().reveal('.avatarEtLogo',{reset: true, distance : '300px', duration: 1000});

            ScrollReveal().reveal('.text',{reset: true, distance : '-300px', duration: 1000});

            ScrollReveal().reveal('.formulaireEffet',{reset: true, scale: 3, duration: 1000});

            function animation() {
                ScrollReveal().reveal('.input1',{delay : 1500, reset: true, distance : '300px',origin : 'left', duration: 1000});

                ScrollReveal().reveal('.input2',{delay : 1700,reset: true, distance : '300px',origin : 'right', duration: 1000});

                ScrollReveal().reveal('.input3',{delay : 1900,reset: true, distance : '300px',origin : 'left', duration: 1000});

                ScrollReveal().reveal('.input4',{delay : 2100,reset: true, distance : '300px',origin : 'right', duration: 1000});

                ScrollReveal().reveal('.input5',{delay : 2300,reset: true, distance : '300px', duration: 1000});

                ScrollReveal().reveal('.input6',{delay : 2500,reset: true, distance : '-300px', duration: 1000});
            }

        },100)
    });


    $("#responsive_headline").fitText(5.2, { minFontSize: '13px', maxFontSize: '2000px' });


})

