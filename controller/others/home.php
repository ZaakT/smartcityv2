<?php

require_once('model/model.php');

function home($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/others/home.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'username'=>$user[1])); 
}
