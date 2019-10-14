<?php

require_once('model/model.php');

function cost_benefits_out($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/output/dashboards_items/cost_benefits_out.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}
