<?php

for($x = 0; $x < 10; $x++)
{
	for($y = 0; $y < 10; $y++)
	{
		$array[$x][$y] = 0;

	}
}

$array[4][4] = 1;
$array[4][5] = 1;

echo json_encode($array);

?>