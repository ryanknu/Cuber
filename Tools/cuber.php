<?php

function FindFile($fn)
{
	static $quiet = true;
	if ( !$quiet ) echo "<br />Looking for: $fn.";
	if ( !file_exists( $fn ) )
	{
		$ip = explode(":", ini_get("include_path"));
		foreach ( $ip as $p )
		{
			if ( !$quiet ) echo "Looking at $p/$fn.";
			if ( file_exists( "$p/$fn" ) )
			{
				return "$p/$fn";
			}
		}
		if ( !$quiet ) echo "Could not find. Dying.";
		return false;
	}
	return $fn;
}

function __CuberAutoloader($class_name) {
	if ( $class_name == "DB" )
		include "Tools/database.php";
	else
	{
		$class_name = strtolower($class_name);
		$file = FindFile($class_name . ".php");
		if ( $file )
		{
			include $file;
		}
	}
}

spl_autoload_register("__CuberAutoLoader");

if (!isset($PathToRoot) )
	$PathToRoot = ".";
$ic = ini_get("include_path");
$ic = "$PathToRoot/Records:$PathToRoot:" . $ic;
set_include_path($ic);

require_once $PathToRoot . "/Tools/logs.php";
require_once $PathToRoot . "/Tools/views.php";

?>