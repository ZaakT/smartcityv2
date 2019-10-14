<?php

require_once('model/model.php');

// --- Financing / Business Model
function business_model($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/business_model.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}