<?php

require_once('model/model.php');

function admin($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/others/admin.twig',array('is_connected'=>true,'is_admin'=>$user[1])); 
}