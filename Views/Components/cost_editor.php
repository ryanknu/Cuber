<?php

if ( isset( $_GET["cost"] ) )
{
	$in = $_GET["cost"];
	$cost = Cost::CostFromString($_GET["cost"]);
	$in = substr($in, 2);
}
else
{
	$cost = new Cost($_GET["id"]);
	$in = $cost->EditString();
}

$d = $cost->EditRecord();
$cL = $d->Get("colorless");
$clp1 = $cL+1;
$cL = str_pad($cL, 2, "0", STR_PAD_LEFT);
$clp1 = str_pad($clp1, 2, "0", STR_PAD_LEFT);

$s = DB::zdb()->select()
	->from("symbols");
	
$rows = DB::zdb()->fetchAll($s);
$colors = array();

function BasicImgStr($color, $i)
{
	$r  = "<span onmouseover=\"hover($i);\"";
	$r .= " onclick=\"click_base($i);\">";
	$r .= '<img src="Views/img/mana_symbols/';
	$r .= $color;
	$r .= '" /></span>';
	return $r;
}

$basics = "";
$vars  = "var subs = [];\n";
$vars .= "var strs = [];\n";
$n = 0;

foreach($rows as $row)
{
	$basics .= BasicImgStr($row["symbol"], $n);
	$symbols = array($row["phy"], $row["or2"], $row["other1"], $row["other2"], $row["other3"], $row["other4"]);
	$strings = array($row["phy_str"], $row["or2_str"], $row["o1_str"], $row["o2_str"], $row["o3_str"], $row["o4_str"]);
	$vars .= "subs[$n] = [ \"" . implode('","', $symbols) . "\"];\n";
	$vars .= "strs[$n] = [ \"" . implode('","', $strings) . "\"];\n";
	++$n;
}

?>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js"></script>  	

<script type="text/javascript">
	<?php echo $vars; ?>
	var soFar = "<?php echo $in; ?>";
	var clp1 = "<?php echo $clp1; ?>";
	var cl = "<?php echo $cL; ?>";
	var bases = ["RR","UU","GG","WW","BB"];
	var hov = 0;
	function img(sym, i)
	{
		r  = "<span onclick='click_up(" + i + ");'>";
		r += "<img src=\"Views/img/mana_symbols/" + sym + "\" />";
		r += "</span>";
		return r;
	}
	
	function hover(color)
	{
		hov = color;
		n = "";
		for ( i = 0; i < subs[color].length; i++ )
		{
			n += img(subs[color][i], i);
		}
		$("#cost_specifics")[0].innerHTML = n;
	}
	
	function addAndForward(str)
	{
		document.location = "request.php?a=cost_editor&cost=" + cl + soFar + str;
	}
	
	function click_add_colorless()
	{
		document.location = "request.php?a=cost_editor&cost=" + clp1 + soFar;
	}
	
	function click_base(index)
	{
		addAndForward(bases[index]);
	}
	
	function click_up(index)
	{
		addAndForward(strs[hov][index]); 
	}
</script>

<table style="border-spacing:0px;">
  <tr>
    <td width="30">&nbsp;</td>
    <td id="cost_specifics">&nbsp;</td>
  </tr>
  <tr>
    <td width="30">&nbsp;</td>
    <td><span onclick="click_add_colorless();"><img src="Views/img/mana_symbols/one.gif" /></span><?php echo $basics; ?></td>
  </tr>
  <tr style="border: 1px solid black; border-radius: 5px;">
    <td width="30" style="height: 35px;border: 1px solid black; border-radius: 7px 0px 0px 7px; border-right: none;"><input type="checkbox" /></td>
    <td style="border: 1px solid black; border-radius: 7px;text-align:right;"><?php echo $cost->PrettyCost(); ?></td>
  </tr>
</table>
