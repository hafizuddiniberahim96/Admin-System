'use strict';
$(window).on("load", function() {
    $('.preloader img').fadeOut();
    $('.preloader').fadeOut(1000);
});

function DobAutoFill(){
    var nric = $('.nric').val().substring(0, 6) ;
    var year,month,day;
    var d = new Date().getFullYear().toString().substr(-2);

    if(parseInt(nric.substring(0,2)) > parseInt(d)) year ='19' + nric.substring(0,2);
    else year ='20' + nric.substring(0,2);
    month =nric.substring(2,4);
    day=nric.substring(4,6);

    $('#dob').val(day+'/'+month+'/'+year)       
}


function readImg(input){
    if(input.files && input.files[0]){
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#profileimg')
                .attr('src', e.target.result)
                .width(290)
                .height(290);
        };

        reader.readAsDataURL(input.files[0]);
    } 
}

$(document).ready(function() {
    new WOW().init();

    DobAutoFill();
    $('.user_form_validator').bootstrapValidator({
        fields: {
            name : {
                validators: {
                    notEmpty: {
                        message: 'The name is required'
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
            nric: {
                validators: {
                    notEmpty: {
                        message: 'The ic number is required'
                    },
                    regexp: {
                        regexp: /^\d{12}$/,
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
            confirmpassword: {
                validators: {
                    notEmpty: {
                        message: 'The confirm password is required and can\'t be empty'
                    },
                    identical: {
                        field: 'password',
                        message: 'Please enter the same password'
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
            postcode: {
                validators: {
                    regexp: {
                        regexp: /^\d{5}$/,
                        message: 'The input is not a valid postcode'
                    }
                }
            },

        }
    });




});