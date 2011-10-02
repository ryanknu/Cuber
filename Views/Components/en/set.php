<?php
	if ( !Auth::Obj()->CanAccess(2) )
		return;
	
	ob_start();
	include "Requests/set_list.php";
	$out = ob_get_contents();
	ob_end_clean();
?>

<script type="text/javascript">
	var aSet = 0;
	
	function reload_set_list()
	{
		log("reload");
		$.ajax({
			url: "request.php?a=set_list",
			success: function(data, textStatus, jqXHR)
			{
				$("#set_list")[0].innerHTML = data;
			}
		});
	}
	
  	function add_set()
  	{
  		$.ajax({
			url: "request.php?a=new_set",
			success: function(data, textStatus, jqXHR)
			{
				reload_set_list();
			}
		});
  	}
  	
  	function edit_set(inSet)
  	{
  		// get the set editor
  		$.ajax({
			url: "request.php?a=set_editor&set=" + inSet,
			success: function(data, textStatus, jqXHR)
			{
				$("#set_editor")[0].innerHTML = ( data );
				aSet = inSet;
				reload_card_list();
			}
		});
  	}
  	
  	function se_e(name, uniq)
  	{
  		$("#"+uniq+"_"+name)[0].className = "se_down";
  		$("#"+uniq+"_e_"+name)[0].className = "se_up";
  		$("#"+uniq+"_i_"+name)[0].focus();
  	}
  	
  	function se_b(name, uniq)
  	{
  		val = $("#"+uniq+"_i_"+name)[0].value;
  		action = $("#"+uniq+"_a_"+name)[0].value;
  		url = action + "&set=" + aSet + "&" + name + "=" + val;
  		$.ajax({
			url: url,
			success: function(data, textStatus, jqXHR)
			{
				$("#set_editor")[0].innerHTML = ( data );
				reload_set_list();
			}
		});
  	}
</script>

<div id="sets_top">
  <section id="sets">
    <p>Sets <a onclick="add_set()">:add</a></p>
    <p id="set_list"><?php echo $out; ?></p>
  </section>
  <aside id="set_editor"></aside>
</div>

