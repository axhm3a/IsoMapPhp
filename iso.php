<?php
	if(isset($_GET['x']) && isset($_GET['y'])) {
		$offsetX = $_GET['x'];
		$offsetY = $_GET['y'];
	} else {
		$offsetX = 1;
		$offsetY = 1;
	}

    require_once 'Renderer.php';
    $renderer = new Renderer();

    header ("Content-type: image/png");
    echo $renderer->renderPng($offsetX, $offsetY);
