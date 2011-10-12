<?php
	ob_start();
	include "Requests/cube_list.php";
	Cube::DrawAddCubeCell();
	$out = ob_get_contents();
	ob_end_clean();
?>

<script type="text/javascript">
	var viewportA = "#viewportA";
	var viewportB = "#viewportB";
	var currentViewport = "#viewportA";
	$(document).ready(function() {
		$(viewportB)[0].style.left = window.innerWidth + "px";
		$(viewportB)[0].style.display = "none";
	});
	
	function hide(selector)
	{
		$(selector)[0].innerHTML = "";
		$(selector)[0].style.display = "none";
	}
	
	function jump_directional(resource, direction)
	{
		dir = "+=";
		pos = -1;
		if ( direction == "left" )
		{
			dir = "-=";
			pos = 1;
		}
			
		// get offscreen viewport
		vp = viewportA;
		if ( currentViewport == viewportA )
			vp = viewportB;
		
		// move offscreen viewport in case window has resized
		$(vp)[0].style.left = (pos * window.innerWidth) + "px";
		$(vp)[0].style.display = "block";
		$(vp)[0].style.width = window.innerWidth + "px";
		
		$.ajax({
			url: resource,
			success: function(data, textStatus, jqXHR)
			{
				speed = 200;
				$(vp)[0].innerHTML = ( data );
				$(currentViewport).animate({"left": dir + window.innerWidth + "px"}, speed);
				$(vp).animate({"left": dir + window.innerWidth + "px"}, speed);
				setTimeout('hide("' + currentViewport + '");', speed);
				currentViewport = vp;		
			}
		});
	}
	
	function jump_left(resource)
	{
		jump_directional(resource, "left");
	}
	
	function jump_right(resource)
	{
		jump_directional(resource, "right");
	}

	function load_cube_list()
	{
		$.ajax({
			url: "request.php?a=cube_list",
			success: function(data, textStatus, jqXHR)
			{
				$("#cubes_list")[0].innerHTML = ( data );
			}
		});
	}
	
	function cube_grid_click(str_identifier)
	{
		if ( str_identifier == "new" )
		{
			$("#cube_cell_new")[0].innerHTML = "Hang tight, making your cube.";
			$.ajax({
				url: "request.php?a=new_cube",
				success: function(data, textStatus, jqXHR)
				{					
					load_cube_list();
				}
			});
		}
		else
		{
			jump_left("request.php?a=cube&cube=" + str_identifier);
		}
	}
	
	function edit_cube()
	{
		$("#cube_main_left").animate({"width": "262px"}, 500);
		$(".flow").animate({"width": "250px"}, 500);
		flows = $(".flow");
		cmr =  $("#cube_main_right")[0];
		cml = $("#cube_main_left")[0];
		cmr.style.display = "inline-block";
		cmr.style.width = (window.innerWidth - 300) + "px";
		cmr.style.height = (window.innerHeight - 125) + "px";
		cml.style.height = (window.innerHeight - 125) + "px";
		$.ajax({
			url: "Requests/set/select.php",
			success: function(data, textStatus, jqXHR)
			{					
				$("#cube_main_right")[0].innerHTML = data;
			}
		});
	}
</script>

<section id="vpAwrapper" style="position:relative;">
  <div id="viewportA" style="position:absolute;">
    <?php echo $out; ?>
  </div>
</section>

<section id="vpBwrapper" style="position:relative;">
  <div id="viewportB" style="position:absolute;">
    &nbsp;
  </div>
</section>

