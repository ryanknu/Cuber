<?php
	$user = Auth::Obj()->User();
	$data = $user->Data();
	if ( $data ) :
?>

<section id="top">
  <span id="top_tab">Cuber</span>
</section>

<?php else: ?>

<section id="top">
  <span id="top_tab" style="border-color:red;">Cuber<span style="color:red">:dev</span></span>
</section>

<?php endif; ?>