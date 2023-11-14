/*!
* Start Bootstrap - Scrolling Nav v5.0.6 (https://startbootstrap.com/template/scrolling-nav)
* Copyright 2013-2023 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-scrolling-nav/blob/master/LICENSE)
*/
//
// Scripts
// 
// your-script.js

window.addEventListener('DOMContentLoaded', event => {
    // Activate Bootstrap scrollspy on the main nav element
    const mainNav = document.body.querySelector('#mainNav');
    if (mainNav) {
        new bootstrap.ScrollSpy(document.body, {
            target: '#mainNav',
            rootMargin: '0px 0px -40%',
        });
    }

    // Initialize the Bootstrap carousel
    const photoCarousel = new bootstrap.Carousel(document.getElementById('photoCarousel'));

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


//quando dá scroll down navbarfica cinza
$(document).ready(function () {
    // Set a scroll listener
    $(window).scroll(function () {
      // Check the scroll position
      if ($(this).scrollTop() > 50) {
        // If scrolled down more than 50 pixels, change the navbar color to black
        $("#mainNav").addClass("black-navbar");
      } else {
        // Otherwise, keep the transparent navbar
        $("#mainNav").removeClass("black-navbar");
      }
    });
  });


// register.js

document.getElementById('registrationForm').addEventListener('submit', function (event) {
    event.preventDefault();
    var username = document.getElementById('username').value;
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirmPassword').value;

    if (password !== confirmPassword) {
        document.getElementById('errorMessage').style.display = 'block';
        document.getElementById('successMessage').style.display = 'none';
    } else {
        document.getElementById('errorMessage').style.display = 'none';
        document.getElementById('successMessage').style.display = 'block';
        // You can add your registration logic here
    }
});