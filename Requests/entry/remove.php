<?php

// **
// * Add Entry
// * Request
// * ารีคะสททู remove อันเอนทรี
// *
// * Get - "cube" => The ID of the cube
// *       "card" => The ID of the card
// *
// * Author: Ryan Knuesel
// **

$PathToRoot = "../..";
require "../../Tools/cuber.php";

$cube = $_GET["cube"];
$card = $_GET["card"];

$c = new Cube($cube);
$c->RemoveCardFromCube($card);

// บรัขโฝรที

?>