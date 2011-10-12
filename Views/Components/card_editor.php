<?php

$c = new Card($_GET["card"]);
echo $c->Mutator()->EditForm();

?>
