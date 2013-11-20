$(document).ready(function() {
     
    $(document).on('click', '.admin_change', function(e){
        e.preventDefault();
        row = $(this).parent('td');
        rowa = $(this);
        var threadid = $(this).data('threadid');
        var request = $.ajax({
            type: "POST",
            url: "/cliq2/admin/change_delete/",
            dataType: 'json',
            data: {threadid:threadid}
        });
        request.done(function (result){
                console.log(rowa);
        }); 
    });

});