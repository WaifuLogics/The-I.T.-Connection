<?php

use Slim\Http\{Request, Response};

$app->get('/', function (Request $request, Response $response, $args) {
    return $this->view->render($response, 'home.twig', [
        //an array of variables that can be used in twig
        'color' => 'Jemoeder',
        'name' => 'Guylian',
        'items' => array_merge(range('A', 'Z'), range('a', 'z'))
    ]);
})->setName('home');