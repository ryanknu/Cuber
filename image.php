<?php

require_once "Tools/cuber.php";
require_once "Records/cube.php";

function GetWholeImage()
{
	$W = 180;
	$H = 130;
	$im = imagecreatefromjpeg('http://gatherer.wizards.com/Handlers/Image.ashx?multiverseid=220230&type=card');
	$dest = imagecreatetruecolor($W, $H);
	imagecopy($dest, $im, 0, 0, 20, 40, $W, $H);
	
	
	header('Content-type: image/png');
	imagepng($dest);
	imagedestroy($dest);
	imagedestroy($im);
}

function a($x, $a)
{
	return (int)(
		255 - ( (255 - $x ) * $a )
	);
}

function GetPartialImage($url)
{
	$W = 150;
	$H = 130;
	$F = 80;
	$STEP = 1.0 / $F;
	$im = imagecreatefromjpeg($url);
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
	
	header('Content-type: image/png');
	imagepng($dest);
	imagedestroy($dest);
	imagedestroy($im);
}

$cube = $_GET["cube"];
$s = DB::zdb()->select()
	->from(Cube::$TABLE, array("image"))
	->where("id = ?", $cube);
$u = DB::zdb()->fetchOne($s);
if ( $u )
	GetPartialImage($u);

?>