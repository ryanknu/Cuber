<?php
	ob_start();
	include "Requests/cube_list.php";
	Cube::DrawAddCubeCell();
	$out = ob_get_contents();
	ob_end_clean();
?>

<script type="text/javascript">
	function load_cube_list()
	{
		$.ajax({
			url: "request.php?a=cube_list",
			success: function(data, textStatus, jqXHR)
			{
				$("#cubes_top")[0].innerHTML = ( data );
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
	}
</script>

<section id="cubes_top">
  <p id="cube_list" style="text-align: center"><?php echo $out; ?></p>
</section>

