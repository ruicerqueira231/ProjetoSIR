/*!
* Start Bootstrap - Scrolling Nav v5.0.6 (https://startbootstrap.com/template/scrolling-nav)
* Copyright 2013-2023 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-scrolling-nav/blob/master/LICENSE)
*/
//
// Scripts
// 
// your-script.js

document.addEventListener('DOMContentLoaded', event => {
    // Activate Bootstrap scrollspy on the main nav element
    const mainNav = document.querySelector("#mainNav");
    if (mainNav) {
        new bootstrap.ScrollSpy(document.body, {
            target: '#mainNav',
            offset: 40, // Specify the offset as needed
        });
    }

    // Collapse responsive navbar when toggler is visible
    const navbarToggler = document.body.querySelector('.navbar-toggler');
    const responsiveNavItems = [].slice.call(
        document.querySelectorAll('#navbarResponsive .nav-link')
    );
    responsiveNavItems.map(function (responsiveNavItem) {
        responsiveNavItem.addEventListener('click', () => {
            if (window.getComputedStyle(navbarToggler).display !== 'none') {
                navbarToggler.click();
            }
        });
    });

});



//quando dá scroll down navbar fica cinza
$(document).ready(function () {
    var initialLogoSrc = "assets/image_logo-color.png";

    $(window).scroll(function () {
        var scrollPosition = $(this).scrollTop();
        if (scrollPosition > 50) {
            // Change the logo source to the new one when scrolling down
            $("#logo").attr("src", "assets/image_logo-white.png");
            $("#mainNav").addClass("black-navbar");
        } else {
            // Revert to the initial logo source when at the top
            $("#logo").attr("src", initialLogoSrc);
            $("#mainNav").removeClass("black-navbar");
        }
    });
});


