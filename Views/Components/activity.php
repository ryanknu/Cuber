<?php
	if ( !Auth::Obj()->CanAccess(3) )
		return;
	
	$acts = new Activity();
	$out = implode("<br />", $acts->Actions());
?>

<section id="activity">
  <p>Activity</p>
  <p><?php echo $out; ?></p>
</section>

