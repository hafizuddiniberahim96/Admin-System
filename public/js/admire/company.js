'use strict';
$(window).on("load", function() {
    $('.preloader img').fadeOut();
    $('.preloader').fadeOut(1000);
});


$(document).ready(function() {
    new WOW().init();

    $(document).on('click', '.btn-add', function (e) {
        e.preventDefault();
        var controlForm = $('.controls:first'),
            currentEntry = $(this).parents('.entry:first'),
            newEntry = $(currentEntry.clone()).appendTo(controlForm);
            newEntry.find('input[type=file]').val('');

        controlForm.find('.entry:not(:last) .btn-add')
            .removeClass('btn-add').addClass('btn-remove')
            .removeClass('btn-success').addClass('btn-danger')
            .html('<span class="fa fa-trash"></span>');
    }).on('click', '.btn-remove', function (e) {
        $(this).parents('.entry:first').remove();

        e.preventDefault();
        return false;
    });

    $(document).on('click', '.product-add', function (e) {
        e.preventDefault();
        var controlForm = $('.product-controls:first'),
            currentEntry = $(this).parents('.product-entry:first'),
            newEntry = $(currentEntry.clone()).appendTo(controlForm);
            newEntry.find('input[type=text]').val('');

        controlForm.find('.product-entry:not(:last) .product-add')
            .removeClass('product-add').addClass('btn-remove')
            .removeClass('btn-success').addClass('btn-danger')
            .html('<span class="fa fa-trash"></span>');
    }).on('click', '.btn-remove', function (e) {
        $(this).parents('.product-entry:first').remove();

        e.preventDefault();
        return false;
    });

    


    $('.company_validator').bootstrapValidator({
        fields: {
            name : {
                validators: {
                    notEmpty: {
                        message: 'The name is required'
                    }
                }
            },
            nossm : {
                validators: {
                    notEmpty: {
                        message: 'The SSM number is required'
                    }
                }
            },
            established : {
                validators: {
                    notEmpty: {
                        message: 'The established date is required'
                    }
                }
            },
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
            phoneNumber: {
                validators: {
                    notEmpty: {
                        message: 'The phone number is required'
                    },
                    regexp: {
                        regexp: /^\d{10,12}$/,
                        message: 'The input is not a valid phone number. Please put phone number without -'
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
            sector_id: {
                validators: {
                    notEmpty: {
                        message: 'Please select at least one service sector'
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

        }
    });




});