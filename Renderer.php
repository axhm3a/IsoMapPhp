<?php

/**
 * Class Renderer
 */
class Renderer
{
    private $assetPath = "assets/";
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
        $offsetX = (int)$offsetX;
        $offsetY = (int)$offsetY;

        $tilesPerDimension = 128;
        $tileHeight = 30;
        $tileWidth = 20;
        $tileHalfWidth = $tileWidth / 2;
        $renderingSurfaceWidth = 2 * 10 * $tilesPerDimension;
        $renderingSurfaceHeight = 2 * 5 * $tilesPerDimension;
        $mapDimensionX = 512;
        $mapDimensionY = 512;

        $renderingSurface = imagecreatetruecolor ($renderingSurfaceWidth, $renderingSurfaceHeight);
        imagealphablending( $renderingSurface, true );

        $objectMap = $this->getObjectMap($mapDimensionX, $mapDimensionY);
        $terrainMap = $this->getTerrainMap($mapDimensionX, $mapDimensionY);


        $tile = array();
        $tile[1] = imagecreatefrompng ( $this->assetPath . "tiles/001.png" );
        $tile[10] = imagecreatefrompng ( $this->assetPath . "tiles/010.png" );
        $tile[11] = imagecreatefrompng ( $this->assetPath . "tiles/011.png" );
        $tile[12] = imagecreatefrompng ( $this->assetPath . "tiles/012.png" );
        $tile[13] = imagecreatefrompng ( $this->assetPath . "tiles/013.png" );
        $object[10] = imagecreatefrompng( $this->assetPath . "objects/obj1.png");
        $object[50] = imagecreatefrompng( $this->assetPath . "objects/obj2.png");

        for ($y = 0; $y < $tilesPerDimension; $y++) {
            $renX = ($renderingSurfaceWidth / 2) - $tileWidth;
            $renY = 0;
            $renX = $renX - ($y * $tileHalfWidth);
            $renY = $renY + ($y * $tileHeight /3 /2);

            for ($x = 0; $x < $tilesPerDimension; $x++) {
                $renX = $renX + $tileWidth / 2;
                $renY = $renY + $tileHeight / 3 / 2;

                if ($x + $offsetX >= $mapDimensionX || $y + $offsetY >= $mapDimensionY) {
                    imagecopy($renderingSurface, $tile[1], $renX, $renY , 0, 0, 20, 20);
                    continue;
                }
                if ($x + $offsetX < 0 || $y + $offsetY < 0) {
                    imagecopy($renderingSurface, $tile[1], $renX, $renY, 0, 0, 20, 20);
                    continue;
                }

                $tileOffset = 0;

                if ($terrainMap[$x+ $offsetX][$y+$offsetY] > $terrainMap[$x+ $offsetX][$y+$offsetY-1]) {
                    $tileOffset = 1;
                }
                if ($terrainMap[$x+ $offsetX][$y+$offsetY] > $terrainMap[$x+ $offsetX-1][$y+$offsetY]) {
                    $tileOffset = 2;
                }
                if ($terrainMap[$x+ $offsetX][$y+$offsetY] > $terrainMap[$x+ $offsetX-1][$y+$offsetY]
                    && $terrainMap[$x+ $offsetX][$y+$offsetY] > $terrainMap[$x+ $offsetX][$y+$offsetY-1]) {
                    $tileOffset = 3;
                }

                if ($terrainMap[$x+ $offsetX][$y+$offsetY] == 0) {
                    $tileOffset = -9;
                }

                imagecopy(
                    $renderingSurface,
                    $tile[10 + $tileOffset],
                    $renX,
                    $renY - ($terrainMap[$x+ $offsetX][$y+$offsetY] * $this->roughness),
                    0,
                    0,
                    20,
                    20
                );

                if ($objectMap[$x+ $offsetX][$y+$offsetY] != 0
                    && $terrainMap[$x+ $offsetX][$y+$offsetY] != 0) {
                    imagecopy(
                        $renderingSurface,
                        $object[$objectMap[$x+ $offsetX][$y+$offsetY]],
                        $renX,
                        $renY - ($terrainMap[$x+ $offsetX][$y+$offsetY] * $this->roughness) - 20,
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

    /**
     * @param int $mapX
     * @param int $mapY
     * @return array
     */
    private function getTerrainMap($mapX, $mapY)
    {
        return $this->getMap($mapX, $mapY, "heightmap.png");
    }

    /**
     * @param int $mapX
     * @param int $mapY
     * @return array
     */
    private function getObjectMap($mapX, $mapY)
    {
        return $this->getMap($mapX, $mapY, "objectmap.png");
    }

    /**
     * @param int $mapX
     * @param int $mapY
     * @param string $mapName
     * @return array
     */
    private function getMap($mapX, $mapY, $mapName)
    {
        $map = array();
        $mapImage = imagecreatefrompng($this->assetPath . $mapName);
        for($x = 0; $x < $mapX; $x++){
            for($y = 0; $y < $mapY; $y++){
                $map[$x][$y] = imagecolorat($mapImage, $x, $y) & 0xFF;
            }
        }
        return $map;
    }
}
 