<?php
	$c = new Cube($_GET["cube"]);
?>

<?php View::Obj()->Component("cube/title", $c); ?>
<div id="cube_main_left" style="display:inline-block;width:97%;border:1px dotted black;overflow-y:scroll;overflow-x:visible;">
  <?php
    foreach( $c->Cards() as $card )
    {
    	View::Obj()->Component("cube/entry", $card);
    }
  ?>
</div>
<div id="cube_main_right" style="display:none;border:1px solid black;vertical-align:top;margin-left:10px;">
  Put yo cube editor here.
</div>