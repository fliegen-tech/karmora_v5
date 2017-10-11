// Smooth Scrolling
$('.smooth-scroll').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'')
        || location.hostname == this.hostname) {

        var target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
           if (target.length) {
             $('html,body').animate({
                 scrollTop: target.offset().top
            }, 1000);
            return false;
        }
    }
});


// On scroll add Animation
$(window).scroll(function() {
    var scroll = $(window).scrollTop();

    // Premier Casual Cover
    if (scroll >= 500) {
        $('.premier-casual-cover ul').addClass('animated zoomIn');
    }

    // Premier Categories
    if (scroll >= 1000) {
        $('.premier-shopper-lists ul').addClass('animated zoomIn');
    }

    // Flawless HomePage Products
    if (scroll >= 300) {
        $('.flawless-product-cover').addClass('animated fadeInLeft');
    }

    // Supplement HomePage Products
    if (scroll >= 700) {
        $('.supplement-homepage .flawless-product-cover').addClass('animated fadeInLeft');
    }

    // Flawless HomePage Notlogin heading
    if (scroll >= 1150) {
        $('.flawles-notlogin').addClass('animated fadeInUp');
    }

    // Supplement HomePage Notlogin heading
    if (scroll >= 1600) {
        $('.supplemts-notlogin').addClass('animated fadeInUp');
    }


    // Flawless days Detail page
    if (scroll >= 900) {
        $('.clent-says .client-says-cover').addClass('animated fadeInUp');
    }

    // Flawless days paring Items
    if (scroll >= 1200) {
        $('.paring-cover .paring-leftbar img').addClass('animated fadeInLeft');
    }

    // Flawless days paring Items
    if (scroll >= 1200) {
        $('.paring-cover .paring-leftbar .rightimg').addClass('animated fadeInRight');
    }

    // Supplement paring item
    if (scroll >= 1750) {
        $('.supplemnts-paring-sec .paring-leftbar img').addClass('animated fadeInLeft');
    }

    // Supplement paring item
    if (scroll >= 1750) {
        $('.supplemnts-paring-sec .rightimg').addClass('animated fadeInRight');
    }

});

$(document).ready(function(){
		// TOP Heading
		$('#top-heading-cover').addClass('animated');
		$('#top-heading-cover').addClass('fadeInLeft');

    // Click2win img
    $('#top-img-cover').addClass('animated');
		$('#top-img-cover').addClass('fadeInLeft');

});


// Slick HomePage Slider
$('.home-page-slider').slick({
    dots: true,
    infinite: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 2000,
});


// Ok Zoom on products
$(function () {
    $('.ingredient-zoom').okzoom({
        width: 400,
        height: 200,
        round: false
    });
});


//plugin bootstrap minus and plus
$('.btn-number').click(function(e){
    e.preventDefault();

    fieldName = $(this).attr('data-field');
    type      = $(this).attr('data-type');
    var input = $("input[name='"+fieldName+"']");
    var currentVal = parseInt(input.val());
    if (!isNaN(currentVal)) {
        if(type == 'minus') {

            if(currentVal > input.attr('min')) {
                input.val(currentVal - 1).change();
            }
            if(parseInt(input.val()) == input.attr('min')) {
                $(this).attr('disabled', true);
            }

        } else if(type == 'plus') {

            if(currentVal < input.attr('max')) {
                input.val(currentVal + 1).change();
            }
            if(parseInt(input.val()) == input.attr('max')) {
                $(this).attr('disabled', true);
            }

        }
    } else {
        input.val(0);
    }
});
$('.input-number').focusin(function(){
   $(this).data('oldValue', $(this).val());
});
$('.input-number').change(function() {

    minValue =  parseInt($(this).attr('min'));
    maxValue =  parseInt($(this).attr('max'));
    valueCurrent = parseInt($(this).val());

    name = $(this).attr('name');
    if(valueCurrent >= minValue) {
        $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Sorry, the minimum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    if(valueCurrent <= maxValue) {
        $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Sorry, the maximum value was reached');
        $(this).val($(this).data('oldValue'));
    }


});
$(".input-number").keydown(function (e) {
    // Allow: backspace, delete, tab, escape, enter and .
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
         // Allow: Ctrl+A
        (e.keyCode == 65 && e.ctrlKey === true) ||
         // Allow: home, end, left, right
        (e.keyCode >= 35 && e.keyCode <= 39)) {
             // let it happen, don't do anything
             return;
    }
    // Ensure that it is a number and stop the keypress
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
    }
});
