<?php
/*
This file acts as a router, that is to say that it will be in charge of the redirection to the "good" controller.
We use the variable $ _GET to retrieve information (like A, A2, ucmID, projectID, ...).
Then, we will call functions (defined in the controllers) according to the value of this information.
*/

// importing files
require __DIR__ . '/vendor/autoload.php';

foreach (glob("controller/*") as $dir){
    foreach (glob("$dir/*.php") as $filename){
        require($filename);
        //var_dump($filename);
    }
    foreach (glob("$dir/*") as $dir2){
        foreach (glob("$dir2/*.php") as $filename){
            require($filename);
            //var_dump($filename);
        }
    }
}
foreach (glob("controller/*.php") as $filename){
    require($filename);
    //var_dump($filename);
}

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/view');
$twig = new Environment($loader);

$is_connected = isConnected();

// *** WE WILL TRY TO DO ***
try{
    // ??? IN THE CASE WHERE AN ACTION (A) IS GIVEN ???
    if(isset($_GET['A'])){
        // ??? IF CONNECTED ???
        if($is_connected){
            // ---------- HOME ---------- 
            if($_GET['A']=='home'){
                home($twig,$is_connected);
            }
            // ---------- LOGOUT ---------- 
            elseif($_GET['A']=='logout'){
                logout($twig);
            }
            // ---------- ADMIN ---------- 
            elseif($_GET['A']=='admin'){
                if(isset($_GET['A2'])){
                    if($_GET['A2']=='manage_db'){
                        manage_db($twig,$is_connected); 
                    } elseif($_GET['A2']=='manage_users'){
                        manage_users($twig,$is_connected); 
                    } elseif($_GET['A2']=='create_user'){
                        create_user($twig,$is_connected,$_POST);
                    } else {
                        header('Location: ?A=admin');
                    }
                } else {
                    admin($twig,$is_connected);
                }
            }
            // ---------- PROFILE ---------- 
            elseif($_GET['A']=='profile'){
                if(isset($_GET['A2'])){
                    if($_GET['A2']=='modify_infos'){
                        modify_infos($twig,$is_connected);
                    } elseif($_GET['A2']=='save_infos'){
                        save_infos($twig,$is_connected,$_POST);
                    } else {
                        header('Location: ?A=profile');
                    }
                } else {
                    profile($twig,$is_connected);
                }
            }
            // ---------- PROJECT DEVELOPEMENT ---------- 
            elseif($_GET['A']=='project_dev'){
                project_dev($twig,$is_connected);    
            }
            // ---------- PROJECT DESIGN ---------- 
            elseif($_GET['A']=='project_design'){
                /* var_dump($_POST); */
                // ??? IN THE CASE WHERE AN ACTION2 (A2) IS GIVEN ???
                if(isset($_GET['A2'])){
                    // --- USE CASES MENU ---
                    if($_GET['A2']=="ucm"){
                        ucm($twig,$is_connected);
                    }
                    elseif($_GET['A2']=="create_ucm"){
                        create_ucm($twig,$is_connected,$_POST);
                    }
                    elseif($_GET['A2']=="delete_ucm"){
                        if(isset($_GET['id'])){
                            delete_ucm($twig,$is_connected,$_GET['id']);
                        }
                        else {
                            header('Location: ?A=project_design&A2=ucm');
                        }
                    }
                    // --- SELECTED USE CASES MENU ---
                    elseif($_GET['A2']=="ucm_selected"){
                        if(isset($_POST['radio_ucm'])){
                            $ucmID = intval($_POST['radio_ucm']);
                            $_SESSION['ucmID']=$ucmID;
                            //var_dump($ucmID);
                            header('Location: ?A=project_design&A2=measures&ucmID='.$ucmID);
                        }
                    }
                    // --- MEASURES ---
                    elseif($_GET['A2']=="measures"){
                        if(isset($_GET['ucmID'])){
                            if($_GET['ucmID']!=0){
                                measures($twig,$is_connected,$_GET['ucmID']);
                            }
                            else {
                                header('Location: ?A=project_design&A2=measures');
                            }
                        }
                        else {
                            measures($twig,$is_connected);
                        }
                    }
                    // --- SELECTED MEASURES ---
                    elseif ($_GET['A2']=="measures_selected") {
                        $list_measID = [];
                        foreach ($_POST as $key => $value) {
                            if(isset($key)){
                                $measID = intval($key);
                                //var_dump($measID);
                                array_push($list_measID,$measID);
                            }
                        }
                        //var_dump($list_measID);
                        measures_selected($list_measID);
                    }
                    // --- CRITERIA ---
                    elseif($_GET['A2']=="criteria"){
                        if(isset($_GET['ucmID'])){
                            if($_GET['ucmID']!=0){
                                criteria($twig,$is_connected,$_GET['ucmID']);
                            }
                            else {
                                header('Location: ?A=project_design&A2=criteria');
                            }
                        }
                        else {
                            criteria($twig,$is_connected);
                        }
                    }
                    // --- SELECTED CRITERIA ---
                    elseif ($_GET['A2']=="criteria_selected") {
                        $list_critID = [];
                        foreach ($_POST as $key => $value) {
                            if(isset($key)){
                                $critID = intval($key);
                                //var_dump($list_critID);
                                array_push($list_critID,$critID);
                            }
                        }
                        var_dump("list_critID :");
                        var_dump($list_critID);
                        criteria_selected($list_critID);
                    }
                    // --- GEOGRAPHY ---
                    elseif($_GET['A2']=="geography"){
                        if(isset($_GET['ucmID'])){
                            if($_GET['ucmID']!=0){
                                geography($twig,$is_connected,$_GET['ucmID']);
                            }
                            else {
                                header('Location: ?A=project_design&A2=geography');
                            }
                        }
                        else {
                            geography($twig,$is_connected);
                        }
                    }
                    // --- SELECTED GEOGRAPHY ---
                    elseif ($_GET['A2']=="geo_selected") {
                        $list_idDLT = [];
                        foreach ($_POST as $key => $value) {
                            if(isset($key)){
                                $idDLT = intval($key);
                                //var_dump($list_idDLT);
                                array_push($list_idDLT,$idDLT);
                            }
                        }
                        var_dump($list_idDLT);
                        geo_selected($list_idDLT);
                    }
                    // --- USE CASES ---
                    elseif($_GET['A2']=="use_case"){
                        if(isset($_GET['ucmID'])){
                            if($_GET['ucmID']!=0){
                                if(isset($_GET['A3'])){
                                    if($_GET['A3']=="uc_selected"){
                                        $list_idUC = [];
                                        foreach ($_POST as $key => $value) {
                                            if(isset($key)){
                                                $idUC = intval($key);
                                                //var_dump($list_idUC);
                                                array_push($list_idUC,$idUC);
                                            }
                                        }
                                        //var_dump($list_idUC);
                                        uc_selected($twig,$is_connected,$list_idUC);
                                    }
                                    else {
                                        header('Location: ?A=project_design&A2=use_case&ucmID='+$_GET['ucmID']);
                                    }
                                }
                                else {
                                    use_case($twig,$is_connected,$_GET['ucmID']);
                                }
                            }
                            else {
                                header('Location: ?A=project_design&A2=use_case');
                            }
                        }
                        else {
                            use_case($twig,$is_connected);
                        }
                    }
                    // --- RATING ---
                    elseif($_GET['A2']=="rating"){
                        if(isset($_GET['ucmID'])){
                            if($_GET['ucmID']!=0){
                                rating($twig,$is_connected,$_GET['ucmID']);
                            }
                            else {
                                header('Location: ?A=project_design&A2=rating');
                            }
                        }
                        else {
                            rating($twig,$is_connected);
                        }
                    }
                    // --- SELECTED RATING ---
                    elseif ($_GET['A2']=="rates_inputed") {
                        rates_inputed($_POST);
                    }
                    // --- SCORING ---
                    elseif($_GET['A2']=="scoring"){
                        if(isset($_GET['ucmID'])){
                            if($_GET['ucmID']!=0){
                                scoring($twig,$is_connected,$_GET['ucmID']);
                            }
                            else {
                                header('Location: ?A=project_design&A2=scoring');
                            }
                        }
                        else {
                            scoring($twig,$is_connected);
                        }
                    }                    
                    // --- GLOBAL SCORE ---
                    elseif($_GET['A2']=="global_score"){
                        if(isset($_GET['ucmID'])){
                            if($_GET['ucmID']!=0){
                                global_score($twig,$is_connected,$_GET['ucmID'],$_POST);
                            }
                            else {
                                header('Location: ?A=project_design&A2=global_score');
                            }
                        }
                        else {
                            global_score($twig,$is_connected);
                        }
                    }
                    // --- IN OTHER CASES ---
                    else {
                        header('Location: ?A=project_design');
                    }
                // --- IN OTHER CASES ---
                } else {
                    project_design($twig,$is_connected);
                } 
            }
            // ---------- PROJECT SCOPING ----------
            elseif($_GET['A']=='project_scoping'){
                if(isset($_GET['A2'])){
                    // --- PROJECT ---
                    if($_GET['A2']=="project"){
                        project($twig,$is_connected);
                    }
                    elseif($_GET['A2']=="create_proj"){
                        create_proj($twig,$is_connected,$_POST);
                    }
                    elseif($_GET['A2']=="delete_proj"){
                        if(isset($_GET['id'])){
                            delete_proj($_GET['id']);
                        }
                        else {
                            header('Location: ?A=project_scoping&A2=project');
                        }
                    }
                    // --- SELECTED PROJECT ---
                    elseif($_GET['A2']=="proj_selected"){
                        if(isset($_POST['radio_proj'])){
                            $projID = intval($_POST['radio_proj']);
                            $_SESSION['projID']=$projID;
                            var_dump($projID);
                            header('Location: ?A=project_scoping&A2=scope&projID='.$projID);
                        }
                    }
                    elseif($_GET['A2']=="scope"){
                        if(isset($_GET['projID'])){
                            if($_GET['projID']!=0){
                                scope($twig,$is_connected,$_GET['projID']);
                            }
                            else {
                                header('Location: ?A=project_scoping&A2=scope');
                            }
                        }
                        else {
                            scope($twig,$is_connected);
                        }
                    } elseif($_GET['A2']=="perimeter"){
                        perimeter($twig,$is_connected);
                    } elseif($_GET['A2']=="size"){
                        size($twig,$is_connected);
                    } elseif($_GET['A2']=="volumes"){
                        volumes($twig,$is_connected);
                    } elseif($_GET['A2']=="schedule"){
                        schedule($twig,$is_connected);
                    } elseif($_GET['A2']=="discount_rate"){
                        discount_rate($twig,$is_connected);
                    } else {
                        header('Location: ?A='.$_GET['A']);
                    }
                } else {
                    project_scoping($twig,$is_connected);
                }        
            
            }
            // ---------- COST BENEFITS ----------
            elseif($_GET['A']=='cost_benefits'){
                if(isset($_GET['A2'])){
                    if($_GET['A2']=="use_case_cb"){
                        use_case_cb($twig,$is_connected);
                    } elseif($_GET['A2']=="project"){
                        project_cb($twig,$is_connected);
                    } elseif($_GET['A2']=="capex"){
                        capex($twig,$is_connected);
                    } elseif($_GET['A2']=="implem"){
                        implem($twig,$is_connected);
                    } elseif($_GET['A2']=="opex"){
                        opex($twig,$is_connected);
                    } elseif($_GET['A2']=="revenues"){
                        revenues($twig,$is_connected);
                    } elseif($_GET['A2']=="cashreleasing"){
                        cashreleasing($twig,$is_connected);
                    } elseif($_GET['A2']=="widercash"){
                        widercash($twig,$is_connected);
                    } elseif($_GET['A2']=="noncash"){
                        noncash($twig,$is_connected);
                    } elseif($_GET['A2']=="risks"){
                        risks($twig,$is_connected);
                    } else {
                        header('Location: ?A='.$_GET['A']);
                    }
                } else {  
                    cost_benefits($twig,$is_connected);
                }        
            }
            // ---------- FINANCING ----------
            elseif($_GET['A']=='financing'){     
                financing($twig,$is_connected);      
            }
            // ---------- BUSINESS MODEL ----------
            elseif($_GET['A']=='business_model'){
                business_model($twig,$is_connected);           
            }
            // ---------- FUNDING ----------
            elseif($_GET['A']=='funding'){
                if(isset($_GET['A2'])){
                    if($_GET['A2']=="scenario"){
                        scenario($twig,$is_connected);
                    } elseif($_GET['A2']=="input"){
                        input($twig,$is_connected);
                    } elseif($_GET['A2']=="output"){
                        output($twig,$is_connected);
                    } elseif($_GET['A2']=="benef"){
                        benef($twig,$is_connected);
                    } elseif($_GET['A2']=="scen_comp"){
                        scen_comp($twig,$is_connected);
                    } else {
                        header('Location: ?A='.$_GET['A']);
                    }
                } else {  
                    funding($twig,$is_connected); 
                }            
            }
            // ---------- DASHBOARDS ----------
            elseif($_GET['A']=='dashboards'){
                 if(isset($_GET['A2'])){
                    if($_GET['A2']=="cost_benefits_out"){
                        cost_benefits_out($twig,$is_connected);
                    } elseif($_GET['A2']=="budget"){
                        budget($twig,$is_connected);
                    } elseif($_GET['A2']=="financing"){
                        financing_out($twig,$is_connected);
                    } elseif($_GET['A2']=="bankability"){
                        bankability($twig,$is_connected);
                    } else {
                        header('Location: ?A='.$_GET['A']);
                    }
                } else { 
                    dashboards($twig,$is_connected);
                }              
            }
            // ---------- SCENARIOS ----------
            elseif($_GET['A']=='scenarios'){
                scenarios($twig,$is_connected);        
            }
            // ---------- IN OTHER CASES ----------
            else {
                header('Location: ?A=home');
            }                  

        }
        // ??? IF NOT CONNECTED ???
        else {
            if($_GET['A']=='login'){
                if(isset($_GET['A2'])){
                    if($_GET['A2']=='form'){
                        connexion($twig,$_POST);
                    } else {
                        header('Location: ?A=login');
                    }
                } else {
                    login($twig);
                }
            } else {
                header('Location: ?A=login');
            }
        }
    }
    // ??? IN OTHER CASES
    else {
        // ??? IF CONNECTED ???
        if($is_connected){
            header('Location: ?A=home');
        }
        // ??? IF NOT CONNECTED ???
        else {
            header('Location: ?A=login');
        }
    }

}
// *** IF THERE IS AN ERROR (EXCEPTION), IT IS CAPTURED TO DISPLAY ON A SPECIAL PAGE ***
catch(Exception $e) {
    $errorMessage = $e->getMessage();
    echo $twig->render('/others/error.twig',array('error'=>$errorMessage)); 
}