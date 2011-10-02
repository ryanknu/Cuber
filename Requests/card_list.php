<?php

require_once "Records/card.php";

$list = Card::CardList($_GET["set"]);
$o = array();
foreach($list as $card)
{
	$id = $card->ID();
	$o[] = $card->Name() . "<a onclick='edit_card($id);'><img src='Views/img/arrow.png' /></a>";
}
$out = implode("<br />", $o);

echo $out;

?>
