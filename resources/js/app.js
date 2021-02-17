/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

require('select2');

var Masonry = require('masonry-layout');


$(function(){
    $('.search-select').select2();

    var msnry = new Masonry('.grid', {
        itemSelector: '.grid-item',
    });

    var initTopPosition = $('.short-cart').offset().top;
    var originalTopPosition = $('.short-cart').css('top');
    var originalWidth = $('.short-cart').css('width');

    $(window).scroll(function(){
        if($(window).scrollTop() > initTopPosition)
            $('.short-cart').css({'position':'fixed','top':'20px','width':originalWidth});
        else
            $('.short-cart').css({'position':'relative','top':originalTopPosition});
    });
})
