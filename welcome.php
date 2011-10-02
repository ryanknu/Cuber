<?php

// Grab Cuber Tools
require_once("Tools/cuber.php");

if ( Auth::Obj()->Authenticated() )
{
	View::Obj()->Title("Cuber - Cube Management Software by Ryan Knuesel");
	View::Obj()->MainView("welcome");
}
else
{
	header("Location: /");
}

?>