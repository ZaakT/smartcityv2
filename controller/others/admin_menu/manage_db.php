<?php

require_once('model/model.php');

function manage_db($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/others/admin_menu/manage_db.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3],'username'=>$user[1])); 
}

//---------------------------------------- USERS ----------------------------------------
function manage_users($twig,$is_connected,$isTaken=false){
    $user = getUser($_SESSION['username']);
    $list_users = getListUsers();
    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/others/admin_menu/manage_db_items/manage_users.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3],'username'=>$user[1],'users'=>$list_users, 'isTaken'=>$isTaken)); 
}

function create_user($twig,$is_connected,$post){
    if(isset($post['isAdmin'])){
        $isAdmin=1;
    } else {
        $isAdmin = 0;
    }
    if(isset($post['d'])){
        $profile="d";
    } elseif(isset($post['s'])) {
        $profile= "s";
    }
    $username = $post['username'];
    $passwordClear = $post['password'];
    $salt = uniqid(mt_rand(), true);
    $toHashed = $passwordClear.$salt;
    $hashed = password_hash($toHashed,PASSWORD_DEFAULT); //length = 60 ?
    $profile=$post['profile'];
    $userInfos = [$username,$salt,$hashed,$isAdmin,$profile];
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
    $list_users = getListUsers();
    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/others/admin_menu/manage_db_items/manage_measures.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3],'username'=>$user[1],'measures'=>$list_measures, 'isTaken'=>$isTaken,'listNbUCs'=>$listNbUCs,'users'=>$list_users)); 
}

function create_measure($twig,$is_connected,$post){
    $name = $post['name'];
    $description = $post['description'];
    $user = $post['user'];

    $measureInfos = [$name,$description,$user];
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
    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/others/admin_menu/manage_db_items/manage_uc_cat.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3],'username'=>$user[1],'isTaken'=>$isTaken,'cat'=>$list_cat,'listNbUCs'=>$listNbUCs)); 
}

function create_uc_category($twig,$is_connected,$post){
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

function delete_uc_category($categoryID){
    deleteUCCat(intval($categoryID));
    header('Location: ?A=admin&A2=manage_db&A3=manage_uc_cat');
}


//------------------------------------ USE CASES ------------------------------------

function manage_usecases($twig,$is_connected,$isTaken=false){
    $user = getUser($_SESSION['username']);
    $list_usecases = getListUCs();
    $list_measures = getListMeasures();
    $list_cat = getListUCsCat();
    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/others/admin_menu/manage_db_items/manage_usecases.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3],'username'=>$user[1],'usecases'=>$list_usecases,'isTaken'=>$isTaken,'measures'=>$list_measures,'cat'=>$list_cat)); 
}

function create_usecase($twig,$is_connected,$post){
    $name = $post['name'];
    $description = $post['description'];
    $measID = intval($post['related_measure']);
    $catID = intval($post['related_category']);
    $usecaseInfos = [$name,$description,$measID,$catID];
    //var_dump($usecaseInfos);
    if(!empty(getUCByNameAndMeasAndCat($name,$measID,$catID))){
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
    $listNbCritCat = getNbsCritCat($list_critCat);
    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/others/admin_menu/manage_db_items/manage_crit_cat.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3],'username'=>$user[1],'isTaken'=>$isTaken,'critCat'=>$list_critCat,'listNbCrit'=>$listNbCritCat)); 
}

function create_crit_category($twig,$is_connected,$post){
    $name = $post['name'];

    $categoryInfos = [$name];
    if(!empty(getCritCat($name))){
        manage_crit_cat($twig,$is_connected,true);
    } else {
        insertCritCat($categoryInfos);
        header('Location: ?A=admin&A2=manage_db&A3=manage_crit_cat');
    }
}

function delete_crit_category($categoryID){
    deleteCritCat(intval($categoryID));
    header('Location: ?A=admin&A2=manage_db&A3=manage_crit_cat');
}


