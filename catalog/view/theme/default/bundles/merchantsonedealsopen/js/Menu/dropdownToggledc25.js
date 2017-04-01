$(document).ready(function () {

//    toggle only current dropdown menu
    $('.dropdown-submenu .btn').on("click", function (e) {
        $(this).next('.dropdown-menu').toggle();
        e.stopPropagation();
        e.preventDefault();
    });

    $('.navbar-header .navbar-toggle').on("click", function (e) {
        if ($('#navbar-ex1-collapse').attr('aria-expanded') === "false") {
            $(".drop-on-hover").css("display", "none");
            $('.plus-minus').removeClass('fa-minus').addClass('fa-plus');
        } else {
            $(".drop-on-hover").css("display", "none");
        }
    });
//    shift between plus and minus icons for toggle navigation
    function changeClass() {
        $(this).find('.plus-minus').toggleClass('fa-minus');
    }

    $('.wrap-btn-mobile-menu').on('click', changeClass);

//    SELECT PARENT
    $(".dropdown-menu.drop-on-hover .active").parents(".dropdown.dropdown-submenu").addClass("active");

});