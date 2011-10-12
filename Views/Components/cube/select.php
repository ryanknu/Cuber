<?php

// **
// * Cube Select
// * Component
// * #viewportA
// *
// * Author: Ryan Knuesel
// **

foreach ( Cube::CubesForUser(Auth::Obj()->User()) as $cube )
	$cube->DrawCubeCell();
	
Cube::DrawAddCubeCell();

?>