//------------------------------------- CRITERIA -------------------------------------

function manage_criteria($twig,$is_connected,$isTaken=false){
    $user = getUser($_SESSION['username']);
    $list_criteria = getListCrit();
    $list_cat = getListCritCat();
    //var_dump($list_cat);
    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/others/admin_menu/manage_db_items/manage_criteria.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3],'username'=>$user[1],'criteria'=>$list_criteria, 'isTaken'=>$isTaken,'cat'=>$list_cat)); 
}

function create_crit($twig,$is_connected,$post){
    $name = $post['name'];
    $description = $post['description'];
    $scoring_guidance = $post['scoring_guidance'];
    $catID = intval($post['related_category']);
    $critInfos = [$name,$description,$scoring_guidance,$catID];
    if(!empty(getCritByNameAndCat($name,$catID))){
        manage_criteria($twig,$is_connected,true);
    } else {
        insertCrit($critInfos);
        header('Location: ?A=admin&A2=manage_db&A3=manage_criteria');
    }
}

function delete_crit($critID){
    deleteCrit(intval($critID));
    header('Location: ?A=admin&A2=manage_db&A3=manage_criteria');
}


//---------------------------------------- DLT ----------------------------------------

function manage_DLT($twig,$is_connected,$isTaken=false){
    $user = getUser($_SESSION['username']);
    $list_DLT = getListDLTs();
    $list_zones = getListZones();
    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];

    echo $twig->render('/others/admin_menu/manage_db_items/manage_dlt.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3],'username'=>$user[1],'dlt'=>$list_DLT, 'zones'=>$list_zones, 'isTaken'=>$isTaken)); 
}

function create_dlt($twig,$is_connected,$post){
    $name = $post['name'];
    $description = $post['description'];
    $infosDLT = [$name,$description];
    //var_dump($infosDLT);
    if(!empty(getDLTByName($name))){
        manage_dlt($twig,$is_connected,true);
    } else {
        insertDLT($infosDLT);
        header('Location: ?A=admin&A2=manage_db&A3=manage_dlt');
    }
}

function delete_dlt($idDLT){
    deleteDLT(intval($idDLT));
    header('Location: ?A=admin&A2=manage_db&A3=manage_dlt');
}


function create_zone($twig,$is_connected,$post){
    $name = $post['name'];
    $type = $post['type'];
    $id_zone = $post['id_zone'];
    $infosZone = [$name,$type,$id_zone];
    //var_dump($infosDLT);
        insertZone($infosZone);
        header('Location: ?A=admin&A2=manage_db&A3=manage_dlt');
}

function delete_zone($idZone){
    deleteZone(intval($idZone));
    header('Location: ?A=admin&A2=manage_db&A3=manage_dlt');
}

//-------------------------------------  MANAGE ITEM  -------------------------------------

function manage_item($catName,$twig,$is_connected,$isTaken=false){
    $user = getUser($_SESSION['username']);
    $list_item = [];
    $listUC = getListUCs();   
    foreach ($listUC as $id_uc => $UC){ 
        $fun = 'getList'.ucwords($catName).'Items';
        $list_tampon = $fun(intval($id_uc));
        foreach ($list_tampon as $id_item => $item){
            $list_item[$id_item] = $item;
            if (array_key_exists('UC',$list_item[$id_item])){
                $list_item[$id_item]['UC'] += [$id_uc,$UC['name']];
            } else {
                $list_item[$id_item]['UC'] = [$id_uc,$UC['name']];
            }
        }            
    }
    //var_dump($list_item, $UC); 

    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/others/admin_menu/manage_db_items/manage_'.$catName.'_item.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3],'username'=>$user[1],'listItem'=>$list_item,'catItemName'=>$catName, 'UC'=>$listUC, 'isTaken'=>$isTaken));
    
}


