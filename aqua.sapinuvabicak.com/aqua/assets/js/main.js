$(document).ready(function() {
    $('.productslider').slick({
        speed: 500,
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        asNavFor: '.productsliderthumb'
    });

    $('.productsliderthumb').slick({
        draggable: true,
        infinite: false,
        arrows: false,
        dots: false,
        slidesToShow: 7,
        slidesToScroll: 7,
        asNavFor: '.productslider',
        centerMode: false,
        focusOnSelect: true,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 5,
                    slidesToScroll: 5,
                }
            },
            {
                breakpoint: 991,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 4
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3
                }
            }
        ]
    });

    $('.mainslider').slick({
        draggable: true,
        autoplay: true,
        autoplaySpeed: 15000,
        speed: 500,
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.thumbslider',
        infinite: true,
    });

    $('.thumbslider').slick({
        draggable: true,
        infinite: false,
        arrows: false,
        dots: false,
        slidesToShow: 6,
        slidesToScroll: 6,
        asNavFor: '.mainslider',
        centerMode: false,
        focusOnSelect: true,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 5,
                    slidesToScroll: 5,
                }
            },
            {
                breakpoint: 991,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 4
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            }
        ]
    });

    $( "section.onsale ul.nav-filter li a" ).click(function() {
        $("section.onsale ul.nav-filter li a").removeClass("active");
        $(this).addClass("active");
        var href = $(this).attr("href");
        href = href.replaceAll("#", "");

        if(href == "hepsi") {
            $("section.onsale .productlist .col").fadeIn();
        } else {
            $("section.onsale .productlist .col:not(."+href+")").hide();
            $("section.onsale .productlist .col."+href+"").fadeIn();
        }
    });

    $( "a.mobileSearch" ).click(function(e) {
        $(".menubar__searchBox").toggleClass("show").toggleClass("d-block");
        e.preventDefault();
    });

    $( "a.categoryToggle" ).click(function(e) {
        $(".menubar__categoryBox").toggleClass("show").toggleClass("d-block");
        e.preventDefault();
    });

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    $("a.addcart").click(function() {
        toastr.success('Ürün başarıyla sepete eklendi!');
    });


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

});