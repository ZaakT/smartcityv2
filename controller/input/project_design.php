<?php

require_once('model/model.php');

// -- Project Design
function project_design($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/project_design.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3])); 
}

// --- Project Design Steps
function ucm($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/project_design_steps/ucm.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3])); 
}

function criteria($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/project_design_steps/criteria.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3])); 
}

function geography($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/project_design_steps/geography.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3])); 
}

function use_case($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/project_design_steps/use_case.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3])); 
}

function rating($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/project_design_steps/rating.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3])); 
}

function scoring($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/project_design_steps/scoring.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3])); 
}

function global_score($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/project_design_steps/global_score.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3])); 
}
