<?php

require_once('model/model.php');

function home($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    $logoName = getLogoName();
    //echo phpversion();
    echo $twig->render('/others/home.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3],'username'=>$user[1], "logoName"=>$logoName)); 
}

function setDevise($idDevise,$lastURL){
    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    $_SESSION['devise_id'] = $idDevise;
    $_SESSION['devise_name'] = $devises[$idDevise]['name'];
    $_SESSION['devise_symbol'] = $devises[$idDevise]['symbol'];
    $tab = explode(',',$lastURL);
    $url = "";
    for($i = 0; $i<count($tab); $i+=2){
        if(isset($tab[$i+1])){
            $url.=$tab[$i]."=".$tab[$i+1]."&";
        }
    }
    //var_dump('Location: '.$url);
    header('Location: '.$url);
}