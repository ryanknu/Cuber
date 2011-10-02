<?php

// Grab Cuber Tools
require_once("Tools/cuber.php");

if ( isset( $_GET["a"] ) )
{
	include "Requests/{$_GET['a']}.php";
}

?>