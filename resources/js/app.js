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
})
