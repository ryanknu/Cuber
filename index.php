<?php

// Grab Cuber Tools
require_once("Tools/cuber.php");
require_once("Tools/Facebook/facebook.php");

// Production Environment
if ( App::Obj()->UseFacebook() )
{
	if ( Auth::Obj()->Authenticated() )
	{
		header("Location: home.php");
	}
	else
	{
		Auth::Obj()->LogIn();
		if ( isset($_GET["code"]) )
		{
			View::Obj()->Title("Cuber - Cube Management Software by Ryan Knuesel");
			View::Obj()->MainView("invitation");
		}
		else
		{
			$fb = new Facebook(App::Obj()->FacebookSettings());
			$loginurl = $fb->getLoginUrl();
			header("Location: $loginurl");
		}
	}
}
// Dev environment
else
{
	// Display Cuber Homepage
	View::Obj()->Title("Cuber - Cube Management Software by Ryan Knuesel");
	View::Obj()->MainView("default");
}

?>