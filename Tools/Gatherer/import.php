<?php

// Gatherer Import file
// Does it in a three step process:
//   1. Download the card data over cURL by the card name
//   2. Quickly shoot through and throw away lots of HTML (coarse)
//   3. Finely strip out HTML tags and reformat data for our system.
//
// This file is not easy to understand and is not meant to be. It is
// ridiculously arbitrary and hackey. It's almost a miracle it works
// at all, and I don't really want to maintain it.

function GathererGrabName($name)
{
	$name = urlencode($name);
	$url = "http://gatherer.wizards.com/Pages/Card/Details.aspx?name=" . $name;
	
	$curl = curl_init();

	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	
	$r = curl_exec($curl);
	if (curl_errno($curl) || !$r)
	{
		throw new Exception("Gatherer grabber postback returned no transit");
	}
	curl_close($curl);
	return $r;
}

function GathererCoarseParse($text)
{
	static $flags = array(
		"Card Name", "Mana Cost",
		"Types", "Card Text", "Flavor Text",
		"Loyalty", "P/T",
		"Expansion", "Rarity", "Card #",
		"Artist"
	);
	$types = array("Loyalty" => "Planeswalker", "P/T" => "Creature");
	$text = explode("\n", $text);
	$out = array();
	$ptr = 0;
	$done = false;
	for( $i = 0; $i < count($text) && !$done; $i++ )
	{
		if ( strpos( $text[$i], $flags[$ptr] ) )
		{
			if ( $flags[$ptr] <> "Expansion" )
				$out[$flags[$ptr]] = trim($text[$i+2]);
			else
				$out[$flags[$ptr]] = trim($text[$i+3]);
			if ( $flags[$ptr] == "Types" )
			{
				foreach( $types as $key => $type )
				{
					if ( strpos($out[$flags[$ptr]], $type) )
					{
						unset($types[$key]);
					}
				}
			}
			$ptr++;
			if ( $ptr >= count($flags) )
				$done = true;
			else
			{
				while ( in_array($flags[$ptr], array_keys($types) ) )
					$ptr++;
			}
		}
	}
	return $out;
}

function GathererFineParse($ca)
{
	static $colors = array(
		"Green" => "GG", "Blue" => "UU",
		"Red" => "RR", "Black" => "BB",
		"White" => "WW", "Green or White" => "GW"
	);
	$ca["Card Name"] = trim(strip_tags($ca["Card Name"]));
	$ca["Card Text"] = trim(strip_tags(str_replace("</div>","\n", $ca["Card Text"])));
	$ca["Flavor Text"] = trim(strip_tags(str_replace("</div>","\n", $ca["Flavor Text"])));
	if ( isset($ca["P/T"]) )
	{
		$ca["P"] = (int)$ca["P/T"];
		$ca["T"] = (int)substr($ca["P/T"], strpos("/", $ca["P/T"]));
		unset($ca["P/T"]);
	}
	$ca["Rarity"] = trim(strip_tags($ca["Rarity"]));
	$ca["Card #"] = trim(strip_tags($ca["Card #"]));
	$ca["Artist"] = trim(strip_tags($ca["Artist"]));
	$mc = $ca["Mana Cost"];
	$t = 0;
	$costs = "";
	while ( $t < strlen($mc) )
	{
		$s = strpos($mc, "alt=", $t) + 5;
		$e = strpos($mc, "\"", $s);
		$l = $e - $s;
		$o = trim(substr($mc, $s, $l));
		if ( is_numeric( $o ) )
		{
			if ( strlen($o) < 2 )
				$costs .= "0";
			$costs .= $o;
		}
		else
		{
			if ( !in_array($o, array_keys($colors) ))
				break;
			$costs .= $colors[$o];
		}
		$t = $e;
	}
	$ca["Mana Cost"] = $costs;
	$ex = $ca["Expansion"];
	$s = strpos($ex, "alt=") + 5;
	$e = strpos($ex, "(", $s);
	$l = $e - $s;
	$ca["Expansion"] = substr($ex, $s, $l);
	$types = explode(" ", $ca["Types"]);
	$typs = array();
	$subs = array();
	$cur = &$typs;
	for( $i = 0; $i < count($types); $i++ )
	{
		if ( !$types[$i] )
		{
			$i++;
			$cur = &$subs;
		}
		else
		{
			$cur[] = trim(strip_tags($types[$i]));
		}
	}
	$ca["Types"] = $typs;
	$ca["Subtypes"] = $subs;
	return $ca;
}

print_r(
	GathererFineParse(
		GathererCoarseParse(
			GathererGrabName("Iona, Shield of Emeria")
		)
	)
);

?>