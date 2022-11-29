'use strict';$(window).on("load",function() {
    $('.preloader img').fadeOut();
    $('.preloader').fadeOut(1000);
});

$(document).ready(function() {
    new WOW().init();

    $('#register_valid_nric').bootstrapValidator({
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
                        message: 'Please enter the same password as above'
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
                        message: 'The input is not a valid ic number. Insert ic number without -'
                    }
                }
            },
            check: {
                validators: {
                    notEmpty: {
                        message: 'Check on the field'
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
    $('#register_valid_passport').bootstrapValidator({
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
                        message: 'Please enter the same password as above'
                    }
                }
            },
            passport: {
                validators: {
                    notEmpty: {
                        message: 'The passport number is required.'
                    },
                    regexp: {
                        regexp: /^[A-Z0-9]{8}$/,
                        message: 'The input is not a valid passport number. Please use capital letter.'
                    }
                }
            },
            check: {
                validators: {
                    notEmpty: {
                        message: 'Check on the field'
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
    $("button[type='reset']").on("click",function () {
        $("#register_valid_nric").bootstrapValidator("resetForm",true);
        $("#register_valid_passport").bootstrapValidator("resetForm",true);
    })
});