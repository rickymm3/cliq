<ul>
<?php
if ($loggedin == true) {
 foreach ($favorites as $fav)
 {
     echo "<li>";
     echo $fav['cliq'];
     echo "</li>";
 }
} else {
    echo $favorites;
}
     
?>
</ul>
