<?php

require_once('model/model.php');

function profile($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/others/profile.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'username'=>$user[1])); 
}
