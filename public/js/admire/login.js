'use strict';
$(window).on("load", function() {
    $('.preloader img').fadeOut();
    $('.preloader').fadeOut(1000);
});
$(document).ready(function() {
    new WOW().init();
    $('#login_validator').bootstrapValidator({
        fields: {
            email: {
                validators: {
                    notEmpty: {
                        message: 'The email address is required'
                    },
                    regexp: {
                        regexp: /^\S+@\S{1,}\.\S{1,}$/,
                        message: 'The input is not a valid email address'
                    }
                }
            },
            nric: {
                validators: {
                    notEmpty: {
                        message: 'The ic number is required'
                    },
                    regexp: {
                        regexp: /^\d{0,12}$/,
                        message: 'The input is not a valid ic number. Please put ic number without -'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'Please provide a password'
                    }
                }
            },
            roles: {
                validators: {
                    notEmpty: {
                        message: 'Please select at least one category.'
                    }
                }
            }
        }
    });

});