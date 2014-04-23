<?php

/**
 * Class Renderer
 */
class Renderer
{
    /**
     * determines the pixel ratio for height information
     * @var int
     */
    private $roughness = 2;

    /**
     * returns arbitrary png data
     * @param int $offsetX
     * @param int $offsetY
     * @return string
     */
    public function renderPng($offsetX, $offsetY)
    {
        $offx = (int)$offsetX;
        $offy = (int)$offsetY;

        $tilesX = 128;
        $tilesY = 128;
        $tileHeight = 30;
        $tileWidth = 20;
        $tileHalfWidth = $tileWidth / 2;
        $width = 2 * 10 * $tilesX;
        $height = 2 * 5 * $tilesY;
        $mapX = 512;
        $mapY = 512;
        $assetPath = "WORK/";
        $renderingSurface = imagecreatetruecolor ($width, $height);
        $heightMap = imagecreatefrompng($assetPath . "heightmap2.png");
        $objectMap = imagecreatefrompng($assetPath . "objmap.png");

        for($x = 0; $x < $mapX; $x++){
            for($y = 0; $y < $mapY; $y++){
                $rgb = imagecolorat($heightMap, $x, $y);
                $map[$x][$y] = $rgb & 0xFF;
            }
        }

        for($x = 0; $x < $mapX; $x++){
            for($y = 0; $y < $mapY; $y++){
                $rgb = imagecolorat($objectMap, $x, $y);
                $mapobj[$x][$y] = $rgb & 0xFF;
            }
        }

        imagealphablending( $renderingSurface, true );

        $tile = array();
        $tile[0] = imagecreatefrompng ( $assetPath . "000.png" );
        $tile[1] = imagecreatefrompng ( $assetPath . "001.png" );
        $tile[10] = imagecreatefrompng ( $assetPath . "010.png" );
        $tile[11] = imagecreatefrompng ( $assetPath . "011.png" );
        $tile[12] = imagecreatefrompng ( $assetPath . "012.png" );
        $tile[13] = imagecreatefrompng ( $assetPath . "013.png" );
        $object[10] = imagecreatefrompng( $assetPath . "obj1.png");
        $object[50] = imagecreatefrompng( $assetPath . "obj2.png");

        for ($y = 0; $y < $tilesY; $y++) {
            $renX = ($width / 2) - $tileWidth;
            $renY = 0;
            $renX = $renX - ($y * $tileHalfWidth);
            $renY = $renY + ($y * $tileHeight /3 /2);

            for ($x = 0; $x < $tilesX; $x++) {
                $renX = $renX + $tileWidth / 2;
                $renY = $renY + $tileHeight / 3 / 2;

                if ($x + $offx >= $mapX || $y + $offy >= $mapY) {
                    imagecopy($renderingSurface, $tile[1], $renX, $renY , 0, 0, 20, 20);
                    continue;
                }
                if ($x + $offx < 0 || $y + $offy < 0) {
                    imagecopy($renderingSurface, $tile[1], $renX, $renY, 0, 0, 20, 20);
                    continue;
                }

                $i = 0;

                if ($map[$x+ $offx][$y+$offy] > $map[$x+ $offx][$y+$offy-1]) {
                    $i = 1;
                }
                if ($map[$x+ $offx][$y+$offy] > $map[$x+ $offx-1][$y+$offy]) {
                    $i = 2;
                }
                if ($map[$x+ $offx][$y+$offy] > $map[$x+ $offx-1][$y+$offy]
                    && $map[$x+ $offx][$y+$offy] > $map[$x+ $offx][$y+$offy-1]) {
                    $i = 3;
                }

                if ($map[$x+ $offx][$y+$offy] == 0) {
                    $i = -9;
                }

                imagecopy(
                    $renderingSurface,
                    $tile[10+ $i],
                    $renX,
                    $renY - ($map[$x+ $offx][$y+$offy]* $this->roughness),
                    0,
                    0,
                    20,
                    20
                );

                if ($mapobj[$x+ $offx][$y+$offy] != 0
                    && $map[$x+ $offx][$y+$offy] != 0) {
                    imagecopy(
                        $renderingSurface,
                        $object[$mapobj[$x+ $offx][$y+$offy]],
                        $renX,
                        $renY - ($map[$x+ $offx][$y+$offy]* $this->roughness) - 20,
                        0,
                        0,
                        20,
                        30
                    );
                }
            }
        }

        ob_start();
        ImagePNG ($renderingSurface);
        return ob_get_clean();
    }
}
 