<?php

require_once('model/model.php');


function dashboards($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/output/dashboards.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}


// ---------------------------------------- PROJECT ----------------------------------------

function project_out($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    $list_projects = getListProjects($user[0]);
    if(isset($_SESSION['projID'])){
        unset($_SESSION['projID']);
    }
    //var_dump($list_projects);
    echo $twig->render('/output/dashboards_items/project_out.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projects'=>$list_projects)); 
}

function cost_benefits_uc($twig,$is_connected,$projID=0){
    $user = getUser($_SESSION['username']);
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            $proj = getProjByID($projID,$user[0]);
            $measures = getListMeasures();
            $ucs = getListUCs();
            $scope = getListSelScope($projID);
            $list_zones = getListZones();
            $repart_zones = sort_zones($list_zones);
            //var_dump($list_zones);
            //var_dump($repart_zones);
            $listSelZones = getListSelZones($projID);
            //var_dump($list_ucs);
            echo $twig->render('/output/dashboards_items/cost_benefits_uc.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'measures'=>$measures,'ucs'=>$ucs,'scope'=>$scope,'zones'=>$repart_zones,'list_sel'=>$listSelZones));
            //prereq_CostBenefits();
        } else {
            throw new Exception("This Project doesn't exist !");
        }
    } else {
        header('Location: ?A=dashboards&A2=project_out');
    }
}

function cost_benefits_all($twig,$is_connected,$projID=0){
    $user = getUser($_SESSION['username']);
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            $proj = getProjByID($projID,$user[0]);
            //var_dump($list_ucs);
            echo $twig->render('/output/dashboards_items/cost_benefits_all.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1]));
            //prereq_CostBenefits();
        } else {
            throw new Exception("This Project doesn't exist !");
        }
    } else {
        header('Location: ?A=dashboards&A2=project_out');
    }
}