<?php

// **
// * Cube Cell
// * Component
// * Draws a big square button that presents a cube face in a list to a user.
// * 
// * Author: Ryan Knuesel
// **

?>
<div class="gridCell" id="cube_cell_<?php echo $view->Get("id"); ?>"
	onclick='cube_grid_click("<?php echo $view->Get("id"); ?>");'
	style="background-clip:border-box;<?php echo $view->Get("bg_image"); ?>background-repeat:no-repeat;position:relative;">
  <div style="position: absolute; bottom: 0; left: 0;text-align:center;width:100%;">
    <?php echo $view->Get("name"); ?><br />
    <?php echo $view->Get("count"); ?>
  </div>
</div>
