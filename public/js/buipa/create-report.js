'use strict';
$(window).on("load", function() {
    $('.preloader img').fadeOut();
    $('.preloader').fadeOut(1000);
});
$(document).ready(function() {
    new WOW().init();
    $('.allocation_budget').bootstrapValidator({
        fields: {
            'expenses_used[]' : {
                validators: {
                    notEmpty: {
                        message: 'The used amount is required.'
                    }
                    
                }
            },
            'overBudget[]': {
                validators: {
                    notEmpty: {
                        message: 'The over budget cannot be less than RM 0.00.'
                    }
                }
            }
            
        }
    });




});