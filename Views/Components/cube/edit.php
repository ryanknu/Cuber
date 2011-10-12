<?php

// **
// * Cube Edit
// * Component
// * Initially displays a grid that shows all the cards in the cube, and
// * after the cube enters edit mode, shows more components in a right
// * pane while this component shrinks onto a left side pane.
// *
// * Author: Ryan Knuesel
// **

$c = new Cube($_GET["cube"]);

?>

<?php View::Obj()->Component("cube/title", $c); ?>

<div id="cube_main_left" style="display:inline-block;width:97%;border:none;overflow-y:scroll;overflow-x:visible;">
  <?php
    foreach( $c->Cards() as $card )
    {
    	View::Obj()->Component("cube/entry", $card);
    }
  ?>
</div>
<div id="cube_main_right" style="display:none;border:none;vertical-align:top;margin-left:10px;">
  Put yo cube editor here. <?php // I did it for the lulz ?>
</div>