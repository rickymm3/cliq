<?php
$i = 0;
$x = -1;
foreach ($visit as $item) 
{
        $n = $item['vnum'];
        $item['dataset'] = "<span class='visp' data-vnum='".$item['vnum']."' data-dataset='".$item['dataset']."'>".$item['dataset']."</span>";
    if ($i == 0) {
        echo "<h3>".$item['vnum']."-".$item['visit']."</h3>";
        echo "<div><p>".$item['dataset'];
        $i ++;
        $x = $n;
    } else {
        if ($n == $x) {
        //no new header
            echo $item['dataset'];
        } else {
        //make new header
            echo "</p></div><h3>".$item['vnum']."-".$item['visit']."</h3>";
            echo "<div><p>".$item['dataset'];
        }
        
        $x = $n;
    }
}

?>