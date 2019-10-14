<?php

require_once('model/model.php');

function admin($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/others/admin.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3])); 
}