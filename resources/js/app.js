/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

require('select2');

var Masonry = require('masonry-layout');

window.addToCart = function(id) {

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'post',
        url: '/cart/'+id+'/add',
        data: {},
        dataType: 'json',
        success: function (response) {

            if (response.modal) {
                $('.modal').modal('hide');
                $('body').append(response.html);
                $('.modal').modal('show');
                $('.modal').on('hidden.bs.modal', function (e) {
                    $('.modal').remove();
                });
            } else {

            }
        }
    });

    return false;
}

$(function(){
    $('.search-select').select2();

    if ($('.grid').length) {
        var msnry = new Masonry('.grid', {
            itemSelector: '.grid-item',
        });
    }

    if ($('.short-cart').length) {
        var initTopPosition = $('.short-cart').offset().top;
        var originalTopPosition = $('.short-cart').css('top');
        var originalWidth = $('.short-cart').css('width');

        $(window).scroll(function(){
            if($(window).scrollTop() > initTopPosition)
                $('.short-cart').css({'position':'fixed','top':'20px','width':originalWidth});
            else
                $('.short-cart').css({'position':'relative','top': originalTopPosition});
        });
    }
})
