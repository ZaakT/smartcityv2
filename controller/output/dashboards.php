<?php

require_once('model/model.php');

function dashboards($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/output/dashboards.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}

