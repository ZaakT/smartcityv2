<?php
session_start();
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

$twig->addGlobal('userRole', getUserRole());
$twig->addGlobal('isDev', isDev());
$twig->addGlobal('isSup', isSup());

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
                            } elseif($_GET['A3']=="delete_user"){
                                if(isset($_GET['id'])){
                                    delete_user($_GET['id']);
                                } else {
                                    header('Location: ?A=admin&A2=manage_db&A3=manage_users');
                                }

                            } else if($_GET['A3']=='manage_currency'){
                                manage_currency($twig,$is_connected); 
                            } elseif($_GET['A3']=='change_rate'){
                                change_currency_rate($twig,$is_connected,$_POST);
                            } else if($_GET['A3']=='manage_measures'){
                                manage_measures($twig,$is_connected); 
                            } elseif($_GET['A3']=='create_measure'){
                                create_measure($twig,$is_connected,$_POST);
                            } elseif($_GET['A3']=="delete_measure"){
                                if(isset($_GET['id'])){
                                    delete_measure($_GET['id']);
                                } else {
                                    header('Location: ?A=admin&A2=manage_db&A3=manage_measures');
                                }

                            } else if($_GET['A3']=='manage_uc_cat'){
                                manage_uc_cat($twig,$is_connected); 
                            } elseif($_GET['A3']=='create_uc_category'){
                                create_uc_category($twig,$is_connected,$_POST);
                            } elseif($_GET['A3']=="delete_uc_category"){
                                if(isset($_GET['id'])){
                                    delete_uc_category($_GET['id']);
                                } else {
                                    header('Location: ?A=admin&A2=manage_db&A3=manage_uc_cat');
                                }

                            } else if($_GET['A3']=='manage_usecases'){
                                manage_usecases($twig,$is_connected);
                            } elseif($_GET['A3']=='create_usecase'){
                                create_usecase($twig,$is_connected,$_POST);
                            } elseif($_GET['A3']=="delete_usecase"){
                                if(isset($_GET['id'])){
                                    delete_usecase($_GET['id']);
                                } else {
                                    header('Location: ?A=admin&A2=manage_db&A3=manage_usecases');
                                }


                            } else if($_GET['A3']=='manage_crit_cat'){
                                manage_crit_cat($twig,$is_connected); 
                            } elseif($_GET['A3']=='create_crit_category'){
                                create_crit_category($twig,$is_connected,$_POST);
                            } elseif($_GET['A3']=="delete_crit_category"){
                                if(isset($_GET['id'])){
                                    delete_crit_category($_GET['id']);
                                } else {
                                    header('Location: ?A=admin&A2=manage_db&A3=manage_crit_cat');
                                }

                            } else if($_GET['A3']=='manage_criteria'){
                                manage_criteria($twig,$is_connected); 
                            } elseif($_GET['A3']=='create_crit'){
                                create_crit($twig,$is_connected,$_POST);
                            } elseif($_GET['A3']=="delete_crit"){
                                if(isset($_GET['id'])){
                                    delete_crit($_GET['id']);
                                } else {
                                    header('Location: ?A=admin&A2=manage_db&A3=manage_criteria');
                                }

                            } else if($_GET['A3']=='manage_dlt'){
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

                            } else if($_GET['A3']=='manage_capex_item'){
                                manage_item('capex',$twig,$is_connected); 
                            } else if($_GET['A3']=='manage_opex_item'){
                                manage_item('opex',$twig,$is_connected); 
                            } else if($_GET['A3']=='manage_implem_item'){
                                manage_item('implem',$twig,$is_connected); 
                            } else if($_GET['A3']=='manage_revenues_item'){
                                manage_item('revenues',$twig,$is_connected); 
                            } elseif($_GET['A3']=='create_item_1'){
                                if(isset($_GET['cat'])){
                                    create_item1($twig,$is_connected,$_POST,$_GET['cat']);
                                } else {
                                    header('Location: ?A=admin&A2=manage_db');
                                }
                            } else if($_GET['A3']=='manage_cashreleasing_item'){
                                manage_item('cashreleasing',$twig,$is_connected); 
                            } else if($_GET['A3']=='manage_widercash_item'){
                                manage_item('widercash',$twig,$is_connected); 
                            } elseif($_GET['A3']=='create_item_2'){
                                if(isset($_GET['cat'])){
                                    create_item2($twig,$is_connected,$_POST,$_GET['cat']);
                                } else {
                                    header('Location: ?A=admin&A2=manage_db');
                                }
                            } else if($_GET['A3']=='manage_quantifiable_item'){
                                manage_item('quantifiable',$twig,$is_connected); 
                            } elseif($_GET['A3']=='create_quantifiable_item'){
                                create_quantifiable_item($twig,$is_connected,$_POST);
                            } else if($_GET['A3']=='manage_noncash_item'){
                                manage_item('noncash',$twig,$is_connected); 
                            } else if($_GET['A3']=='manage_risks_item'){
                                manage_item('risks',$twig,$is_connected); 
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
            // ---------- PROJECT DESIGN ---------- 
            elseif($_GET['A']=='project_design'){
                verifIsDev();
                /* var_dump($_POST); */
                // ??? IN THE CASE WHERE AN ACTION2 (A2) IS GIVEN ???
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
                    // --- SELECTED MEASURE ---
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
                        //var_dump("list_critID :");
                        //var_dump($list_critID);
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
                        //var_dump($list_idDLT);
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
            // ---------- PROJECT SDESIGN ----------
            elseif($_GET['A']=='project_sdesign'){
                verifIsSup();
                if(isset($_GET['A2'])){
                    if($_GET['A2']=="project"){
                        \general\project($twig,$is_connected,'?A=project_sdesign&A2=proj_selected','project_sdesign');
                    }
                    elseif($_GET['A2']=="proj_selected"){
                        if(isset($_POST['radio_proj'])){
                            $projID = intval($_POST['radio_proj']);
                            $_SESSION['projID']=$projID;
                            //var_dump($projID);
                            header('Location: ?A=project_sdesign&A2=scope1&projID='.$projID);
                        }
                    }
                    // --- SELECTED USE CASES MENU ---
                    elseif($_GET['A2']=="ucm_selected"){
                        if(isset($_POST['radio_ucm'])){
                            $ucmID = intval($_POST['radio_ucm']);
                            $_SESSION['ucmID']=$ucmID;
                            //var_dump($ucmID);
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
                    }
                    elseif($_GET['A2']=="scope1"){
                        if(isset($_GET['projID'])){
                            if($_GET['projID']!=0){
                                scope1($twig,$is_connected,$_GET['projID']);
                            }
                            else {
                                header('Location: ?A=project_sdesign&A2=scope1');
                            }
                        }
                        else {
                            scope1($twig,$is_connected);
                        }
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
                        create_proj($_POST);
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
                            //var_dump($projID);
                            header('Location: ?A=project_scoping&A2=scope&projID='.$projID);
                        }
                    }
                    elseif($_GET['A2']=="scope"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                scope($twig,$is_connected,$_SESSION['projID']);
                            }
                            else {
                                header('Location: ?A=project_scoping&A2=scope');
                            }
                        }
                        else {
                            scope($twig,$is_connected);
                        }
                    // --- SELECTED SCOPE ---
                    } elseif($_GET['A2']=="scope_selected"){
                        //var_dump($_POST);
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
                        //var_dump($_POST);
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
                        //var_dump($_POST);
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
                        //var_dump($_POST);
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
                        //var_dump($_POST);
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
                        //var_dump($_POST);
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
                    } elseif($_GET['A2']=="proj_selected"){
                        if(isset($_POST['radio_proj'])){
                            $projID = intval($_POST['radio_proj']);
                            $_SESSION['projID']=$projID;
                            header('Location: ?A=input_project_common_supplier&A2=use_case_selection&projID='.$projID);
                        }
                    } elseif(isset($_SESSION['projID']) and $_SESSION['projID']!=0){
                        //Le projet est choisi
                        if($_GET['A2']=="use_case_selection"){
                            \general\use_case_selection($twig,$is_connected,'?A=input_project_common_supplier&A2=use_case_selected&projID='.$_SESSION['projID'],'input_project_common_supplier',$_SESSION['projID']);                        
                        } elseif($_GET['A2']=="use_case_selected"){
                            if(isset($_POST['radio_uc'])){
                                //var_dump($_POST);
                                $ucID = intval($_POST['radio_uc']);
                                $_SESSION['ucID']=$ucID;
                                //var_dump($ucID);
                                header('Location: ?A='.$_GET['A'].'&A2=schedule&A3=selection&projID='.$_SESSION['projID'].'&ucID='.$ucID);
                            }
                            else {
                                header('Location: ?A='.$_GET['A'].'&A2=use_case_selection');
                            }
                        } elseif(isset($_GET['ucID']) and $_GET['ucID']!=0){ 
                            //Le use case est choisi
                            if($_GET['A2']=="schedule") {
                                supplier_schedule($twig,$is_connected,$_SESSION['projID'], $_GET['ucID']); 
                            }  // --- CAPEX OR OPEX (XPEX) ---
                            else if($_GET['A2']=="capex" or $_GET['A2']=="opex" or $_GET['A2']=="deployment_costs"){
                                if(isset($_GET['A3'])){
                                    if($_GET['A3']=="selection"){
                                        xpex_selection($twig,$is_connected,$_SESSION['projID'], $_GET['ucID'],$_GET['A'], $_GET['A2']); 
                                    }elseif($_GET['A3']=="selected"){
                                        xpex_selected($twig,$is_connected, $_POST,  $_GET['A2'], $_GET['A']); 
                                    }elseif($_GET['A3']=="create_xpex"){
                                        create_xpex($twig,$is_connected, $_POST,  $_GET['A2'], $_GET['A']); 
                                    }elseif($_GET['A3']=="delete_xpex"){
                                        if(isset($_GET['id'])){
                                            delete_xpex_user($_GET['id'],$_GET['A2'], $_GET['A']); 
                                        }else{
                                            header('Location: ?A='.$_GET['A'].'&A2='.$_GET['A2'].'&projID='.$_SESSION['projID'].'&ucID='.$_GET['ucID']);
                                        }
                                        
                                    }elseif($_GET['A3']=="inputed"){
                                        if(isset($_POST)){
                                            xpex_inputed($_POST, $_GET['A']);
                                        }
                                        else{
                                            header('Location: ?A='.$_GET['A'].'&A2='.$_GET['A2'].'&projID='.$_SESSION['projID'].'&ucID='.$_GET['ucID']);
                                        }
                                    }
                                }else {
                                    xpex_selection($twig,$is_connected,$_SESSION['projID'], $_GET['ucID'],$_GET['A'], $_GET['A2']);
                                }

                            }                             
                            else{  
                                header('Location: ?A=input_project_common_supplier&A2=use_case_selection&projID='.$projID);
                            }
                        }  
                    }  
                } else {  
                    \general\commonPage($twig,$is_connected, "?A=input_project_common_supplier&A2=project_selection", "input_project_common_supplier");
                }
            }

            // ---------- Input Project Common CUSTOMER ----------
            elseif($_GET['A']=='input_project_common'){
                verifIsSup();
                if(isset($_GET['A2'])){
                    if($_GET['A2']=='project_selection'){
                        \general\project($twig,$is_connected, '?A=input_project_common&A2=proj_selected',  'input_project_common');
                        //project_ipc($twig,$is_connected);

                    // --- SELECTED PROJECT ---
                    } elseif($_GET['A2']=="proj_selected"){
                        if(isset($_POST['radio_proj'])){
                            $projID = intval($_POST['radio_proj']);
                            $_SESSION['projID']=$projID;
                            header('Location: ?A=input_project_common&A2=use_case_selection&projID='.$projID);
                        }
                    
                    }elseif(isset($_SESSION['projID']) and $_SESSION['projID']!=0){
                        // --- USE CASE SELECTION ---
                        if($_GET['A2']=="use_case_selection"){
                                \general\use_case_selection($twig,$is_connected,'?A=input_project_common&A2=use_case_selected&projID='.$_SESSION['projID'],'input_project_common',$_SESSION['projID']);                        
                        } elseif($_GET['A2']=="use_case_selected"){
                            if(isset($_POST['radio_uc'])){
                                //var_dump($_POST);
                                $ucID = intval($_POST['radio_uc']);
                                $_SESSION['ucID']=$ucID;
                                //var_dump($ucID);
                                header('Location: ?A='.$_GET['A'].'&A2=capex&A3=selection&projID='.$_SESSION['projID'].'&ucID='.$ucID);
                            }
                            else {
                                header('Location: ?A='.$_GET['A'].'&A2=use_case_selection');
                            }
                        } elseif(isset($_GET['ucID']) and $_GET['ucID']!=0){
                            // --- CAPEX OR OPEX OR DEPLOYMENT COST  (XPEX) ---
                            if($_GET['A2']=="capex" or $_GET['A2']=="opex" or $_GET['A2']=="deployment_costs"){
                                if(isset($_GET['A3'])){
                                    if($_GET['A3']=="selection"){
                                        xpex_selection($twig,$is_connected,$_SESSION['projID'], $_GET['ucID'],$_GET['A'], $_GET['A2']); 
                                    }elseif($_GET['A3']=="selected"){
                                        xpex_selected($twig,$is_connected, $_POST,  $_GET['A2'], $_GET['A']); 
                                    }elseif($_GET['A3']=="create_xpex"){
                                        create_xpex($twig,$is_connected, $_POST,  $_GET['A2'], $_GET['A']); 
                                    }elseif($_GET['A3']=="delete_xpex"){
                                        if(isset($_GET['id'])){
                                            delete_xpex_user($_GET['id'],$_GET['A2'], $_GET['A']); 
                                        }else{
                                            header('Location: ?A='.$_GET['A'].'&A2='.$_GET['A2'].'&projID='.$_SESSION['projID'].'&ucID='.$_GET['ucID']);
                                        }
                                        
                                    }elseif($_GET['A3']=="inputed"){
                                        if(isset($_POST)){
                                            xpex_inputed($_POST, $_GET['A']);
                                        }
                                        else{
                                            header('Location: ?A='.$_GET['A'].'&A2='.$_GET['A2'].'&projID='.$_SESSION['projID'].'&ucID='.$_GET['ucID']);
                                        }
                                    }
                                }else {
                                    xpex_selection($twig,$is_connected,$_SESSION['projID'], $_GET['ucID'],$_GET['A'], $_GET['A2']);
                                }

                            }                             
                            else{  
                                header('Location: ?A=input_project_common&A2=use_case_selection&projID='.$projID);
                            }
                        }

                            
                    } else {
                        header('Location: ?A=input_project_common&A2=project_selection');
                    }

                } else {  
                    //input_project_common($twig,$is_connected);
                    \general\commonPage($twig,$is_connected, "?A=input_project_common&A2=project_selection", "input_project_common");
                }
            }

            // ---------- Deal Criteria ----------
            elseif($_GET['A']=='deal_criteria'){
                verifIsSup();
                if(isset($_GET['A3']) and ($_GET['A3']=="" or $_GET['A3']=="supplier" or $_GET['A3']=="customer")){
                    if(isset($_GET['A2'])){
                        if($_GET['A2']=='project_selection'){
                            \general\project($twig,$is_connected, '?A=deal_criteria&A2=proj_selected&A3='.$_GET['A3'], 'deal_criteria_'.$_GET['A3']);
                        // --- SELECTED PROJECT ---
                        } elseif($_GET['A2']=="proj_selected"){
                            if(isset($_POST['radio_proj'])){
                                $projID = intval($_POST['radio_proj']);
                                $_SESSION['projID']=$projID;
                                header('Location: ?A=deal_criteria&A2=deal_criteria&projID='.$projID.'&A3='.$_GET['A3']);
                            }
                        // --- DEAL CRiTERIA ---
                        } elseif($_GET['A2']=="deal_criteria"){
                            if(isset($_SESSION['projID'])){
                                deal_criteria($twig,$is_connected, $_SESSION['projID'], $_GET['A3']);
                            }else{
                                header('Location: ?A=deal_criteria&A2project_selection&A3='.$_GET['A3']);
                            }
                            
                        } else if($_GET['A2']=="deal_criteria_input") {
                            deal_criteria_input_nogo_target($_POST, $_GET['A3']);
                        }
                    } else {  
                        \general\commonPage($twig,$is_connected, '?A=deal_criteria&A2=project_selection&A3='.$_GET['A3'], 'deal_criteria_'.$_GET['A3']);
                    }
                }else{
                    header('Location: ?A=home');
                }
                
            }
            // ---------- Dashborads ----------
            elseif($_GET['A']=='customer_dashboards'){
                verifIsSup();
                if(isset($_GET['A2'])){
                    if($_GET['A2']=='project_selection'){
                        \general\project($twig,$is_connected, '?A=customer_dashboards&A2=proj_selected', 'customer_dashboards');
                    } elseif($_GET['A2']=="proj_selected"){
                        if(isset($_POST['radio_proj'])){
                            $projID = intval($_POST['radio_proj']);
                            $_SESSION['projID']=$projID;
                            header('Location: ?A=customer_dashboards&A2=summary&projID='.$projID);
                        }
                    }elseif($_GET['A2']=="summary"){
                        if(isset($_SESSION['projID'])&&$_SESSION['projID']!=0){
                            dashboards_summary($twig,$is_connected, $_SESSION['projID']);
                        }else{
                            header('Location: ?A=customer_dashboards&A2project_selection');
                        }
                    }elseif($_GET['A2']=="project_details"){
                        if(isset($_SESSION['projID'])&&$_SESSION['projID']!=0){
                            dashboards_project_details($twig,$is_connected, $_SESSION['projID']);
                        }else{
                            header('Location: ?A=customer_dashboards&A2project_selection');
                        }
                    }elseif($_GET['A2']=="use_case_details"){
                        if(isset($_SESSION['projID'])&&$_SESSION['projID']!=0){
                            dashboards_use_case_details($twig,$is_connected, $_SESSION['projID']);
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
                    \general\commonPage($twig,$is_connected, '?A=customer_dashboards&A2=project_selection', 'customer_dashboards');

                }
            }

            elseif($_GET['A']=='supplier_dashboards'){
                verifIsSup();
                if(isset($_GET['A2'])){
                    if($_GET['A2']=='project_selection'){
                        \general\project($twig,$is_connected, '?A=supplier_dashboards&A2=proj_selected', 'supplier_dashboards');
                    } elseif($_GET['A2']=="proj_selected"){
                        if(isset($_POST['radio_proj'])){
                            $projID = intval($_POST['radio_proj']);
                            $_SESSION['projID']=$projID;
                            header('Location: ?A=supplier_dashboards&A2=summary&projID='.$projID);
                        }
                    }elseif($_GET['A2']=="summary"){
                        if(isset($_SESSION['projID'])&&$_SESSION['projID']!=0){
                            dashboards_summary($twig,$is_connected, $_SESSION['projID']);
                        }else{
                            header('Location: ?A=supplier_dashboards&A2project_selection');
                        }
                    }elseif($_GET['A2']=="project_details"){
                        if(isset($_SESSION['projID'])&&$_SESSION['projID']!=0){
                            dashboards_project_details($twig,$is_connected, $_SESSION['projID']);
                        }else{
                            header('Location: ?A=supplier_dashboards&A2project_selection');
                        }
                    }elseif($_GET['A2']=="use_case_details"){
                        if(isset($_SESSION['projID'])&&$_SESSION['projID']!=0){
                            dashboards_use_case_details($twig,$is_connected, $_SESSION['projID']);
                        }else{
                            header('Location: ?A=supplier_dashboards&A2project_selection');
                        }
                    }
                } else{
                    \general\commonPage($twig,$is_connected, '?A=supplier_dashboards&A2=project_selection', 'supplier_dashboards');
                }
            }

            // ---------- INPUT USE CASE (SUPPLIER !!) ----------
            elseif($_GET['A']=='input_use_case_supplier') {
                if(isset($_GET['A2'])) { 
                    if($_GET['A2']=="project_selection"){
                        \general\project($twig,$is_connected, "?A=".$_GET['A']."&A2=proj_selected", "input_use_case_supplier");
                    // --- SELECTED PROJECT ---
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
                                    $ucID = intval($_POST['radio_uc']);
                                    $_SESSION['ucID']=$ucID;
                                    header('Location: ?A='.$_GET['A'].'&A2=schedule&projID='.$_SESSION['projID'].'&ucID='.$ucID);
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
                        use_case_schedule($twig,$is_connected, $_GET['projID'], $_GET['ucID']);
                    } elseif($_GET['A2']=="equipment_revenues"){
                        use_case_equipment($twig,$is_connected, $_GET['projID'], $_GET['ucID']);
                    } elseif($_GET['A2']=="deployment_revenues"){
                        use_case_deployment($twig,$is_connected, $_GET['projID'], $_GET['ucID']);
                    } elseif($_GET['A2']=="operating_revenues"){
                        use_case_operating($twig,$is_connected, $_GET['projID'], $_GET['ucID']);
                    } 
                } else {
                    input_use_case_supplier($twig,$is_connected);
                }
            }

            // ---------- COST BENEFITS ----------
            elseif($_GET['A']=='cost_benefits' or $_GET['A']=='input_use_case'){
                //Available for Dev AND sup, do NOT use verifIsSup(); or verifIsDev();
                if(isset($_GET['A2'])){
                    if($_GET['A2']=="project_cb"){
                        //project_cb($twig,$is_connected);
                        \general\project($twig,$is_connected, "?A=".$_GET['A']."&A2=proj_selected", "cost_benefits");
                    // --- SELECTED PROJECT ---
                    } elseif($_GET['A2']=="proj_selected"){
                        if(isset($_POST['radio_proj'])){
                            $projID = intval($_POST['radio_proj']);
                            $_SESSION['projID']=$projID;
                            //var_dump($projID);
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
                                    //var_dump($_POST);
                                    $ucID = intval($_POST['radio_uc']);
                                    $_SESSION['ucID']=$ucID;
                                    //var_dump($ucID);
                                    header('Location: ?A='.$_GET['A'].'&A2=capex&projID='.$_SESSION['projID'].'&ucID='.$ucID);
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
                    }elseif(isSup() and ( $_GET['A2']=="capex" or $_GET['A2']=="opex" or $_GET['A2']=="deployment_costs")){
                        if(isset($_GET['ucID']) and $_GET['ucID']!=0 and isset($_SESSION['projID']) and $_SESSION['projID']!=0){
                                if(isset($_GET['A3'])){
                                    if($_GET['A3']=="selection"){
                                        xpex_selection($twig,$is_connected,$_SESSION['projID'], $_GET['ucID'],$_GET['A'], $_GET['A2']); 
                                    }elseif($_GET['A3']=="selected"){
                                        xpex_selected($twig,$is_connected, $_POST,  $_GET['A2'], $_GET['A']); 
                                    }elseif($_GET['A3']=="create_xpex"){
                                        create_xpex($twig,$is_connected, $_POST,  $_GET['A2'], $_GET['A']); 
                                    }elseif($_GET['A3']=="delete_xpex"){
                                        if(isset($_GET['id'])){
                                            delete_xpex_user($_GET['id'],$_GET['A2'], $_GET['A']); 
                                        }else{
                                            header('Location: ?A='.$_GET['A'].'&A2='.$_GET['A2'].'&projID='.$_SESSION['projID'].'&ucID='.$_GET['ucID']);
                                        }
                                        
                                    }elseif($_GET['A3']=="inputed"){
                                        if(isset($_POST)){
                                            xpex_inputed($_POST, $_GET['A']);
                                        }
                                        else{
                                            header('Location: ?A='.$_GET['A'].'&A2='.$_GET['A2'].'&projID='.$_SESSION['projID'].'&ucID='.$_GET['ucID']);
                                        }
                                    }elseif($_GET['A3']=="delete_selection_xpex"){
                                        delete_selection_xpex($_SESSION['projID'],$_GET['ucID'],$_GET['A2'], $_GET['A'] );
                                    }
                                }else {
                                    xpex_selection($twig,$is_connected,$_SESSION['projID'], $_GET['ucID'],$_GET['A'], $_GET['A2']);
                                }
        
                            }                             
                            else{
                                
                                header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$projID);
                            }
                    }
                    // -*-*
                    elseif($_GET['A2']=="capex"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                if(isset($_GET['ucID'])){
                                    if($_GET['ucID']!=0){
                                        if(isset($_GET['A3'])){
                                            // --- CAPEX SELECTED ---
                                            if($_GET['A3']=="capex_selected"){
                                                capex_selected($twig,$is_connected,$_POST);
                                            }
                                            else {
                                                header('Location: ?A='.$_GET['A'].'&A2=capex&projID='.$_SESSION['projID'].'&ucID='.$ucID);
                                            }
                                        }
                                        else {
                                            if(isset($_GET['isTaken']) && $_GET['isTaken']){
                                                xpex_selection($twig,$is_connected,$_SESSION['projID'],$_GET['ucID'], 'cost_benefits', "capex", true);
                                                //capex($twig,$is_connected,$_SESSION['projID'],$_GET['ucID'],true);
                                            } else {
                                                xpex_selection($twig,$is_connected,$_SESSION['projID'],$_GET['ucID'], 'cost_benefits', "capex");
                                                //capex($twig,$is_connected,$_SESSION['projID'],$_GET['ucID']);
                                            }
                                        }
                                    }
                                    else {                                    
                                        header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                    }
                                } else {                                        
                                    header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                }
                            }
                            else { 
                                header('Location: ?A='.$_GET['A'].'&A2=project');
                            }
                        }
                        else {
                            capex($twig,$is_connected);
                        }
                    } elseif($_GET['A2']=="create_capex"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                if(isset($_GET['ucID'])){
                                    if($_GET['ucID']!=0){
                                        create_capex($twig,$is_connected,$_POST);
                                    } else {
                                        header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                    }
                                } else {
                                    header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                }
                            } else {
                                header('Location: ?A='.$_GET['A'].'&A2=project_cb');  
                            }    
                        } else {
                            header('Location: ?A='.$_GET['A'].'&A2=project_cb');
                        }
                    } elseif($_GET['A2']=="delete_capex"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                if(isset($_GET['ucID'])){
                                    if($_GET['ucID']!=0){
                                        if(isset($_GET['id'])){
                                            if($_GET['id']!=0){
                                                delete_capex_user($_GET['id']);
                                            }
                                            else {
                                                header('Location: ?A='.$_GET['A'].'&A2=capex&projID='.$projID.'&ucID='.$ucID);
                                            }
                                        }
                                        else {
                                            header('Location: ?A='.$_GET['A'].'&A2=capex&projID='.$projID.'&ucID='.$ucID);
                                        }
                                    } else {
                                        header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                    }
                                } else {
                                    header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                }
                            } else {
                                header('Location: ?A='.$_GET['A'].'&A2=project_cb');  
                            }    
                        } else {
                            header('Location: ?A='.$_GET['A'].'&A2=project_cb');
                        }
                    } elseif($_GET['A2']=="delete_selection_capex"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                if(isset($_GET['ucID'])){
                                    if($_GET['ucID']!=0){
                                        delete_selection_capex($_SESSION['projID'],$_GET['ucID']);
                                    } else {
                                        header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                    }
                                } else {
                                    header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                }
                            } else {
                                header('Location: ?A='.$_GET['A'].'&A2=project_cb');  
                            }    
                        } else {
                            header('Location: ?A='.$_GET['A'].'&A2=project_cb');
                        }
                    // --- INPUTED CAPEX ---
                    } elseif($_GET['A2']=="capex_inputed"){
                        //var_dump($_POST);
                        capex_inputed($_POST);

                    // --- IMPLEM ---
                    } elseif($_GET['A2']=="implem"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                if(isset($_GET['ucID'])){
                                    if($_GET['ucID']!=0){
                                        if(isset($_GET['A3'])){
                                            // --- IMPLEM SELECTED ---
                                            if($_GET['A3']=="implem_selected"){
                                                implem_selected($twig,$is_connected,$_POST);
                                            }
                                            else {
                                                header('Location: ?A='.$_GET['A'].'&A2=implem&projID='.$_SESSION['projID'].'&ucID='.$ucID);
                                            }
                                        }
                                        else {
                                            if(isset($_GET['isTaken']) && $_GET['isTaken']){
                                                implem($twig,$is_connected,$_SESSION['projID'],$_GET['ucID'],true);
                                            } else {
                                                implem($twig,$is_connected,$_SESSION['projID'],$_GET['ucID']);
                                            }
                                        }
                                    }
                                    else {                                    
                                        header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                    }
                                } else {                                        
                                    header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                }
                            }
                            else { 
                                header('Location: ?A='.$_GET['A'].'&A2=project');
                            }
                        }
                        else {
                            implem($twig,$is_connected);
                        }
                    } elseif($_GET['A2']=="create_implem"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                if(isset($_GET['ucID'])){
                                    if($_GET['ucID']!=0){
                                        create_implem($twig,$is_connected,$_POST);
                                    } else {
                                        header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                    }
                                } else {
                                    header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                }
                            } else {
                                header('Location: ?A='.$_GET['A'].'&A2=project_cb');  
                            }    
                        } else {
                            header('Location: ?A='.$_GET['A'].'&A2=project_cb');
                        }
                    } elseif($_GET['A2']=="delete_implem"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                if(isset($_GET['ucID'])){
                                    if($_GET['ucID']!=0){
                                        if(isset($_GET['id'])){
                                            if($_GET['id']!=0){
                                                delete_implem_user($_GET['id']);
                                            }
                                            else {
                                                header('Location: ?A='.$_GET['A'].'&A2=implem&projID='.$projID.'&ucID='.$ucID);
                                            }
                                        }
                                        else {
                                            header('Location: ?A='.$_GET['A'].'&A2=implem&projID='.$projID.'&ucID='.$ucID);
                                        }
                                    } else {
                                        header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                    }
                                } else {
                                    header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                }
                            } else {
                                header('Location: ?A='.$_GET['A'].'&A2=project_cb');  
                            }    
                        } else {
                            header('Location: ?A='.$_GET['A'].'&A2=project_cb');
                        }
                    } elseif($_GET['A2']=="delete_selection_implem"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                if(isset($_GET['ucID'])){
                                    if($_GET['ucID']!=0){
                                        delete_selection_implem($_SESSION['projID'],$_GET['ucID']);
                                    } else {
                                        header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                    }
                                } else {
                                    header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                }
                            } else {
                                header('Location: ?A='.$_GET['A'].'&A2=project_cb');  
                            }    
                        } else {
                            header('Location: ?A='.$_GET['A'].'&A2=project_cb');
                        }
                    // --- INPUTED IMPLEM ---
                    } elseif($_GET['A2']=="implem_inputed"){
                        //var_dump($_POST);
                        implem_inputed($_POST);

                    // --- OPEX ---
                    } elseif($_GET['A2']=="opex"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                if(isset($_GET['ucID'])){
                                    if($_GET['ucID']!=0){
                                        if(isset($_GET['A3'])){
                                            // --- OPEX SELECTED ---
                                            if($_GET['A3']=="opex_selected"){
                                                opex_selected($twig,$is_connected,$_POST);
                                            }
                                            else {
                                                header('Location: ?A='.$_GET['A'].'&A2=opex&projID='.$_SESSION['projID'].'&ucID='.$ucID);
                                            }
                                        }
                                        else {
                                            if(isset($_GET['isTaken']) && $_GET['isTaken']){
                                                opex($twig,$is_connected,$_SESSION['projID'],$_GET['ucID'],true);
                                            } else {
                                                opex($twig,$is_connected,$_SESSION['projID'],$_GET['ucID']);
                                            }
                                        }
                                    }
                                    else {                                    
                                        header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                    }
                                } else {                                        
                                    header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                }
                            }
                            else { 
                                header('Location: ?A='.$_GET['A'].'&A2=project');
                            }
                        }
                        else {
                            opex($twig,$is_connected);
                        }
                    } elseif($_GET['A2']=="create_opex"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                if(isset($_GET['ucID'])){
                                    if($_GET['ucID']!=0){
                                        create_opex($twig,$is_connected,$_POST);
                                    } else {
                                        header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                    }
                                } else {
                                    header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                }
                            } else {
                                header('Location: ?A='.$_GET['A'].'&A2=project_cb');  
                            }    
                        } else {
                            header('Location: ?A='.$_GET['A'].'&A2=project_cb');
                        }
                    } elseif($_GET['A2']=="delete_opex"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                if(isset($_GET['ucID'])){
                                    if($_GET['ucID']!=0){
                                        if(isset($_GET['id'])){
                                            if($_GET['id']!=0){
                                                delete_opex_user($_GET['id']);
                                            }
                                            else {
                                                header('Location: ?A='.$_GET['A'].'&A2=opex&projID='.$projID.'&ucID='.$ucID);
                                            }
                                        }
                                        else {
                                            header('Location: ?A='.$_GET['A'].'&A2=opex&projID='.$projID.'&ucID='.$ucID);
                                        }
                                    } else {
                                        header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                    }
                                } else {
                                    header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                }
                            } else {
                                header('Location: ?A='.$_GET['A'].'&A2=project_cb');  
                            }    
                        } else {
                            header('Location: ?A='.$_GET['A'].'&A2=project_cb');
                        }
                    } elseif($_GET['A2']=="delete_selection_opex"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                if(isset($_GET['ucID'])){
                                    if($_GET['ucID']!=0){
                                        delete_selection_opex($_SESSION['projID'],$_GET['ucID']);
                                    } else {
                                        header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                    }
                                } else {
                                    header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                }
                            } else {
                                header('Location: ?A='.$_GET['A'].'&A2=project_cb');  
                            }    
                        } else {
                            header('Location: ?A='.$_GET['A'].'&A2=project_cb');
                        }
                    // --- INPUTED OPEX ---
                    } elseif($_GET['A2']=="opex_inputed"){
                        //var_dump($_POST);
                        opex_inputed($_POST);

                    // -*-*
                        // --- REVENUES ---
                    }elseif($_GET['A2']=="revenues"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                if(isset($_GET['ucID'])){
                                    if($_GET['ucID']!=0){
                                        if(isset($_GET['A3'])){
                                            // --- REVENUES SELECTED ---
                                            if($_GET['A3']=="revenues_selected"){
                                                revenues_selected($twig,$is_connected,$_POST);
                                            }
                                            else {
                                                header('Location: ?A='.$_GET['A'].'&A2=revenues&projID='.$_SESSION['projID'].'&ucID='.$ucID);
                                            }
                                        }
                                        else {
                                            if(isset($_GET['isTaken']) && $_GET['isTaken']){
                                                revenues($twig,$is_connected,$_SESSION['projID'],$_GET['ucID'],true);
                                            } else {
                                                revenues($twig,$is_connected,$_SESSION['projID'],$_GET['ucID']);
                                            }
                                        }
                                    }
                                    else {                                    
                                        header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                    }
                                } else {                                        
                                    header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                }
                            }
                            else { 
                                header('Location: ?A='.$_GET['A'].'&A2=project');
                            }
                        }
                        else {
                            revenues($twig,$is_connected);
                        }
                    } elseif($_GET['A2']=="create_revenues"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                if(isset($_GET['ucID'])){
                                    if($_GET['ucID']!=0){
                                        create_revenues($twig,$is_connected,$_POST);
                                    } else {
                                        header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                    }
                                } else {
                                    header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                }
                            } else {
                                header('Location: ?A='.$_GET['A'].'&A2=project_cb');  
                            }    
                        } else {
                            header('Location: ?A='.$_GET['A'].'&A2=project_cb');
                        }
                    } elseif($_GET['A2']=="delete_revenues"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                if(isset($_GET['ucID'])){
                                    if($_GET['ucID']!=0){
                                        if(isset($_GET['id'])){
                                            if($_GET['id']!=0){
                                                delete_revenues_user($_GET['id']);
                                            }
                                            else {
                                                header('Location: ?A='.$_GET['A'].'&A2=revenues&projID='.$projID.'&ucID='.$ucID);
                                            }
                                        }
                                        else {
                                            header('Location: ?A='.$_GET['A'].'&A2=revenues&projID='.$projID.'&ucID='.$ucID);
                                        }
                                    } else {
                                        header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                    }
                                } else {
                                    header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                }
                            } else {
                                header('Location: ?A='.$_GET['A'].'&A2=project_cb');  
                            }    
                        } else {
                            header('Location: ?A='.$_GET['A'].'&A2=project_cb');
                        }
                    } elseif($_GET['A2']=="delete_selection_revenues"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                if(isset($_GET['ucID'])){
                                    if($_GET['ucID']!=0){
                                        delete_selection_revenues($_SESSION['projID'],$_GET['ucID']);
                                    } else {
                                        header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                    }
                                } else {
                                    header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                }
                            } else {
                                header('Location: ?A='.$_GET['A'].'&A2=project_cb');  
                            }    
                        } else {
                            header('Location: ?A='.$_GET['A'].'&A2=project_cb');
                        }
                    // --- INPUTED REVENUES ---
                    } elseif($_GET['A2']=="revenues_inputed"){
                        //var_dump($_POST);
                        revenues_inputed($_POST);

                    // --- CASH RELEASING ---
                    } elseif($_GET['A2']=="cashreleasing"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                if(isset($_GET['ucID'])){
                                    if($_GET['ucID']!=0){
                                        if(isset($_GET['A3'])){
                                            // --- CASH RELEASING SELECTED ---
                                            if($_GET['A3']=="cashreleasing_selected"){
                                                cashreleasing_selected($twig,$is_connected,$_POST);
                                            }
                                            else {
                                                header('Location: ?A='.$_GET['A'].'&A2=cashreleasing&projID='.$_SESSION['projID'].'&ucID='.$ucID);
                                            }
                                        }
                                        else {
                                            if(isset($_GET['isTaken']) && $_GET['isTaken']){
                                                cashreleasing($twig,$is_connected,$_SESSION['projID'],$_GET['ucID'],true);
                                            } else {
                                                cashreleasing($twig,$is_connected,$_SESSION['projID'],$_GET['ucID']);
                                            }
                                        }
                                    }
                                    else {                                    
                                        header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                    }
                                } else {                                        
                                    header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                }
                            }
                            else { 
                                header('Location: ?A='.$_GET['A'].'&A2=project');
                            }
                        }
                        else {
                            cashreleasing($twig,$is_connected);
                        }
                    } elseif($_GET['A2']=="create_cashreleasing"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                if(isset($_GET['ucID'])){
                                    if($_GET['ucID']!=0){
                                        create_cashreleasing($twig,$is_connected,$_POST);
                                    } else {
                                        header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                    }
                                } else {
                                    header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                }
                            } else {
                                header('Location: ?A='.$_GET['A'].'&A2=project_cb');  
                            }    
                        } else {
                            header('Location: ?A='.$_GET['A'].'&A2=project_cb');
                        }
                    } elseif($_GET['A2']=="delete_cashreleasing"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                if(isset($_GET['ucID'])){
                                    if($_GET['ucID']!=0){
                                        if(isset($_GET['id'])){
                                            if($_GET['id']!=0){
                                                delete_cashreleasing_user($_GET['id']);
                                            }
                                            else {
                                                header('Location: ?A='.$_GET['A'].'&A2=cashreleasing&projID='.$projID.'&ucID='.$ucID);
                                            }
                                        }
                                        else {
                                            header('Location: ?A='.$_GET['A'].'&A2=cashreleasing&projID='.$projID.'&ucID='.$ucID);
                                        }
                                    } else {
                                        header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                    }
                                } else {
                                    header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                }
                            } else {
                                header('Location: ?A='.$_GET['A'].'&A2=project_cb');  
                            }    
                        } else {
                            header('Location: ?A='.$_GET['A'].'&A2=project_cb');
                        }
                    } elseif($_GET['A2']=="delete_selection_cashreleasing"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                if(isset($_GET['ucID'])){
                                    if($_GET['ucID']!=0){
                                        delete_selection_cashreleasing($_SESSION['projID'],$_GET['ucID']);
                                    } else {
                                        header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                    }
                                } else {
                                    header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                }
                            } else {
                                header('Location: ?A='.$_GET['A'].'&A2=project_cb');  
                            }    
                        } else {
                            header('Location: ?A='.$_GET['A'].'&A2=project_cb');
                        }
                    // --- INPUTED CASH RELEASING ---
                    } elseif($_GET['A2']=="cashreleasing_inputed"){
                        //var_dump($_POST);
                        cashreleasing_inputed($_POST);
                    
                    // --- WIDER CASH ---
                    } elseif($_GET['A2']=="widercash"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                if(isset($_GET['ucID'])){
                                    if($_GET['ucID']!=0){
                                        if(isset($_GET['A3'])){
                                            // --- WIDER CASH SELECTED ---
                                            if($_GET['A3']=="widercash_selected"){
                                                widercash_selected($twig,$is_connected,$_POST);
                                            }
                                            else {
                                                header('Location: ?A='.$_GET['A'].'&A2=widercash&projID='.$_SESSION['projID'].'&ucID='.$ucID);
                                            }
                                        }
                                        else {
                                            if(isset($_GET['isTaken']) && $_GET['isTaken']){
                                                widercash($twig,$is_connected,$_SESSION['projID'],$_GET['ucID'],true);
                                            } else {
                                                widercash($twig,$is_connected,$_SESSION['projID'],$_GET['ucID']);
                                            }
                                        }
                                    }
                                    else {                                    
                                        header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                    }
                                } else {                                        
                                    header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                }
                            }
                            else { 
                                header('Location: ?A='.$_GET['A'].'&A2=project');
                            }
                        }
                        else {
                            widercash($twig,$is_connected);
                        }
                    } elseif($_GET['A2']=="create_widercash"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                if(isset($_GET['ucID'])){
                                    if($_GET['ucID']!=0){
                                        create_widercash($twig,$is_connected,$_POST);
                                    } else {
                                        header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                    }
                                } else {
                                    header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                }
                            } else {
                                header('Location: ?A='.$_GET['A'].'&A2=project_cb');  
                            }    
                        } else {
                            header('Location: ?A='.$_GET['A'].'&A2=project_cb');
                        }
                    } elseif($_GET['A2']=="delete_widercash"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                if(isset($_GET['ucID'])){
                                    if($_GET['ucID']!=0){
                                        if(isset($_GET['id'])){
                                            if($_GET['id']!=0){
                                                delete_widercash_user($_GET['id']);
                                            }
                                            else {
                                                header('Location: ?A='.$_GET['A'].'&A2=widercash&projID='.$projID.'&ucID='.$ucID);
                                            }
                                        }
                                        else {
                                            header('Location: ?A='.$_GET['A'].'&A2=widercash&projID='.$projID.'&ucID='.$ucID);
                                        }
                                    } else {
                                        header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                    }
                                } else {
                                    header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                }
                            } else {
                                header('Location: ?A='.$_GET['A'].'&A2=project_cb');  
                            }    
                        } else {
                            header('Location: ?A='.$_GET['A'].'&A2=project_cb');
                        }
                    } elseif($_GET['A2']=="delete_selection_widercash"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                if(isset($_GET['ucID'])){
                                    if($_GET['ucID']!=0){
                                        delete_selection_widercash($_SESSION['projID'],$_GET['ucID']);
                                    } else {
                                        header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                    }
                                } else {
                                    header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                }
                            } else {
                                header('Location: ?A='.$_GET['A'].'&A2=project_cb');  
                            }    
                        } else {
                            header('Location: ?A='.$_GET['A'].'&A2=project_cb');
                        }
                    // --- INPUTED WIDER CASH ---
                    } elseif($_GET['A2']=="widercash_inputed"){
                        //var_dump($_POST);
                        widercash_inputed($_POST);
                    
                    // --- QUANTIFIABLE NON MONETIZABLE BENEFITS ---
                    } elseif($_GET['A2']=="quantifiable"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                if(isset($_GET['ucID'])){
                                    if($_GET['ucID']!=0){
                                        if(isset($_GET['A3'])){
                                            // --- QUANTIFIABLE SELECTED ---
                                            if($_GET['A3']=="quantifiable_selected"){
                                                quantifiable_selected($twig,$is_connected,$_POST);
                                            }
                                            else {
                                                header('Location: ?A='.$_GET['A'].'&A2=quantifiable&projID='.$_SESSION['projID'].'&ucID='.$ucID);
                                            }
                                        }
                                        else {
                                            if(isset($_GET['isTaken']) && $_GET['isTaken']){
                                                quantifiableBenefits($twig,$is_connected,$_SESSION['projID'],$_GET['ucID'],true);
                                            } else {
                                                quantifiableBenefits($twig,$is_connected,$_SESSION['projID'],$_GET['ucID']);
                                            }
                                        }
                                    }
                                    else {                                    
                                        header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                    }
                                } else {                                        
                                    header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                }
                            }
                            else { 
                                header('Location: ?A='.$_GET['A'].'&A2=project');
                            }
                        }
                        else {
                            quantifiableBenefits($twig,$is_connected);
                        }
                    } elseif($_GET['A2']=="create_quantifiable"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                if(isset($_GET['ucID'])){
                                    if($_GET['ucID']!=0){
                                        create_quantifiable($twig,$is_connected,$_POST);
                                    } else {
                                        header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                    }
                                } else {
                                    header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                }
                            } else {
                                header('Location: ?A='.$_GET['A'].'&A2=project_cb');  
                            }    
                        } else {
                            header('Location: ?A='.$_GET['A'].'&A2=project_cb');
                        }
                    } elseif($_GET['A2']=="delete_quantifiable"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                if(isset($_GET['ucID'])){
                                    if($_GET['ucID']!=0){
                                        if(isset($_GET['id'])){
                                            if($_GET['id']!=0){
                                                delete_quantifiable_user($_GET['id']);
                                            }
                                            else {
                                                header('Location: ?A='.$_GET['A'].'&A2=quantifiable&projID='.$projID.'&ucID='.$ucID);
                                            }
                                        }
                                        else {
                                            header('Location: ?A='.$_GET['A'].'&A2=quantifiable&projID='.$projID.'&ucID='.$ucID);
                                        }
                                    } else {
                                        header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                    }
                                } else {
                                    header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                }
                            } else {
                                header('Location: ?A='.$_GET['A'].'&A2=project_cb');  
                            }    
                        } else {
                            header('Location: ?A='.$_GET['A'].'&A2=project_cb');
                        }
                    } elseif($_GET['A2']=="delete_selection_quantifiable"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                if(isset($_GET['ucID'])){
                                    if($_GET['ucID']!=0){
                                        delete_selection_quantifiable($_SESSION['projID'],$_GET['ucID']);
                                    } else {
                                        header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                    }
                                } else {
                                    header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                }
                            } else {
                                header('Location: ?A='.$_GET['A'].'&A2=project_cb');  
                            }    
                        } else {
                            header('Location: ?A='.$_GET['A'].'&A2=project_cb');
                        }
                    // --- INPUTED QUANTIFIABLE ---
                    } elseif($_GET['A2']=="quantifiable_inputed"){
                        //var_dump($_POST);
                        quantifiable_inputed($_POST);
                    
                    // --- NON CASH ---
                    } elseif($_GET['A2']=="noncash"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                if(isset($_GET['ucID'])){
                                    if($_GET['ucID']!=0){
                                        if(isset($_GET['A3'])){
                                            // --- NON CASH SELECTED ---
                                            if($_GET['A3']=="noncash_selected"){
                                                noncash_selected($twig,$is_connected,$_POST);
                                            }
                                            else {
                                                header('Location: ?A='.$_GET['A'].'&A2=noncash&projID='.$_SESSION['projID'].'&ucID='.$ucID);
                                            }
                                        }
                                        else {
                                            if(isset($_GET['isTaken']) && $_GET['isTaken']){
                                                noncash($twig,$is_connected,$_SESSION['projID'],$_GET['ucID'],true);
                                            } else {
                                                noncash($twig,$is_connected,$_SESSION['projID'],$_GET['ucID']);
                                            }
                                        }
                                    }
                                    else {                                    
                                        header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                    }
                                } else {                                        
                                    header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                }
                            }
                            else { 
                                header('Location: ?A='.$_GET['A'].'&A2=project');
                            }
                        }
                        else {
                            noncash($twig,$is_connected);
                        }
                    } elseif($_GET['A2']=="create_noncash"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                if(isset($_GET['ucID'])){
                                    if($_GET['ucID']!=0){
                                        create_noncash($twig,$is_connected,$_POST);
                                    } else {
                                        header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                    }
                                } else {
                                    header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                }
                            } else {
                                header('Location: ?A='.$_GET['A'].'&A2=project_cb');  
                            }    
                        } else {
                            header('Location: ?A='.$_GET['A'].'&A2=project_cb');
                        }
                    } elseif($_GET['A2']=="delete_noncash"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                if(isset($_GET['ucID'])){
                                    if($_GET['ucID']!=0){
                                        if(isset($_GET['id'])){
                                            if($_GET['id']!=0){
                                                delete_noncash_user($_GET['id']);
                                            }
                                            else {
                                                header('Location: ?A='.$_GET['A'].'&A2=noncash&projID='.$projID.'&ucID='.$ucID);
                                            }
                                        }
                                        else {
                                            header('Location: ?A='.$_GET['A'].'&A2=noncash&projID='.$projID.'&ucID='.$ucID);
                                        }
                                    } else {
                                        header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                    }
                                } else {
                                    header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                }
                            } else {
                                header('Location: ?A='.$_GET['A'].'&A2=project_cb');  
                            }    
                        } else {
                            header('Location: ?A='.$_GET['A'].'&A2=project_cb');
                        }
                    } elseif($_GET['A2']=="delete_selection_noncash"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                if(isset($_GET['ucID'])){
                                    if($_GET['ucID']!=0){
                                        delete_selection_noncash($_SESSION['projID'],$_GET['ucID']);
                                    } else {
                                        header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                    }
                                } else {
                                    header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                }
                            } else {
                                header('Location: ?A='.$_GET['A'].'&A2=project_cb');  
                            }    
                        } else {
                            header('Location: ?A='.$_GET['A'].'&A2=project_cb');
                        }
                    // --- INPUTED NON CASH ---
                    } elseif($_GET['A2']=="noncash_inputed"){
                        //var_dump($_POST);
                        noncash_inputed($_POST);
                    
                    // --- RISKS ---
                    } elseif($_GET['A2']=="risks"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                if(isset($_GET['ucID'])){
                                    if($_GET['ucID']!=0){
                                        if(isset($_GET['A3'])){
                                            // --- RISKS SELECTED ---
                                            if($_GET['A3']=="risks_selected"){
                                                risks_selected($twig,$is_connected,$_POST);
                                            }
                                            else {
                                                header('Location: ?A='.$_GET['A'].'&A2=risks&projID='.$_SESSION['projID'].'&ucID='.$ucID);
                                            }
                                        }
                                        else {
                                            if(isset($_GET['isTaken']) && $_GET['isTaken']){
                                                risks($twig,$is_connected,$_SESSION['projID'],$_GET['ucID'],true);
                                            } else {
                                                risks($twig,$is_connected,$_SESSION['projID'],$_GET['ucID']);
                                            }
                                        }
                                    }
                                    else {                                    
                                        header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                    }
                                } else {                                        
                                    header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                }
                            }
                            else { 
                                header('Location: ?A='.$_GET['A'].'&A2=project');
                            }
                        }
                        else {
                            risks($twig,$is_connected);
                        }
                    } elseif($_GET['A2']=="create_risk"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                if(isset($_GET['ucID'])){
                                    if($_GET['ucID']!=0){
                                        create_risk($twig,$is_connected,$_POST);
                                    } else {
                                        header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                    }
                                } else {
                                    header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                }
                            } else {
                                header('Location: ?A='.$_GET['A'].'&A2=project_cb');  
                            }    
                        } else {
                            header('Location: ?A='.$_GET['A'].'&A2=project_cb');
                        }
                    } elseif($_GET['A2']=="delete_risk"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                if(isset($_GET['ucID'])){
                                    if($_GET['ucID']!=0){
                                        if(isset($_GET['id'])){
                                            if($_GET['id']!=0){
                                                delete_risk_user($_GET['id']);
                                            }
                                            else {
                                                header('Location: ?A='.$_GET['A'].'&A2=risks&projID='.$projID.'&ucID='.$ucID);
                                            }
                                        }
                                        else {
                                            header('Location: ?A='.$_GET['A'].'&A2=risks&projID='.$projID.'&ucID='.$ucID);
                                        }
                                    } else {
                                        header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                    }
                                } else {
                                    header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                }
                            } else {
                                header('Location: ?A='.$_GET['A'].'&A2=project_cb');  
                            }    
                        } else {
                            header('Location: ?A='.$_GET['A'].'&A2=project_cb');
                        }
                    } elseif($_GET['A2']=="delete_selection_risks"){
                        if(isset($_SESSION['projID'])){
                            if($_SESSION['projID']!=0){
                                if(isset($_GET['ucID'])){
                                    if($_GET['ucID']!=0){
                                        delete_selection_risks($_SESSION['projID'],$_GET['ucID']);
                                    } else {
                                        header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                    }
                                } else {
                                    header('Location: ?A='.$_GET['A'].'&A2=use_case_cb&projID='.$_SESSION['projID']);
                                }
                            } else {
                                header('Location: ?A='.$_GET['A'].'&A2=project_cb');  
                            }    
                        } else {
                            header('Location: ?A='.$_GET['A'].'&A2=project_cb');
                        }
                    // --- INPUTED RISKS ---
                    } elseif($_GET['A2']=="risks_inputed"){
                        //var_dump($_POST);
                        risks_inputed($_POST);

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
                        
                    } else {
                        header('Location: ?A='.$_GET['A']);
                    }
                } else {  
                    cost_benefits($twig,$is_connected);
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
                            //var_dump($scenID);
                            header('Location: ?A=funding&A2=work_cap_req&scenID='.$scenID);
                        }
                    } elseif($_GET['A2']=="create_scen"){
                        //var_dump($_POST);
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
            elseif($_GET['A']=='scenario_settings'){
                if(isset($_GET['A2'])){
                    //progression
                } else {  
                    \general\commonPage($twig,$is_connected, '?A=scenario_settings', 'scenario_settings');
                }            
            }

            // ---------- DASHBOARDS ----------
            elseif($_GET['A']=='dashboards'){
                verifIsDev();
                if(isset($_GET['A2'])){
                    if($_GET['A2']=="project"){
                        \general\project($twig,$is_connected, "?A=dashboards&A2=proj_selected",'dashboards');
                    // --- SELECTED PROJECT ---
                    } elseif($_GET['A2']=="proj_selected"){
                        if(isset($_POST['radio_proj'])){
                            $projID = intval($_POST['radio_proj']);
                            $_SESSION['projID']=$projID;
                            //var_dump($projID);
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
                    } else if($_GET['A2']=="bankability_input") {
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
                                /*    } else if($_GET['A3']=="output2"){
                                        financing_out_5($twig,$is_connected,$_SESSION['projID'],$_POST);
                                    } else if($_GET['A3']=="output3"){
                                        financing_out_3($twig,$is_connected,$_SESSION['projID'],$_POST);
                                    } else if($_GET['A3']=="output4"){
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
            elseif($_GET['A']=='comp_projects'){ 
                verifIsDev();
                if(isset($_GET['A2'])){
                    if($_GET['A2']=="projects"){
                        projects($twig,$is_connected);
                    } else if($_GET['A2']=="projects_selected"){
                        projects_selected($_POST);
                    } else if($_GET['A2']=="summary"){
                        projects_summary($twig,$is_connected);
                    } else if($_GET['A2']=="invest"){
                        investment($twig,$is_connected);
                    } else if($_GET['A2']=="op"){
                        operations($twig,$is_connected);
                    } else if($_GET['A2']=="cash_flows"){
                        cash_flows($twig,$is_connected);
                    } else if($_GET['A2']=="non_quant"){
                        non_quant($twig,$is_connected);
                    } else if($_GET['A2']=="finsoc_comp"){
                        finsoc_comp($twig,$is_connected);
                    } else {
                        header('Location: ?A='.$_GET['A']);
                    }
                } else {
                    comp_projects($twig,$is_connected); 
                }          
            }
            elseif($_GET['A']=='comp_finscen'){ 
                verifIsDev();
                if(isset($_GET['A2'])){
                    if($_GET['A2']=="scenarios"){
                        scenarios($twig,$is_connected);
                    } else if($_GET['A2']=="scenarios_selected"){
                        scenarios_selected($_POST);
                    } else if($_GET['A2']=="fin_summary"){
                        fin_summary($twig,$is_connected);
                    } else if($_GET['A2']=="cash_flows"){
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


