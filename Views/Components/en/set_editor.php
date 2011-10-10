<?php

$s = new Set($_GET["set"]);
echo $s->Mutator()->EditForm();

?>

<div id="import_box">
Multi-Import:<br />
<textarea id="cards_import"></textarea>
<a onclick="pre_import();">Input</a>
</div>