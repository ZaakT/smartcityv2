<?php

require_once('model/model.php');

// -- Project Scoping
function project_scoping($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/input/project_scoping.twig',array('is_connected'=>true,'is_admin'=>$user[1])); 
}

// --- Project Scoping Steps
function project($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/input/project_scoping_steps/project.twig',array('is_connected'=>true,'is_admin'=>$user[1])); 
}

function scope($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/input/project_scoping_steps/scope.twig',array('is_connected'=>true,'is_admin'=>$user[1])); 
}

function perimeter($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/input/project_scoping_steps/perimeter.twig',array('is_connected'=>true,'is_admin'=>$user[1])); 
}

function size($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/input/project_scoping_steps/size.twig',array('is_connected'=>true,'is_admin'=>$user[1])); 
}

function volumes($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/input/project_scoping_steps/volumes.twig',array('is_connected'=>true,'is_admin'=>$user[1])); 
}

function schedule($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/input/project_scoping_steps/schedule.twig',array('is_connected'=>true,'is_admin'=>$user[1])); 
}

function discount_rate($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/input/project_scoping_steps/discount_rate.twig',array('is_connected'=>true,'is_admin'=>$user[1])); 
}