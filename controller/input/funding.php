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










function work_cap_req($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/funding_steps/work_cap_req.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}

function funding_sources($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/funding_steps/funding_sources.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}


function benef($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/funding_steps/benef.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}