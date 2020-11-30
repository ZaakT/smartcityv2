<?php
session_start();
/*
This file acts as a router, that is to say that it will be in charge of the redirection to the "good" controller.
We use the variable $ _GET to retrieve information (like A, A2, ucmID, projectID, ...).
Then, we will call functions (defined in the controllers) according to the value of this information.
*/
ini_set("xdebug.var_display_max_children", '-1');
ini_set("xdebug.var_display_max_data", '-1');
ini_set("xdebug.var_display_max_depth", '-1');
// importing files
require __DIR__ . '/vendor/autoload.php';
function prereq_navbar($side){
    echo "<script>prereq_navbar('$side');</script>";
}
foreach (glob("controller/*") as $dir){
    foreach (glob("$dir/*.php") as $filename){
        require($filename);
    }
    foreach (glob("$dir/*") as $dir2){
        foreach (glob("$dir2/*.php") as $filename){
            require($filename);
        }
    }
}
foreach (glob("controller/*.php") as $filename){
    require($filename);
}

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/view');
$twig = new Environment($loader, [
    'debug' => true
]);
$twig->addExtension(new \Twig\Extension\DebugExtension());
$twig->addGlobal('userRole', getUserRole());
$twig->addGlobal('isDev', isDev());
$twig->addGlobal('isSup', isSup());
$twig->addGlobal('companyName', companyName());
$twig->addGlobal('divisionName', divisionName());
$twig->addGlobal('language', getLanguage());
$twig->addGlobal('dicTraductions', $GLOBALS['dicTrad']);
$twig->addGlobal('GlobalProjID', getProjID());
$twig->addGlobal('getNbConfirmedUC', getNbConfirmedUC());getLogoName();
$twig->addGlobal('logoName', getLogoName());
$twig->addGlobal('nbProjectHidden', getNbProjHidden());
$twig->addGlobal('hasPOSchedule', !empty(getProjetKeyDates(getProjID())));


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
                        if(isset($_GET['A3'])){
                            if($_GET['A3']=='manage_users'){
                                manage_users($twig,$is_connected); 
                            } elseif($_GET['A3']=='manage_users'){
                                manage_users($twig,$is_connected); 
                            } elseif($_GET['A3']=='create_user'){
                                create_user($twig,$is_connected,$_POST);
                            } elseif($_GET['A3']=='create_user_group'){
                                create_user_group($twig,$is_connected,$_POST);
                            } elseif($_GET['A3']=="delete_user"){
                                if(isset($_GET['id'])){
                                    delete_user($_GET['id']);
                                } else {
                                    header('Location: ?A=admin&A2=manage_db&A3=manage_users');
                                }

                            } elseif($_GET['A3']=='manage_currency'){
                                manage_currency($twig,$is_connected); 
                            } elseif($_GET['A3']=='change_rate'){
                                change_currency_rate($twig,$is_connected,$_POST);
                            } elseif($_GET['A3']=='manage_measures'){
                                manage_measures($twig,$is_connected); 
                            } elseif($_GET['A3']=='create_xpex_cat'){
                                create_xpex_cat_db($twig,$is_connected,$_POST);
                            } elseif($_GET['A3']=='delete_xpex_cat'){
                                delete_xpex_cat_db($twig,$is_connected,$_POST);
                            }elseif($_GET['A3']=='create_measure'){
                                create_measure($twig,$is_connected,$_POST);
                            } elseif($_GET['A3']=="delete_measure"){
                                if(isset($_GET['id'])){
                                    delete_measure($_GET['id']);
                                } else {
                                    header('Location: ?A=admin&A2=manage_db&A3=manage_measures');
                                }

                            } elseif($_GET['A3']=='manage_uc_cat'){
                                manage_uc_cat($twig,$is_connected); 
                            } elseif($_GET['A3']=='create_uc_category'){
                                create_uc_category($twig,$is_connected,$_POST);
                            } elseif($_GET['A3']=="delete_uc_category"){
                                if(isset($_GET['id'])){
                                    delete_uc_category($_GET['id']);
                                } else {
                                    header('Location: ?A=admin&A2=manage_db&A3=manage_uc_cat');
                                }

                            } elseif($_GET['A3']=='manage_usecases'){
                                manage_usecases($twig,$is_connected);
                            } elseif($_GET['A3']=='create_usecase'){
                                create_usecase($twig,$is_connected,$_POST);
                            } elseif($_GET['A3']=="delete_usecase"){
                                if(isset($_GET['id'])){
                                    delete_usecase($_GET['id']);
                                } else {
                                    header('Location: ?A=admin&A2=manage_db&A3=manage_usecases');
                                }


                            } elseif($_GET['A3']=='manage_crit_cat'){
                                manage_crit_cat($twig,$is_connected); 
                            } elseif($_GET['A3']=='create_crit_category'){
                                create_crit_category($twig,$is_connected,$_POST);
                            } elseif($_GET['A3']=="delete_crit_category"){
                                if(isset($_GET['id'])){
                                    delete_crit_category($_GET['id']);
                                } else {
                                    header('Location: ?A=admin&A2=manage_db&A3=manage_crit_cat');
                                }

                            } elseif($_GET['A3']=='manage_criteria'){
                                manage_criteria($twig,$is_connected); 
                            } elseif($_GET['A3']=='create_crit'){
                                create_crit($twig,$is_connected,$_POST);
                            } elseif($_GET['A3']=="delete_crit"){
                                if(isset($_GET['id'])){
                                    delete_crit($_GET['id']);
                                } else {
                                    header('Location: ?A=admin&A2=manage_db&A3=manage_criteria');
                                }

                            } elseif($_GET['A3']=='manage_dlt'){
                                manage_dlt($twig,$is_connected); 
                            } elseif($_GET['A3']=='create_dlt'){
                                create_dlt($twig,$is_connected,$_POST);
                            } elseif($_GET['A3']=='create_zone'){
                                create_zone($twig,$is_connected,$_POST);
                            } elseif($_GET['A3']=="delete_dlt"){
                                if(isset($_GET['id'])){
                                    delete_dlt($_GET['id']);
                                } else {
                                    header('Location: ?A=admin&A2=manage_db&A3=manage_dlt');
                                }
                            } elseif($_GET['A3']=="delete_zone"){
                                if(isset($_GET['id'])){
                                    delete_zone($_GET['id']);
                                } else {
                                    header('Location: ?A=admin&A2=manage_db&A3=manage_dlt');
                                }

                            } elseif($_GET['A3']=='manage_capex_item'){
                                manage_item('capex',$twig,$is_connected); 
                            } elseif($_GET['A3']=='manage_opex_item'){
                                manage_item('opex',$twig,$is_connected); 
                            } elseif($_GET['A3']=='manage_implem_item'){
                                manage_item('implem',$twig,$is_connected); 
                            } elseif($_GET['A3']=='manage_revenues_item'){
                                manage_item('revenues',$twig,$is_connected); 
                            } elseif($_GET['A3']=='manage_revenuesProtection_item'){
                                manage_item('revenuesProtection',$twig,$is_connected); 
                            } elseif($_GET['A3']=='create_item_1'){
                                if(isset($_GET['cat'])){
                                    create_item1($twig,$is_connected,$_POST,$_GET['cat']);
                                } else {
                                    header('Location: ?A=admin&A2=manage_db');
                                }
                            } elseif($_GET['A3']=='manage_cashreleasing_item'){
                                manage_item('cashreleasing',$twig,$is_connected); 
                            } elseif($_GET['A3']=='manage_widercash_item'){
                                manage_item('widercash',$twig,$is_connected); 
                            } elseif($_GET['A3']=='create_item_2'){
                                if(isset($_GET['cat'])){
                                    create_item2($twig,$is_connected,$_POST,$_GET['cat']);
                                } else {
                                    header('Location: ?A=admin&A2=manage_db');
                                }
                            } elseif($_GET['A3']=='manage_quantifiable_item'){
                                manage_item('quantifiable',$twig,$is_connected); 
                            } elseif($_GET['A3']=='create_quantifiable_item'){
                                create_quantifiable_item($twig,$is_connected,$_POST);
                            } elseif($_GET['A3']=='manage_noncash_item'){
                                manage_item('noncash',$twig,$is_connected); 
                            } elseif($_GET['A3']=='manage_risks_item'){
                                manage_item('risks',$twig,$is_connected); 
                            } elseif($_GET['A3']=='manage_equipment_revenue'){
                                manage_item('equipment_revenue',$twig,$is_connected); 
                            } elseif($_GET['A3']=='manage_deployment_revenue'){
                                manage_item('deployment_revenue',$twig,$is_connected); 
                            } elseif($_GET['A3']=='manage_operating_revenue'){
                                manage_item('operating_revenue',$twig,$is_connected); 
                            } elseif($_GET['A3']=='manage_guid_criteria'){
                                manage_guid_criteria($twig,$is_connected); 
                            } elseif($_GET['A3']=='update_guid_crit'){
                                if(isset($_POST)){
                                    update_guid_crit($twig,$is_connected, $_POST); 
                                }else{
                                    header('Location: ?A=admin&A2=manage_db&A3=manage_guid_criteria');
                                }
                            } elseif($_GET['A3']=='create_item_3'){
                                if(isset($_GET['cat'])){
                                    create_item3($twig,$is_connected,$_POST,$_GET['cat']);
                                } else {
                                    header('Location: ?A=admin&A2=manage_db');
                                }
                            } elseif($_GET['A3']=="delete_item"){
                                if(isset($_GET['cat']) && isset($_GET['id'])){
                                    delete_item($_GET['cat'],$_GET['id']);
                                } else {
                                    header('Location: ?A=admin&A2=manage_db&A3=manage_capex_item');
                                }

                            } else {
                                header('Location: ?A=admin&A2=manage_db');
                            }
                        } else {
                            manage_db($twig,$is_connected); 
                        }
                    }else {
                        header('Location: ?A=admin');
                    }
                } else {
                    admin($twig,$is_connected);
                }
            }
            // ---------- LANGUAGE ---------- 
            elseif($_GET['A']=='setLanguage'){
                if(isset($_GET['language'])){
                    if($_GET['language'] == "en" || $_GET['language'] == "fr"){
                        $lastURL = isset($_GET['lastURL']) ? $_GET['lastURL'] : "?A,home";
                        setLanguage($_GET['language'], $lastURL);
                    }
                }else{
                    header('Location: ?A=home');
                }
            }
            // ---------- PROFILE ---------- 
            elseif($_GET['A']=='profile'){
                if(isset($_GET['A2'])){
                    if($_GET['A2']=='modify_infos'){
                        modify_infos($twig,$is_connected);
                    } elseif($_GET['A2']=='save_infos'){
                        save_infos($twig,$is_connected,$_POST, $_FILES);
                    } else {
                        header('Location: ?A=profile');
                    }
                } else {
                    profile($twig,$is_connected);
                }
            }
            // ---------- PROJECT DESIGN ---------- 
            elseif($_GET['A']=='project_design'){
                verifIsDev();
                
                if(isset($_GET['A2'])){
                    // --- USE CASES MENU ---
                    if($_GET['A2']=="ucm"){
                        if(isset($_GET['isTaken']) && $_GET['isTaken']){
                            ucm($twig,$is_connected,true);
                        } else {
                            ucm($twig,$is_connected);
                        }
                    }
                    elseif($_GET['A2']=="create_ucm"){
                        create_ucm($_POST);
                    }
                    elseif($_GET['A2']=="delete_ucm"){
                        if(isset($_GET['id'])){
                            delete_ucm($_GET['id']);
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
                    // --- SELECTED MEASURE ---
                    elseif ($_GET['A2']=="measures_selected") {
                        $list_measID = [];
                        foreach ($_POST as $key => $value) {
                            if(isset($key)){
                                $measID = intval($key);
                                array_push($list_measID,$measID);
                            }
                        }
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
                                array_push($list_critID,$critID);
                            }
                        }
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
                                array_push($list_idDLT,$idDLT);
                            }
                        }
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
                                                array_push($list_idUC,$idUC);
                                            }
                                        }
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
            // ---------- PROJECT SDESIGN ----------
            elseif($_GET['A']=='project_sdesign'){
                verifIsSup();
                if(isset($_GET['A2'])){
                    if($_GET['A2']=="project"){
                        \general\project($twig,$is_connected,'?A=project_sdesign&A2=proj_selected','project_sdesign');
                    }elseif($_GET['A2']=="basket"){
                        \general\project($twig,$is_connected, '','project_sdesign');
                    }elseif($_GET['A2']=="create_proj"){
                        if(isset($_POST)){
                            \general\create_proj($_POST,$_GET['A'], "project" );
                        }
                        else{
                            
                            header('Location: ?A='.$_GET['A'].'=&A2=project');
                        }
                    }elseif($_GET['A2']=="basket_proj"){
                        if(isset($_GET['id'])){
                            \general\basket_proj($_GET['id'], $_GET['A'], "project");
                        }
                        else {
                            header('Location: ?A='.$_GET['A'].'&A2=project');
                        }
                    }elseif($_GET['A2']=="restore_proj"){
                        if(isset($_GET['id'])){
                            \general\restore_proj($_GET['id'], $_GET['A'], "basket");
                        }
                        else {
                            header('Location: ?A='.$_GET['A'].'&A2=project');
                        }
                    }elseif($_GET['A2']=="delete_proj"){
                        if(isset($_GET['id'])){
                            \general\delete_proj($_GET['id'], $_GET['A'], "basket");
                        }
                        else {
                            header('Location: ?A='.$_GET['A'].'&A2=project');
                        }
                    }elseif($_GET['A2']=="edit_proj"){
                        if(isset($_POST)){
                            \general\edit_proj($_POST,$_GET['A'], "project");
                        }
                        else{
                            
                            header('Location: ?A='.$_GET['A'].'=&A2=project');
                        }
                    }elseif($_GET['A2']=="duplicate_proj"){
                        if(isset($_POST)){
                            \general\duplicate_proj($_POST,$_GET['A'], "project");
                        }
                        else{
                            
                           // header('Location: ?A='.$_GET['A'].'=&A2=project');
                        }
                    }elseif($_GET['A2']=="proj_selected"){
                        if(isset($_POST['radio_proj'])){
                            $projID = intval($_POST['radio_proj']);
                            $_SESSION['projID']=$projID;
                            header('Location: ?A=project_sdesign&A2=perimeter1&projID='.$projID);
                        }
                    }
                    // --- SELECTED USE CASES MENU ---
                    elseif($_GET['A2']=="ucm_selected"){
                        if(isset($_POST['radio_ucm'])){
                            $ucmID = intval($_POST['radio_ucm']);
                            $_SESSION['ucmID']=$ucmID;
                            header('Location: ?A=project_sdesign&A2=scope&ucmID='.$ucmID);
                        }
                    }
                    elseif($_GET['A2']=="perimeter1"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                perimeter1($twig,$is_connected,$_SESSION['projID']);
                            }
                            else {
                                header('Location: ?A=project_sdesign&A2=perimeter1');
                            }
                        }
                        else {
                            perimeter1($twig,$is_connected);
                        }
                    }elseif($_GET['A2']=="perimeter1_inputed"){
                        if(isset($_SESSION['projID']) && isset($_POST)){
                            if($_SESSION['projID']!=0){
                                perimeter1_inputed($twig,$is_connected,$_SESSION['projID'], $_POST);
                            }
                            else {
                                header('Location: ?A=project_sdesign&A2=perimeter1');
                            }
                        }
                        else {
                            perimeter1($twig,$is_connected);
                        }
                    }
                    elseif($_GET['A2']=="scope1"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                scope($twig,$is_connected,$_SESSION['projID'], "project_sdesign");
                            }
                            else {
                                header('Location: ?A=project_sdesign&A2=scope1');
                            }
                        }
                        else {
                            scope_selected($twig,$is_connected);
                        }
                    } elseif($_GET['A2']=="scope_selected"){
                        scope_selected($_POST);
                    }
                } else {
                    project_sdesign($twig,$is_connected);
                }
            }
            // ---------- PROJECT SCOPING ----------
            elseif($_GET['A']=='project_scoping'){
                verifIsDev();
                if(isset($_GET['A2'])){
                    // --- PROJECT ---
                    if($_GET['A2']=="project"){
                        \general\project($twig,$is_connected,'?A=project_scoping&A2=proj_selected','project_scoping');
                    }
                    elseif($_GET['A2']=="create_proj"){
                        if(isset($_POST)){
                            \general\create_proj($_POST,$_GET['A'], "project" );
                        }
                        else{
                            
                            header('Location: ?A='.$_GET['A'].'=&A2=project');
                        }
                    }
                    elseif($_GET['A2']=="delete_proj"){
                        if(isset($_GET['id'])){
                            \general\delete_proj($_GET['id'], $_GET['A'], "project");
                        }
                        else {
                            header('Location: ?A='.$_GET['A'].'&A2=project');
                        }
                    }
                    // --- SELECTED PROJECT ---
                    elseif($_GET['A2']=="proj_selected"){
                        if(isset($_POST['radio_proj'])){
                            $projID = intval($_POST['radio_proj']);
                            $_SESSION['projID']=$projID;
                            header('Location: ?A=project_scoping&A2=scope&projID='.$projID);
                        }
                    }
                    elseif($_GET['A2']=="scope"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                scope($twig,$is_connected,$_SESSION['projID'], "project_scoping");
                            }
                            else {
                                header('Location: ?A=project_scoping&A2=scope');
                            }
                        }
                        else {
                            scope($twig,$is_connected, 0, "project_scoping");
                        }
                    // --- SELECTED SCOPE ---
                    } elseif($_GET['A2']=="scope_selected"){
                        scope_selected($_POST);
                    // --- PERIMETER ---
                    } elseif($_GET['A2']=="perimeter"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                perimeter($twig,$is_connected,$_SESSION['projID']);
                            }
                            else {
                                header('Location: ?A=project_scoping&A2=perimeter');
                            }
                        }
                        else {
                            perimeter($twig,$is_connected);
                        }
                    // --- SELECTED PERIMETER ---
                    } elseif($_GET['A2']=="perimeter_selected"){
                        perimeter_selected($_POST);
                    // --- SIZE ---
                    } elseif($_GET['A2']=="size"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                size($twig,$is_connected,$_SESSION['projID']);
                            }
                            else {
                                header('Location: ?A=project_scoping&A2=size');
                            }
                        }
                        else {
                            size($twig,$is_connected);
                        }
                    // --- SELECTED SIZE ---
                    } elseif($_GET['A2']=="size_selected"){
                        size_selected($_POST);
                    // --- VOLUMES ---
                    } elseif($_GET['A2']=="volumes"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                volumes($twig,$is_connected,$_SESSION['projID']);
                            }
                            else {
                                header('Location: ?A=project_scoping&A2=volumes');
                            }
                        }
                        else {
                            volumes($twig,$is_connected);
                        }
                    // --- SELECTED VOLUMES ---
                    } elseif($_GET['A2']=="volumes_selected"){
                        volumes_selected($_POST);
                    // --- SCHEDULE ---
                    } elseif($_GET['A2']=="schedule"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                schedule($twig,$is_connected,$_SESSION['projID']);
                            }
                            else {
                                header('Location: ?A=project_scoping&A2=schedule');
                            }
                        }
                        else {
                            schedule($twig,$is_connected);
                        }
                    // --- SELECTED SCHEDULES ---
                    } elseif($_GET['A2']=="schedules_selected"){
                        schedules_selected($_POST);
                    // --- DISCOUNT RATE ---
                    } elseif($_GET['A2']=="discount_rate"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                discount_rate($twig,$is_connected,$_SESSION['projID']);
                            }
                            else {
                                header('Location: ?A=project_scoping&A2=discount_rate');
                            }
                        }
                        else {
                            discount_rate($twig,$is_connected);
                        }
                    // --- SELECTED DISCOUNT RATE ---
                    } elseif($_GET['A2']=="discount_rate_selected"){
                        discount_rate_selected($_POST);
                    } else {
                        header('Location: ?A='.$_GET['A']);
                    }
                } else {

                    \general\commonPage($twig,$is_connected, "?A=project_scoping&A2=project", "project_scoping");
                    //project_scoping($twig,$is_connected);
                }        
            
            }
            
            // ---------- Customer BC / Supplier BC ----------
            // **** 
            // ---------- Input Project Common SUPPLIER ----------
            elseif($_GET['A']=='input_project_common_supplier'){
                verifIsSup();
                if(isset($_GET['A2'])) {
                    if($_GET['A2']=='project_selection'){
                        \general\project($twig,$is_connected, '?A=input_project_common_supplier&A2=proj_selected',  'input_project_common_supplier');
                    } elseif($_GET['A2']=="create_proj"){
                        if(isset($_POST)){
                            \general\create_proj($_POST,$_GET['A'], "project_selection" );
                        }
                        else{
                            
                            header('Location: ?A='.$_GET['A'].'=&A2=project_selection');
                        }
                    }elseif($_GET['A2']=="delete_proj"){
                        if(isset($_GET['id'])){
                            \general\delete_proj($_GET['id'], $_GET['A'], "project_selection");
                        }
                        else {
                            header('Location: ?A='.$_GET['A'].'&A2=project');
                        }
                    }elseif($_GET['A2']=="proj_selected"){
                        if(isset($_POST['radio_proj'])){
                            $projID = intval($_POST['radio_proj']);
                            $_SESSION['projID']=$projID;
                            header('Location: ?A=input_project_common_supplier&A2=schedule&projID='.$projID);
                        }
                    } elseif(isset($_SESSION['projID']) and $_SESSION['projID']!=0){
                        //Le projet est choisi
                            if($_GET['A2']=="schedule") {
                                if(isset($_GET['A3'])){
                                    if($_GET['A3'] == "save"){
                                        if($_POST) {
                                            save_supplier_schedule($twig,$is_connected, $_POST);
                                        } else {
                                            throw new Exception("There was an error with the form.");
                                        }
                                    }
                                } else {
                                    supplier_schedule($twig,$is_connected,$_SESSION['projID']); 
                                }
                            }  // --- CAPEX OR OPEX (XPEX) ---
                            elseif($_GET['A2']=="equipment_revenues" || $_GET['A2']=="deployment_revenues" || $_GET['A2']=="operating_revenues" ||  $_GET['A2']=="capex" || $_GET['A2']=="opex" || $_GET['A2']=="deployment_costs"){
                                $side = "supplier";
                                if(isset($_GET['A3'])){
                                    if($_GET['A3']=="selection"){
                                        $isTaken = isset($_GET['isTaken'])? $_GET['isTaken']=="true" : false;
                                        xpex_selection($twig,$is_connected,$_SESSION['projID'], -1,$_GET['A'], $_GET['A2'],"supplier", $isTaken); 
                                    }elseif($_GET['A3']=="selected"){
                                        xpex_selected($twig,$is_connected, $_POST,  $_GET['A2'], $_GET['A'],"supplier"); 
                                    }elseif($_GET['A3']=="create_xpex"){
                                        create_xpex($twig,$is_connected, $_POST,  $_GET['A2'], $_GET['A'],"supplier"); 
                                    }elseif($_GET['A3']=="create_xpex_cat"){
                                        //var_dump($side);
                                        create_xpex_cat($twig,$is_connected, $_POST,  $_GET['A2'], $_GET['A'],$side); 
                                    }elseif($_GET['A3']=="delete_xpex_cat"){
                                        //var_dump($side);
                                        delete_xpex_cat($twig,$is_connected, $_POST,  $_GET['A2'], $_GET['A'],$side); 
                                    }elseif($_GET['A3']=="delete_xpex"){
                                        if(isset($_GET['id'])){
                                            delete_xpex_user($_GET['id'],$_GET['A2'], $_GET['A']); 
                                        }else{
                                            header('Location: ?A='.$_GET['A'].'&A2='.$_GET['A2'].'&projID='.$_SESSION['projID']);
                                        }
                                        
                                    }elseif($_GET['A3']=="inputed"){
                                        if(isset($_POST)){
                                            xpex_inputed($_POST, $_GET['A'], $_GET['A2']);
                                        }
                                        else{
                                            header('Location: ?A='.$_GET['A'].'&A2='.$_GET['A2'].'&projID='.$_SESSION['projID']);
                                        }
                                    }
                                }else {
                                    $isTaken = isset($_GET['isTaken'])? $_GET['isTaken']=="true" : false;
                                    xpex_selection($twig,$is_connected,$_SESSION['projID'], -1,$_GET['A'], $_GET['A2'],"supplier", $isTaken);
                                }
                        }elseif($_GET['A2']=="deal_criteria"){
                            deal_criteria($twig,$is_connected, $_SESSION['projID'], "supplier", $_GET['A']);
                         
                    }  elseif($_GET['A2']=="deal_criteria_input") {
                        deal_criteria_input_nogo_target($_POST, "supplier");
                    } 
                    }  
                } else {  
                    \general\commonPage($twig,$is_connected, "?A=input_project_common_supplier&A2=schedule", "input_project_common_supplier");
                }
                prereq_navbar("input");
            }

            // ---------- Input Project Common CUSTOMER ----------
            elseif($_GET['A']=='input_project_common'){
                verifIsSup();
                if(isset($_GET['A2'])){
                    if($_GET['A2']=='project_selection'){
                        \general\project($twig,$is_connected, '?A=input_project_common&A2=proj_selected',  'input_project_common');
                        //project_ipc($twig,$is_connected);

                    // --- SELECTED PROJECT ---
                    }elseif($_GET['A2']=="create_proj"){
                        if(isset($_POST)){
                            \general\create_proj($_POST,$_GET['A'], "project_selection" );
                        }
                        else{
                            
                            header('Location: ?A='.$_GET['A'].'=&A2=project_selection');
                        }
                    }elseif($_GET['A2']=="delete_proj"){
                        if(isset($_GET['id'])){
                            \general\delete_proj($_GET['id'], $_GET['A'], "project_selection");
                        }
                        else {
                            header('Location: ?A='.$_GET['A'].'&A2=project');
                        }
                    }elseif($_GET['A2']=="proj_selected"){
                        if(isset($_POST['radio_proj'])){
                            $projID = intval($_POST['radio_proj']);
                            $_SESSION['projID']=$projID;
                            header('Location: ?A=input_project_common&A2=capex&projID='.$projID);
                        }
                    
                    }elseif(isset($_SESSION['projID']) and $_SESSION['projID']!=0){
                        // --- USE CASE SELECTION ---
                            if($_GET['A2']=="capex" or $_GET['A2']=="opex" or $_GET['A2']=="deployment_costs"){
                                $side = "customer";
                                if(isset($_GET['A3'])){
                                    if($_GET['A3']=="selection"){
                                        $isTaken = isset($_GET['isTaken'])? $_GET['isTaken']=="true" : false;
                                        xpex_selection($twig,$is_connected,$_SESSION['projID'], -1,$_GET['A'], $_GET['A2'],"customer", $isTaken);
                                    }elseif($_GET['A3']=="selected"){
                                        xpex_selected($twig,$is_connected, $_POST,  $_GET['A2'], $_GET['A'],"customer"); 
                                    }elseif($_GET['A3']=="create_xpex"){
                                        create_xpex($twig,$is_connected, $_POST,  $_GET['A2'], $_GET['A'],"customer"); 
                                    }elseif($_GET['A3']=="create_xpex_cat"){
                                        //var_dump($side);
                                        create_xpex_cat($twig,$is_connected, $_POST,  $_GET['A2'], $_GET['A'],$side); 
                                    }elseif($_GET['A3']=="delete_xpex_cat"){
                                        //var_dump($side);
                                        delete_xpex_cat($twig,$is_connected, $_POST,  $_GET['A2'], $_GET['A'],$side); 
                                    }elseif($_GET['A3']=="delete_xpex"){
                                        if(isset($_GET['id'])){
                                            delete_xpex_user($_GET['id'],$_GET['A2'], $_GET['A']); 
                                        }else{
                                            header('Location: ?A='.$_GET['A'].'&A2='.$_GET['A2'].'&projID='.$_SESSION['projID']);
                                        }
                                        
                                    }elseif($_GET['A3']=="inputed"){
                                        if(isset($_POST)){
                                            xpex_inputed($_POST, $_GET['A'], $_GET['A2']);
                                        }
                                        else{
                                            header('Location: ?A='.$_GET['A'].'&A2='.$_GET['A2'].'&projID='.$_SESSION['projID']);
                                        }
                                    }
                                }else {
                                    $isTaken = isset($_GET['isTaken'])? $_GET['isTaken']=="true" : false;
                                    xpex_selection($twig,$is_connected,$_SESSION['projID'], -1,$_GET['A'], $_GET['A2'],"customer",  $isTaken);
                                }

                            }elseif($_GET['A2']=="deal_criteria"){
                                deal_criteria($twig,$is_connected, $_SESSION['projID'], "customer", $_GET['A']);
                             
                        } elseif($_GET['A2']=="deal_criteria_input") {
                            deal_criteria_input_nogo_target($_POST, "customer");
                        }                            
                            else{  
                                header('Location: ?A=input_project_common&A2=use_case_selection&projID='.$projID);
                            }
                        

                            
                    } else {
                        header('Location: ?A=input_project_common&A2=project_selection');
                    }

                } else {  
                    //input_project_common($twig,$is_connected);
                    \general\commonPage($twig,$is_connected, "?A=input_project_common&A2=capex", "input_project_common");
                }
                prereq_navbar("input");
            }

            
            // ---------- Dashborads ----------
            elseif($_GET['A']=='customer_dashboards'){
                verifIsSup();
                if(isset($_GET['A2'])){
                    if($_GET['A2']=='project_selection'){
                        \general\project($twig,$is_connected, '?A=customer_dashboards&A2=proj_selected', 'customer_dashboards');
                    }elseif($_GET['A2']=="create_proj"){
                        if(isset($_POST)){
                            \general\create_proj($_POST,$_GET['A'], "project_selection" );
                        }
                        else{
                            
                            header('Location: ?A='.$_GET['A'].'=&A2=project_selection');
                        }
                    }elseif($_GET['A2']=="delete_proj"){
                        if(isset($_GET['id'])){
                            \general\delete_proj($_GET['id'], $_GET['A'], "project_selection");
                        }
                        else {
                            header('Location: ?A='.$_GET['A'].'&A2=project');
                        }
                    } elseif($_GET['A2']=="proj_selected"){
                        if(isset($_POST['radio_proj'])){
                            $projID = intval($_POST['radio_proj']);
                            $_SESSION['projID']=$projID;
                            header('Location: ?A=customer_dashboards&A2=summary&projID='.$projID);
                        }
                    }elseif($_GET['A2']=="summary"){
                        if(isset($_SESSION['projID'])&&$_SESSION['projID']!=0){
                            if(isset($_GET["A3"]) && $_GET["A3"]=="save_uc_confirm" && isset($_POST)){
                                save_uc_selection_filter($twig,$is_connected, $_POST,$_GET['A']);    
                            }else{
                                dashboards_summary($twig,$is_connected, $_SESSION['projID'], $_GET['A'], "customer");
                            }
                        }else{
                            header('Location: ?A=customer_dashboards&A2project_selection');
                        }
                    }elseif($_GET['A2']=="project_details"){
                        if(isset($_SESSION['projID'])&&$_SESSION['projID']!=0){
                            dashboards_project_details($twig,$is_connected, $_SESSION['projID'], $_GET['A'], "customer");
                        }else{
                            header('Location: ?A=customer_dashboards&A2project_selection');
                        }
                    }elseif($_GET['A2']=="use_case_details"){
                        if(isset($_SESSION['projID'])&&$_SESSION['projID']!=0){
                            dashboards_use_case_details($twig,$is_connected, $_SESSION['projID'], $_GET['A'], "customer");
                        }else{
                            header('Location: ?A=customer_dashboards&A2project_selection');
                        }
                    }elseif($_GET['A2']=="non_monetizable"){
                        if(isset($_SESSION['projID'])&&$_SESSION['projID']!=0){
                            dashboards_non_monetizable($twig,$is_connected, $_SESSION['projID']);
                        }else{
                            header('Location: ?A=customer_dashboards&A2project_selection');
                        }
                    }elseif($_GET['A2']=="qualitative"){
                        if(isset($_SESSION['projID'])&&$_SESSION['projID']!=0){
                            dashboards_qualitative($twig,$is_connected, $_SESSION['projID']);
                        }else{
                            header('Location: ?A=customer_dashboards&A2project_selection');
                        }
                    }
                } else{
                    \general\commonPage($twig,$is_connected, '?A=customer_dashboards&A2=summary', 'customer_dashboards');

                }
                prereq_navbar("output");
            }

            elseif($_GET['A']=='supplier_dashboards'){
                verifIsSup();
                if(isset($_GET['A2'])){
                    if($_GET['A2']=='project_selection'){
                        \general\project($twig,$is_connected, '?A=supplier_dashboards&A2=proj_selected', 'supplier_dashboards');
                    }elseif($_GET['A2']=="create_proj"){
                        if(isset($_POST)){
                            \general\create_proj($_POST,$_GET['A'], "project_selection" );
                        }
                        else{
                            
                            header('Location: ?A='.$_GET['A'].'=&A2=project_selection');
                        }
                    }elseif($_GET['A2']=="delete_proj"){
                        if(isset($_GET['id'])){
                            \general\delete_proj($_GET['id'], $_GET['A'], "project_selection");
                        }
                        else {
                            header('Location: ?A='.$_GET['A'].'&A2=project');
                        }
                    } elseif($_GET['A2']=="proj_selected"){
                        if(isset($_POST['radio_proj'])){
                            $projID = intval($_POST['radio_proj']);
                            $_SESSION['projID']=$projID;
                            header('Location: ?A=supplier_dashboards&A2=summary&projID='.$projID);
                        }
                    }elseif($_GET['A2']=="summary"){
                        if(isset($_SESSION['projID'])&&$_SESSION['projID']!=0){
                            if(isset($_GET["A3"]) && $_GET["A3"]=="save_uc_confirm" && isset($_POST)){
                                save_uc_selection_filter($twig,$is_connected, $_POST,$_GET['A']);    
                            }else{
                                dashboards_summary($twig,$is_connected, $_SESSION['projID'], $_GET['A'], "customer");
                            }
                        }else{
                            header('Location: ?A=supplier_dashboards&A2project_selection');
                        }
                    }elseif($_GET['A2']=="project_details"){
                        if(isset($_SESSION['projID'])&&$_SESSION['projID']!=0){
                            dashboards_project_details($twig,$is_connected, $_SESSION['projID'], $_GET['A'], "supplier");
                        }else{
                            header('Location: ?A=supplier_dashboards&A2project_selection');
                        }
                    }elseif($_GET['A2']=="use_case_details"){
                        if(isset($_SESSION['projID'])&&$_SESSION['projID']!=0){
                            dashboards_use_case_details($twig,$is_connected, $_SESSION['projID'], $_GET['A'], "supplier");
                        }else{
                            header('Location: ?A=supplier_dashboards&A2project_selection');
                        }
                    }
                } else{
                    \general\commonPage($twig,$is_connected, '?A=supplier_dashboards&A2=summary', 'supplier_dashboards');
                }
                prereq_navbar("output");
            }

            // ---------- INPUT USE CASE (SUPPLIER !!) ----------
            elseif($_GET['A']=='input_use_case_supplier') {
                verifIsSup();
                if(isset($_GET['A2'])) { 
                    if($_GET['A2']=="project_selection"){
                        \general\project($twig,$is_connected, "?A=".$_GET['A']."&A2=proj_selected", "input_use_case_supplier");
                    // --- SELECTED PROJECT ---
                    }elseif($_GET['A2']=="create_proj"){
                        if(isset($_POST)){
                            \general\create_proj($_POST,$_GET['A'], "project_selection" );
                        }
                        else{
                            
                            header('Location: ?A='.$_GET['A'].'=&A2=project_selection');
                        }
                    }elseif($_GET['A2']=="delete_proj"){
                        if(isset($_GET['id'])){
                            \general\delete_proj($_GET['id'], $_GET['A'], "project_selection");
                        }
                        else {
                            header('Location: ?A='.$_GET['A'].'&A2=project');
                        }
                    } elseif($_GET['A2']=="proj_selected"){
                        if(isset($_POST['radio_proj'])){
                            $projID = intval($_POST['radio_proj']);
                            $_SESSION['projID']=$projID;
                            header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$projID);
                        }
                    } elseif($_GET['A2']=="use_case_cb"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                \general\use_case_selection($twig,$is_connected,'?A=input_use_case_supplier&A2=uc_selected&projID='.$_SESSION['projID'],$_GET['A'],$_SESSION['projID']);
                            }
                            else {
                                header('Location: ?A='.$_GET['A'].'&A2=use_case_cb');
                            }
                        }
                        else {
                            use_case_cb($twig,$is_connected);
                        }
                    } elseif($_GET['A2']=="uc_selected"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                if(isset($_POST['radio_uc'])){
                                    \general\use_case_selected($twig,$is_connected,$_POST,"input_use_case_supplier","schedule","input_project_common_supplier","schedule");
                                }
                                else {
                                    header('Location: ?A='.$_GET['A'].'&A2=use_case_cb');
                                }
                            }
                            else {
                                header('Location: ?A='.$_GET['A'].'&A2=use_case_cb');
                            }
                        }
                        else {
                            header('Location: ?A='.$_GET['A'].'&A2=use_case_cb');
                        }
                    } elseif($_GET['A2']=="schedule") {
                        if(isset($_GET['A3'])) {
                            if($_GET['A3'] == "save") {
                                if($_POST) {
                                    save_use_case_schedule($twig,$is_connected, $_POST);
                                } else {
                                    throw new Exception("There was an error with the form.");
                                }
                            }
                        } else {
                            use_case_schedule($twig,$is_connected, $_SESSION['projID'], $_GET['ucID']);
                        }
                    } elseif($_GET['A2']=="equipment_revenues" || 
                    $_GET['A2']=="deployment_revenues" ||
                    $_GET['A2']=="operating_revenues" ||  
                    $_GET['A2']=="capex" || 
                    $_GET['A2']=="opex" || 
                    $_GET['A2']=="revenues" || 
                    $_GET['A2']=="revenuesProtection" || 
                    $_GET['A2']=="cashreleasing" || 
                    $_GET['A2']=="widercash" || 
                    $_GET['A2']=="quantifiable" || 
                    $_GET['A2']=="noncash" || 
                    $_GET['A2']=="risks" || 
                    $_GET['A2']=="deployment_costs"){
                        if(isset($_GET['ucID']) and $_GET['ucID']!=0 and isset($_SESSION['projID']) and $_SESSION['projID']!=0){
                            $side = isDev() ? "projDev" : "supplier";
                            if(isset($_GET['A3'])){
                                    if($_GET['A3']=="selection"){
                                        $isTaken = isset($_GET['isTaken'])? $_GET['isTaken']=="true" : false;
                                        xpex_selection($twig,$is_connected,$_SESSION['projID'], $_GET['ucID'],$_GET['A'], $_GET['A2'],$side, $isTaken); 
                                    }elseif($_GET['A3']=="selected"){
                                        xpex_selected($twig,$is_connected, $_POST,  $_GET['A2'], $_GET['A'],$side); 
                                    }elseif($_GET['A3']=="create_xpex"){
                                        create_xpex($twig,$is_connected, $_POST,  $_GET['A2'], $_GET['A'],$side); 
                                    }elseif($_GET['A3']=="create_xpex_cat"){
                                        //var_dump($side);
                                        create_xpex_cat($twig,$is_connected, $_POST,  $_GET['A2'], $_GET['A'],$side); 
                                    }elseif($_GET['A3']=="delete_xpex_cat"){
                                        //var_dump($side);
                                        delete_xpex_cat($twig,$is_connected, $_POST,  $_GET['A2'], $_GET['A'],$side); 
                                    }elseif($_GET['A3']=="delete_xpex"){
                                        if(isset($_GET['id'])){
                                            delete_xpex_user($_GET['id'],$_GET['A2'], $_GET['A']); 
                                        }else{
                                            header('Location: ?A='.$_GET['A'].'&A2='.$_GET['A2'].'&projID='.$_SESSION['projID'].'&ucID='.$_GET['ucID']);
                                        }
                                        
                                    }elseif($_GET['A3']=="inputed"){
                                        if(isset($_POST)){
                                            xpex_inputed($_POST, $_GET['A'], $_GET['A2']);
                                        }
                                        else{
                                            header('Location: ?A='.$_GET['A'].'&A2='.$_GET['A2'].'&projID='.$_SESSION['projID'].'&ucID='.$_GET['ucID']);
                                        }
                                    }elseif($_GET['A3']=="delete_selection_xpex"){
                                        delete_selection_xpex($_SESSION['projID'],$_GET['ucID'],$_GET['A2'], $_GET['A'] );
                                    }
                                }else {
                                    $isTaken = isset($_GET['isTaken'])? $_GET['isTaken']=="true" : false;
                                    xpex_selection($twig,$is_connected,$_SESSION['projID'], $_GET['ucID'],$_GET['A'], $_GET['A2'],$side, $isTaken);
                                }
        
                            }                             
                            else{
                                
                                header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$projID);
                            }

                        
                } elseif($_GET['A2']=="summary"){

                    if(isset($_SESSION['projID'])){
                        if($_SESSION['projID']!=0){
                            if(isset($_GET['confirm'])){
                                summary($twig,$is_connected,$_SESSION['projID'],$_GET['confirm'],$_GET['A']);
                            } else {
                                summary($twig,$is_connected,$_SESSION['projID'],0,$_GET['A']);
                            }
                        }
                        else { 
                            header('Location: ?A='.$_GET['A'].'&A2=project_cb');
                        }
                    }
                    else {
                        header('Location: ?A='.$_GET['A'].'&A2=project_cb');
                    }
                    
                }elseif($_GET['A2']=="summary_inputed"){
                    if(isset($_SESSION['projID'])){
                        if($_SESSION['projID']!=0){
                            if(isset($_POST)){
                                summary_inputed($twig,$is_connected,$_SESSION['projID'], $_POST, $_GET['A']);
                            }else{
                                header('Location: ?A='.$_GET['A'].'&A2=summary&projID='.$_SESSION['projID']);
                            }
                        }
                        else { 
                            header('Location: ?A='.$_GET['A'].'&A2=project_cb');
                        }
                    }
                    else {
                        header('Location: ?A='.$_GET['A'].'&A2=project_cb');
                    }
                    
                } 
            }else {
                    input_use_case_supplier($twig,$is_connected);
                }
                prereq_navbar("input");
            }
            // ---------- COMPARISON (SUPPLIER !!) ----------
            elseif($_GET['A']=='supplier_comparison') {
                verifIsSup();
                if(isset($_GET['A2'])){
                    if($_GET['A2']=="proj_selected" and isset($_POST)){
                        comp_proj_selected($twig,$is_connected, $_POST);
                    }elseif(isset($_SESSION['listProjComp'])){
                        if($_GET["A2"] ==  "comparison"){
                            supplier_comparison($twig,$is_connected);
                        }

                    }else{
                        projectComparison($twig,$is_connected);
                    }

                }else{
                    projectComparison($twig,$is_connected);
                }
                prereq_navbar("comparison");
            
            }
            // ---------- COST BENEFITS ----------
            elseif($_GET['A']=='cost_benefits' or $_GET['A']=='input_use_case'){
                //Available for Dev AND sup, do NOT use verifIsSup(); or verifIsDev();
                if(isset($_GET['A2'])){
                    if($_GET['A2']=="project_cb"){
                        //project_cb($twig,$is_connected);
                        \general\project($twig,$is_connected, "?A=".$_GET['A']."&A2=proj_selected", "cost_benefits");
                    // --- SELECTED PROJECT ---
                    } elseif($_GET['A2']=="create_proj"){
                        if(isset($_POST)){
                            \general\create_proj($_POST,$_GET['A'], "project_cb" );
                        }
                        else{
                            
                            header('Location: ?A='.$_GET['A'].'&A2=project_cb');
                        }
                    }elseif($_GET['A2']=="delete_proj"){
                        if(isset($_GET['id'])){
                            \general\delete_proj($_GET['id'], $_GET['A'], "project_cb");
                        }
                        else {
                            header('Location: ?A='.$_GET['A'].'&A2=project');
                        }
                    }elseif($_GET['A2']=="proj_selected"){
                        if(isset($_POST['radio_proj'])){
                            $projID = intval($_POST['radio_proj']);
                            $_SESSION['projID']=$projID;
                            header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$projID);
                        }
                    // --- USE CASES ---
                    } elseif($_GET['A2']=="use_case_cb"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                \general\use_case_selection($twig,$is_connected,'?A=cost_benefits&A2=uc_selected&projID='.$_SESSION['projID'],$_GET['A'],$_SESSION['projID']);
                            }
                            else {
                                header('Location: ?A='.$_GET['A'].'&A2=use_case_cb');
                            }
                        }
                        else {
                            use_case_cb($twig,$is_connected);
                        }
                    // --- SELECTED USE CASE ---
                    } elseif($_GET['A2']=="uc_selected"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                if(isset($_POST['radio_uc'])){
                                    \general\use_case_selected($twig,$is_connected,$_POST,$_GET['A'],"capex","input_project_common","capex");

                                }
                                else {
                                    header('Location: ?A='.$_GET['A'].'&A2=use_case_cb');
                                }
                            }
                            else {
                                header('Location: ?A='.$_GET['A'].'&A2=use_case_cb');
                            }
                        }
                        else {
                            header('Location: ?A='.$_GET['A'].'&A2=use_case_cb');
                        }
                    
                    // --- CAPEX ---
                    }elseif($_GET['A2']=="equipment_revenues" || 
                    $_GET['A2']=="deployment_revenues" ||
                    $_GET['A2']=="operating_revenues" ||  
                    $_GET['A2']=="capex" || 
                    $_GET['A2']=="opex" || 
                    $_GET['A2']=="revenues" || 
                    $_GET['A2']=="revenuesProtection" || 
                    $_GET['A2']=="cashreleasing" || 
                    $_GET['A2']=="widercash" || 
                    $_GET['A2']=="quantifiable" || 
                    $_GET['A2']=="noncash" || 
                    $_GET['A2']=="risks" || 
                    $_GET['A2']=="deployment_costs"){
                        if(isset($_GET['ucID']) and $_GET['ucID']!=0 and isset($_SESSION['projID']) and $_SESSION['projID']!=0){
                                $side = isDev() ? "projDev" : "customer";
                                if(isset($_GET['A3'])){
                                    if($_GET['A3']=="selection"){
                                        $isTaken = isset($_GET['isTaken'])? $_GET['isTaken']=="true" : false;
                                        xpex_selection($twig,$is_connected,$_SESSION['projID'], $_GET['ucID'],$_GET['A'], $_GET['A2'],$side, $isTaken); 
                                    }elseif($_GET['A3']=="selected"){
                                        xpex_selected($twig,$is_connected, $_POST,  $_GET['A2'], $_GET['A'],$side); 
                                    }elseif($_GET['A3']=="create_xpex"){
                                        create_xpex($twig,$is_connected, $_POST,  $_GET['A2'], $_GET['A'],$side); 
                                    }elseif($_GET['A3']=="create_xpex_cat"){
                                        create_xpex_cat($twig,$is_connected, $_POST,  $_GET['A2'], $_GET['A'],$side); 
                                    }elseif($_GET['A3']=="delete_xpex_cat"){
                                        delete_xpex_cat($twig,$is_connected, $_POST,  $_GET['A2'], $_GET['A'],$side); 
                                    }elseif($_GET['A3']=="delete_xpex"){
                                        if(isset($_GET['id'])){
                                            delete_xpex_user($_GET['id'],$_GET['A2'], $_GET['A']); 
                                        }else{
                                            header('Location: ?A='.$_GET['A'].'&A2='.$_GET['A2'].'&projID='.$_SESSION['projID'].'&ucID='.$_GET['ucID']);
                                        }
                                        
                                    }elseif($_GET['A3']=="inputed"){
                                        if(isset($_POST)){
                                            xpex_inputed($_POST, $_GET['A'], $_GET['A2']);
                                        }
                                        else{
                                            header('Location: ?A='.$_GET['A'].'&A2='.$_GET['A2'].'&projID='.$_SESSION['projID'].'&ucID='.$_GET['ucID']);
                                        }
                                    }elseif($_GET['A3']=="delete_selection_xpex"){
                                        delete_selection_xpex($_SESSION['projID'],$_GET['ucID'],$_GET['A2'], $_GET['A'] );
                                    }
                                }else {
                                    $isTaken = isset($_GET['isTaken'])? $_GET['isTaken']=="true" : false;
                                    xpex_selection($twig,$is_connected,$_SESSION['projID'], $_GET['ucID'],$_GET['A'], $_GET['A2'],$side, $isTaken);
                                }
        
                            }                             
                            else{
                                
                                header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$projID);
                            }


                    // --- SUMMARY ---
                    } elseif($_GET['A2']=="summary"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                if(isset($_GET['confirm'])){
                                    summary($twig,$is_connected,$_SESSION['projID'],$_GET['confirm']);
                                } else {
                                    summary($twig,$is_connected,$_SESSION['projID']);
                                }
                            }
                            else { 
                                header('Location: ?A='.$_GET['A'].'&A2=project_cb');
                            }
                        }
                        else {
                            header('Location: ?A='.$_GET['A'].'&A2=project_cb');
                        }
                        
                    }elseif($_GET['A2']=="summary_inputed"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                if(isset($_POST)){
                                    summary_inputed($twig,$is_connected,$_SESSION['projID'], $_POST, $_GET['A']);
                                }else{
                                    header('Location: ?A='.$_GET['A'].'&A2=summary&projID='.$_SESSION['projID']);
                                }
                            }
                            else { 
                                header('Location: ?A='.$_GET['A'].'&A2=project_cb');
                            }
                        }
                        else {
                            header('Location: ?A='.$_GET['A'].'&A2=project_cb');
                        }
                        
                    } else {
                        header('Location: ?A='.$_GET['A']);
                    }
                } else {  
                    cost_benefits($twig,$is_connected);
                }
            
                if(isSup()){
                    prereq_navbar("input");
                }
            } 

            // ---------- BUSINESS MODEL ----------
            elseif($_GET['A']=='business_model'){
                verifIsDev();
                if(isset($_GET['A2'])){
                    if($_GET['A2']=="project"){
                        project_bm($twig,$is_connected);
                    // --- SELECTED PROJECT ---
                    } elseif($_GET['A2']=="proj_selected"){
                        if(isset($_POST['radio_proj'])){
                            $projID = intval($_POST['radio_proj']);
                            $_SESSION['projID']=$projID;
                            header('Location: ?A=business_model&A2=bm&projID='.$projID);
                        }
                    } elseif($_GET['A2']=="pref"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                pref($twig,$is_connected,$_SESSION['projID']);
                            }
                            else { 
                                header('Location: ?A=business_model&A2=project');
                            }
                        }
                        else {
                            header('Location: ?A=business_model&A2=project');
                        }
                    } elseif($_GET['A2']=="pref_selected"){
                        pref_selected($_POST);
                    } elseif($_GET['A2']=="reco"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                reco($twig,$is_connected,$_SESSION['projID']);
                            }
                            else { 
                                header('Location: ?A=business_model&A2=project');
                            }
                        }
                        else {
                            header('Location: ?A=business_model&A2=project');
                        }
                    } elseif($_GET['A2']=="bm"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                business_model_interactive($twig,$is_connected,$_SESSION['projID']);
                            }
                            else { 
                                header('Location: ?A=business_model&A2=project');
                            }
                        }
                        else {
                            header('Location: ?A=business_model&A2=project');
                        }
                    } else {
                        header('Location: ?A='.$_GET['A']);
                    }
                } else {  
                    business_model($twig,$is_connected);  
                }         
            }


            // ---------- FUNDING ----------
            elseif($_GET['A']=='funding'){
                verifIsDev();
                if(isset($_GET['A2'])){
                    if($_GET['A2']=="scenario"){
                        if(isset($_GET['isTaken']) && $_GET['isTaken']){
                            scenario($twig,$is_connected,true);
                        } else {
                            scenario($twig,$is_connected);
                        }
                    // --- SELECTED SCENARIO ---
                    } elseif($_GET['A2']=="scen_selected"){
                        if(isset($_POST['radio_scen'])){
                            $scenID = intval($_POST['radio_scen']);
                            $_SESSION['scenID']=$scenID;
                            header('Location: ?A=funding&A2=work_cap_req&scenID='.$scenID);
                        }
                    } elseif($_GET['A2']=="create_scen"){
                        create_scen($twig,$is_connected,$_POST);
                    }
                    elseif($_GET['A2']=="delete_scen"){
                        if(isset($_GET['id'])){
                            delete_scen($_GET['id']);
                        }
                        else {
                            header('Location: ?A=funding&A2=scenario');
                        }
                    } elseif($_GET['A2']=="work_cap_req"){
                        if(isset($_GET['scenID'])){
                            if($_GET['scenID']!=0){
                                work_cap_req($twig,$is_connected,$_GET['scenID']);
                            }
                            else { 
                                header('Location: ?A=funding&A2=scenario');
                            }
                        }
                        else {
                            header('Location: ?A=funding&A2=scenario');
                        }
                    } elseif($_GET['A2']=="wcr_input"){
                        wcr_input($_POST);
                    } elseif($_GET['A2']=="funding_sources"){
                        if(isset($_GET['scenID'])){
                            if($_GET['scenID']!=0){
                                if(isset($_GET['A3'])){
                                    if($_GET['A3']=="input_entities"){
                                        input_entities($twig,$is_connected,$_GET['scenID']);
                                    } else {
                                        header('Location: ?A=funding&A2=funding_sources&scenID='.$_GET['scenID']);
                                    }
                                } else {
                                    funding_sources($twig,$is_connected,$_GET['scenID']);
                                }
                            }
                            else { 
                                header('Location: ?A=funding&A2=scenario');
                            }
                        }
                        else {
                            header('Location: ?A=funding&A2=scenario');
                        }
                    } elseif($_GET['A2']=="create_entity"){
                        create_entity($_POST);
                    } elseif($_GET['A2']=="delete_entity"){
                        delete_entity($_POST);
                    } elseif($_GET['A2']=="fs_selected"){
                        fs_selected($_POST);
                    } elseif($_GET['A2']=="entities_inputed"){
                        entities_inputed($_POST);

                    } elseif($_GET['A2']=="benef"){
                        if(isset($_GET['scenID'])){
                            if($_GET['scenID']!=0){
                                benef($twig,$is_connected,$_GET['scenID']);
                            }
                            else { 
                                header('Location: ?A=funding&A2=scenario');
                            }
                        }
                        else {
                            header('Location: ?A=funding&A2=scenario');
                        }
                    } elseif($_GET['A2']=="create_benef"){
                        create_benef($_POST);
                    } elseif($_GET['A2']=="delete_benef"){
                        delete_benef($_POST);
                    } elseif($_GET['A2']=="benef_selected"){
                        benef_selected($_POST);
                    } else {
                        header('Location: ?A='.$_GET['A']);
                    }
                } else {  
                    funding($twig,$is_connected); 
                }            
            }

            // ---------- SCENARIO SETTINGS ----------


            // ---------- DASHBOARDS ----------
            elseif($_GET['A']=='dashboards'){
                verifIsDev();
                if(isset($_GET['A2'])){
                    if($_GET['A2']=="project"){
                        \general\project($twig,$is_connected, "?A=dashboards&A2=proj_selected",'dashboards');
                    // --- SELECTED PROJECT ---
                    }elseif($_GET['A2']=="create_proj"){
                        if(isset($_POST)){
                            \general\create_proj($_POST,$_GET['A'], "project" );
                        }
                        else{
                            
                            header('Location: ?A='.$_GET['A'].'=&A2=project');
                        }
                    }elseif($_GET['A2']=="delete_proj"){
                        if(isset($_GET['id'])){
                            \general\delete_proj($_GET['id'], $_GET['A'], "project");
                        }
                        else {
                            header('Location: ?A='.$_GET['A'].'&A2=project');
                        }
                    } elseif($_GET['A2']=="proj_selected"){
                        if(isset($_POST['radio_proj'])){
                            $projID = intval($_POST['radio_proj']);
                            $_SESSION['projID']=$projID;
                            header('Location: ?A=dashboards&A2=global_dashboard&projID='.$projID);
                        }
                    } elseif($_GET['A2']=="cost_benefits_uc"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                if(isset($_GET['A3'])){
                                    if($_GET['A3']=="output"){
                                        cbuc_output($twig,$is_connected,$_SESSION['projID'],$_POST);
                                    } else {
                                        header('Location: ?A=dashboards&A2=cost_benefits_uc&projID='.$_SESSION['projID']);
                                    }
                                } else {
                                    cost_benefits_uc($twig,$is_connected,$_SESSION['projID']);
                                }
                            }
                            else { 
                                header('Location: ?A=dashboards&A2=project');
                            }
                        }
                        else {
                            header('Location: ?A=dashboards&A2=project');
                        }
                    } elseif($_GET['A2']=="cost_benefits_all"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                cost_benefits_all($twig,$is_connected,$_SESSION['projID']);
                            }
                            else { 
                                header('Location: ?A=dashboards&A2=project');
                            }
                        }
                        else {
                            header('Location: ?A=dashboards&A2=project');
                        }
                    } elseif($_GET['A2']=="cost_benefits"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                cb_output_v2($twig,$is_connected,$_SESSION['projID']);
                            }
                            else { 
                                header('Location: ?A=dashboards&A2=project');
                            }
                        }
                        else {
                            header('Location: ?A=dashboards&A2=project');
                        }
                    }  elseif($_GET['A2']=="budget"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                budget_output($twig,$is_connected,$_SESSION['projID']);
                            }
                            else { 
                                header('Location: ?A=dashboards&A2=project');
                            }
                        }
                        else {
                            header('Location: ?A=dashboards&A2=project');
                        }                    
                    } elseif($_GET['A2']=="budget_uc"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                if(isset($_GET['A3'])){
                                    if($_GET['A3']=="output"){
                                        budget_uc_output($twig,$is_connected,$_SESSION['projID'],$_POST);
                                    } else {
                                        header('Location: ?A=dashboards&A2=budget_uc&projID='.$_SESSION['projID']);
                                    }
                                } else {
                                    budget_uc($twig,$is_connected,$_SESSION['projID']);
                                }
                            }
                            else { 
                                header('Location: ?A=dashboards&A2=project');
                            }
                        }
                        else {
                            header('Location: ?A=dashboards&A2=project');
                        }
                    } elseif($_GET['A2']=="budget_all"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                budget_all($twig,$is_connected,$_SESSION['projID']);
                            }
                            else { 
                                header('Location: ?A=dashboards&A2=project');
                            }
                        }
                        else {
                            header('Location: ?A=dashboards&A2=project');
                        }                    
                    } elseif($_GET['A2']=="bankability_input") {
                        bankability_input_nogo_target($_POST);                    
                    } elseif($_GET['A2']=="bankability"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                    bankability_new($twig,$is_connected,$_SESSION['projID']);
                            }
                            else { 
                                header('Location: ?A=dashboards&A2=project');
                            }
                        }
                        else {
                            header('Location: ?A=dashboards&A2=project');
                        }
                    } elseif($_GET['A2']=="project_dashboard"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                project_dashboard($twig,$is_connected,$_SESSION['projID']);
                            }
                            else { 
                                header('Location: ?A=dashboards&A2=project');
                            }
                        }
                        else {
                            header('Location: ?A=dashboards&A2=project');
                        }   
                    } elseif($_GET['A2']=="global_dashboard"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                global_dashboard($twig,$is_connected,$_SESSION['projID']);
                            }
                            else { 
                                header('Location: ?A=dashboards&A2=project');
                            }
                        }
                        else {
                            header('Location: ?A=dashboards&A2=project');
                        }   
                    } elseif($_GET['A2']=="financing"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                if(isset($_GET['A3'])){
                                    if($_GET['A3']=="output"){
                                        financing_general($twig,$is_connected,$_SESSION['projID'],$_POST);
                                /*    } elseif($_GET['A3']=="output2"){
                                        financing_out_5($twig,$is_connected,$_SESSION['projID'],$_POST);
                                    } elseif($_GET['A3']=="output3"){
                                        financing_out_3($twig,$is_connected,$_SESSION['projID'],$_POST);
                                    } elseif($_GET['A3']=="output4"){
                                        financing_out_4($twig,$is_connected,$_SESSION['projID'],$_POST); */
                                    } else {
                                        header('Location: ?A=dashboards&A2=financing&projID='.$_SESSION['projID']);
                                    }
                                } else {
                                    financing_out($twig,$is_connected,$_SESSION['projID']);
                                }
                            }
                            else { 
                                header('Location: ?A=dashboards&A2=project');
                            }
                        }
                        else {
                            header('Location: ?A=dashboards&A2=project');
                        }
                    } else {
                        header('Location: ?A='.$_GET['A']);
                    }
                } else { 
                    dashboards($twig,$is_connected);
                }              
            }
            // ---------- COMPARISON ----------
            elseif($_GET['A']=='comparison'){  
                verifIsDev(); 
                comparison($twig,$is_connected);  
            }
            elseif($_GET['A']=='comp_projects' && isset($_GET['side'])){ 
                //verifIsDev();
                if(isset($_GET['A2'])){
                    if($_GET['A2']=="projects"){
                        projects($twig,$is_connected, $_GET['side']);
                    } elseif($_GET['A2']=="projects_selected"){
                        projects_selected($_POST, $_GET['side']);
                    } elseif($_GET['A2']=="summary"){
                        projects_summary($twig,$is_connected, $_GET['side']);
                    } elseif(($_GET['A2']=="invest" || $_GET['A2']=="finsoc_comp" || $_GET['A2']=="cash_flows" || $_GET['A2']=="non_quant" || $_GET['A2']=="op")){
                        comparisonCategoriePage($twig,$is_connected, $_GET['A2'], $_GET['side']);
                        //investment($twig,$is_connected);
                    } /*elseif($_GET['A2']=="op"){
                        comparisonCategoriePage($twig,$is_connected, $_GET['A2']);
                        //operations($twig,$is_connected);
                    } elseif($_GET['A2']=="cash_flows"){
                        cash_flows($twig,$is_connected);
                    } elseif($_GET['A2']=="non_quant"){
                        non_quant($twig,$is_connected);
                    } elseif($_GET['A2']=="finsoc_comp"){
                        finsoc_comp($twig,$is_connected);
                    } */else {
                        header('Location: ?A='.$_GET['A']);
                    }
                } else {
                    comp_projects($twig,$is_connected); 
                }  
                prereq_navbar("comparison");
        
            }
            elseif($_GET['A']=='comp_finscen'){ 
                verifIsDev();
                if(isset($_GET['A2'])){
                    if($_GET['A2']=="scenarios"){
                        scenarios($twig,$is_connected);
                    } elseif($_GET['A2']=="scenarios_selected"){
                        scenarios_selected($_POST);
                    } elseif($_GET['A2']=="fin_summary"){
                        fin_summary($twig,$is_connected);
                    } elseif($_GET['A2']=="cash_flows"){
                        cash_flows_comp($twig,$is_connected);
                    } else {
                        header('Location: ?A='.$_GET['A']);
                    }
                } else {
                    comp_finscen($twig,$is_connected); 
                }          
            }
            // ---------- DEVISES ----------
            elseif($_GET['A']=='setDevise'){
                if(isset($_GET['id'])){
                    $lastURL = isset($_GET['lastURL']) ? $_GET['lastURL'] : "?A,home";
                    setDevise(intval($_GET['id']),$lastURL);
                } else {
                    header('Location: ?A=home');
                }
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


