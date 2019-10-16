<?php

require_once('model/model.php');

// -- Project Design
function project_design($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/project_design.twig',array('is_connected'=>$is_connected,'username'=>$user[1],'is_admin'=>$user[3])); 
}

// --- Project Design Steps
function ucm($twig,$is_connected,$isTaken=false){
    $user = getUser($_SESSION['username']);
    $list_ucms = getListUCMS($user[0]);
    //var_dump($list_ucms);
    echo $twig->render('/input/project_design_steps/ucm.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'ucms'=>$list_ucms,'isTaken'=>$isTaken,'part'=>'Use Cases Menu','username'=>$user[1])); 
}

function create_ucm($twig,$is_connected,$post){
    $name = $post['name'];
    $description = isset($post['description']) ? $post['description'] : "";
    $user = getUser($_SESSION['username']);
    $idUser = $user[0];
    $ucmInfos = [$name,$description,$idUser];
    if(!empty(getUCM($idUser,$name))){
        ucm($twig,$is_connected,true);
    } else {
        insertUCM($ucmInfos);
        header('Location: ?A=project_design&A2=ucm');
    }
}

function delete_ucm($twig,$is_connected,$idUCM){
    // var_dump($idUCM);
    deleteUCM($idUCM);
    header('Location: ?A=project_design&A2=ucm');
}

// measures
function measures($twig,$is_connected,$ucmID=0){
    $user = getUser($_SESSION['username']);
    if($ucmID!=0){
        if(getUCMByID($ucmID,$user[0])){
            $ucm = getUCMByID($ucmID,$user[0]);
            $list_measures = getListMeasures($ucmID);
            echo $twig->render('/input/project_design_steps/measures.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu',"selected"=>$ucm[1],'username'=>$user[1],'measures'=>$list_measures));
        } else {
            header('Location: ?A=project_design&A2=measures');
        }
    } else {
        echo $twig->render('/input/project_design_steps/measures.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu','username'=>$user[1]));
    }
}



// criteria
function criteria($twig,$is_connected,$ucmID=0){
    $user = getUser($_SESSION['username']);
    if($ucmID!=0){
        if(getUCMByID($ucmID,$user[0])){
            $ucm = getUCMByID($ucmID,$user[0]);
            echo $twig->render('/input/project_design_steps/criteria.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu',"selected"=>$ucm[1],'username'=>$user[1]));
        } else {
            header('Location: ?A=project_design&A2=criteria');
        }
    } else {
        echo $twig->render('/input/project_design_steps/criteria.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu','username'=>$user[1]));
    }
}

function geography($twig,$is_connected,$ucmID=0){
    $user = getUser($_SESSION['username']);
    if($ucmID!=0){
        if(getUCMByID($ucmID,$user[0])){
            $ucm = getUCMByID($ucmID,$user[0]);
            echo $twig->render('/input/project_design_steps/geography.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu',"selected"=>$ucm[1],'username'=>$user[1]));
        } else {
            header('Location: ?A=project_design&A2=geography');
        }
    } else {
        echo $twig->render('/input/project_design_steps/geography.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu','username'=>$user[1]));
    }
}

function use_case($twig,$is_connected,$ucmID=0){
    $user = getUser($_SESSION['username']);
    if($ucmID!=0){
        if(getUCMByID($ucmID,$user[0])){
            $ucm = getUCMByID($ucmID,$user[0]);
            echo $twig->render('/input/project_design_steps/use_case.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu',"selected"=>$ucm[1],'username'=>$user[1]));
        } else {
            header('Location: ?A=project_design&A2=use_case');
        }
    } else {
        echo $twig->render('/input/project_design_steps/use_case.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu','username'=>$user[1]));
    }
}

function rating($twig,$is_connected,$ucmID=0){
    $user = getUser($_SESSION['username']);
    if($ucmID!=0){
        if(getUCMByID($ucmID,$user[0])){
            $ucm = getUCMByID($ucmID,$user[0]);
            echo $twig->render('/input/project_design_steps/rating.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu',"selected"=>$ucm[1],'username'=>$user[1]));
        } else {
            header('Location: ?A=project_design&A2=rating');
        }
    } else {
        echo $twig->render('/input/project_design_steps/rating.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu','username'=>$user[1]));
    }
}

function scoring($twig,$is_connected,$ucmID=0){
    $user = getUser($_SESSION['username']);
    if($ucmID!=0){
        if(getUCMByID($ucmID,$user[0])){
            $ucm = getUCMByID($ucmID,$user[0]);
            echo $twig->render('/input/project_design_steps/scoring.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu',"selected"=>$ucm[1],'username'=>$user[1]));
        } else {
            header('Location: ?A=project_design&A2=scoring');
        }
    } else {
        echo $twig->render('/input/project_design_steps/scoring.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu','username'=>$user[1]));
    }
}

function global_score($twig,$is_connected,$ucmID=0){
    $user = getUser($_SESSION['username']);
    if($ucmID!=0){
        if(getUCMByID($ucmID,$user[0])){
            $ucm = getUCMByID($ucmID,$user[0]);
            echo $twig->render('/input/project_design_steps/global_score.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu',"selected"=>$ucm[1],'username'=>$user[1]));
        } else {
            header('Location: ?A=project_design&A2=global_score');
        }
    } else {
        echo $twig->render('/input/project_design_steps/global_score.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu','username'=>$user[1]));
    }
}
