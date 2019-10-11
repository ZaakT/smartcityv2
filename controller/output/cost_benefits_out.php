<?php

require_once('model/model.php');

function cost_benefits_out($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/output/dashboards_items/cost_benefits_out.twig',array('is_connected'=>true,'is_admin'=>$user[1]));
}
