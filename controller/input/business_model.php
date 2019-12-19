<?php

require_once('model/model.php');

// --- Business Model
function business_model($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/business_model.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}

// ---------------------------------------- PROJECT ----------------------------------------

function project_bm($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    $list_projects = getListProjects($user[0]);
    if(isset($_SESSION['projID'])){
        unset($_SESSION['projID']);
    }
    //var_dump($list_projects);
    echo $twig->render('/input/business_model_steps/project_bm.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projects'=>$list_projects)); 
}

// ---------------------------------------- PREFERENCES ----------------------------------------


function pref($twig,$is_connected,$projID=0){
    $user = getUser($_SESSION['username']);
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            $proj = getProjByID($projID,$user[0]);

            $listInvestCap = getListInvestCap();
            $listPaybackConst = getListPaybackConst();
            $listBusinessModelPref = getListBusinessModelPref();

            echo $twig->render('/input/business_model_steps/pref.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'investCap'=>$listInvestCap,'paybackConst'=>$listPaybackConst,'businessModelPref'=>$listBusinessModelPref));
            prereq_BusinessModel();
        } else {
            throw new Exception("This Project doesn't exist !");
        }
    } else {
        header('Location: ?A=business_model&A2=project');
    }
}

function pref_selected($post){
    if(isset($_SESSION['projID'])){
        $projID = $_SESSION['projID'];
        if($post){
            var_dump($projID,$post);
            //header('Location: ?A=funding&A2=funding_sources&A3=input_entities&scenID='.$scenID);
        } else {
            throw new Exception("There is no data inputed !");
        }
    } else {
        throw new Exception("There is no project selected !");
    }
}
// ---------------------------------------- CHECK PRE-REQ ----------------------------------------
function prereq_BusinessModel(){
    if(isset($_SESSION['projID'])){
        $projID = $_SESSION['projID'];
        echo "<script>prereq_businessModel(true);</script>";
    }
}
