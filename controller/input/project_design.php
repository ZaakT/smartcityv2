<?php

require_once('model/model.php');

// -- Project Design
function project_design($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/input/project_design.twig',array('is_connected'=>true,'is_admin'=>$user[1])); 
}

// --- Project Design Steps
function ucm($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/input/project_design_steps/ucm.twig',array('is_connected'=>true,'is_admin'=>$user[1])); 
}

function criteria($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/input/project_design_steps/criteria.twig',array('is_connected'=>true,'is_admin'=>$user[1])); 
}

function geography($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/input/project_design_steps/geography.twig',array('is_connected'=>true,'is_admin'=>$user[1])); 
}

function use_case($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/input/project_design_steps/use_case.twig',array('is_connected'=>true,'is_admin'=>$user[1])); 
}

function rating($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/input/project_design_steps/rating.twig',array('is_connected'=>true,'is_admin'=>$user[1])); 
}

function scoring($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/input/project_design_steps/scoring.twig',array('is_connected'=>true,'is_admin'=>$user[1])); 
}

function global_score($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/input/project_design_steps/global_score.twig',array('is_connected'=>true,'is_admin'=>$user[1])); 
}
