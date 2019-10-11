<?php

require_once('model/model.php');

// - Projec Developement
function project_dev($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/input/project_dev.twig',array('is_connected'=>true,'is_admin'=>$user[1])); 
}
