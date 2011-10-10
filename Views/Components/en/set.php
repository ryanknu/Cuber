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
  	
  	var cards;
  	function pre_import()
  	{
  		cards = $("#cards_import")[0].value.split("\n");
  		$("#import_box")[0].innerHTML = "";
  		o = "Importing... <br />";
  		for ( i = 0; i < cards.length; i++ )
  		{
  			o += ( "<span id='c_" + i + "'>" + cards[i] + "</span><br />" );
  		}
  		$("#import_box")[0].innerHTML = o;
  		setTimeout("cimport(" + 0 + ");", 100);
  	}
  	
  	function cimport(i)
  	{
  		name = $.URLEncode(cards[i]);
  		$("#c_" + i)[0].style.color = "purple";
  		$.ajax({
			url: "request.php?a=gg_card&set=" + aSet + "&card=" + name,
			success: function(data, textStatus, jqXHR)
			{
				nc = "green";
				if ( data == "dupe" )
					nc = "orange";
				if ( data == "fail" )
					nc = "red";
				$("#c_" + i)[0].style.color = nc;
				if ( i < cards.length - 1 )
					setTimeout("cimport(" + (i+1) + ");", 100);
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

