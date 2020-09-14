<?php

require_once('model/model.php');

function supplier_schedule($twig,$is_connected, $projID){
    $user = getUser($_SESSION['username']);
    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];

    if($projID != 0) {
        $keyDates = getProjetKeyDates($projID);

        echo $twig->render('/input/input_project_common_steps/common_schedule.twig',array('key_dates'=>$keyDates, 'is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3], 'projID'=>$projID));
        prereq_ipc(0);
    } else {
        throw new Exception("Invalid project ID !");
    }
}

function use_case_schedule($twig,$is_connected, $projID, $ucID){
    $user = getUser($_SESSION['username']);
    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];

    if($projID != 0 and $ucID != 0) {
        $keyDates = getProjetKeyDates($projID);
        $projectStart = $keyDates[0]['start_date'];
        $duration = $keyDates[0]['duration'];
        $projectEnd = new DateTime($projectStart);
        $projectEnd->modify("+$duration months");
        $projectEnd = $projectEnd->format('Y-m-d');

        echo $twig->render('/input/use_case_supplier_steps/project_schedule.twig',array('project_start'=>$projectStart, 'project_end'=>$projectEnd, 'is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3], 'projID'=>$projID, 'ucID'=>$ucID));
        prereq_ipc(0);
    } else {
        throw new Exception("Please select a project and use case first.");
    }
}

function use_case_equipment($twig,$is_connected, $projID, $ucID){
    $user = getUser($_SESSION['username']);
    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    $revenues_items = [];
    
    if($ucID != 0) {
        $revenues_items = getEquipmentRevenues($projID, $ucID);
        echo $twig->render('/input/use_case_supplier_steps/equipment_revenue.twig',array('revenues_items'=>$revenues_items, 'is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3], 'projID'=>$projID, 'ucID'=>$ucID));
    } else {
        throw new Exception("Error with use case identifier");
    }
}

function insert_equiprev_data($twig, $is_connected, $projID, $ucID, $post=[]) {
    if($post) {
        createEquipmentRevenue($projID, $ucID, $_POST['name'], $_POST['cost_per_unit'], $_POST['number_of_units']);
    } else {
        throw new Exception("No data was entered.");
    }

    header('Location: /?A=input_use_case_supplier&A2=equipment_revenues&projID='. $projID .'&ucID='. $ucID);
}

function use_case_deployment($twig,$is_connected, $projID, $ucID){
    $user = getUser($_SESSION['username']);
    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/input/use_case_supplier_steps/deployment_revenue.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3], 'projID'=>$projID, 'ucID'=>$ucID));
}

function use_case_operating($twig,$is_connected, $projID, $ucID){
    $user = getUser($_SESSION['username']);
    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/input/use_case_supplier_steps/operating_revenue.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3], 'projID'=>$projID, 'ucID'=>$ucID));
}

?>