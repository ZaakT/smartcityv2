<?php

require_once('model/model.php');

// --- Funding
function funding($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/input/funding.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3]));
}

// ---- Financing / Funding Steps

// --------------------------------------------- SCENARIOS ---------------------------------------------  
function scenario($twig,$is_connected,$isTaken=false){
    $user = getUser($_SESSION['username']);
    $list_scenarios = getListScenarios($user[0]);
    //var_dump($list_scenarios);
    $list_projects = getListProjects2($user[0]);
    //var_dump($list_projects);
    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/input/funding_steps/scenario.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Scenario",'scenarios'=>$list_scenarios,'projects'=>$list_projects,'isTaken'=>$isTaken)); 
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

// ------------------------------------------- WORK CAP. REQ. --------------------------------------------
function work_cap_req($twig,$is_connected,$scenID=0){
    $user = getUser($_SESSION['username']);
    if($scenID!=0){
        if(getScenByID($scenID)){
            $list_scenarios = getListScenarios($user[0]);
            $list_projects = getListProjects2($user[0]);
            $scen = getScenByID($scenID);
            $projID = $scen['id_proj'];
            $parent = array_merge(['id'=>$projID],$list_projects[$projID]);
            $scope = getListSelScope($projID);

            $selInvest = $scen['input_invest'];
            $selOp = $scen['input_op'];
            
            $schedules = getListSelDates($projID);
            $keydates_proj = getKeyDatesProj($schedules,$scope);
            $projectYears = getYears($keydates_proj[0],$keydates_proj[2]);
            $projectDates = createProjectDates($keydates_proj[0],$keydates_proj[2]);
            
            $keydates_uc = [];

            $capexPerMonth = array_fill_keys($projectDates,0);
            $capexTot = ['tot'=>0] + array_fill_keys($projectYears,0);

            $implemPerMonth = array_fill_keys($projectDates,0);
            $implemTot = ['tot'=>0] + array_fill_keys($projectYears,0);

            $opexPerMonth = array_fill_keys($projectDates,0);
            $opexTot = ['tot'=>0] + array_fill_keys($projectYears,0);

            $revenuesPerMonth = array_fill_keys($projectDates,0);
            $revenuesTot = ['tot'=>0] + array_fill_keys($projectYears,0);

            $cashreleasingPerMonth = array_fill_keys($projectDates,0);
            $cashreleasingTot = ['tot'=>0] + array_fill_keys($projectYears,0);

            $widercashPerMonth = array_fill_keys($projectDates,0);
            $widercashTot = ['tot'=>0] + array_fill_keys($projectYears,0);

            $capexList = ['tot'=>0];
            $selUCS = [];
            foreach ($scope as $measID => $list_ucs) {
                foreach ($list_ucs as $ucID) {
                    array_push($selUCS,$ucID);
                }
            }

            foreach ($scope as $measID => $list_ucs) {
                foreach ($list_ucs as $ucID) {
                    $implemSchedule = $schedules['implem'][$ucID];
                    $opexSchedule = $schedules['opex'][$ucID];

                    $uc_stardate = $implemSchedule['startdate'];
                    $uc_implem_enddate = $implemSchedule['100date'];
                    $uc_enddate = $opexSchedule['enddate'];

                    $startdate = explode('/',$uc_stardate);
                    $startdate = new DateTime($startdate[1]."-".$startdate[0]."-01");
                    $enddate = explode('/',$uc_enddate);
                    $enddate = new DateTime($enddate[1]."-".$enddate[0]."-01");
                    $duration = intval($enddate->diff($startdate)->y*12 + $enddate->diff($startdate)->m);
                    
                    $keydates_uc[$ucID] = ["startdate"=>$uc_stardate,'implem_enddate'=>$uc_implem_enddate,'project_duration'=>$duration];

                    $implemSchedule = $schedules['implem'][$ucID];
                    $opexSchedule = $schedules['opex'][$ucID];
                    $revenuesSchedule = isset($schedules['revenues'][$ucID]) ? $schedules['revenues'][$ucID] : [];

                    $implemRepart = getRepartPercImplem($implemSchedule,$projectDates);

                    
                    $capex = getTotCapexByUC($projID,$ucID);
                    $capexPerMonth_new = calcCapexPerMonth($implemRepart,$capex);
                    $capexTot_new = calcCapexTot($capexPerMonth_new,$projectYears);
                    $capexPerMonth = add_arrays($capexPerMonth,$capexPerMonth_new);
                    $capexTot = add_arrays($capexTot,$capexTot_new);
                    $capexList['tot'] += $capexTot['tot'];
                    $capexList[$ucID]['value'] = $capexTot['tot'];

                    $implem = getTotImplemByUC($projID,$ucID);
                    $implemPerMonth_new = calcImplemPerMonth($implemRepart,$implem);
                    $implemTot_new = calcImplemTot($implemPerMonth_new,$projectYears);
                    $implemPerMonth = add_arrays($implemPerMonth,$implemPerMonth_new);
                    $implemTot = add_arrays($implemTot,$implemTot_new);
                    
                    $opexRepart = getRepartPercOpex($opexSchedule,$projectDates);
                    $opex = getOpexValues($projID,$ucID);
                    $opexPerMonth_new = calcOpexPerMonth2($opexRepart,$opex);
                    $opexTot_new = calcOpexTot($opexPerMonth_new,$projectYears);
                    $opexPerMonth = add_arrays($opexPerMonth,$opexPerMonth_new);
                    $opexTot = add_arrays($opexTot,$opexTot_new);

                    if(scheduleFilled($revenuesSchedule) && !empty($revenuesSchedule)){
                        $revenuesRepart = getRepartPercRevenues($revenuesSchedule,$projectDates);
                        $revenuesValues = getRevenuesValues($projID,$ucID);
                        $revenuesPerMonth_new = calcRevenuesPerMonth2($revenuesRepart,$revenuesValues);
                        $revenuesTot_new = calcRevenuesTot($revenuesPerMonth_new,$projectYears);
                        $revenuesPerMonth = add_arrays($revenuesPerMonth,$revenuesPerMonth_new);
                        $revenuesTot = add_arrays($revenuesTot,$revenuesTot_new);
                    } else {
                        $revenuesPerMonth_new = array_fill_keys($projectDates,0);
                        $revenuesPerMonth = add_arrays($revenuesPerMonth,$revenuesPerMonth_new);
                        $revenuesTot_new = calcRevenuesTot($revenuesPerMonth,$projectYears);
                        $revenuesTot = add_arrays($revenuesTot,$revenuesTot_new);
                    }

                    $cashreleasingValues = getCashReleasingValues($projID,$ucID);
                    $cashreleasingPerMonth_new = calcCashReleasingPerMonth2($opexRepart,$cashreleasingValues);
                    $cashreleasingTot_new = calcCashReleasingTot($cashreleasingPerMonth_new,$projectYears);
                    $cashreleasingPerMonth = add_arrays($cashreleasingPerMonth,$cashreleasingPerMonth_new);
                    $cashreleasingTot = add_arrays($cashreleasingTot,$cashreleasingTot_new);
                    
                    $widercashValues = getWiderCashValues($projID,$ucID);
                    $widercashPerMonth_new = calcWiderCashPerMonth2($opexRepart,$widercashValues);
                    $widercashTot_new = calcWiderCashTot($widercashPerMonth_new,$projectYears);
                    $widercashPerMonth = add_arrays($widercashPerMonth,$widercashPerMonth_new);
                    $widercashTot = add_arrays($widercashTot,$widercashTot_new);

                }
            }

            $netcashPerMonth = calcNetCashPerMonth($projectDates,$capexPerMonth,$implemPerMonth,$opexPerMonth,$revenuesPerMonth,$cashreleasingPerMonth);

            $tot_capex = $capexTot['tot'];
            $tot_implem = $implemTot['tot'];
            $tot_invest = $tot_capex + $tot_implem;
            $tot_op = calcOperating($netcashPerMonth[2],$tot_invest);

            $values = ['capex'=>$tot_capex,'implem'=>$tot_implem,'invest'=>$tot_invest,'op'=>$tot_op,'total'=>$tot_invest+$tot_op];
            //var_dump($values);
            $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
            
            echo $twig->render('/input/funding_steps/work_cap_req.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Scenario",'sel_scen'=>$scen['name'],'part2'=>"Related Project",'parent'=>$parent['name'],'scenarios'=>$list_scenarios,'values'=>$values,'selInvest'=>$selInvest,'selOp'=>$selOp,'scenID'=>$scenID)); 
            prereq_Funding();
        } else {
            throw new Exception("This Project doesn't exist !");
        }
    } else {
        header('Location: ?A=funding&A2=scenario');
    }
}

function calcOperating($netcash_cumul,$invest){
    $tot_op = 0;
    foreach ($netcash_cumul as $date => $value) {
        if($value < 0){
            $tot_op_new = $value+$invest;
            if($tot_op_new <= $tot_op){
                $tot_op = $tot_op_new;
            }
        } else {
            return 0;
        }
    }
    return -$tot_op;
}

function wcr_input($post=[]){
    if(isset($_SESSION['scenID'])){
        $scenID = $_SESSION['scenID'];
        if(isset($post['wcr_input_op']) && isset($post['wcr_input_invest'])){
            $wcr_input_op = floatval($post['wcr_input_op']);
            $wcr_input_invest = floatval($post['wcr_input_invest']);
            insertInputScenario($wcr_input_op,$wcr_input_invest,$scenID);
            update_ModifDate_scen($scenID);
            header('Location: ?A=funding&A2=funding_sources&scenID='.$scenID);
        } else {
            throw new Exception("There is an error with the input fields !");
        }
    } else {
        throw new Exception("There is no scenario selected !");
    }
}


// -------------------------------------------- FUNDING SOURCES -------------------------------------------

function funding_sources($twig,$is_connected,$scenID=0){
    $user = getUser($_SESSION['username']);
    if($scenID!=0){
        if(getScenByID($scenID)){
            $list_scenarios = getListScenarios($user[0]);
            $list_projects = getListProjects2($user[0]);
            $scen = getScenByID($scenID);
            $projID = $scen['id_proj'];
            $parent = array_merge(['id'=>$projID],$list_projects[$projID]);

            $listSel = getListSelFS($scenID);
            //var_dump($listSel);

            $list_FS_cat = getListFundingSourcesCat();
            $list_FS = getListFundingSources(); 
            $selLoansAndBonds = getListLoansAndBonds($scenID);
            $selOthers = getListOthers($scenID);
            $selEntities = getEntities($selLoansAndBonds,$selOthers);
            //var_dump($selEntities);
            $funding_target = getFundingTarget($scenID);

            $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
            
            echo $twig->render('/input/funding_steps/funding_sources.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Scenario",'sel_scen'=>$scen['name'],'part2'=>"Related Project",'parent'=>$parent['name'],'scenarios'=>$list_scenarios,'FS_cat'=>$list_FS_cat,'FS'=>$list_FS,'entities'=>$selEntities,'scenID'=>$scenID,'funding_target'=>$funding_target,'listSel'=>$listSel)); 
            prereq_Funding();
        } else {
            throw new Exception("This Scenario doesn't exist !");
        }
    } else {
        header('Location: ?A=funding&A2=scenario');
    }
}

function getEntities($selLoansAndBonds,$selOthers){
    $list = [];
    foreach ($selLoansAndBonds as $key => $value) {
        $list[$key] = $value;
    }
    foreach ($selOthers as $key => $value) {
        $list[$key] = $value;
    }
    return $list;
}

function create_entity($post){
    if($post){
        $scenID = intval($post['scenID']);
        $sourceID = intval($post['id_source']);
        $name = $post['name'];
        $description = $post['description'];
        /* $listLoansAndBonds = getListLoansAndBonds($scenID);
        $listOthers = getListOthers($scenID); */
        $source = getFundingSourceByID($sourceID);
        if($source['id_type']==2){
            //var_dump('LOANS AND BONDS !!');
            insertLoansAndBonds($scenID,$sourceID,$name,$description);
            update_ModifDate_scen($scenID);
            header('Location: ?A=funding&A2=funding_sources&scenID='.$scenID);
        } else if($source['id_type']==1){
            insertOthers($scenID,$sourceID,$name,$description);
            update_ModifDate_scen($scenID);
            header('Location: ?A=funding&A2=funding_sources&scenID='.$scenID);
        } else {
            throw new Exception("There is a problem the funding sources");
        }
    } else {
        throw new Exception("There is no data inputed !");
    }
}

function delete_entity($post){
    if($post){
        $scenID = intval($post['scenID']);
        $sourceID = intval($post['id_source']);
        $entityID = intval($post['entity_to_delete']);
        //var_dump($entity,$scenID,$sourceID);
        deleteEntity($entityID);
        update_ModifDate_scen($scenID);
        header('Location: ?A=funding&A2=funding_sources&scenID='.$scenID);
    } else {
        throw new Exception("There is no entity selected !");
    }
}

function fs_selected($post){
    if(isset($_SESSION['scenID'])){
        $scenID = $_SESSION['scenID'];
        if($post){
            $selFS = [];
            foreach($post as $key => $value){
                if(intval($key)==0){
                    $temp = explode('_',$key);
                    $selFS[intval($temp[1])] = floatval($value);
                }
            }
            $listSel = getListSelFS($scenID);
            
            $AddAndRemoveFS = getAddAndRemoveFS($selFS,$listSel);
            $toAdd = $AddAndRemoveFS[0];
            $toRemove = $AddAndRemoveFS[1];
            //var_dump($listSel,$selFS,$toAdd,$toRemove);
            deleteSelFS($toRemove);
            insertSelFS($scenID,$toAdd);
            
            $listFS = getListFundingSources();
            //var_dump($listFS);
            $selLoansAndBonds = getListLoansAndBonds($scenID);
            $selOthers = getListOthers($scenID);
            $selEntities = getEntities($selLoansAndBonds,$selOthers);
            foreach ($selEntities as $sourceID => $list_entities){
                //var_dump($sourceID ,$list_entities);
                if(!empty($list_entities)){
                    if($listFS[$sourceID]['id_type']==1){ // others
                        $infos = ['date'=>null];
                        updateFundingSourceOthers($scenID,$sourceID,$infos);
                    } else if($listFS[$sourceID]['id_type']==2){ // L&B
                        $infos = ['startdate'=>null,'maturitydate'=>null,'interest'=>0];
                        updateFundingSourceLB($scenID,$sourceID,$infos);
                    }
                }
                if(!array_key_exists($sourceID,$selFS)){
                    //updateFundingSourceOthers($scenID,$sourceID,$infos); //& update
                    foreach ($list_entities as $entityID => $entity){
                        //var_dump($entity['name']);
                        deleteEntity($entityID);
                    }
                }
            }

            update_ModifDate_scen($scenID);
            header('Location: ?A=funding&A2=funding_sources&A3=input_entities&scenID='.$scenID);
        } else {
            throw new Exception("There is no data inputed !");
        }
    } else {
        throw new Exception("There is no scenario selected !");
    }
}

function getAddAndRemoveFS($selFS,$listSel){
    $toAdd = [];
    $toRemove = [];
    foreach($selFS as $key => $value){
        if(array_key_exists($key,$listSel)){
            if($value == $listSel[$key]['share']){
                // do nothing
            } else {
                $toRemove[$key] = $listSel[$key]['share'];
                $toAdd[$key] = $value;
            }
        } else {
            $toAdd[$key] = $value;
        }
    }
    foreach($listSel as $key => $value){
        if(array_key_exists($key,$selFS)){
            // do nothing
        } else {
            $toRemove[$key] = $value['share'];
        }
    }
    return [$toAdd,$toRemove];
}

function input_entities($twig,$is_connected,$scenID){
    $user = getUser($_SESSION['username']);
    if($scenID!=0){
        if(getScenByID($scenID)){
            $list_scenarios = getListScenarios($user[0]);
            $list_projects = getListProjects2($user[0]);
            $scen = getScenByID($scenID);
            $projID = $scen['id_proj'];
            $parent = array_merge(['id'=>$projID],$list_projects[$projID]);

            $listSel = getListSelFS($scenID);

            $list_FS_cat = getListFundingSourcesCat();
            $list_FS = getListFundingSources();
            $selLoansAndBonds = getListLoansAndBonds($scenID);
            $selOthers = getListOthers($scenID);
            $selEntities = getEntities($selLoansAndBonds,$selOthers);
            //var_dump($selEntities);
            $funding_target = getFundingTarget($scenID);

            $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/input/funding_steps/input_entities.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Scenario",'sel_scen'=>$scen['name'],'part2'=>"Related Project",'parent'=>$parent['name'],'scenarios'=>$list_scenarios,'FS_cat'=>$list_FS_cat,'FS'=>$list_FS,'entities2'=>$selLoansAndBonds,'entities1'=>$selOthers,'entities'=>$selEntities,'scenID'=>$scenID,'funding_target'=>$funding_target,'listSel'=>$listSel));
            prereq_Funding(); 
        } else {
            throw new Exception("This Scenario doesn't exist !");
        }
    } else {
        header('Location: ?A=funding&A2=scenario');
    }
}

function entities_inputed($post){
    if(isset($_SESSION['scenID'])){
        $scenID = $_SESSION['scenID'];
        if($post){
            $data = [];
            foreach($post as $key => $value){
                $temp = explode('_',$key);
                if($temp[0]=='input'){ // it's a date
                    $date_input = explode('/',$value);
                    $date_to_insert = date_create($date_input[1]."-".$date_input[0]."-01")->format('Y-m-d H:i:s');
                    $dateType = $temp[1];
                    $sourceID = intval($temp[2]);
                    if(sizeof($temp) == 3){ // source without entity
                        $data[$sourceID][0][$dateType] = $date_to_insert;
                    } else if (sizeof($temp) == 4){ // source with entities
                        $entityID = intval($temp[3]);
                        $data[$sourceID][$entityID][$dateType] = $date_to_insert;
                    }
                } else if ($temp[0]=='interest') {
                    $sourceID = intval($temp[1]);
                    if(sizeof($temp) == 2){ // source without entity
                        $data[$sourceID][0]['interest'] = $value;
                    } else if (sizeof($temp) == 3){ // source with entities
                        $entityID = intval($temp[2]);
                        $data[$sourceID][$entityID]['interest'] = $value;
                    }
                } else if ($temp[0]=='shareFS') { // source without entity
                    $sourceID = intval($temp[1]);
                    $data[$sourceID][0]['share'] = $value;
                } else if ($temp[0]=='share') { // source with entities
                    $sourceID = intval($temp[1]);
                    $entityID = intval($temp[2]);
                    $data[$sourceID][$entityID]['share'] = $value;
                }
            }
            $list_FS = getListFundingSources();
            foreach ($data as $sourceID => $list_entities){
                foreach ($list_entities as $entityID => $infos){
                    if($list_FS[$sourceID]['id_type']==1){ // others
                        if($entityID == 0){
                            updateFundingSourceOthers($scenID,$sourceID,$infos);
                        } else {
                            updateEntityOthers($entityID,$infos);
                        }
                    } else if($list_FS[$sourceID]['id_type']==2){ // Loans & Bonds
                        if($entityID == 0){
                            updateFundingSourceLB($scenID,$sourceID,$infos);
                        } else {
                            updateEntityLB($entityID,$infos);
                        }
                    }
                } 
            }
            update_ModifDate_scen($scenID);
            header('Location: ?A=funding&A2=benef&scenID='.$scenID);
        } else {
            throw new Exception("There is no data inputed !");
        }
    } else {
        throw new Exception("There is no scenario selected !");
    }
}


// --------------------------------------------- BENEF. ---------------------------------------------


function benef($twig,$is_connected,$scenID=0){
    $user = getUser($_SESSION['username']);
    if($scenID!=0){
        if(getScenByID($scenID)){
            $list_scenarios = getListScenarios($user[0]);
            $list_projects = getListProjects2($user[0]);
            $scen = getScenByID($scenID);
            $projID = $scen['id_proj'];
            $parent = array_merge(['id'=>$projID],$list_projects[$projID]);

            $listBenef = getListBenef($scenID);
            $funding_target = getFundingTarget($scenID);
            //var_dump($listBenef);

            $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/input/funding_steps/benef.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Scenario",'sel_scen'=>$scen['name'],'part2'=>"Related Project",'parent'=>$parent['name'],'scenarios'=>$list_scenarios,'scenID'=>$scenID,'funding_target'=>$funding_target,'listBenef'=>$listBenef));
            prereq_Funding();
        } else {
            throw new Exception("This Scenario doesn't exist !");
        }
    } else {
        header('Location: ?A=funding&A2=scenario');
    }
}

function create_benef($post){
    if($post){
        $scenID = intval($post['scenID']);
        $name = $post['name'];
        //$description = $post['description'];
        $infos['name'] = $name;
        insertBenef($scenID,$infos);
        update_ModifDate_scen($scenID);
        header('Location: ?A=funding&A2=benef&scenID='.$scenID);
    } else {
        throw new Exception("There is no data inputed !");
    }
}

function delete_benef($post){
    if($post){
        $scenID = intval($post['scenID']);
        $benefID = intval($post['benef_to_delete']);
        //var_dump($benef,$scenID,$sourceID);
        deleteBenef($benefID);
        update_ModifDate_scen($scenID);
        header('Location: ?A=funding&A2=benef&scenID='.$scenID);
    } else {
        throw new Exception("There is no benef selected !");
    }
}


function benef_selected($post){
    if(isset($_SESSION['scenID'])){
        $scenID = $_SESSION['scenID'];
        $scen = getScenByID($scenID);
        $projID = $scen['id_proj'];
        if($post){
            //var_dump($post);
            foreach($post as $key => $value){
                $infos = [];
                $temp = explode('_',$key);
                $benefID = intval($temp[1]);
                $share = floatval($value);
                $infos['share'] = $share;
                updateBenef($benefID,$infos);
            }

            update_ModifDate_scen($scenID);
            header('Location: ?A=dashboards&A2=financing&projID='.$projID);
        } else {
            throw new Exception("There is no data inputed !");
        }
    } else {
        throw new Exception("There is no scenario selected !");
    }
}

// ---------------------------------------- CHECK PRE-REQ ----------------------------------------
function prereq_Funding(){
    if(isset($_SESSION['scenID'])){
        $scenID = $_SESSION['scenID'];
            echo "<script>prereq_funding(true);</script>";
    }
}