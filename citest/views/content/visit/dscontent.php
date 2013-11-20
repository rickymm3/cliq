<h2> Adjust related Datasets for Visit:  <?=$visitinfo['name']?> </h3>
<?php

if ($datasets) {
foreach ($datasets as $ds) 
   
{
    echo $ds['name']. "<br>";
    
}
} else {
    echo "Empty!";
} ?>
<br><a href=''>Add Datasets to <?=$visitinfo['name']?> </a>
<br><a href=''>Manage Datasets</a>
