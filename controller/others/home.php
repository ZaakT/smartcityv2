<?php

require_once('model/model.php');

function home($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/others/home.twig',array('is_connected'=>true,'is_admin'=>$user[1],'username'=>$user[0],'id_user'=>$user[2])); 
}
