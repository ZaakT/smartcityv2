<?php

require_once('model/model.php');

// - Projec Developement
function project_dev($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/project_dev.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3])); 
}
