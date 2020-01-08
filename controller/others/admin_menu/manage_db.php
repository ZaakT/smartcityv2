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
    $listNbUCs = getNbUCsMeas($list_measures);
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


//---------------------------------- USE CASES CAT. ----------------------------------

function manage_uc_cat($twig,$is_connected,$isTaken=false){
    $user = getUser($_SESSION['username']);
    $list_cat = getListUCsCat();
    $listNbUCs = getNbUCsCat($list_cat);
    echo $twig->render('/others/admin_menu/manage_db_items/manage_uc_cat.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'username'=>$user[1],'isTaken'=>$isTaken,'cat'=>$list_cat,'listNbUCs'=>$listNbUCs)); 
}

function create_category($twig,$is_connected,$post){
    $name = $post['name'];
    $description = $post['description'];

    $categoryInfos = [$name,$description];
    if(!empty(getUCsCat($name))){
        manage_uc_cat($twig,$is_connected,true);
    } else {
        insertUCCat($categoryInfos);
        header('Location: ?A=admin&A2=manage_db&A3=manage_uc_cat');
    }
}

function delete_category($categoryID){
    deleteUCCat(intval($categoryID));
    header('Location: ?A=admin&A2=manage_db&A3=manage_uc_cat');
}


//------------------------------------ USE CASES ------------------------------------

function manage_usecases($twig,$is_connected,$isTaken=false){
    $user = getUser($_SESSION['username']);
    $list_usecases = getListUCs();
    $list_measures = getListMeasures();
    $list_cat = getListUCsCat();
    echo $twig->render('/others/admin_menu/manage_db_items/manage_usecases.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'username'=>$user[1],'usecases'=>$list_usecases,'isTaken'=>$isTaken,'measures'=>$list_measures,'cat'=>$list_cat)); 
}

function create_usecase($twig,$is_connected,$post){
    $name = $post['name'];
    $description = $post['description'];
    $measID = intval($post['related_measure']);
    $catID = intval($post['related_category']);
    $usecaseInfos = [$name,$description,$measID,$catID];
    var_dump($usecaseInfos);
    if(!empty(getUCByName($name))){
        manage_usecases($twig,$is_connected,true);
    } else {
        insertUseCase($usecaseInfos);
        header('Location: ?A=admin&A2=manage_db&A3=manage_usecases');
    }
}

function delete_usecase($usecaseID){
    deleteUseCase(intval($usecaseID));
    header('Location: ?A=admin&A2=manage_db&A3=manage_usecases');
}

//----------------------------------- CRITERIA CAT. -----------------------------------

function manage_crit_cat($twig,$is_connected,$isTaken=false){
    $user = getUser($_SESSION['username']);
    $list_critCat = getListCritCat();
    echo $twig->render('/others/admin_menu/manage_db_items/manage_crit_cat.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'username'=>$user[1],'isTaken'=>$isTaken,'critCat'=>$list_critCat)); 
}


//------------------------------------- CRITERIA -------------------------------------

function manage_criteria($twig,$is_connected,$isTaken=false){
    $user = getUser($_SESSION['username']);
    $list_criteria = getListCrit();
    echo $twig->render('/others/admin_menu/manage_db_items/manage_criteria.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'username'=>$user[1],'criteria'=>$list_criteria, 'isTaken'=>$isTaken)); 
}


//---------------------------------------- DLT ----------------------------------------

function manage_DLT($twig,$is_connected,$isTaken=false){
    $user = getUser($_SESSION['username']);
    $list_DLT = getListDLTs();
    echo $twig->render('/others/admin_menu/manage_db_items/manage_dlt.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'username'=>$user[1],'DLT'=>$list_DLT, 'isTaken'=>$isTaken)); 
}