function create_item1($twig,$is_connected,$post,$catItem){
    //ajoute dans la db un item de catégorie 1 (opex, capex, implementatin, revenues)
    $name = $post['name'];
    $description = $post['description'];
    $unit = $post['unit'];
    $source = $post['source'];
    $range_min = $post['range_min'];
    $range_max = $post['range_max'];
    $uc = $post['uc_id'];
    $itemInfos = [$name,$description,$unit,$source,$range_min,$range_max,$uc];
    if(!empty(getItemByNameAndCat($name,$catItem))){
        manage_item($catItem,$twig,$is_connected,true); 
    } else {
        insertItem($itemInfos,$catItem);
        header('Location: ?A=admin&A2=manage_db&A3=manage_'.$catItem.'_item');
    }
}

function create_item2($twig,$is_connected,$post,$catItem){
    //ajoute dans la db un item de catégorie 2 (cash releasing b, wider cash b)
    $name = $post['name'];
    $description = $post['description'];
    $unit = $post['unit'];
    $source = $post['source'];
    $unit_cost = $post['unit_cost'];
    $range_min_red_nb = $post['range_min_red_nb'];
    $range_max_red_nb = $post['range_max_red_nb'];
    $range_min_red_cost = $post['range_min_red_cost'];
    $range_max_red_cost = $post['range_max_red_cost'];
    $uc = $post['uc_id'];
    $itemInfos = [$name,$description,$unit,$source,$unit_cost,$range_min_red_nb,$range_max_red_nb,$range_min_red_cost,$range_max_red_cost,$uc];
    if(!empty(getItemByNameAndCat($name,$catItem))){
        manage_item($catItem,$twig,$is_connected,true); 
    } else {
        insertItem($itemInfos,$catItem);
        header('Location: ?A=admin&A2=manage_db&A3=manage_'.$catItem.'_item');
    }
}

function create_item3($twig,$is_connected,$post,$catItem){
    //ajoute dans la db un item quantifiable
    $name = $post['name'];
    $description = $post['description'];
    $uc = $post['uc_id'];
    $itemInfos = [$name,$description,$uc];
    if(!empty(getItemByNameAndCat($name,$catItem))){
        manage_item($catItem,$twig,$is_connected,true); 
    } else {
        insertItem($itemInfos,$catItem);
        header('Location: ?A=admin&A2=manage_db&A3=manage_'.$catItem.'_item');
    }
}

function create_quantifiable_item($twig,$is_connected,$post){
    //ajoute dans la db un item de catégorie 3 (non cash b, risks)
    $name = $post['name'];
    $description = $post['description'];
    $unit = $post['unit'];
    $source = $post['source'];
    $range_min_red_nb = $post['range_min_red_nb'];
    $range_max_red_nb = $post['range_max_red_nb'];
    $uc = $post['uc_id'];    
    $itemInfos = [$name,$description,$unit,$source,$range_min_red_nb,$range_max_red_nb,$uc];
    if(!empty(getItemByNameAndCat($name,'quantifiable'))){
        manage_item('quantifiable',$twig,$is_connected,true); 
    } else {
        insertItem($itemInfos,'quantifiable');
        header('Location: ?A=admin&A2=manage_db&A3=manage_quantifiable_item');
    }
}

function delete_item($catItem,$itemID){
    deleteItem($catItem, intval($itemID));
    header('Location: ?A=admin&A2=manage_db&A3=manage_'.$catItem.'_item');
}

function manage_currency($twig,$is_connected,$isTaken=false) {
    $user = getUser($_SESSION['username']);

    $list_currency = getListDevises();
    //var_dump($list_currency);
    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/others/admin_menu/manage_db_items/manage_currency.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3],'username'=>$user[1],'list_currency'=>$list_currency, 'isTaken'=>$isTaken)); 
}

function change_currency_rate($twig,$is_connected,$post) {

    $newrate = $post['newrate'];
    $id = $post['id'];
    changeExchangeRate($id,$newrate);
    manage_currency($twig, $is_connected);
}