'use strict';
$(window).on("load", function() {
    $('.preloader img').fadeOut();
    $('.preloader').fadeOut(1000);
});
$(document).ready(function() {
    new WOW().init();
    $('.institution_validator').bootstrapValidator({
        fields: {
            name : {
                validators: {
                    notEmpty: {
                        message: 'The name is required'
                    }
                }
            },
            address: {
                validators: {
                    notEmpty: {
                        message: 'The addresss is required'
                    }
                }
            },
            state_id: {
                validators: {
                    notEmpty: {
                        message: 'Please select at least one state'
                    }
                }
            },
            region_id: {
                validators: {
                    notEmpty: {
                        message: 'Please select at least one region'
                    }
                }
            },
            postcode: {
                validators: {
                    notEmpty: {
                        message: 'The postcode is required'
                    },
                    regexp: {
                        regexp: /^\d{5}$/,
                        message: 'The input is not a valid postcode'
                    }
                }
            },

            type: {
                validators: {
                    notEmpty: {
                        message: 'Please select at least one type'
                    }
                }
            },
        }
    });




});