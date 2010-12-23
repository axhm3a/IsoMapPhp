<?php
$heightmapim = imagecreatefrompng("c:\\dev\\objectmap.png");

echo "<table>";
for($x = 0; $x < 15; $x++){
	echo "<tr>";
		for($y = 0; $y < 15; $y++){
			$rgb = imagecolorat($heightmapim, $y, $x);
			echo "<td>" . ($rgb & 0xFF) . "</td>";
		}
	echo "</tr>";
	}
	
?>