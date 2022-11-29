$(document).ready(function() {
    isAwardchecked();
    $( "#unlimited" ).change(function() {
        if($(this).is(":checked")){
            $('#seat').prop('disabled', true);
        }
        else if($(this).is(":not(:checked)")){
            $('#seat').prop('disabled', false);

        }        
    });
    


    $( "#eventcheckbox" ).change(function() {
        isAwardchecked();  
    });

    function isAwardchecked(){
        var penaziranform = $('#penaziran_form');
        if($('#eventcheckbox').is(":checked")){
           $('#penaziran_form').show();
           penaziranform.find('input').prop('disabled', false);
           penaziranform.find('select').prop('disabled', false);
        }
        else if($('#eventcheckbox').is(":not(:checked)")){
           $('#penaziran_form').hide();
            penaziranform.find('input').prop('disabled', true);
            penaziranform.find('select').prop('disabled', true);
        }  
    }


    $('.date_start').daterangepicker({
        locale: {
            format: 'DD/MM/YYYY'
        },
        singleDatePicker: true,
        minDate: new Date()
    });

    $('.date_end').daterangepicker({
        locale: {
            format: 'DD/MM/YYYY'
        },
        singleDatePicker: true,
        minDate: new Date()
    });

     $('.register_before').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            },
            singleDatePicker: true,
            minDate: new Date()
    });

        $( ".date_start" ).change(function() {
            var parts = $( this ).val().split("/");
            $('.date_end').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY'
                },
                singleDatePicker: true,
                minDate: new Date(parts[2], parts[1] - 1, parts[0])
            });
            
            $('.register_before').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY'
                },
                singleDatePicker: true,
                maxDate: new Date(parts[2], parts[1] - 1, parts[0]),
                minDate: new Date()
            });
    
            
        });

});