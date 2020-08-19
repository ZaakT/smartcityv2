<?php
function dashboards_summary($twig,$is_connected, $projID){
    $user = getUser($_SESSION['username']);
    $list_projects = getListProjects($user[0]);

    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            $proj = getProjByID($projID,$user[0]);

            
            echo $twig->render('/output/customer_dashboards_steps/summary.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'projects'=>$list_projects)); 

        }
    }
}

function dashboards_project_details($twig,$is_connected, $projID){
    $user = getUser($_SESSION['username']);
    $list_projects = getListProjects($user[0]);

    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            $proj = getProjByID($projID,$user[0]);

            
            echo $twig->render('/output/customer_dashboards_steps/project_details.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'projects'=>$list_projects)); 

        }
    }
}

function dashboards_use_case_details($twig,$is_connected, $projID){
    $user = getUser($_SESSION['username']);
    $list_projects = getListProjects($user[0]);

    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            $proj = getProjByID($projID,$user[0]);

            
            echo $twig->render('/output/customer_dashboards_steps/use_case_details.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'projects'=>$list_projects)); 

        }
    }
}

function dashboards_non_monetizable($twig,$is_connected, $projID){
    $user = getUser($_SESSION['username']);
    $list_projects = getListProjects($user[0]);

    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            $proj = getProjByID($projID,$user[0]);

            
            echo $twig->render('/output/customer_dashboards_steps/non_monetizable.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'projects'=>$list_projects)); 

        }
    }
}

function dashboards_qualitative($twig,$is_connected, $projID){
    $user = getUser($_SESSION['username']);
    $list_projects = getListProjects($user[0]);

    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            $proj = getProjByID($projID,$user[0]);

            
            echo $twig->render('/output/customer_dashboards_steps/qualitative.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'projects'=>$list_projects)); 

        }
    }
}

