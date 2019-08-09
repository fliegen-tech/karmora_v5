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
    // Premier Categories
    if (scroll >= 1000) {
        $('.premier-shopper-lists ul').addClass('animated zoomIn');
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
    // Supplement paring item
    if (scroll >= 250) {
        $('.cash-o-palooza-sec .before-animated').addClass('animated fadeInUp');
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
    arrows: false,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 2000,
    cssEase: 'linear'
});


// Slick Cashback Silder Slider
$('.cash-back-banner').slick({
    dots: true,
    infinite: true,
    arrows: false,
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 2000,
    cssEase: 'linear',
});

// Slick COP Silder Slider
$('.cash-o-palooza-slider').slick({
    dots: false,
    infinite: true,
    arrows: true,
    slidesToShow: 4,
    slidesToScroll: 1,
    autoplay: false,
    cssEase: 'linear',
    prevArrow: '<i class="fa fa-chevron-left slick-left-arrow" aria-hidden="true"></i>',
    nextArrow: '<i class="fa fa-chevron-right slick-right-arrow" aria-hidden="true"></i>',
    responsive: [
        {
            breakpoint: 1120,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 2
            }
        },
        {
            breakpoint: 900,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2
            }
        },
        {
            breakpoint: 700,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }
    ]
});

// Slick SHD Silder Slider
$('.smoking-deal-slider').slick({
    dots: false,
    infinite: true,
    arrows: true,
    slidesToShow: 4,
    slidesToScroll: 1,
    autoplay: false,
    cssEase: 'linear',
    prevArrow: '<i class="fa fa-chevron-left slick-left-arrow" aria-hidden="true"></i>',
    nextArrow: '<i class="fa fa-chevron-right slick-right-arrow" aria-hidden="true"></i>',
    responsive: [
        {
            breakpoint: 1120,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 2
            }
        },
        {
            breakpoint: 900,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2
            }
        },
        {
            breakpoint: 700,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }
    ]
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

function phonevalidation() {
    $("#date").mask("99/99/9999");
    $("#phone_no_mark").mask("(999) 999-9999");
    $("#phone_no_bi").mask("(999) 999-9999");
    $("#tin").mask("99-9999999");
    $("#ssn").mask("999-99-9999");
}


// New js After starting Devlopment
$(document).ready(function(){
    // Supplemts Popups
    $('.supplements-popup').attr('data-toggle', 'modal');
    $('.supplements-popup').attr('data-target', '#supplements-popup');
});

function refreal_search(search_value, search_option) {
    $('#refreal_name').show();
    $('.member-filed').hide();
    $('.member-filed').html('');
    jQuery('#refreal_name').html('');
    if (search_option == 'id') {
        jQuery('#refreal_name_list').val('');
    } else {
        jQuery('#refreal_member_id_list').val('');
        search_value = search_value.replace(/,/g, "");
    }
    if (search_value != '' && search_option != '') {
        jQuery("#refreal_name").css("display", "block");
        jQuery.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: baseurl + 'searchrefreal/' + search_value + '/' + search_option,
            data: {"karmora_mikamak677": csrfHash},
            context: document.body,
            error: function (data, transport) {
            },
            success: function (data) {
                console.info(data);
                if (data.html == 'No member found') {
                    jQuery('#refreal_name').html('');
                    jQuery('#refreal_name').html('<div class="no-member-found">' + data.html + '</div>');
                } else {
                    if (search_value.charAt(0) == '1') {
                        search_value = search_value.slice(1);
                        jQuery('#refreal_member_id').val(search_value);
                    }
                    jQuery('#refreal_name').html('');
                    jQuery('#refreal_name').html(data.html);
                }
                jQuery("#refreal_name").css("display", "block");

            }
        });
    }
}


function selectthisuser(user_name,name) {
    jQuery('#refreal_member_id').val('');
    jQuery('#refreal_member_id').val(user_name);
    jQuery('#refreal_name').html('');
    jQuery('.member-filed').show();
    jQuery('.member-filed').html(name);

}

// for home page serach
function store_search(search_value) {
    $('#search').html('');
    var search_value = search_value.replace('/', '22').replace('\\', '33');
    search_value = encodeURIComponent(search_value).replace(/[!'()]/g, escape).replace(/\*/g, "%2A");
    if (search_value != '') {
        this.value = '';

        jQuery.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: baseurl + 'store/storeSearch/' + search_value,
            data: {"karmora_mikamak677": csrfHash},
            context: document.body,
            error: function (data, transport) {
                //alert("Sorry, the operation is failed.");
            },
            success: function (data) {
                $('#search').html('');
                $('#search').html(data.html);
            }
        });

    } else {
    }
}
// for home page serach
function emptyvalue() {
    $('#search').html('');
}

// Video Popup
$('.footer-video-show').on('click', function () {
    $('#cash-back-gurantee').modal('hide');
    $('#video-popup').modal('show');
});


$('.top-rightbar .search-cover-top').click( function() {
  $(".searchform").toggleClass("classblock");
} );