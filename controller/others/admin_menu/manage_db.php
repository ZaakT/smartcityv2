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
    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/others/admin_menu/manage_db_items/manage_measures.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3],'username'=>$user[1],'measures'=>$list_measures, 'isTaken'=>$isTaken,'listNbUCs'=>$listNbUCs)); 
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
    $catID = intval($post['related_category']);
    $critInfos = [$name,$description,$catID];
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
    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];

    echo $twig->render('/others/admin_menu/manage_db_items/manage_dlt.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3],'username'=>$user[1],'dlt'=>$list_DLT, 'isTaken'=>$isTaken)); 
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

//------------------------------------- ITEM CAT 1 : capex, opex, implem, revenues  -------------------------------------

function manage_capex_item($twig,$is_connected,$isTaken=false){
    $user = getUser($_SESSION['username']);
    $list_capex_item = [];
    $listUC = getListUCs();
    foreach ($listUC as $id_uc => $UC){
        $list_tampon = getListCapexAdvice($id_uc);
        foreach ($list_tampon as $id_item => $item){
            $list_capex_item[$id_item] = $item;
            if (array_key_exists('UC',$list_capex_item[$id_item])){
                $list_capex_item[$id_item]['UC'] += [$id_uc,$UC['name']];
            } else {
                $list_capex_item[$id_item]['UC'] = [$id_uc,$UC['name']];
            }
        }            
    }
    //var_dump($list_capex_item, $UC); 

    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/others/admin_menu/manage_db_items/manage_capex_item.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3],'username'=>$user[1],'listItem'=>$list_capex_item,'catItemName'=>'capex', 'UC'=>$listUC, 'isTaken'=>$isTaken));
    
}

function manage_implem_item($twig,$is_connected,$isTaken=false){
    $user = getUser($_SESSION['username']);
    $list_implem_item = [];
    $listUC = getListUCs();  
    foreach ($listUC as $id_uc => $UC){ 
        $list_tampon = getListImplemAdvice($id_uc);
        foreach ($list_tampon as $id_item => $item){
            $list_implem_item[$id_item] = $item;
            if (array_key_exists('UC',$list_implem_item[$id_item])){
                $list_implem_item[$id_item]['UC'] += [$id_uc,$UC['name']];
            } else {
                $list_implem_item[$id_item]['UC'] = [$id_uc,$UC['name']];
            }
        }            
    }
    //var_dump($list_capex_item, $UC); 

    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/others/admin_menu/manage_db_items/manage_implem_item.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3],'username'=>$user[1],'listItem'=>$list_implem_item,'catItemName'=>'implem', 'UC'=>$listUC, 'isTaken'=>$isTaken));
    
}


function manage_opex_item($twig,$is_connected,$isTaken=false){
    $user = getUser($_SESSION['username']);
    $list_opex_item = [];
    $listUC = getListUCs();  
    foreach ($listUC as $id_uc => $UC){ 
        $list_tampon = getListOpexAdvice($id_uc);
        foreach ($list_tampon as $id_item => $item){
            $list_opex_item[$id_item] = $item;
            if (array_key_exists('UC',$list_opex_item[$id_item])){
                $list_opex_item[$id_item]['UC'] += [$id_uc,$UC['name']];
            } else {
                $list_opex_item[$id_item]['UC'] = [$id_uc,$UC['name']];
            }
        }            
    }
    //var_dump($list_capex_item, $UC); 

    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/others/admin_menu/manage_db_items/manage_opex_item.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3],'username'=>$user[1],'listItem'=>$list_opex_item,'catItemName'=>'opex', 'UC'=>$listUC, 'isTaken'=>$isTaken));
    
}

function manage_revenues_item($twig,$is_connected,$isTaken=false){
    $user = getUser($_SESSION['username']);
    $list_revenues_item = [];
    $listUC = getListUCs();   
    foreach ($listUC as $id_uc => $UC){ 
        $list_tampon = getListRevenuesAdvice($id_uc);
        foreach ($list_tampon as $id_item => $item){
            $list_revenues_item[$id_item] = $item;
            if (array_key_exists('UC',$list_revenues_item[$id_item])){
                $list_revenues_item[$id_item]['UC'] += [$id_uc,$UC['name']];
            } else {
                $list_revenues_item[$id_item]['UC'] = [$id_uc,$UC['name']];
            }
        }            
    }
    //var_dump($list_capex_item, $UC); 

    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/others/admin_menu/manage_db_items/manage_revenues_item.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3],'username'=>$user[1],'listItem'=>$list_revenues_item,'catItemName'=>'revenues', 'UC'=>$listUC, 'isTaken'=>$isTaken));
    
}


function create_item1($twig,$is_connected,$post,$catItem){
    $name = $post['name'];
    $description = $post['description'];
    $unit = $post['unit'];
    $source = $post['source'];
    $range_min = $post['range_min'];
    $range_max = $post['range_max'];
    $uc = $post['uc_id'];
    $itemInfos = [$name,$description,$unit,$source,$range_min,$range_max,$uc];
    if(!empty(getItemByNameAndCat($name,$catItem))){
        switch ($catItem) {
            case "capex":
                 manage_capex_item($twig,$is_connected,true); break;
            case "implem":
                manage_implem_item($twig,$is_connected,true); break;
            case "opex":
                manage_opex_item($twig,$is_connected,true); break;
            case "revenues":
                manage_revenues_item($twig,$is_connected,true); break;
        }

    } else {
        insertItem($itemInfos,$catItem);
        header('Location: ?A=admin&A2=manage_db&A3=manage_'.$catItem.'_item');
    }
}

function delete_item($catItem,$itemID){
    deleteItem($catItem, intval($itemID));
    header('Location: ?A=admin&A2=manage_db&A3=manage_'.$catItem.'_item');
}