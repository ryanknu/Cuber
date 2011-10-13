<?php

// **
// * Set List
// * Component
// * Displays all the cards in a set, with cube controls overlaid.
// *
// * Author: Ryan Knuesel
// **

$set = new Set($_GET["set"]);
foreach( $set->Cards() as $card )
{
	View::Component("card/card", $card);
}

?>
