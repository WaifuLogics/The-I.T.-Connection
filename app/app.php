<?php
require(__DIR__ . "/../vendor/autoload.php");
require(__DIR__ . '/config/config.php');

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
    $view->offsetSet("accountId", $_SESSION['user_key']);

    return $view;
};

$container['database'] = function ($c) {
    $s = $GLOBALS['config']['database'];
    /*Database connection information*/
    $servername = $s['servername'];
    $username = $s['username'];
    $password = $s['password'];
    $dbname = $s['dbname'];

    return new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
};

require(__DIR__ . "/router.php");
