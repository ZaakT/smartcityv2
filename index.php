<?php

require __DIR__ . '/vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/view');
$twig = new Environment($loader);


if(isset($_GET['path'])){
    $path = $_GET['path'];
    $is_connected = true;
    $is_admin = true;
} else {
    $path = "/others/login";
    $is_connected = false;
    $is_admin = false;
}


echo $twig->render($path.'.twig',array('is_connected'=>$is_connected,'is_admin'=>$is_admin)); 
//is_admin à récupérer en SQL