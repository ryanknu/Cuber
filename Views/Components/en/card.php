<?php
	if ( !Auth::Obj()->CanAccess(2) )
		return;
?>

<script type="text/javascript">
	
	function reload_card_list()
	{
		$.ajax({
			url: "request.php?a=card_list&set=" + aSet,
			success: function(data, textStatus, jqXHR)
			{
				$("#card_list")[0].innerHTML = ( data );
			}
		});
	}
	
	function add_card()
	{
		$.ajax({
			url: "request.php?a=new_card&set=" + aSet,
			success: function(data, textStatus, jqXHR)
			{
				reload_card_list();
			}
		});
	}
	
	function edit_card(id)
	{
		$.ajax({
			url: "request.php?a=card_editor&card=" + id,
			success: function(data, textStatus, jqXHR)
			{
				$("#card_editor")[0].innerHTML = data;
			}
		});
	}
	
	function ce_e(name, uniq)
  	{
  		$("#"+uniq+"_"+name)[0].className = "se_down";
  		$("#"+uniq+"_e_"+name)[0].className = "se_up";
  		$("#"+uniq+"_i_"+name)[0].focus();
  	}
  	
  	function ce_b(name, uniq)
  	{
  		val = $("#"+uniq+"_i_"+name)[0].value;
  		action = $("#"+uniq+"_a_"+name)[0].value;
  		url = action + "&card=" + aSet + "&" + name + "=" + val;
  		$.ajax({
			url: url,
			success: function(data, textStatus, jqXHR)
			{
				$("#card_editor")[0].innerHTML = ( data );
				reload_set_list();
			}
		});
  	}
</script>

<div id="cards_top">
  <section id="cards">
    <p>Cards <a onclick="add_card()">:add</a></p>
    <p id="card_list">^ open a set ^</p>
  </section>
  <aside id="card_editor"></aside>
</div>