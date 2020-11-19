<?php

require_once('model/model.php');

function dropDays($list){
    $newList = [];
    if($list){
        foreach ($list as $key => $value) {
            $exp = explode('-', $value);
            $newList[$key]=count($exp)>2 ? implode('-', [$exp[0], $exp[1]]) : $value;
        }
    }
    return $newList;
}

function supplier_schedule($twig,$is_connected, $projID){
    $user = getUser($_SESSION['username']);
    $proj = getProjByID($projID,$user[0]);
    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];

    if($projID != 0) {
        $keyDates = getProjetKeyDates($projID);
        $keyDates = isset($keyDates[0]) ? dropDays($keyDates[0]) : $keyDates;
        echo $twig->render('/input/input_project_common_steps/common_schedule.twig',array('key_dates'=>$keyDates, 'is_connected'=>$is_connected,
        'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3], 'projID'=>$projID,'part'=>"Project","selected"=>$proj[1], 'username'=>$user[1]));
        prereq_ipc(0);
    } else {
        throw new Exception("Invalid project ID !");
    }
}

function save_supplier_schedule($twig,$is_connected, $post){
    $keyDates = getProjetKeyDates($_SESSION['projID']);
    if(empty($keyDates)) {
        insertProjetKeyDates($_SESSION['projID'], $_POST['pstart']."-01", $_POST['pduration'], $_POST['dstart']."-01", $_POST['dduration']);
    } else {
        alterProjetKeyDates($_SESSION['projID'], $_POST['pstart']."-01", $_POST['pduration'], $_POST['dstart']."-01", $_POST['dduration']);
    }

    header('Location: ?A=input_project_common_supplier&A2=equipment_revenues&projID='.$_SESSION['projID']);

}

function use_case_schedule($twig,$is_connected, $projID, $ucID){
    $user = getUser($_SESSION['username']);
    $proj = getProjByID($projID,$user[0]);
    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];

    if($projID != 0 and $ucID != 0) {
        $uc = getUCByID($ucID);
        $keyDates = getProjetKeyDates($projID);
        $projectStart = $keyDates[0]['start_date'];
        $duration = $keyDates[0]['duration'];
        $projectEnd = new DateTime($projectStart);
        $projectEnd->modify("+$duration months");
        $projectEnd = $projectEnd->format('Y-m');
        $projectStart = new DateTime($projectStart);
        $projectStart = $projectStart->format('Y-m');

        $project_dep_start = $keyDates[0]['deploy_start_date'];
        $duration = $keyDates[0]['deploy_duration'];
        $project_dep_end = new DateTime($project_dep_start);
        $project_dep_end->modify("+$duration months");
        $project_dep_end = $project_dep_end->format('Y-m-d');
        $scheduleDates = dropDays(getProjetSchedule($projID, $ucID));
        echo $twig->render('/input/use_case_supplier_steps/project_schedule.twig',array('schedule_dates'=>$scheduleDates, 'project_start'=>$projectStart, 'project_end'=>$projectEnd, "project_dep_end"=>$project_dep_end, "project_dep_start"=>$project_dep_start,
        'is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3], 'projID'=>$projID, 'ucID'=>$ucID,'part'=>"Project","selected"=>$proj[1],
        'username'=>$user[1], 'part2'=>"Use Case",'selected2'=>$uc[1]));
        prereq_ipc(0);
    } else {
        throw new Exception("Please select a project and use case first.");
    }
}

function save_use_case_schedule($twig,$is_connected, $post){
    $keyDates = getProjetSchedule($_SESSION['projID'], $_SESSION['ucID']);
    if(empty($keyDates)) {
        insertProjectSchedule($_SESSION['projID'], $_SESSION['ucID'], $post['deploy_start']."-01", $post['deployment_duration']."-01", $post['uc_end']."-01", $post['pricing_start']."-01", $post['poc_duration']."-01");
    } else {
        alterProjectSchedule($_SESSION['projID'], $_SESSION['ucID'], $post['deploy_start']."-01", $post['deployment_duration']."-01", $post['uc_end']."-01", $post['pricing_start']."-01", $post['poc_duration']."-01");
    }

    header('Location: ?A=input_use_case_supplier&A2=equipment_revenues&projID='.$_SESSION['projID'].'&ucID='.$_SESSION['ucID']);
}
