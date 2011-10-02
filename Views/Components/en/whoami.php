<?php
	$user = Auth::Obj()->User();
	$data = $user->Data();
	if ( $data ) :
?>

<section id="whoami">
  Welcome to Cuber, <?php echo $data["name"]; ?>
</section>

<?php else: ?>

<section id="whoami">
  Welcome to Cuber! You are currently in dev mode!
</section>

<?php endif; ?>