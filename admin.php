<?php

// Grab Cuber Tools
require_once("Tools/cuber.php");

if ( Auth::Obj()->Authenticated() && Auth::Obj()->CanAccess(2) )
{
	View::Obj()->Title("Cuber Admin - Cube Management Software by Ryan Knuesel");
	View::Obj()->MainView("admin");
}
else
{
	header("Location: /");
}

?>