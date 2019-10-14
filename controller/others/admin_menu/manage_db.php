<?php

require_once('model/model.php');

function manage_db($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/others/admin_menu/manage_db.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'username'=>$user[1])); 
}

function manage_users($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    $list_users = getListUsers();
    echo $twig->render('/others/admin_menu/manage_users.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'username'=>$user[1],'users'=>$list_users)); 
}

function create_user($twig,$is_connected){
}