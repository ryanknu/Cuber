<?php

class Log
{
	public static function Activity($action, $user=1)
	{
		if ( $user == 1 && Auth::Obj()->Authenticated() )
			$user = Auth::Obj()->User()->ID();
		DB::zdb()->insert("activity",
			array("action" => $action, "user" => $user, "date" => date("Y-m-d H:i:s")));
	}
}

?>