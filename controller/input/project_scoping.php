<?php

require_once('model/model.php');

// -- Project Scoping
function project_scoping($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/project_scoping.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3])); 
}

// --- Project Scoping Steps

// ---------------------------------------- PROJECT ----------------------------------------
function project($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    $list_projects = getListProjects($user[0]);
    //var_dump($list_projects);
    echo $twig->render('/input/project_scoping_steps/project.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'username'=>$user[1],'part'=>"Project",'projects'=>$list_projects)); 
}

function create_proj($twig,$is_connected,$post){
    $name = $post['name'];
    $description = isset($post['description']) ? $post['description'] : "";
    $user = getUser($_SESSION['username']);
    $idUser = $user[0];
    $projInfos = [$name,$description,$idUser];
    if(!empty(getProj($idUser,$name))){
        project($twig,$is_connected,true);
    } else {
        insertProj($projInfos);
        header('Location: ?A=project_scoping&A2=project');
    }
}

function delete_proj($idProj){
    // var_dump($idProj);
    deleteProj($idProj);
    header('Location: ?A=project_scoping&A2=project');
}

// ---------------------------------------- SCOPE ----------------------------------------

function scope($twig,$is_connected,$projID=0){
    $user = getUser($_SESSION['username']);
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            $proj = getProjByID($projID,$user[0]);
            $list_measures = getListMeasures();
            $list_ucs = getListUCs();
            echo $twig->render('/input/project_scoping_steps/scope.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'projID'=>$projID,'part'=>'Project',"selected"=>$proj[1],'username'=>$user[1],'measures'=>$list_measures,'ucs'=>$list_ucs)); 
            //prereq_ProjectScoping();
        } else {
            header('Location: ?A=project_scoping&A2=scope');
        }
    } else {
        echo $twig->render('/input/project_scoping_steps/scope.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'projID'=>$projID,'part'=>'Project','username'=>$user[1]));
        //prereq_ProjectScoping();
    }
}

function perimeter($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/project_scoping_steps/perimeter.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3])); 
}

function size($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/project_scoping_steps/size.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3])); 
}

function volumes($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/project_scoping_steps/volumes.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3])); 
}

function schedule($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/project_scoping_steps/schedule.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3])); 
}

function discount_rate($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/project_scoping_steps/discount_rate.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3])); 
}