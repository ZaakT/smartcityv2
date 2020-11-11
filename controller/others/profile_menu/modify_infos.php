<?php

require_once('model/model.php');

function getLogoName(){
    if(isset($_SESSION['logoName'])){
        if($_SESSION['logoName'] != ""){
            return $_SESSION['logoName'];
        }
    }
    return "LogoUrbatis.png";
}


function modify_infos($twig,$is_connected,$isTaken=false){
    $logoName = getLogoName();
    $user = getUser($_SESSION['username']);
    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    $listGroups = getListUserGroup();
    echo $twig->render('/others/profile_menu/modify_infos.twig',array('is_connected'=>$is_connected, "logoName"=>$logoName, 'devises'=>$devises,'selDevSym'=>$selDevSym,
    'selDevName'=>$selDevName,'is_admin'=>$user[3],'username'=>$user[1],'isTaken'=>$isTaken,'listGroups'=>$listGroups, "userGroup"=>$user[9], "lastname"=>$user[10], 
    "firstname"=>$user[11], 'email'=>$user[12])); 
}

function renameImage($target_file, $userID){
    $exp = explode(".", $target_file);
    $begin="";
    for($i = 0;$i<count($exp)-1; $i++ ){
        $begin.=$exp[$i];
    }
    return $begin."_".$userID.".".$exp[count($exp)-1];
}

function getExt($name){
    $exp = explode('.', $name);
    return $exp[array_key_last($exp)];
}
function save_infos($twig,$is_connected,$post, $files){
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
        if(!empty($files)){
            $target_dir="uploads/logos/";
            $target_file = $target_dir .$user[0].".". getExt(basename($files["logoName"]["name"]));
            move_uploaded_file($files["logoName"]["tmp_name"], $target_file);
            $logoName=explode("/",  $target_file);
            $logoName=$logoName[array_key_last($logoName)];           

        }else{
            $logoName = getLogoName();
        }
        $userInfos = [$id,$username_new,$salt,$hashed, $logoName, $post['companyName'],$post['divisionName'],$post['group'],$post['lastName'],$post['firstname'],$post['email']];
        $_SESSION['logoName']=$logoName;
        $_SESSION['companyName']=$post['companyName'];
        $_SESSION['divisionName']=$post['divisionName'];
        modifyUser($userInfos);
        $_SESSION['username'] = $username_new;
        setcookie('username',$_SESSION['username']);
        header('Location: ?A=profile');
    }
}