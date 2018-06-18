<?php

// IMPORTANT
// Start the local server with: php -S 127.0.0.1:8080 index.php

if (PHP_SAPI == 'cli-server') {
    $_SERVER['SCRIPT_NAME'] = '/index.php';
}

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);
// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.
if ($uri !== '/' && file_exists(__DIR__.$uri)) {
    return false;
}

session_start();
if(isset($_SESSION['user_key'])){
  $globalUserKey = $_SESSION['user_key'];
}

require('app/app.php');

$app->run();
