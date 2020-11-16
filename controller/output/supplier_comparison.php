<?php

function projectComparison($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    $list_proj_select =isset( $_SESSION["listProjComp"]) ? $_SESSION["listProjComp"] : [];
    $sideBarName = "supplier_comparison";
    $list_projects = getListProjects($user[0]);
    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    foreach ($list_projects as $key => $proj) {
        $list_projects[$key][array_key_last($list_projects[$key])+1]= !empty(getProjetKeyDates($list_projects[$key]['id']));
        //$list_projects[$key][array_key_last($list_projects[$key])+1]= count(getConfirmedUseCases($user[0],$sessionProj))>0; // has a uc confirmed
        
    }

    echo $twig->render('/output/supplier_comparison_items/projects_selection.twig',array('is_connected'=>$is_connected,'devises'=>$devises, "list_proj_select"=>$list_proj_select,
    'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'projects'=>$list_projects, 'sideBarName'=>$sideBarName)); 

}

function comp_proj_selected($twig,$is_connected, $post){
    $_SESSION['listProjComp'] = array_keys($post);
    var_dump('Location: ?A='.$_GET['A'].'&A2=comparison');
    header('Location: ?A='.$_GET['A'].'&A2=comparison');


}

function supplier_comparison($twig,$is_connected){

    $user = getUser($_SESSION['username']);
    $list_proj_select =isset( $_SESSION["listProjComp"]) ? $_SESSION["listProjComp"] : [];
    $sideBarName = "supplier_comparison";
    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];

    echo $twig->render('/output/supplier_comparison_items/comparison.twig',array('is_connected'=>$is_connected,'devises'=>$devises, "list_proj_select"=>$list_proj_select,
    'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1], 'sideBarName'=>$sideBarName)); 
}