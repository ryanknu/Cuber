<div style="text-align:center">
<h1>Be patient, biatch!</h1>
<p>Something went wrong, like this:</p>
<pre><?php echo $e->getMessage(); ?></pre>
<?php
	$s = DB::zdb()->select()
		->from("error_one_liners", array("text"));
	$messagesL = DB::zdb()->fetchAll($s);
	$messages = array();
	foreach( $messagesL as $mess )
		$messages[] = $mess["text"];
	$message = $messages[array_rand($messages)];
?>
<p><?php echo $message; ?></p>
</div>