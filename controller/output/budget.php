<?php

require_once('model/model.php');

function budget($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/output/dashboards_items/budget.twig',array('is_connected'=>true,'is_admin'=>$user[1]));
}