<?php

require_once('model/model.php');

function manage_db($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/others/admin_menu/manage_db.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'username'=>$user[1])); 
}

function manage_users($twig,$is_connected,$isTaken=false){
    $user = getUser($_SESSION['username']);
    $list_users = getListUsers();
    echo $twig->render('/others/admin_menu/manage_users.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'username'=>$user[1],'users'=>$list_users, 'isTaken'=>$isTaken)); 
}

function create_user($twig,$is_connected,$post){
    if(isset($post['isAdmin'])){
        $isAdmin=1;
    } else {
        $isAdmin = 0;
    }
    $username = $post['username'];
    $passwordClear = $post['password'];
    $salt = uniqid(mt_rand(), true);
    $toHashed = $passwordClear.$salt;
    $hashed = password_hash($toHashed,PASSWORD_DEFAULT); //length = 60 ?
    $userInfos = [$username,$salt,$hashed,$isAdmin,1];
    if(!empty(getUser($username))){
        manage_users($twig,$is_connected,true);
    } else {
        insertUser($userInfos);
        header('Location: ?A=admin&A2=manage_users');
    }
}

