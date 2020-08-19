<?php
namespace general;
use general;

function project($twig,$is_connected, $nextPage, $sideBarName,$deleteMode=true, $scopeMode=true, $veriScopefMode=false, $createMode=true, $commonPage='/others/general_common.twig'){
    $user = getUser($_SESSION['username']);
    $list_projects = getListProjects($user[0]);
    if(isset($_SESSION['projID'])){
        unset($_SESSION['projID']);
    }
    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];

    
    echo $twig->render('/others/general_steps/project.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projects'=>$list_projects, 'nextPage'=>$nextPage, 'sideBarName'=>$sideBarName, 'commonPage'=>$commonPage, 'deleteMode'=>$deleteMode, 'scopeMode'=>$scopeMode, 'veriScopefMode'=>$veriScopefMode, 'createMode'=>$createMode, 'isTaken'=>(isset($_GET['isTaken']) && $_GET['isTaken']))); 
}



function commonPage($twig,$is_connected, $nextPage, $sideBarName, $lorem='Lorem ipsum ...', $title='', $scripts=''){
    $user = getUser($_SESSION['username']);
    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/others/general_common.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3], 'nextPage'=>$nextPage, 'sideBarName'=>$sideBarName, 'scripts'=>$scripts, 'lorem'=>$lorem, 'centralTitle'=>$title));
}
