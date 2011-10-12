<?php
	if ( !Auth::Obj()->CanAccess(2) )
		return;
	// need to use the Invite model
	$s = DB::zdb()->select()
		->from("invites")
		->where("owner = ?", Auth::Obj()->User()->ID())
		->where("available = 1");
	$invites = DB::zdb()->fetchAll($s);
	$out = array();
	foreach( $invites as $invite )
		$out[] = $invite["code"];
	$codes = @implode("<br />", $out);
	$ct = count($out);
?>

<script type="text/javascript">
	function new_invite()
	{
		$.ajax({
			url: "request.php?a=new_invite",
			success: function(data, textStatus, jqXHR)
			{
				$("#invites")[0].innerHTML += ( "<br />" + data );
			}
		});
	}
</script>

<section id="invites">
  Invites: <?php echo $ct; ?>
  <a onclick="new_invite();">Add</a>
  <br />
  <?php if ($codes) { ?>Codes:<?php } ?><br />
  <?php echo $codes; ?>
</section>

