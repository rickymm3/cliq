<script> 
$(function() {
    $( ".sortable" ).sortable({
      placeholder: "ui-state-highlight"
    });
    $( ".sortable" ).disableSelection();
    $( ".sortable" ).sortable({ axis: 'y' });
     $( ".sortable" ).sortable({ handle: '.ui-icon' });
  });
 </script>
<span class="left ui-icon ui-icon-arrow-2-n-s"></span><p>(click and drag to reorder)</p>
<ul class="sortable">
  <?php
  foreach ($visit as $item) { ?>
    <li class="ui-state-default visitselect pointer" data-visitid='<?=$item['visitid']?>'><span class="left ui-icon ui-icon-arrow-2-n-s"></span><?=$item['name']?></li>
  <?php }
  ?>
</ul>