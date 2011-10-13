<?php // Param in: $view - typeof Set ?>
<div class="gridCell" id="set_cell_<?php echo $view->ID(); ?>"
	onclick='set_grid_click("<?php echo $view->ID(); ?>");'
	style="background-clip:border-box;<?php // echo IMAGE; ?>background-repeat:no-repeat;position:relative;">
  <div style="position: absolute; bottom: 0; left: 0;text-align:center;width:100%;">
    <?php echo $view->Name(); ?>
  </div>
</div>
