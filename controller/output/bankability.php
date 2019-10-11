<?php

require_once('model/model.php');

function bankability($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/output/dashboards_items/bankability.twig',array('is_connected'=>true,'is_admin'=>$user[1]));
}