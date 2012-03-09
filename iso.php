<?php 	
	header ("Content-type: image/png");

	if(isset($_GET['x']) && isset($_GET['y']))
	{
		$offx = $_GET['x'];
		$offy = $_GET['y'];
	}
	else
	{
		$offx = 1;
		$offy = 1;
	}
	
	$tilesX = 50;  //16
	$tilesY = 50;  //21
	$tileHeight = 30;
	$tileWidth = 20;
	$tileHalfWidth = $tileWidth / 2;
	$tileHalfHeight = $tileHeight / 2;
	$width = 2 * 10 * $tilesX;
	$height = 2 * 5 * $tilesY;
	$zackig = 2;
	$mapX =512;
	$mapY =512;
	$path = "WORK/";
	$im = imagecreatetruecolor ($width, $height);
	$heightmapim = imagecreatefrompng($path . "heightmap2.png");
	$objmapim = imagecreatefrompng($path . "objmap.png");
	
	for($x = 0; $x < $mapX; $x++){
		for($y = 0; $y < $mapY; $y++){
 			$rgb = imagecolorat($heightmapim, $x, $y);
			$map[$x][$y] = $rgb & 0xFF;
		}
	}
	
	for($x = 0; $x < $mapX; $x++){
		for($y = 0; $y < $mapY; $y++){
			$rgb = imagecolorat($objmapim, $x, $y);
			$mapobj[$x][$y] = $rgb & 0xFF;
		}
	}
	
	imagealphablending( $im, true );

	$background_color = ImageColorAllocate ($im, 0, 0, 0);
	$tile[0] = imagecreatefrompng ( $path . "000.png" );
	$tile[1] = imagecreatefrompng ( $path . "001.png" );
	$tile[10] = imagecreatefrompng ( $path . "010.png" );
	$tile[11] = imagecreatefrompng ( $path . "011.png" );
	$tile[12] = imagecreatefrompng ( $path . "012.png" );
	$tile[13] = imagecreatefrompng ( $path . "013.png" );
	$object[10] = imagecreatefrompng( $path . "obj1.png");
	$object[50] = imagecreatefrompng( $path . "obj2.png");
		
	for ($y = 0; $y < $tilesY; $y++){
		$renX = ($width / 2) - $tileWidth;
		$renY = 0;
		$renX = $renX - ($y * $tileHalfWidth);
		$renY = $renY + ($y * $tileHeight /3 /2);
		
		for ($x = 0; $x < $tilesX; $x++){
			$renX = $renX + $tileWidth / 2;
			$renY = $renY + $tileHeight / 3 / 2;
			
			if($x + $offx >= $mapX || $y + $offy >= $mapY){
				imagecopy($im, $tile[1], $renX, $renY , 0, 0, 20, 20);	
				continue;
			}
			if($x + $offx < 0 || $y + $offy < 0){
				imagecopy($im, $tile[1], $renX, $renY, 0, 0, 20, 20);	
				continue;
			}
			
			$i = 0;
			
			if($map[$x+ $offx][$y+$offy] > $map[$x+ $offx][$y+$offy-1]){
				$i = 1;}
			if($map[$x+ $offx][$y+$offy] > $map[$x+ $offx-1][$y+$offy]){
				$i = 2;}
			if($map[$x+ $offx][$y+$offy] > $map[$x+ $offx-1][$y+$offy] && $map[$x+ $offx][$y+$offy] > $map[$x+ $offx][$y+$offy-1]){
				$i = 3;}
			
			if($map[$x+ $offx][$y+$offy] == 0){
				$i = -9;
			}
			
			imagecopy($im, $tile[10+ $i], $renX, $renY - ($map[$x+ $offx][$y+$offy]*$zackig), 0, 0, 20, 20);	
			
			if ($mapobj[$x+ $offx][$y+$offy] != 0 && $map[$x+ $offx][$y+$offy] != 0){
					imagecopy($im, $object[$mapobj[$x+ $offx][$y+$offy]], $renX, $renY - ($map[$x+ $offx][$y+$offy]*$zackig) - 20, 0, 0, 20, 30);
			}
		}		
	}
	
	ImagePNG ($im);
?>