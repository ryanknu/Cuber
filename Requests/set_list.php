<?php

// ****
// ****
// Legacy Notice
// This file is conforms to a very bad design. The new one is much better,
// but this file is part of a component that is going to be scrapped anyway.
// For a better example, look at the Views/Components/cube/ folder.
// ****
// ****

require_once "Records/set.php";

$sets = Set::SetList(true);
$s = array();
foreach ( $sets as $set )
{
	$setString = $set->String();
	$id = $set->ID();
	if ( !$set->Active() )
	{
		$setString = "<span style=\"text-decoration: line-through;\">$setString</span>";
	}
	$s[] = $setString . "<a onclick='edit_set($id);'><img src='Views/img/arrow.png' /></a>";
}
$out = implode("<br />", $s);

echo $out;

?>