<?php

require_once('model/model.php');

// --- Funding
function funding($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/funding.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}

// ---- Financing / Funding Steps

// ------------------------------------------------------- SCENARIOS -------------------------------------------------------  
function scenario($twig,$is_connected,$isTaken=false){
    $user = getUser($_SESSION['username']);
    $list_scenarios = getListScenarios($user[0]);
    //var_dump($list_scenarios);
    $list_projects = getListProjects2($user[0]);
    //var_dump($list_projects);
    echo $twig->render('/input/funding_steps/scenario.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Scenario",'scenarios'=>$list_scenarios,'projects'=>$list_projects,'isTaken'=>$isTaken)); 
}

function create_scen($twig,$is_connected,$post){
    $name = $post['name'];
    $description = isset($post['description']) ? $post['description'] : "";
    $projID = intval($post['related_project']);
    $scenInfos = [$name,$description,$projID];
    $user = getUser($_SESSION['username']);
    $userID = $user[0];
    if(!empty(getScen($userID,$name))){
        header('Location: ?A=funding&A2=scenario&isTaken=true');
    } else {
        insertScen($scenInfos);
        header('Location: ?A=funding&A2=scenario');
    }
}

function delete_scen($idScen){
    // var_dump($idScen);
    deleteScen($idScen);
    header('Location: ?A=funding&A2=scenario');
}

function work_cap_req($twig,$is_connected,$scenID=1){
    $user = getUser($_SESSION['username']);
    if($scenID!=0){
        if(getScenByID($scenID)){
            $list_scenarios = getListScenarios($user[0]);
            $list_projects = getListProjects2($user[0]);
            $scen = getScenByID($scenID);
            $parentID = $scen['id_proj'];
            $parent = array_merge(['id'=>$parentID],$list_projects[$parentID]);
            //var_dump($parent);
            $tot_capex = getTotCapexFromProj($parentID);
            $tot_implem = getTotImplemFromProj($parentID);
            $tot_op = 0;
            $values = ['capex'=>$tot_capex,'implem'=>$tot_implem,'op'=>$tot_op];
            var_dump($values);
            echo $twig->render('/input/funding_steps/work_cap_req.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Scenario",'sel_scen'=>$scen['name'],'part2'=>"Related Project",'parent'=>$parent['name'],'scenarios'=>$list_scenarios,'values'=>$values)); 
        } else {
            throw new Exception("This Project doesn't exist !");
        }
    } else {
        header('Location: ?A=funding&A2=scenario');
    }
}

function funding_sources($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/funding_steps/funding_sources.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}


function benef($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/funding_steps/benef.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}