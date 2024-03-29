<?php

// **
// * Cube Entry
// * Component
// * Displays a card in a cube in a box.
// *
// * Author: Ryan Knuesel
// **

$name = $view->Name();
$img = $view->Image();
if ( $img )
{
	$i = $img->GetClass("Stripe");
	$bg = "background-image:url('$i');";
}
else
{
	$bg = "";
}

?>

<div id="cube_title" class="cube_section flow"
	style="<?php echo $bg; ?>">
  <?php echo $name; ?>
</div>

