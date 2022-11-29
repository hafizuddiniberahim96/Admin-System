

$(document).ready(function() {
    $('#filterbtn').click(function(){
        var roles = $('#roles').val().toString().split(',').join('|');
        var table = $('.table').DataTable();
        table.column(4).search(roles,true,false);
        table.draw();
 
    });

    $('#confirm-delete').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('value', $(e.relatedTarget).data('value'));
        var value= $(this).find('.btn-ok').attr('value').split(',');
     

        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        $("#myModalLabel").html($(e.relatedTarget).data('title'));
        $("#message").html('<strong>'+$(e.relatedTarget).data('title')+'</strong>');

        $('.debug-url').html('User: <strong>' +value[0]  + '</strong><br>NRIC: <strong>'+value[1]+'</strong>');
    });
});