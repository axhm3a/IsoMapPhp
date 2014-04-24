<?php

class Controller
{
    /**
     * @param array $get
     */
    public static function run($get)
    {
        $controller = new Controller();
        $controller->handleRequest($get);
    }

    /**
     * @param array $get
     */
    public function handleRequest($get)
    {
        $offsetX = isset($get['x']) ? $get['x'] : 1;
        $offsetY = isset($get['y']) ? $get['y'] : 1;

        if(!isset($get['png'])) {
            $offset = 50;
            include 'index.phtml';

        } else {
            require_once 'Renderer.php';
            $renderer = new Renderer();

            header ("Content-type: image/png");
            echo $renderer->renderPng($offsetX, $offsetY);
        }
    }
}
