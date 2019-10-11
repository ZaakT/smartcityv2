<?php

require_once('model/model.php');

// -- Scenarios
function scenarios($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/output/scenarios.twig',array('is_connected'=>true,'is_admin'=>$user[1]));
}

