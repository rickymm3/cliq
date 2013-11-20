$( document ).ready(function() {
    
    $(document).on("click", ".visitsubmit", function(){
        var visitname = $('.inputname').val();
        var request = $.ajax({
                type: "POST",
                url: "/v6.test/citest/index.php/ajax/addvisit",
                dataType: 'json',
                data: {visitname: visitname}
            });
            request.done(function (html){
                $('.sortable').append(html['listitem']);
                $(".sortable").sortable('refresh');
            });
            return false;
    });

    $('.ui-icon').hover(
        function () {
            $(this).addClass('ui-state-hover ns-resize');
        },
        function () {
            $(this).removeClass('ui-state-hover ns-resize');
        }
    );

    /*
    $(".allowsort").change( function(){
        
       if( $(this).is(':checked') ) 
       {
           $(".sortable").sortable( "disable" );
           $(".sortable li").each(function(i, el){
               $(el).addClass('visitselect');
           });
       } else { 
           $(".sortable").sortable( "enable" );
           $(".sortable li").each(function(i, el){
               $(el).removeClass('visitselect');
           });
       };
    });*/
    
    $(document).on("click", ".visitselect", function(){
        var visitid = $(this).data('visitid');
        var request = $.ajax({
             type: "POST",
             url: "/v6.test/citest/index.php/ajax/getvisitcontent",
             dataType: 'json',
             data: {visitid: visitid}
        });
        request.done(function (html){
             $('.contentreplace').html(html['content']);
        });
    });
    
    $(".sortable").sortable({
    stop: function(event, ui) {
        var data = [];

        $(".sortable li").each(function(i, el){
            var temp = [];
            var p = $(el).data('visitid');
            var i = $(el).index();
            temp = {
                    'order' : i,
                    'visitid' : p
                };
            data.push(temp);
        });
        var order = JSON.stringify(data);
        var request = $.ajax({
                type: "POST",
                url: "/v6.test/citest/index.php/ajax/resortvisit",
                dataType: 'json',
                data: {order: order}
            });
        request.done(function (response){
                if (!response) { alert('error'); }
            });
        }
    });
    
});