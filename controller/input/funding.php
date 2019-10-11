<?php

require_once('model/model.php');

// --- Financing / Funding
function funding($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/input/funding.twig',array('is_connected'=>true,'is_admin'=>$user[1]));
}

// ---- Financing / Funding Steps
function scenario($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/input/funding_steps/scenario.twig',array('is_connected'=>true,'is_admin'=>$user[1]));
}

function input($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/input/funding_steps/input.twig',array('is_connected'=>true,'is_admin'=>$user[1]));
}

function output($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/input/funding_steps/output.twig',array('is_connected'=>true,'is_admin'=>$user[1]));
}

function benef($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/input/funding_steps/benef.twig',array('is_connected'=>true,'is_admin'=>$user[1]));
}

function scen_comp($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/input/funding_steps/scen_comp.twig',array('is_connected'=>true,'is_admin'=>$user[1]));
}