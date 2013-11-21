<ul class='navul'>
<?php
foreach ($category as $item)
{
	$this->load->view('header/category_row', $item);
} 
 
?>
</ul>