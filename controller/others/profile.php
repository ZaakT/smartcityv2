<?php

require_once('model/model.php');

function profile($twig,$id_user){
    $user = getUser($id_user);
    $city = getUserCity($id_user);
    echo $twig->render('/others/profile.twig',array('is_connected'=>true,'is_admin'=>$user[1],'username'=>$user[0],'id_user'=>$user[2],'password'=>$user[3],'city'=>$city)); 
}