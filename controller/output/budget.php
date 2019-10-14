<?php

require_once('model/model.php');

function budget($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/output/dashboards_items/budget.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}