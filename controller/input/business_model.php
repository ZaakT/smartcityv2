<?php

require_once('model/model.php');

// --- Business Model
function business_model($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/input/business_model.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3]));
}

// ---------------------------------------- PROJECT ----------------------------------------

function project_bm($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    $list_projects = getListProjects($user[0]);
    if(isset($_SESSION['projID'])){
        unset($_SESSION['projID']);
    }
    //var_dump($list_projects);
    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/input/business_model_steps/project_bm.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projects'=>$list_projects)); 
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

            $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/input/business_model_steps/pref.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'investCap'=>$listInvestCap,'paybackConst'=>$listPaybackConst,'businessModelPref'=>$listBusinessModelPref));
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
            $id_investcap = intval($post['invest_cap']);
            $id_payconst = intval($post['payback_const']);
            $id_bmpref = intval($post['bm_pref']);

            $selBM = getSelBM($projID);
            
            if($selBM){
                deleteSelBM($projID);
                insertSelBM($projID,$id_investcap,$id_payconst,$id_bmpref);
            } else {
                insertSelBM($projID,$id_investcap,$id_payconst,$id_bmpref);
            }
            header('Location: ?A=business_model&A2=reco&projID='.$projID);
        } else {
            throw new Exception("There is no data inputed !");
        }
    } else {
        throw new Exception("There is no project selected !");
    }
}

// ----------------------------------- RECOMMENDATIONS ------------------------------------

function reco($twig,$is_connected,$projID=0){
    $user = getUser($_SESSION['username']);
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            $proj = getProjByID($projID,$user[0]);

            $selBM = getSelBM($projID);

            $listInvestCap = getListInvestCap();
            $listPaybackConst = getListPaybackConst();
            $listBusinessModelPref = getListBusinessModelPref();
            $listBMBank = getListBMBank();
            $listBMSocBank = getListBMSocBank();
            $listBMReco = getListBMReco();

            $id_investcap = $selBM['id_investcap'];
            $id_payconst = $selBM['id_payconst'];
            $id_bmpref = $selBM['id_bmpref'];

            $BM_infos = ['invest_cap'=>$listInvestCap[$id_investcap]['description'],'payback_const'=>$listPaybackConst[$id_payconst]['description'],'bm_pref'=>$listBusinessModelPref[$id_bmpref]['description']];

            $reco = getBMReco($id_investcap,$id_payconst,$id_bmpref);

            $id_bm = $reco[1];
            
            $calcBank = calcBank($projID);
            $bank = getBMBank($calcBank[0]);
            $soc_bank = getBMSocBank($calcBank[1]);

            $proj_qualif = ['invest_cap'=>$listInvestCap[$id_investcap]['description'],'proj_bank'=>$listBMBank[$bank],'soc_bm'=>$listBMSocBank[$soc_bank]];

            $funding_opt = getFundingOpt($id_bm,$id_investcap,$bank,$soc_bank);
            /* $funding_opt = ['City'=>0,'Grants'=>0,'Equity investors'=>0,'Impact Investors'=>0,'Bank Debt'=>0,'Green Debt'=>0,'Suppliers'=>0,'Alternative'=>0]; */
            //var_dump($proj_qualif);

            $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/input/business_model_steps/reco.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'BM_infos'=>$BM_infos,'reco'=>$reco,'proj_qualif'=>$proj_qualif,'listBMReco'=>$listBMReco,'funding_opt'=>$funding_opt));
            prereq_BusinessModel();
        } else {
            throw new Exception("This Project doesn't exist !");
        }
    } else {
        header('Location: ?A=business_model&A2=project');
    }
}

function getBMBank($bank){ //should correspond with the database
    if($bank <= 3)
        return 1;
    else if (4 <= $bank && $bank <= 6) //to check with manuel
        return 2;
    else if ($bank >= 7)
        return 3;
}

function getBMSocBank($bank){ //should correspond with the database
    if($bank <= 3)
        return 1;
    else if (4 <= $bank && $bank <= 6) //to check with manuel
        return 2;
    else if ($bank >= 7)
        return 3;
}

