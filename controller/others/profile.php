<?php

require_once('model/model.php');

function profile($twig){
    $user = getUser($_SESSION['username']);
    $city = getUserCity($user[0]);
    echo $twig->render('/others/profile.twig',array('is_connected'=>true,'is_admin'=>$user[3],'username'=>$user[1],'id_user'=>$user[0],'password'=>$user[2],'city'=>$city)); 
}