<?php
require(__DIR__ . "/../vendor/autoload.php");

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true
    ]
]);

// Get container
$container = $app->getContainer();

// Register component on container
$container['view'] = function ($c) {
    $view = new \Slim\Views\Twig(__DIR__ . '/views', [
        //'cache' => 'path/to/cache'
    ]);

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace(
        'index.php',
        '',
        $c['request']->getUri()->getBasePath()
    ), '/');
    $view->addExtension(new Slim\Views\TwigExtension(
        $c['router'],
        $basePath
    ));

    $view->offsetSet('loggedIn', !empty($_SESSION['user_name']));
    if(isset($_SESSION['user_name'])){
        $view->offsetSet("accountName", $_SESSION['user_name']);
    }

    return $view;
};

$container['database'] = function ($c) {
    /*Database connection information*/
    $servername = "protask.duncte123.me";
    $username = "pro";
    $password = "30Fos5L1Y";
    $dbname = "it_connection";

    return new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
};

require(__DIR__ . "/router.php");