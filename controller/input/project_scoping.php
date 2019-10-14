<?php

require_once('model/model.php');

// -- Project Scoping
function project_scoping($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/project_scoping.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3])); 
}

// --- Project Scoping Steps
function project($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/project_scoping_steps/project.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3])); 
}

function scope($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/project_scoping_steps/scope.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3])); 
}

function perimeter($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/project_scoping_steps/perimeter.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3])); 
}

function size($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/project_scoping_steps/size.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3])); 
}

function volumes($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/project_scoping_steps/volumes.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3])); 
}

function schedule($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/project_scoping_steps/schedule.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3])); 
}

function discount_rate($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/project_scoping_steps/discount_rate.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3])); 
}