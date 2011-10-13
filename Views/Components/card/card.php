<?php

// **
// * Card
// * Component
// * Hmm. Guess I have to draw a card.
// *
// * Author: Ryan Knuesel
// **

$image = "background-image:url('" . $view->Frame() . "');";
$text = $view->Text();

?>
<div class="cardRule" id="UNIQ_ID"
	onclick='4;'
	style="background-clip:border-box;<?php echo $image; ?>background-repeat:no-repeat;position:relative;">
  <div style="position: absolute; top: 7px; left: 10px;" class="cardText">
    <?php echo $view->Name(); ?>
  </div>
  <div style="position: absolute; top: 97px; left: 10px;text-align:left;width:90px;height:40px;overflow:scroll;" class="cardText">
    <?php echo $text; ?>
  </div>
</div>
