<?php

require_once('model/model.php');

// -- Scenarios
function scenarios($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/output/scenarios.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}

