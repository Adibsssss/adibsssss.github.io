document.addEventListener("DOMContentLoaded", function () {
    const navbar = document.querySelector('.navbar');

    window.addEventListener('scroll', function () {
        const isScrolled = window.scrollY > 50;
        navbar.classList.toggle('navbar-scrolled', isScrolled);
    });
});
