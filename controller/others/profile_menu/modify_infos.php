<?php

require_once('model/model.php');

function modify_infos($twig,$is_connected,$isTaken=false){
    $logoName = isset($_SESSION['logoName']) ? $_SESSION['logoName'] : "LogoUrbatis";
    $user = getUser($_SESSION['username']);
    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    echo $twig->render('/others/profile_menu/modify_infos.twig',array('is_connected'=>$is_connected, "logoName"=>$logoName, 'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3],'username'=>$user[1],'isTaken'=>$isTaken)); 
}

function save_infos($twig,$is_connected,$post){
    $user = getUser($post['username']);
    if(!empty($user) and $user[0]!=$_SESSION['id']){
        modify_infos($twig,$is_connected,true);
    } else {
        $id = $_SESSION['id'];
        $username_new = $post['username'];
        if(!empty($post['password'])){
            $passwordClear = $post['password'];
            $salt = uniqid(mt_rand(), true);
            $toHashed = $passwordClear.$salt;
            $hashed = password_hash($toHashed,PASSWORD_DEFAULT); //length = 60 ?
        } else {
            $user = getUser($_SESSION['username']);
            $salt = $user[4];
            $hashed = $user[2];
        }
        $userInfos = [$id,$username_new,$salt,$hashed];
        modifyUser($userInfos);
        $_SESSION['username'] = $username_new;
        setcookie('username',$_SESSION['username']);
        header('Location: ?A=profile');
    }
}