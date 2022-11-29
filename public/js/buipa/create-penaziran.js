'use strict';

$(document).ready(function() {
    new WOW().init();
    $('.penaziran_event_validator').bootstrapValidator({
        fields: {
            'mark[]' : {
                validators: {
                    between:{
                        max:100,
                        min:0,
                        message : 'The mark cannot be less than 0 or more than 100.'
                    },
                    notEmpty: {
                        message: 'The mark is required'
                    }
                    
                }
            },
            'penaziran_doc[]': {
                validators: {
                    notEmpty: {
                        message: 'The penaziran document is required at least one.'
                    }
                }
            },
            'penaziran_desc[]': {
                validators: {
                    notEmpty: {
                        message: 'The penaziran description is required.'
                    }
                }
            }
            
        }
    });
});