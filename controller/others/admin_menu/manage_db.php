<?php

require_once('model/model.php');

function manage_db($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/others/admin_menu/manage_db.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'username'=>$user[1])); 
}

//---------------------------------------- USERS ----------------------------------------
function manage_users($twig,$is_connected,$isTaken=false){
    $user = getUser($_SESSION['username']);
    $list_users = getListUsers();
    echo $twig->render('/others/admin_menu/manage_db_items/manage_users.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'username'=>$user[1],'users'=>$list_users, 'isTaken'=>$isTaken)); 
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
    $userInfos = [$username,$salt,$hashed,$isAdmin];
    if(!empty(getUser($username))){
        manage_users($twig,$is_connected,true);
    } else {
        insertUser($userInfos);
        header('Location: ?A=admin&A2=manage_db&A3=manage_users');
    }
}

function delete_user($userID){
    deleteUser(intval($userID));
    header('Location: ?A=admin&A2=manage_db&A3=manage_users');
}


//------------------------------------- MEASURES -------------------------------------

function manage_measures($twig,$is_connected,$isTaken=false){
    $user = getUser($_SESSION['username']);
    $list_measures = getListMeasures();
    $listNbUCs = getNbUCs($list_measures);
    //var_dump($listNbUCs);
    echo $twig->render('/others/admin_menu/manage_db_items/manage_measures.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'username'=>$user[1],'measures'=>$list_measures, 'isTaken'=>$isTaken,'listNbUCs'=>$listNbUCs)); 
}

function create_measure($twig,$is_connected,$post){
    $name = $post['name'];
    $description = $post['description'];

    $measureInfos = [$name,$description];
    if(!empty(getMeasure($name))){
        manage_measures($twig,$is_connected,true);
    } else {
        insertMeasure($measureInfos);
        header('Location: ?A=admin&A2=manage_db&A3=manage_measures');
    }
}

function delete_measure($measureID){
    deleteMeasure(intval($measureID));
    header('Location: ?A=admin&A2=manage_db&A3=manage_measures');
}


//------------------------------------- USE CASES -------------------------------------


function manage_usecases($twig,$is_connected,$isTaken=false){
    $user = getUser($_SESSION['username']);
    $list_usecases = getListUCs();
    echo $twig->render('/others/admin_menu/manage_db_items/manage_usecases.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'username'=>$user[1],'usecases'=>$list_usecases, 'isTaken'=>$isTaken)); 
}

function manage_criteria($twig,$is_connected,$isTaken=false){
    $user = getUser($_SESSION['username']);
    $list_criteria = getListCrit();
    echo $twig->render('/others/admin_menu/manage_db_items/manage_criteria.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'username'=>$user[1],'criteria'=>$list_criteria, 'isTaken'=>$isTaken)); 
}

function manage_DLT($twig,$is_connected,$isTaken=false){
    $user = getUser($_SESSION['username']);
    $list_DLT = getListDLTs();
    echo $twig->render('/others/admin_menu/manage_db_items/manage_dlt.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'username'=>$user[1],'DLT'=>$list_DLT, 'isTaken'=>$isTaken)); 
}