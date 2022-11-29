

$(document).ready(function() {
    $('#confirm-delete').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('value', $(e.relatedTarget).data('value'));
        var value= $(this).find('.btn-ok').attr('value').split(',');
     

        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        $("#myModalLabel").html($(e.relatedTarget).data('title'));
        $("#message").html('<strong>'+$(e.relatedTarget).data('title')+'</strong>');

        $('.debug-url').html('Institution: <strong>' +value[0]  + '</strong>');
    });
});