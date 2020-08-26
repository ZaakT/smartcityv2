<?php

require_once('model/model.php');

function login($twig,$username_in=true,$password_in=true){
    $username = isset($_COOKIE['username']) ? $_COOKIE['username'] : "";
    $devises = getListDevises();

    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];

    $_SESSION['devise_name'] = $selDevName;
    $_SESSION['devise_symbol'] = $selDevSym;
    
    echo $twig->render('/others/login.twig',array('username'=>$username,'username_in'=>$username_in,'password_in'=>$password_in)); 
    
    echo $twig->render('/others/home.twig');
}

function connexion($twig,$post){
    if(isset($post['inputLogin']) and isset($post['inputPassword'])){
        $username = $post['inputLogin'];
        $password_in = $post['inputPassword'];
        if(!empty(getUser($username))){
            $id = getUser($username)[0];
            $password_db = getUser($username)[2];
            $salt = getUser($username)[4];
            $isPasswordCorrect = password_verify($password_in.$salt,$password_db);
            if($isPasswordCorrect){
                session_start();
                $_SESSION['id'] = $id;
                $_SESSION['username'] = $username;
                setcookie('username',$_SESSION['username'],time()+3600*24*365);
                header('Location: ?A=home');
            } else {
                login($twig,true,false);
            }
        } else {
            login($twig,false,true);
        }
    }
}

function isConnected(){
    if(isset($_SESSION['id']) and isset($_SESSION['username'])){
        setcookie('username',$_SESSION['username']);
    }
    return isset($_SESSION['id']) and isset($_SESSION['username']);
}

function isDev(){
    if($_SESSION['profile'] == "d" ){
        setcookie('username',$_SESSION['username']);
    }
    return isset($_SESSION['id']) AND isset($_SESSION['username']) AND isset($_SESSION['profile']);
}

function isSupplier(){
    if($_SESSION['profile'] == "d" ){
        setcookie('username',$_SESSION['username']);
    }
    return isset($_SESSION['id']) AND isset($_SESSION['username']) AND isset($_SESSION['profile']);
}