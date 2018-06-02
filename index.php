<?php
session_start();
if(isset($_SESSION['user_key'])){
  $globalUserKey = $_SESSION['user_key'];
}

require('app/app.php');

$app->run();
