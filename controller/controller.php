<?php

require_once('model/model.php');

function login($twig){
    setcookie("test","test",time()+3600);
    echo $twig->render('/others/login.twig',array('is_connected'=>false)); 
}

function home($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/others/home.twig',array('is_connected'=>true,'is_admin'=>$user[1],'username'=>$user[0],'id_user'=>$user[2])); 
}

function disconnect($twig){
    echo $twig->render('/others/login.twig',array('is_connected'=>false)); 
}

function admin($twig){
    echo $twig->render('/others/admin.twig',array('is_connected'=>true,'is_admin'=>$user[1])); 
}

function profile($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/others/profile.twig',array('is_connected'=>true,'is_admin'=>$user[1],'username'=>$user[0],'id_user'=>$user[2])); 
}

function project_dev($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/input/project_dev.twig',array('is_connected'=>true,'is_admin'=>$user[1])); 
}

function project_design($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/input/project_design.twig',array('is_connected'=>true,'is_admin'=>$user[1])); 
}

function ucm($twig,$id_user){
    echo $twig->render('/others/profile.twig',array('is_connected'=>true,'is_admin'=>$user[1])); 
}

function project_scoping($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/input/project_scoping.twig',array('is_connected'=>true,'is_admin'=>$user[1])); 
}

function cost_benefits($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/input/cost_benefits.twig',array('is_connected'=>true,'is_admin'=>$user[1]));
}

function financing($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/input/financing.twig',array('is_connected'=>true,'is_admin'=>$user[1]));
}

function business_model($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/input/business_model.twig',array('is_connected'=>true,'is_admin'=>$user[1]));
}

function funding($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/input/funding.twig',array('is_connected'=>true,'is_admin'=>$user[1]));
}

function dashboards($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/output/dashboards.twig',array('is_connected'=>true,'is_admin'=>$user[1]));
}

function scenarios($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/output/scenarios.twig',array('is_connected'=>true,'is_admin'=>$user[1]));
}