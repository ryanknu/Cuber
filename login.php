<?php

// Grab Cuber Tools
require_once("Tools/cuber.php");

Auth::Obj()->LogIn(@$_POST["user"], @$_POST["pass"]);

// Logout Hook
if ( isset($_GET["out"]) )
	Auth::Obj()->LogOut();

$loc = "/";
if ( Auth::Obj()->Authenticated() )
	$loc = "home.php";

header("Location: $loc");

?>