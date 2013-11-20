<ul class='navul'>
<?php
foreach ($category as $item)
{ ?>
<li class="nav-item <?=$item['catabbr']?>" data-cliqid="<?=$item['cliqid']?>">
    <a href='/cliqedit/cliq/<?=$item['cliqid']?>/<?=$item['catabbr']?>'>
        <?=$item['category']?>
    </a>
</li>
<?php } ?>
</ul>