function calcBank($projID){
    $measures = getListMeasures();
    $ucs = getListUCs();
    $scope = getListSelScope($projID);

    $schedules = getListSelDates($projID);
    $keydates_proj = getKeyDatesProj($schedules,$scope);
    $projectYears = getYears($keydates_proj[0],$keydates_proj[2]);
    $projectDates = createProjectDates($keydates_proj[0],$keydates_proj[2]);
    //var_dump($keydates_proj);
    $keydates_uc = [];
    $volumes = [];

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

    $capexAmortTot_all = [];
    $netProjectCost = [];
    $baselineOpCost = [];
    $CRV = [];
    $capexAmort_all = [];
    
    $ratingNonCash = -1;
    $ratingRisks = -1;

    $nbUCS = 0;

    $dr_year = getListSelDiscountRate($projID);
    $dr_month = pow(1+($dr_year/100),1/12)-1;

    $capexList = ['tot'=>0];
    $selUCS = [];
    foreach ($scope as $measID => $list_ucs) {
        foreach ($list_ucs as $ucID) {
            array_push($selUCS,$ucID);
        }
    }

    $fin_ROI = array_fill_keys($selUCS,["value"=>0,"score"=>0]);
    $fin_payback = array_fill_keys($selUCS,["value"=>0,"score"=>0]);
    $fin_score = array_fill_keys($selUCS,0);

    $soc_ROI = array_fill_keys($selUCS,["value"=>0,"score"=>0]);
    $soc_payback = array_fill_keys($selUCS,["value"=>0,"score"=>0]);
    $noncash = array_fill_keys($selUCS,["value"=>0,"score"=>0]);
    $risk = array_fill_keys($selUCS,["value"=>0,"score"=>0]);
    $soc_score = array_fill_keys($selUCS,0);

    $ROI = 0;
    $SOCROI = 0;
    $NPV = 0;
    $SOCNPV = 0;
    foreach ($scope as $measID => $list_ucs) {
        foreach ($list_ucs as $ucID) {
            $nbUCS++;
            $volumes[$ucID] = getListVolumesPerUC($projID,$ucID);
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

            $capexAmortization = calcCapexAmort($capexPerMonth,getCapexAmort($projID,$ucID),$projectDates,$projectYears);
            $capexAmort_all = add_arrays($capexAmort_all,$capexAmortization);

            $baseline_crb = getBaselineCRB($projID,$ucID);
            $netProjectCost_old = calcNetProjectCost($projectYears,$implemTot,$opexTot_new,$revenuesTot_new,$capexAmortization);
            $netProjectCost = add_arrays($netProjectCost,$netProjectCost_old);
            $baselineOpCost_old = calcBaselineOpCost($projectYears,$baseline_crb,$cashreleasingTot_new);
            $baselineOpCost = add_arrays($baselineOpCost,$baselineOpCost_old);
            

            $CRV_old = getCRV($projectYears,$capexTot,$capexAmortization);
            $CRV = add_arrays($CRV,$CRV_old);

            $ratingNonCash_new = getNonCashRating($projID,$ucID);
            if($ratingNonCash_new != -1){
                if($ratingNonCash == -1){
                    $ratingNonCash = 0;
                }
                $ratingNonCash += $ratingNonCash_new;
            }

            $ratingRisks_new = getRisksRating($projID,$ucID);
            if($ratingRisks_new != -1){
                if($ratingRisks == -1){
                    $ratingRisks = 0;
                }
                $ratingRisks += $ratingRisks_new;
            }
            $netcashPerMonth = calcNetCashPerMonth($projectDates,$capexPerMonth_new,$implemPerMonth_new,$opexPerMonth_new,$revenuesPerMonth_new,$cashreleasingPerMonth_new);

            $netsoccashPerMonth = calcNetSocCashPerMonth($projectDates,$capexPerMonth_new,$implemPerMonth_new,$opexPerMonth_new,$revenuesPerMonth_new,$cashreleasingPerMonth_new,$widercashPerMonth_new);

            $sum_capex_implem = add_arrays($capexPerMonth_new,$implemPerMonth_new);

            $NPV1 = calcNPV($dr_month,$netcashPerMonth[0]);
            $NPV2 = calcNPV($dr_month,$sum_capex_implem);
            $fin_ROI[$ucID]["value"] = calcROI($NPV1,$NPV2);
            $fin_ROI[$ucID]["score"] = calcROI_score($fin_ROI[$ucID]["value"]);
            $fin_payback[$ucID]["value"] = calcPayback($netcashPerMonth)[0];
            $fin_payback[$ucID]["score"] = calcPayback_score($fin_payback[$ucID]["value"]/100);
            $fin_score[$ucID] = calcMoyFinBankability($fin_ROI[$ucID]["score"],$fin_payback[$ucID]["score"]);
            $ROI += $fin_ROI[$ucID]["value"];
            $NPV +=  $NPV1;

            $SOCNPV1 = calcNPV($dr_month,$netsoccashPerMonth[0]);
            $SOCNPV2 = calcNPV($dr_month,$sum_capex_implem);
            $soc_ROI[$ucID]["value"] = calcROI($SOCNPV1,$SOCNPV2);
            $soc_ROI[$ucID]["score"] = calcROI_score($soc_ROI[$ucID]["value"]);
            $soc_payback[$ucID]["value"] = calcPayback($netsoccashPerMonth)[0];
            $soc_payback[$ucID]["score"] = calcPayback_score($soc_payback[$ucID]["value"]/100);
            $noncash[$ucID]["value"] = getNonCashRating($projID,$ucID);
            $noncash[$ucID]["score"] = calcNoncash_score($noncash[$ucID]["value"]);
            $risk[$ucID]["value"] = getRisksRating($projID,$ucID);
            $risk[$ucID]["score"] = calcRisk_score($risk[$ucID]["value"]);
            $soc_score[$ucID] = calcMoySocBankability($soc_ROI[$ucID]["score"],$soc_payback[$ucID]["score"],$noncash[$ucID]["score"],$risk[$ucID]["score"]);
            $SOCROI += $soc_ROI[$ucID]["value"];
            $SOCNPV +=  $SOCNPV1;

        }
    }

    $netcashPerMonth = calcNetCashPerMonth($projectDates,$capexPerMonth,$implemPerMonth,$opexPerMonth,$revenuesPerMonth,$cashreleasingPerMonth);
    $netcashTot = calcNetCashTot($netcashPerMonth[0],$projectYears);
    
    $payback = calcPayback($netcashPerMonth)[1];

    $netsoccashPerMonth = calcNetSocCashPerMonth($projectDates,$capexPerMonth,$implemPerMonth,$opexPerMonth,$revenuesPerMonth,$cashreleasingPerMonth,$widercashPerMonth);
    $netsoccashTot = calcNetSocCashTot($netsoccashPerMonth[0],$projectYears);

    $socpayback = calcPayback($netsoccashPerMonth)[1];

    $budgetCost = add_arrays($netProjectCost,$baselineOpCost);
    $OB = calcOB($projectYears,$budgetCost);
    $OBYI = $OB[0];
    //$OBCI = $OB[1];

    $ratingNonCash = $nbUCS != 0 ? $ratingNonCash/$nbUCS : -1;
    $ratingRisks = $nbUCS != 0 ? $ratingRisks/$nbUCS : -1;

    
    foreach ($capexList as $key => $value) {
        if($key != 'tot'){
            $capexList[$key]['weight'] = $capexList['tot']!=0 ? 100*$value['value']/$capexList['tot'] : 0;
        }
    }
    $scores = getWeightedScores3($fin_score,$soc_score,$capexList);
    return [$scores['fin'],$scores['soc']];
}

function getWeightedScores3($fin_score,$soc_score,$capexList){
    $list = ['fin'=>0,'soc'=>0,'proj'=>0];
    foreach ($capexList as $key => $tab) {
        if($key != 'tot'){
            $ucID = $key;
            $weight = $tab['weight'];
            $list['fin'] += $fin_score[$ucID]*$weight/100;
            $list['soc'] += $soc_score[$ucID]*$weight/100;
        }
    }
    $list['proj'] = floatval(number_format((($list['fin']+$list['soc'])/2),1,'.',','));
    $list['fin'] = floatval(number_format($list['fin'],1,'.',','));
    $list['soc'] = floatval(number_format($list['soc'],1,'.',','));
    return $list;
}

// ---------------------------------------- CHECK PRE-REQ ----------------------------------------
function prereq_BusinessModel(){
    if(isset($_SESSION['projID'])){
        $projID = $_SESSION['projID'];
            echo "<script>prereq_businessModel(true);</script>";
    }
}
