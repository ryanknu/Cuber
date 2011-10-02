<?php

// Grab Cuber Tools
require_once("Tools/cuber.php");
require_once("Records/invite.php");

if ( App::Obj()->UseFacebook() )
{
	try
	{
		User::Create($_POST);
		if ( !Auth::Obj()->Authenticated() )
			View::Obj()->MainView("fb_failure");
		else
			header("Location: welcome.php");
	}
	catch( Exception $e )
	{
		View::Obj()->Exception($e);
	}
}
else
{
	try
	{
		
		if ( isset($_POST["user"]) )
		{
			if ( @$_POST["pass"] == @$_POST["pass2"] )
				User::Create($_POST);
		}
		
		if ( !Auth::Obj()->Authenticated() )
		{
			View::Obj()->Title("Cuber - Sign up!");
			View::Obj()->MainView("signup");
		}
		else
		{
			header("Location: welcome.php");
		}
	
	}
	catch( Exception $e )
	{
		View::Obj()->Exception($e);
	}
}

?>