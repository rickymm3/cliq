<div class="header-history">
    <span class="history-list">
        <?php
if (!$history == '') {
    foreach ($history as $item)
    {
        if (!$this->session->userdata('temp')) 
        { // ignore text below
            if ($item['cliqid'] != $current[0]['cliqid']) 
            {
            ?>
            <a class='cliq' data-keyword='<?=$item['cliq']?> 'data-cliqid='<?=$item['cliqid']?>'><?=$item['cliq']?></a> 
            <?php
            }
        } else {
            ?>
            <a class='cliq' data-keyword='<?=$item['cliq']?> 'data-cliqid='<?=$item['cliqid']?>'><?=$item['cliq']?></a> 
            <?php 
        }
    } ?><a class='cliq' data-keyword='<?=$current[0]['cliq']?> 'data-cliqid='<?=$current[0]['cliqid']?>'><?=$current[0]['cliq']?></a> 
    <?php
} else {
    echo ""; 
}
?>
    </span>
</div>