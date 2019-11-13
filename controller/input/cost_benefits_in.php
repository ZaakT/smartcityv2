
<?php

require_once('model/model.php');

// -- Cost Benefits
function cost_benefits($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/cost_benefits_in.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}


// --- Cost Benefits Steps

// ---------------------------------------- PROJECT ----------------------------------------

function project_cb($twig,$is_connected,$projID=0){
    $user = getUser($_SESSION['username']);
    $list_projects = getListProjects($user[0]);
    //var_dump($list_projects);
    echo $twig->render('/input/cost_benefits_steps/project.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projects'=>$list_projects)); 
}


// ---------------------------------------- USE CASE ----------------------------------------

function use_case_cb($twig,$is_connected,$projID=0){
    $user = getUser($_SESSION['username']);
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            $proj = getProjByID($projID,$user[0]);
            $list_measures = getListMeasures();
            $list_ucs = getListUCs();
            $selScope = getListSelScope($projID);
            //var_dump($list_ucs);
            echo $twig->render('/input/cost_benefits_steps/use_case.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'selScope'=>$selScope,'ucs'=>$list_ucs,'measures'=>$list_measures));
        } else {
            header('Location: ?A=cost_benefits&A2=use_case_cb');
        }
    } else {
        echo $twig->render('/input/cost_benefits_steps/use_case.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'username'=>$user[1]));
    }
}


// ---------------------------------------- CAPEX ----------------------------------------

function capex($twig,$is_connected,$projID=0,$ucID=0){
    $user = getUser($_SESSION['username']);
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            if($ucID!=0){
                if(getUCByID($ucID)){
                    $proj = getProjByID($projID,$user[0]);
                    $uc = getUCByID($ucID);
                    echo $twig->render('/input/cost_benefits_steps/capex.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project","selected"=>$proj[1],'part2'=>"Use Case",'selected2'=>$uc[1],'projID'=>$projID,'ucID'=>$ucID));
                } else {
                    throw new Exception("This Use Case doesn't exist !");
                }
            } else {
                header('Location: ?A=cost_benefits&A2=use_case_cb');
            }
        } else {
            throw new Exception("This Project doesn't exist !");
        }
    } else {
        header('Location: ?A=cost_benefits&A2=use_case_cb');
    }
}

function implem($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/cost_benefits_steps/implem.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}

function opex($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/cost_benefits_steps/opex.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}

function revenues($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/cost_benefits_steps/revenues.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}

function cashreleasing($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/cost_benefits_steps/cashreleasing.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}

function widercash($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/cost_benefits_steps/widercash.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}

function noncash($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/cost_benefits_steps/noncash.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}

function risks($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/cost_benefits_steps/risks.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}