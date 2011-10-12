<?php

// **
// * Cube Title
// * Component
// * Displays the title bar of the cube.
// *
// * Author: Ryan Knuesel
// **

$title = $view->Name();

?>

<div id="cube_title" class="cube_section header" style="width:97%">
  <a onclick="edit_cube();">edit</a><?php echo $title; ?>
</div>

