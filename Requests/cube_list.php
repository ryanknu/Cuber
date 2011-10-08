<?php

require_once "Records/cube.php";

$cubes = Cube::CubesForUser(Auth::Obj()->User());

foreach ( $cubes as $cube )
{
	$cube->DrawCubeCell();
}

?>