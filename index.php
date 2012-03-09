<?php 

	if(isset($_GET['x']) && isset($_GET['y']))
	{
		$x = $_GET['x'];
		$y = $_GET['y'];
	}
	else
	{
		$x = 1;
		$y = 1;
	}
	
	$jump = 50;



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<!-- <meta name="viewport" content="width=240, initial-scale=1.0"/> -->
<title>axhm3a's ISO Engine</title>
<style type="text/css">
  body, img { margin-top:0px; margin-left:0px; }
</style>
</head>
<body bgcolor="#000000">
<p align="center"><font color="#FFFFFF">axhm3a's proof of concept:</font></p>
<p align="center"><font color="#FFFFFF">2d isometric landscape with height information</font></p>
<form action="index.php" method="get">
<table align="center" border="0" cellpadding="0" cellspacing="0">
<tr><td><a href="index.php?x=<?php echo $x - $jump;?>&y=<?php echo $y;?>"><img src="blue.png" width="50" height="50"></a></td><td><img src="black.png" width="800" height="50"></td><td><a href="index.php?x=<?php echo $x;?>&y=<?php echo $y - $jump;?>"><img src="yellow.png" width="50" height="50"></a></td>
<tr><td><img src="black.png" width="50" height="400"></td><td><a href="index.php"><img src="iso.php?x=<?php echo $x;?>&y=<?php echo $y;?>" height="400" width="800"></a></td><td><img src="black.png" width="50" height="400"></td>
<tr><td><a href="index.php?x=<?php echo $x;?>&y=<?php echo $y + $jump;?>"><img src="green.png" width="50" height="50"></a></td><td><img src="black.png" width="800" height="50"></td><td><a href="index.php?x=<?php echo $x + $jump; ?>&y=<?php echo $y; ?>"><img src="red.png" width="50" height="50"></a></td>
</table>
</form>
<p align="center"><font color="#FFFFFF">&copy; 2010 - 2012 Daniel Basten</font></p>
</body>
</html>