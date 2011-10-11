<?php

function OddSequence($len)
{
	$str = "";
	while( strlen( $str ) < $len )
	{
		$str .= chr(rand(ord('A'), ord('Z')));
	}
	return $str;
}

function UniqFilename()
{
	$u = OddSequence(20);
	// do some kind of check to see if it's already there
	return $u;
}

function GetGathererURL($id)
{
	return
		"http://gatherer.wizards.com/Handlers/Image.ashx?multiverseid="
		. $id . "&type=card";
}

function GetURLFor($name, $class)
{
	return "Generated/Images/" . $class . "/" . $name . ".png";
}

function GetImages($id)
{
	$url = GetGathererURL($id);
	$W = 180;
	$H = 130;
	$im = imagecreatefromjpeg($url);
	
	// Get whole art
	$dest = imagecreatetruecolor($W, $H);
	imagecopy($dest, $im, 0, 0, 20, 40, $W, $H);
	$name = UniqFilename();
	$c = "Card";
	$r[$c] = GetURLFor($name, $c);
	fclose(fopen($r[$c], "c"));
	imagepng($dest, $r[$c]);
	imagedestroy($dest);
	
	// Get stripe
	$W = 180;
	$H = 40;
	$F = 120;
	$STEP = 1.0 / $F;
	$dest = imagecreatetruecolor($W, $H);
	imagecopy($dest, $im, 0, 0, 20, 65, $W, $H);
	
	$a = 1;
	for( $x = $W - $F; $x < $W; $x++ )
	{
		for ( $y = 0; $y < $H; $y++ )
		{
			$i = imagecolorat($dest, $x, $y);
			$c = imagecolorsforindex($dest, $i);
			$c = imagecolorallocate($dest, 
				a($c['red'], $a),
				a($c['green'], $a), 
				a($c['blue'], $a)
			);
			imagesetpixel($dest, $x, $y, $c);
		}
		$a -= $STEP;
	}
	$c = "Stripe";
	$r[$c] = GetURLFor($name, $c);
	fclose(fopen($r[$c], "c"));
	imagepng($dest, $r[$c]);
	imagedestroy($dest);
	// Get Cube image
	$W = 150;
	$H = 130;
	$F = 80;
	$STEP = 1.0 / $F;
	$dest = imagecreatetruecolor($W, $H);
	imagecopy($dest, $im, 0, 0, 35, 40, $W, $H);
	
	$a = 1;
	for( $y = $H - $F; $y < $H; $y++ )
	{
		for ( $x = 0; $x < $W; $x++ )
		{
			$i = imagecolorat($dest, $x, $y);
			$c = imagecolorsforindex($dest, $i);
			$c = imagecolorallocate($dest, 
				a($c['red'], $a),
				a($c['green'], $a), 
				a($c['blue'], $a)
			);
			imagesetpixel($dest, $x, $y, $c);
		}
		$a -= $STEP;
	}
	$c = "Cube";
	$r[$c] = GetURLFor($name, $c);
	fclose(fopen($r[$c], "c"));
	imagepng($dest, $r[$c]);
	imagedestroy($dest);
	
	// Destroy main image
	imagedestroy($im);
	return $r;
}

function a($x, $a)
{
	return (int)(
		255 - ( (255 - $x ) * $a )
	);
}

?>