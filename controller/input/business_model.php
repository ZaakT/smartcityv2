<?php

require_once('model/model.php');

// --- Financing / Business Model
function business_model($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/input/business_model.twig',array('is_connected'=>true,'is_admin'=>$user[1]));
}