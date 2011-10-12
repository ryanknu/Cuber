<?php

// ****
// ****
// Legacy Notice
// This file is conforms to a very bad design. The new one is much better,
// but this file is part of a component that is going to be scrapped anyway.
// For a better example, look at the Views/Components/cube/ folder.
// ****
// ****

require_once "Tools/cuber.php";
require_once "Tools/Gatherer/import.php";
require_once "Records/card.php";

try
{
	if ( !isset($_GET["card"]) )
		throw new Exception();
	if ( !isset($_GET["set"]) )
		throw new Exception();
	
	$card = GathererGrab(urldecode($_GET["card"]));
	$card["set"] = $_GET["set"];
	$s = DB::zdb()->select()
		->from(Card::$TABLE, array("id"))
		->where("`set` = ?", $_GET["set"])
		->where("name = ?", $card["Card Name"]);
	if ( DB::zdb()->fetchOne($s) )
	{
		echo "dupe";
	}
	else
	{
		Card::Create($card);
		echo "great success";
	}
}
catch ( Exception $e )
{
	Log::Failure(print_r($e, true));
	echo "fail";
}

?>