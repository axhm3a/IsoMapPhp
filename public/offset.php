<?php 	
	header ("Content-type: image/png");
	$im = imagecreatetruecolor (100, 100);
	$background_color = ImageColorAllocate ($im, 0, 0, 0);
	$position = imagecreatefrompng( "c:\\dev\\obj3.png");
	$surface = imagecreatefrompng ( "c:\\dev\\tile1.png" );
	
	$posX = 50.0;
	$posY = 45.0;
	
	$offx = 5;
	$offy = -( -5 ); 
	
	
	imagecopy($im, $surface, round($posX), round($posY) , 0, 0, 20, 30);
	$off = 50;
	
	$scale = 10/5;	
	imagecopy(
		$im, 
		$position, 
		
		($scale / 2 * ($offx + $offy))+ $off, 
		($scale /4 * ($offx - $offy))+ $off -25,
		//$posX 		+ ($offX * 20), 
		//($posY -20)	+ $offY * 10 + $offX * 10, 
		
		0, 0, 20, 30);
		
$red = imagecolorallocate($im, 255, 0, 0);
$blue = imagecolorallocate($im, 0, 0, 255);

	for ($x = 0; $x <= 10; $x++)
	{
			$y = 0;
			imagesetpixel ($im, $x, $y, $red);
			imagesetpixel ($im, round($scale / 2 * ($x + $y))+ $off, round($scale /4 * ($x - $y))+$off, $blue);
	}
	for ($x = 1; $x <= 10; $x++)
	{
			$y = 10;
			imagesetpixel ($im, $x, $y, $red);
			imagesetpixel ($im, round($scale / 2 * ($x + $y))+ $off, round($scale /4 * ($x - $y))+$off, $blue);
	}
	for ($y = 0; $y <= 10; $y++)
	{
			$x = 10;
			imagesetpixel ($im, $x, $y, $red);
			imagesetpixel ($im, round($scale / 2 * ($x + $y))+ $off, round($scale /4 * ($x - $y))+$off, $blue);
	}
	for ($y = 1; $y <= 10; $y++)
	{
			$x = 0;
			imagesetpixel ($im, $x, $y, $red);
			imagesetpixel ($im, round($scale / 2 * ($x + $y))+ $off, round($scale /4 * ($x - $y))+$off, $blue);
	}
		
	
	ImagePNG ($im);
?>