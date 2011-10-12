<?php

$sets = Set::SetList();
foreach ( $sets as $set )
{
	View::Obj()->Component("set/cell", $set);
}

?>