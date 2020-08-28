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
    
}

function connexion($twig,$post){
    if(isset($post['inputLogin']) and isset($post['inputPassword'])){
        $username = $post['inputLogin'];
        $password_in = $post['inputPassword'];
        if(!empty(getUser($username))){
            $id = getUser($username)[0];
            $password_db = getUser($username)[2];
            $salt = getUser($username)[4];
            $profile = getUser($username)[5];
            $isPasswordCorrect = password_verify($password_in.$salt,$password_db);
            if($isPasswordCorrect){
                session_start();
                $_SESSION['id'] = $id;
                $_SESSION['username'] = $username;
                $_SESSION['profile'] = $profile;
                setcookie('username',$_SESSION['username'],time()+3600*24*365);
                setcookie('profile',$_SESSION['profile'],time()+3600*24*365);
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
    return true;
    return getUserRole()=="project_developper";
}

function isSup(){
    
    return true;
    return getUserRole()=="supplier";
}

function getUserRole(){
    if(isset($_SESSION['profile'])){
        setcookie('profile',$_SESSION['profile']);
        if($_SESSION['profile'] == "d" ){
            return "project_developper";
        }else if($_SESSION['profile'] == "s" ){
            return "supplier";
        }
        throw new Exception("Wrong profile ! : ");
    }
}

function verifIsDev(){
    // If the user is not dev he will be redirected to the home page
    if(!isDev()){
        header('Location: ?A=home');
    }

}

function verifIsSup(){
    // If the user is not sup he will be redirected to the home page
    if(!isSup()){
        header('Location: ?A=home');
    }
}