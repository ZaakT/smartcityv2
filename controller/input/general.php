<?php
namespace general;
use general;

function project($twig,$is_connected, $nextPage, $sideBarName){
    $user = getUser($_SESSION['username']);
    $list_projects = getListProjects($user[0]);
    if(isset($_SESSION['projID'])){
        unset($_SESSION['projID']);
    }
    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];

    
    echo $twig->render('/others/general_steps/project.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projects'=>$list_projects, 'nextPage'=>$nextPage, 'sideBarName'=>$sideBarName,  'isTaken'=>(isset($_GET['isTaken']) && $_GET['isTaken']))); 
}



function commonPage($twig,$is_connected, $nextPage, $sideBarName){
    $user = getUser($_SESSION['username']);
    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/others/general_common.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3], 'nextPage'=>$nextPage, 'sideBarName'=>$sideBarName));
}

function use_case_selection($twig,$is_connected, $nextPage, $sideBarName, $projID=0){
    $user = getUser($_SESSION['username']);
    if($projID!=0){
        if(isset($_SESSION['ucID'])){
            unset($_SESSION['ucID']);
        }
        if(getProjByID($projID,$user[0])){
            $proj = getProjByID($projID,$user[0]);
            $list_measures = getListMeasures();
            $list_ucs = getListUCs();
            $selScope = getListSelScope($projID);
            //var_dump($list_ucs);
            $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
            
            echo $twig->render('/others/general_steps/use_case_selection.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'selScope'=>$selScope,'ucs'=>$list_ucs,'measures'=>$list_measures, 'nextPage'=>$nextPage, 'sideBarName'=>$sideBarName));
            if($type=='input_project_common'){
                prereq_ipc(0);
            }
        } else {
            header('Location: ?A='.$sideBarName);
        }
    } else {
        $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
        
        echo $twig->render('/others/general_steps/use_case_selection.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1], 'nextPage'=>$nextPage, 'sideBarName'=>$sideBarName));
    }
} 
