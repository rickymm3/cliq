<div class="select">
<script>
    $(function() {
        $( ".selectable" ).selectable({
      stop: function() {
        var html2 = "Step 2: Select the dependant Field";
        $('#feedback .steps').empty().append(html2);
        var html = "";
        $( ".ui-selected", this ).each(function() {
            var ecid = $(this).data('ecid');
            var field = $(this).data('field');
            var ds = $(this).data('dataset');
            //eventually check if there are duplicate ecid
            html = "<li class='depend' data-field='"+field+"' data-ecid='"+ ecid+"'>"+ds+" - "+field+"</li>";
            $(".ul-depend").append(html)
        });
      }
    });
    });

$(document).on('click', '.depend', function(){
    var field = $(this).data('field');
    var ecid = $(this).data('ecid');
    var html = '';
    $('li').removeClass('selected');
    $(this).addClass("selected")
    html += "<p>How do these relate?</p>";
    html += "<select><option value='1' data-ecid='"+ecid+"'>If "+field+" is empty, so are the rest</option></select>";
    html += "<button class='buildbutton'>Generate?</button></div>";
    var result = $( "#feedback .steps" ).empty();
    result.append( html );
});
    
</script>
    <span class="ecdataset"><?=$stuff[0]['dataset']?></span> 	
    <span class="ecvisit"><?=$stuff[0]['visit']?></span>
<ol class="selectable">
<?php
foreach ($stuff as $variable)
{?>
<li class="ui-widget-content" data-dataset="<?=$variable['dataset']?>" data-field="<?=$variable['field']?>" data-ecid="<?=$variable['ecspecs_id']?>">
    <textarea ><?=$variable['ecnum']?></textarea>
    <span class="ecfield"><?=$variable['field']?></span>
</li>
<?php }
?>

</ol>
</div>
