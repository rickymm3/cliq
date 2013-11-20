$(document).ready(function() {
    $(function() {
        $( ".accordion" ).accordion();
    });
    
    
$(document).on('click', '.clearselect', function() {
   $('.ul-depend').empty(); 
   $('.steps').empty().append('Nothing Selected')
   $('.final').empty();
});
//button to generate info   
$(document).on('click', '.buildbutton', function() {
    $('.final').empty();
    var liarray = new Array();
    var selected = '';
    var ds = $('.ecdataset').text();
    $( ".ul-depend li").each(function(index) {
        var temp = new Array();
        if ($(this).hasClass('selected'))
            {
                selected = { selected: $(this).data('ecid')};
            }
        temp[0] = {
            ecid: $(this).data('ecid'),
            field: $(this).data('field'),
            ds: $(this).data('dataset')};
        liarray[index] = temp;
    });
    liarray = JSON.stringify(liarray);
    var request = $.ajax({
        type: "POST",
        url: "/v6.test/citest/index.php/ajax/generate",
        dataType: 'JSON',
        data: {liarray:liarray, selected: selected, ds:ds}
    });
    request.done(function (response){
        $('.final').append("<textarea class='tafinal'>"+response['html']+"</textarea>")
    });
});
    
$(".visit_map").on("click", ".visp", function(){
    var vnum = $(this).data("vnum");
    var dataset = $(this).data("dataset");
    var request = $.ajax({
            type: "POST",
            url: "/v6.test/citest/index.php/ajax/dscontent",
            dataType: 'json',
            data: {vnum: vnum, dataset:dataset}
        });
        request.done(function (html){
            $('.contentreplace').html(html['content']);
        });
});



    $( ".builder" ).draggable({ containment: ".background", scroll: false })

    $("#add").click(function() {
        var intId = $("#buildyourform div").length + 1;
        var fieldWrapper = $("<div class=\"fieldwrapper\" id=\"field" + intId + "\"/>");
        //var fName = $("<input type=\"text\" class=\"fieldname\" />");
        var fType = $("<select class=\"fieldtype\"><option value=\"checkbox\">Checked</option><option value=\"textbox\">Text</option><option value=\"textarea\">Paragraph</option></select>");
        var removeButton = $("<input type=\"button\" class=\"remove\" value=\"-\" />");
        removeButton.click(function() {
            $(this).parent().remove();
        });
        fieldWrapper.append(fType);
        fieldWrapper.append(removeButton);
        $("#buildyourform").append(fieldWrapper);
    });
    
    
    $("#preview").click(function() {
        $("#yourform").remove();
        var fieldSet = $("<div id=\"yourform\"></div>");
        $("#buildyourform div").each(function() {
            var id = "input" + $(this).attr("id").replace("field","");
            //var label = $("<label for=\"" + id + "\">" + $(this).find("input.fieldname").first().val() + "</label>");
            var input;
            switch ($(this).find("select.fieldtype").first().val()) {
                case "checkbox":
                    input = $("<div type=\"checkbox\" class=\"builder newtype\" id=\"" + id + "\" name=\"" + id + "\">X<div>");
                    break;
                case "textbox":
                    input = $("<div type=\"text\" class=\"builder newtype \" id=\"" + id + "\" name=\"" + id + "\">Text</div>");
                    break;
                case "textarea":
                    input = $("<div class=\"builder newtype\" id=\"" + id + "\" name=\"" + id + "\" >Text Area</div>");
                    break;    
            }
            fieldSet.append(input);
        });
        $(".background").append(fieldSet);
        $('.newtype').css({
            width: "100px",
            height: "30px",
            left: "500 px",
            top: "500 px"
        })
        $( ".builder" ).draggable({ containment: ".background", scroll: false });
    });


    /*('.builder').on('click', '.builder-item',function(e){
        e.preventDefault();
        var type = $(this).data("type");
        if (type == '1') {
            var form = '';
            }
        if (type =='2'){
             var form = "type=\'text\'";
            }
        if (type == '3'){
            var form = "type='checkbox'"
        }
        var html = "<input " +form+"/>";
        dropform(html);
    });
    
    function dropform(html){
        var div = "<div class=\'newtype\' class=\'fieldname\'/>"+html+"</div>";
        console.log(div);
        $('.newtype').css({
            position: "absolute",
            'z-index': "100",
            left: "500 px",
            top: "500 px"
        })
        .appendTo("body");
alert ('completed');
    }
    
    $(".builder-item").hover(
    function () {
      $(this).addClass("hover");
      var type = $(this).data('type');
      alert (type);
    },
    function () {
      $(this).removeClass("hover");
    }
    );*/

    function load_thread(type)
    {
        var request = $.ajax({
            type: "POST",
            url: "/v6.test/citest/index.php/ajax/addelement/"+type,
            dataType: 'json',
            data: {type:type}
        });
        request.done(function (response){
            $('.background').append(response['html']);
        });
    }

});
