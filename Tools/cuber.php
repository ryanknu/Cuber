<?php

function __autoload($class_name) {
	if ( $class_name == "DB" )
		include "Tools/database.php";
	else
	{
		$class_name = strtolower($class_name);
		@include "Records/$class_name.php";
	}
}

if (isset( $PathToRoot ) )
{
	$ic = ini_get("include_path");
	$ic = "$PathToRoot:" . $ic;
	set_include_path($ic);
}

//require_once "Tools/database.php";
require_once "Records/auth.php";
require_once "Records/user.php";
require_once "Records/app.php";
require_once "Tools/logs.php";
require_once "Tools/views.php";

?>