<?php

require_once('model/model.php');

// ---------------------------------- COMPARISON ----------------------------------
function comparison($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/output/comparison.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3]));
}


// ---------------------------------- COMPARE PROJECTS ----------------------------------

function comp_projects($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/output/comparison_items/comp_projects.twig',array('is_connected'=>$is_connected,
    'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3]));
}

function projects($twig,$is_connected, $side = "customer"){
    $user = getUser($_SESSION['username']);
    $idUser = $user[0];
    $projects = getListProjects2($idUser);
    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/output/comparison_items/projects_item/projects.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,
    'selDevName'=>$selDevName,'is_admin'=>$user[3],'projects'=>$projects, "side"=>$side));
}

function projects_selected($post, $side = "customer"){
    if($post){
        $user = getUser($_SESSION['username']);
        $selProjects = [];
        foreach($post as $key => $value){
            $idProj = intval(explode('proj_',$key)[1]);
            array_push($selProjects,$idProj);
        }
        $_SESSION['selProjects'] = $selProjects;
        header('Location: ?A=comp_projects&A2=summary&side='.$side);
    } else {
        throw new Exception("No project selected !");
    }
}


function projects_summary($twig,$is_connected, $side = "customer"){
    $user = getUser($_SESSION['username']);
    $idUser = $user[0];
    $projects = getListProjects2($idUser);
    if(isset($_SESSION['selProjects'])){
        $selProjects  = $_SESSION['selProjects'];
        $projectsData = [];
        foreach($selProjects as $key => $projID){
            $scope = getListSelScope($projID);
            $schedules = getListSelDates($projID);
            $keydates_proj = isDev() ? getKeyDatesProj($schedules,$scope) : getKeyDatesProjSupplier($projID);
            $start_date = $keydates_proj[0];
            $start_date2 = explode('/',$start_date);
            $start_date2 = date_create_from_format('m/Y',$start_date2[0].'/'.$start_date2[1]);
            $end_date = $keydates_proj[2];
            $end_date2 = explode('/',$end_date);
            $end_date2 = date_create_from_format('m/Y',$end_date2[0].'/'.$end_date2[1]);
            $duration_Y = intval($end_date2->diff($start_date2)->y);
            $duration_M = intval($end_date2->diff($start_date2)->m);
            $duration = $duration_Y*12+$duration_M;

            $solutionsSize = [];
            foreach ($scope as $measID => $listUcs) {
                foreach ($listUcs as $ucID) {
                    $sol = getSolutionByUcID($ucID);
                    if(isset($solutionsSize[$sol['id']])){
                        $solutionsSize[$sol['id']]['nb'] += 1;
                    }else{
                        $solutionsSize[$sol['id']] = ["name"=>$sol['name'], "nb"=>1];
                    }
                }
            }
            $projectsData[$projID] = ['scope'=>$scope,"solutionsSize"=>$solutionsSize,'start_date'=>$start_date,'duration_Y'=>$duration_Y,'duration_M'=>$duration_M,'duration'=>$duration];
        }
        $measures = getListMeasures();
        $ucs = getListUCs();
        $devises = getListDevises();
        $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
        $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
        echo $twig->render('/output/comparison_items/projects_item/summary.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,
        'selDevName'=>$selDevName,'is_admin'=>$user[3],'projects'=>$projects,'selProjects'=>$selProjects,'projectsData'=>$projectsData,'measures'=>$measures,
        'ucs'=>$ucs,"side"=>$side));
        prereq_compProjects();
    } else {
        throw new Exception("There is no selected projects");
    }
}

function getCBValues($projID,$scope,$schedules,$keydates_proj, $side = "customer"){
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
            $netProjectCost_old = calcNetProjectCost($projectYears,$implemTot,$opexTot_new,$revenuesTot_new,$capexAmortization["perYear"]);
            $netProjectCost = add_arrays($netProjectCost,$netProjectCost_old);
            $baselineOpCost_old = calcBaselineOpCost($projectYears,$baseline_crb,$cashreleasingTot_new);
            $baselineOpCost = add_arrays($baselineOpCost,$baselineOpCost_old);
            

            $CRV_old = getCRV($projectYears,$capexTot,$capexAmortization["perYear"]);
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
    
    $resPayback = calcPayback($netcashPerMonth);
    $payback = $resPayback[1];

    $netsoccashPerMonth = calcNetSocCashPerMonth($projectDates,$capexPerMonth,$implemPerMonth,$opexPerMonth,$revenuesPerMonth,$cashreleasingPerMonth,$widercashPerMonth);
    $netsoccashTot = calcNetSocCashTot($netsoccashPerMonth[0],$projectYears);

    $resSocPayback = calcPayback($netsoccashPerMonth);
    $socpayback = $resSocPayback[1];

    $budgetCost = add_arrays($netProjectCost,$baselineOpCost);
    $OB = calcOB($projectYears,$budgetCost);
    $OBYI = $OB[0];
    //$OBCI = $OB[1];
    
    $ratingNonCash = $nbUCS != 0 && $ratingNonCash > 0 ? $ratingNonCash/$nbUCS : -1;
    
    $ratingRisks = $nbUCS != 0 && $ratingRisks > 0 ? $ratingRisks/$nbUCS : -1;
    


    $capexTot = 0;
    $implemTot = 0;
    $opexTot = 0;
    $revenuesTot = 0;
    $cashreleasingTot = 0;
    $widercashTot = 0;
    //
    $revenuesSuppEquipTot = 0;
    $revenuesSuppDepTot = 0;
    $revenuesSuppRecTot = 0;
    //
    foreach ($scope as $i => $value) {
        for($j = 0; $j<count($scope[$i]); $j++){
            $ucID = $scope[$i][$j];
            $capexTot += getCashOutYear($projID, $ucID, $projectYears, $scope, "from_ntt","capex", $side)['tot'] + getCashOutYear($projID, $ucID, $projectYears, $scope, "from_outside_ntt","capex", $side)['tot'];
            $implemTot += getCashOutYear($projID, $ucID, $projectYears, $scope, "from_ntt","implem", $side)['tot'] + getCashOutYear($projID, $ucID, $projectYears, $scope, "internal","implem", $side)['tot'] + getCashOutYear($projID, $ucID, $projectYears, $scope, "from_outside_ntt","implem", $side)['tot'];
            $opexTot += getCashOutYear($projID, $ucID, $projectYears, $scope, "from_ntt","opex", $side)['tot'] + getCashOutYear($projID, $ucID, $projectYears, $scope, "internal","opex", $side)['tot'] + getCashOutYear($projID, $ucID, $projectYears, $scope, "from_outside_ntt","opex", $side)['tot'];
            $revenuesTot += getCashInMonthYear($projID, $ucID, $projectYears, $scope, "revenues", $side)['tot'] ;
            $cashreleasingTot += getCashInMonthYear($projID, $ucID, $projectYears, $scope, "cash_realeasing_benefits", $side)['tot'] ;
            $widercashTot += getCashInMonthYear($projID, $ucID, $projectYears, $scope, "wider_cash_benefits", $side)['tot'];
            if($side == "supplier"){
                $revenuesSuppEquipTot = getCashInMonthYear($projID, $ucID, $projectYears, $scope, "equipment", $side)['tot'];
                $revenuesSuppDepTot = getCashInMonthYear($projID, $ucID, $projectYears, $scope, "deployment", $side)['tot'];
                $revenuesSuppRecTot = getCashInMonthYear($projID, $ucID, $projectYears, $scope, "operating", $side)['tot'];
            }
        }
    }
    $capexTot = round($capexTot, 2);
    $implemTot = round($implemTot, 2);
    $opexTot = round($opexTot, 2);
    $revenuesTot = round($revenuesTot, 2);
    $cashreleasingTot = round($cashreleasingTot, 2);
    $widercashTot = round($widercashTot, 2);
    //
    $revenuesSuppEquipTot = round($revenuesSuppEquipTot, 2);
    $revenuesSuppDepTot = round($revenuesSuppDepTot, 2);
    $revenuesSuppRecTot = round($revenuesSuppRecTot, 2);
    //
    $cashin = $revenuesTot + $cashreleasingTot + $widercashTot + $revenuesSuppEquipTot + $revenuesSuppDepTot + $revenuesSuppRecTot;
    $cashout = $capexTot + $implemTot + $opexTot;
    return ['capex'=>$capexTot,'implementation'=>$implemTot,'opex'=>$opexTot ,'revenues'=>$revenuesTot, "cashin"=>$cashin, "cashout"=>$cashout,
    'cashreleasing'=>$cashreleasingTot,'widercash'=>$widercashTot,'netcash'=>$netcashTot[0]['tot'],'netsoccash'=>$netsoccashTot[0]['tot'],
    'noncash'=>$ratingNonCash,'risks'=>$ratingRisks,'npv'=>$NPV,'socnpv'=>$SOCNPV,'roi'=>$ROI,'socroi'=>$SOCROI,'payback'=>$resPayback[0],'socpayback'=>$resSocPayback[0]];
}

function comparisonCategoriePage($twig,$is_connected, $cat, $side="customer"){
    
    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    $dataIndicator = [
        'capex'=>["name"=>"Capex", "unit"=>$selDevSym],
        'implementation'=>["name"=>"Implementation", "unit"=>$selDevSym],
        'opex'=>["name"=>"Opex", "unit"=>$selDevSym],
        'revenues'=>["name"=>"Revenue", "unit"=>$selDevSym],
        'cashreleasing'=>["name"=>"Cash Releasing Benefits", "unit"=>$selDevSym],
        'widercash'=>["name"=>"Wider Cash Benefits", "unit"=>$selDevSym],
        'netcash'=>["name"=>"Net Cash", "unit"=>$selDevSym],
        'netsoccash'=>["name"=>"Net Societal Cash", "unit"=>$selDevSym],
        'noncash'=>["name"=>"Non cash benefits", "unit"=>"#"],
        'risks'=>["name"=>"Risk", "unit"=>"%"],
        'cashin'=>["name"=>"Cash-In", "unit"=>$selDevSym],
        'cashout'=>["name"=>"Cash-Out", "unit"=>$selDevSym],
        'npv'=>["name"=>"NPV", "unit"=>$selDevSym],
        'socnpv'=>["name"=>"Societal NPV", "unit"=>$selDevSym],
        'roi'=>["name"=>"ROI", "unit"=>"%"],
        'socroi'=>["name"=>"Societal ROI", "unit"=>"%"],
        'payback'=>["name"=>"Payback", "unit"=>"month(s)"],
        'socpayback'=>["name"=>"Societal Payback", "unit"=>"month(s)"],

    ];
    $cat2Indicator = [
        "invest"=>['capex','implementation'],
        "op"=>['opex','revenues','cashreleasing','widercash'],
        "cash_flows"=>['netcash','netsoccash'],
        "non_quant"=>['noncash','risks'],
        "finsoc_comp"=>['cashin','cashout','npv','socnpv','roi', 'socroi', 'payback', 'socpayback']];

    $cat2Bubble = [
        "invest"=>[],
        "op"=>[],
        "cash_flows"=>[],
        "non_quant"=>[],
        "finsoc_comp"=>[['cashin', "cashout"], ["npv", "socnpv"], ['roi', 'socroi'], ['payback', 'socpayback']]
    ];


            
    $user = getUser($_SESSION['username']);
    if(isset($_SESSION['selProjects']) && count($_SESSION['selProjects'])){
        $selProjects  = $_SESSION['selProjects'];
        $projects = getListProjects2($user[0]);
        $compoData = [];
        $bubbleData = [];

        foreach($selProjects as $key => $projID){
            $scope = getListSelScope($projID);
            $schedules = getListSelDates($projID);
            $keydates_proj = isDev() ? getKeyDatesProj($schedules,$scope) : getKeyDatesProjSupplier($projID);
            $CB_values = getCBValues($projID,$scope,$schedules,$keydates_proj, $side);
            $compoData[$projID] = [];
            $bubbleData[$projID] = [];
            foreach ($cat2Indicator[$cat] as  $indicator) {
                $compoData[$projID][$indicator] = $CB_values[$indicator];
            }
            foreach ($cat2Bubble[$cat] as  $bubble) {
                array_push($bubbleData[$projID], [$bubble[0] => $CB_values[$bubble[0]],$bubble[1] => $CB_values[$bubble[1]]]);
            }
        } 
       
        echo $twig->render('/output/comparison_items/projects_item/general_comp.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,
        'selDevName'=>$selDevName,'is_admin'=>$user[3],'compoData'=>$compoData,'projects'=>$projects, "side"=>$side, "list_compo" => $cat2Indicator[$cat],"list_bubble" => $cat2Bubble[$cat],
        "cat2Indicator"=>$cat2Indicator[$cat], 'bubbleData'=>$bubbleData, "cat2Bubble"=>$cat2Bubble[$cat], "dataIndicator"=>$dataIndicator, "cat"=>$cat));
        prereq_compProjects();

    } else {
        throw new Exception("There is no selected projects");

    }
}


function investment($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    if(isset($_SESSION['selProjects'])){
        $selProjects  = $_SESSION['selProjects'];
        $projects = getListProjects2($user[0]);
        $list_compo = ['capex','implementation'];
        $compoData = [];
        foreach ($selProjects as $projID) {
            $compoData[$projID] = ['capex'=>0,'implementation'=>0];
        }
        foreach($selProjects as $key => $projID){
            $scope = getListSelScope($projID);
            $schedules = getListSelDates($projID);
            $keydates_proj = isDev() ? getKeyDatesProj($schedules,$scope) : getKeyDatesProjSupplier($projID);
            $CB_values = getCBValues($projID,$scope,$schedules,$keydates_proj);
            $capex = $CB_values['capex'];
            $implem = $CB_values['implementation'];
            $compoData[$projID]['capex'] = $capex;
            $compoData[$projID]['implementation'] = $implem;
        }
        $devises = getListDevises();
        $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
        $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
        
        echo $twig->render('/output/comparison_items/projects_item/investment.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3],'list_compo'=>$list_compo,'compoData'=>$compoData,'projects'=>$projects));
        prereq_compProjects();
    } else {
        throw new Exception("There is no selected projects");

    }
}

function operations($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    if(isset($_SESSION['selProjects'])){
        $selProjects  = $_SESSION['selProjects'];
        $projects = getListProjects2($user[0]);
        $list_compo = ['opex','revenues','cash releasing benefits','wider cash benefits'];
        $compoData = [];
        foreach ($selProjects as $projID) {
            $compoData[$projID] = ['opex'=>[],'revenues'=>[],'cash releasing benefits'=>[],'wider cash benefits'=>[]];
        }
        foreach($selProjects as $key => $projID){
            $scope = getListSelScope($projID);
            $schedules = getListSelDates($projID);
            $keydates_proj = isDev() ? getKeyDatesProj($schedules,$scope) : getKeyDatesProjSupplier($projID);
            $CB_values = getCBValues($projID,$scope,$schedules,$keydates_proj);
            $opex = $CB_values['opex'];
            $revenues = $CB_values['revenues'];
            $cashreleasing = $CB_values['cashreleasing'];
            $widercash = $CB_values['widercash'];
            $compoData[$projID]['opex'] = $opex;
            $compoData[$projID]['revenues'] = $revenues;
            $compoData[$projID]['cash releasing benefits'] = $cashreleasing;
            $compoData[$projID]['wider cash benefits'] = $widercash;
        }

        //var_dump($compoData);
        $devises = getListDevises();
        $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
        $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
        
        echo $twig->render('/output/comparison_items/projects_item/operations.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3],'list_compo'=>$list_compo,'compoData'=>$compoData,'projects'=>$projects));
        prereq_compProjects();
    } else {
        throw new Exception("There is no selected projects");

    }
}

function cash_flows($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    if(isset($_SESSION['selProjects'])){
        $selProjects  = $_SESSION['selProjects'];
        $projects = getListProjects2($user[0]);
        $list_compo = ['net cash','net societal cash'];
        $compoData = [];
        foreach ($selProjects as $projID) {
            $compoData[$projID] = ['netcash'=>0,'netsoccash'=>0];
        }
        foreach($selProjects as $key => $projID){
            $scope = getListSelScope($projID);
            $schedules = getListSelDates($projID);
            $keydates_proj = isDev() ? getKeyDatesProj($schedules,$scope) : getKeyDatesProjSupplier($projID);
            $CB_values = getCBValues($projID,$scope,$schedules,$keydates_proj);
            $netcash = $CB_values['netcash'];
            $netsoccash = $CB_values['netsoccash'];
            $compoData[$projID]['netcash'] = $netcash;
            $compoData[$projID]['netsoccash'] = $netsoccash;
        }

        //var_dump($compoData);
        $devises = getListDevises();
        $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
        $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
        
        echo $twig->render('/output/comparison_items/projects_item/cash_flows.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3],'list_compo'=>$list_compo,'compoData'=>$compoData,'projects'=>$projects));
        prereq_compProjects();
    } else {
        throw new Exception("There is no selected projects");

    }
}

function non_quant($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    if(isset($_SESSION['selProjects'])){
        $selProjects  = $_SESSION['selProjects'];
        $projects = getListProjects2($user[0]);
        $list_compo = ['non cash benefits','risks'];
        $compoData = [];
        foreach ($selProjects as $projID) {
            $compoData[$projID] = ['noncash'=>0,'risks'=>0];
        }
        foreach($selProjects as $key => $projID){
            $scope = getListSelScope($projID);
            $schedules = getListSelDates($projID);
            $keydates_proj = isDev() ? getKeyDatesProj($schedules,$scope) : getKeyDatesProjSupplier($projID);
            $CB_values = getCBValues($projID,$scope,$schedules,$keydates_proj);
            $noncash = $CB_values['noncash'];
            $risks = $CB_values['risks'];
            $compoData[$projID]['noncash'] = $noncash;
            $compoData[$projID]['risks'] = $risks;
        }

        //var_dump($compoData);
        $devises = getListDevises();
        $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
        $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
        
        echo $twig->render('/output/comparison_items/projects_item/non_quant.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3],'list_compo'=>$list_compo,'compoData'=>$compoData,'projects'=>$projects));
        prereq_compProjects();
    } else {
        throw new Exception("There is no selected projects");

    }
}

function finsoc_comp($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    if(isset($_SESSION['selProjects'])){
        $selProjects  = $_SESSION['selProjects'];
        $projects = getListProjects2($user[0]);
        $list_compo = ['npv','societal npv','return over investment','societal return over investment','payback','societal payback'];
        $compoData = [];
        foreach ($selProjects as $projID) {
            $compoData[$projID] = ['npv'=>0,'societal npv'=>0,'return over investment'=>0,'societal return over investment'=>0,'payback'=>0,'societal payback'=>0];
        }
        foreach($selProjects as $key => $projID){
            $scope = getListSelScope($projID);
            $schedules = getListSelDates($projID);
            $keydates_proj = isDev() ? getKeyDatesProj($schedules,$scope) : getKeyDatesProjSupplier($projID);
            $CB_values = getCBValues($projID,$scope,$schedules,$keydates_proj);
            $npv = $CB_values['npv'];
            $socnpv = $CB_values['socnpv'];
            $roi = $CB_values['roi'];
            $socroi = $CB_values['socroi'];
            $payback = $CB_values['payback'];
            $socpayback = $CB_values['socpayback'];
            $compoData[$projID]['npv'] = $npv;
            $compoData[$projID]['socnpv'] = $socnpv;
            $compoData[$projID]['roi'] = $roi;
            $compoData[$projID]['socroi'] = $socroi;
            $compoData[$projID]['payback'] = $payback;
            $compoData[$projID]['socpayback'] = $socpayback;
        }

        $devises = getListDevises();
        $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
        $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
        
        echo $twig->render('/output/comparison_items/projects_item/finsoc_comp.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3],'list_compo'=>$list_compo,'compoData'=>$compoData,'projects'=>$projects));
        prereq_compProjects();
    } else {
        throw new Exception("There is no selected projects");

    }
}

function prereq_compProjects(){
    if(isset($_SESSION['selProjects'])){
        echo "<script>prereq_compProjects(true);</script>";
    }  
}











// ------------------------------- COMPARE FINANCIAL SCENARIOS -------------------------------

function comp_finscen($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/output/comparison_items/comp_finscen.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3]));
}

function scenarios($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    $idUser = $user[0];
    $projects = getListProjects2($idUser);
    $list_scen = [];
    foreach($projects as $projID => $proj){
        $list_scen[$projID] = 
        getListScenariosByProj($projID);
    }
    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/output/comparison_items/fin_scen_items/scenarios.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3],'projects'=>$projects,'list_scen'=>$list_scen));
}

function scenarios_selected($post){
    if($post){
        $user = getUser($_SESSION['username']);
        $selScenarios = [];
       foreach($post as $key => $value){
            $temp = explode('_',$key);
            if($temp[0] == "scen"){
                $scenID = intval($temp[1]);
                array_push($selScenarios,$scenID);
            }
        }
        $_SESSION['selScenarios'] = $selScenarios;
        header('Location: ?A=comp_finscen&A2=fin_summary');
    } else {
        throw new Exception("No project selected !");
    }
}

function fin_summary($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    $idUser = $user[0];
    if(isset($_SESSION['selScenarios'])){
        $selScenarios  = $_SESSION['selScenarios'];
        $list_compo = ['funding mix','cash flows'];
        $list_scen = [];
        foreach($selScenarios as $scenID){
            $list_scen[$scenID] = getScenByID($scenID);
        }
        $projects = getListProjects2($idUser);

        $FS = getListFundingSources();
        $FS_cat = getListFundingSourcesCat();
        $sel_FS = [];
        $funding_target = [];
        foreach($selScenarios as $scenID){
            $data = getFinancingData($scenID,$FS);
            $sel_FS[$scenID] = $data['sel_FS'];
            $funding_target[$scenID] = $data['funding_target'];
        }

        $devises = getListDevises();
        $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
        $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
        
        echo $twig->render('/output/comparison_items/fin_scen_items/fin_summary.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3],'projects'=>$projects,'list_scen'=>$list_scen,'list_compo'=>$list_compo,'FS'=>$FS,'FS_cat'=>$FS_cat,'sel_FS'=>$sel_FS,'funding_target'=>$funding_target));
        prereq_compFinScen();
    } else {
        throw new Exception("There is no selected scenarios");

    }
}

function getFinancingData($scenID,$list_FS){
    $list_selFS = getListSelFS($scenID);

    $list_selLB = getListLoansAndBonds($scenID);
    $list_selOthers = getListOthers($scenID);
    $list_selEntities = getEntities($list_selLB,$list_selOthers);

    $list_FS_noentity = getFStoInclude($list_selEntities,$list_selFS,$list_FS);
    $list_FS_noentity_LB = $list_FS_noentity[0];
    $list_FS_noentity_others = $list_FS_noentity[1];

    $datesLB = getDatesLB($list_selLB,$list_FS_noentity_LB);
    $datesOthers = getDatesOthers($list_selOthers,$list_FS_noentity_others);

    $funding_target = getFundingTarget($scenID);

    $keydates_LB = array_replace($datesLB[1], $datesLB[2]);
    $keydates_others = array_replace($datesOthers[0], $datesOthers[1]);

    $keydates = array_replace($keydates_LB,$keydates_others);
    return ['sel_FS'=>$list_selFS,'funding_target'=>$funding_target,'keydates'=>$keydates];
}

function cash_flows_comp($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    $idUser = $user[0];
    if(isset($_SESSION['selScenarios'])){
        $selScenarios  = $_SESSION['selScenarios'];
        $list_compo = ['funding mix','cash flows'];
        $list_scen = [];
        foreach($selScenarios as $scenID){
            $list_scen[$scenID] = getScenByID($scenID);
        }
        $projects = getListProjects2($idUser);
        $FS = getListFundingSources();
        $FS_cat = getListFundingSourcesCat();
        $sel_FS = [];
        $funding_target = [];
        $keydates = [];
        $years = [];
        $cashFlows = [];
        foreach($selScenarios as $scenID){
            $data = getFinancingData($scenID,$FS);
            $sel_FS[$scenID] = $data['sel_FS'];
            $funding_target[$scenID] = $data['funding_target'];
            $keydates[$scenID] = $data['keydates'];
            $scen = getScenByID($scenID);
            $projID = $scen['id_proj'];
            $cashFlows_data = getCashFlows($scenID,$projID,$FS);
            $years_new = $cashFlows_data['years'];
            $years = addYears($years,$years_new);
            $funding_req = calcFundingReq($cashFlows_data);
            $funding_res = calcFundingRes($cashFlows_data);
            $netcash = calcNetCash($years_new,$funding_res,$funding_req);
            $cashbalance = calcCashBalance($netcash);
            $cashFlows[$scenID] = ['netcash'=>$netcash,'cashbalance'=>$cashbalance];

        }
        $years = correctYears($years);
        

        $devises = getListDevises();
        $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
        $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
        
        echo $twig->render('/output/comparison_items/fin_scen_items/cash_flows.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3],'projects'=>$projects,'list_scen'=>$list_scen,'list_compo'=>$list_compo,'FS'=>$FS,'FS_cat'=>$FS_cat,'sel_FS'=>$sel_FS,'funding_target'=>$funding_target,'years'=>$years,'cashFlows'=>$cashFlows));
        prereq_compFinScen();
    } else {
        throw new Exception("There is no selected scenarios");

    }
}

function calcFundingRes($cashFlows_data){
    $funding_ressources = $cashFlows_data['funding_ressources'];
    $list = [];
    foreach($funding_ressources as $idSource => $list_years){
        foreach($list_years as $year => $value){
            if(array_key_exists($year,$list)){
                $list[$year] += $value;
            } else {
                $list[$year] = $value;
            }
        }
    }
    return $list;
}

function calcNetCash($years,$funding_res,$funding_req){
    $list = [];
    //var_dump($years);
    foreach($years as $year){
        $I = isset($funding_req[$year]) ? $funding_req[$year] : 0;
        $II = isset($funding_res[$year]) ? $funding_res[$year] : 0;
        $list[$year] = $II - $I;
    }
    //var_dump($list);
    return $list;
}

function calcCashBalance($netcash){
    $list = [];
    foreach($netcash as $key => $value){
        $last = end($list) ? end($list) : 0;
        $list[$key] = $last + $value;
    }
    return $list;
}

function calcFundingReq($cashFlows_data){
    $years = $cashFlows_data['years'];
    $capex = $cashFlows_data['capex'];
    $implem = $cashFlows_data['implem'];
    $opex = $cashFlows_data['opex'];
    $revenues = $cashFlows_data['revenues'];
    $cashreleasing = $cashFlows_data['cashreleasing'];
    $interestTerm = $cashFlows_data['interestTerm'];
    $interestRev = $cashFlows_data['interestRev'];
    $reimbTerm = $cashFlows_data['reimbTerm'];
    $reimbRev = $cashFlows_data['reimbRev'];
    $list = [];
    foreach($years as $year){
        $a = isset($capex[$year]) ? $capex[$year] : 0;
        $b = isset($implem[$year]) ? $implem[$year] : 0;
        $c = isset($opex[$year]) ? $opex[$year] : 0;
        $d = isset($revenues[$year]) ? $revenues[$year] : 0;
        $e = isset($cashreleasing[$year]) ? $cashreleasing[$year] : 0;

        $A = $a + $b;
        $B = $c - $d - $e;
        $C = calcTotFin($year,$interestTerm,$interestRev);
        $D = calcTotFin($year,$reimbTerm,$reimbRev);
        //var_dump($A.' - '.$B.' - '.$C.' - '.$D);
        
        $list[$year] = $A + $B + $C + $D;
    }
    //var_dump($list);
    return $list;
}

function calcTotFin($year,$term,$rev){
    $tot = 0;
    foreach($term as $idSource => $list_entities){
        if(array_key_exists('All Years',$list_entities)){
            $tot += isset($list_entities[$year]) ?  $list_entities[$year] : 0;
        } else {
            foreach($list_entities as $idEntity => $list_values){
                $tot += isset($list_values[$year]) ?  $list_values[$year] : 0;
            }
        }
    }
    foreach($rev as $idSource => $list_entities){
        if(array_key_exists('All Years',$list_entities)){
            $tot += isset($list_entities[$year]) ?  $list_entities[$year] : 0;
        } else {
            foreach($list_entities as $idEntity => $list_values){
                $tot += isset($list_values[$year]) ?  $list_values[$year] : 0;
            }
        }
    }
    return $tot;
}

function addYears($years_old,$years_new){
    foreach($years_new as $year){
        if(!in_array($year,$years_old)){
            array_push($years_old,$year);
        }
    }
    return $years_old;
}

function correctYears($years){
    $years_correct = [];
    $start = $years[0];
    $end = end($years);
    for ($year=$start; $year <= $end ; $year++) { 
        array_push($years_correct,$year);
    }
    return $years_correct;
}

function getCashFlows($scenID,$projID,$list_FS){
    
    $scope = getListSelScope($projID);
    $schedules = getListSelDates($projID);
    $keydates_proj = isDev() ? getKeyDatesProj($schedules,$scope) : getKeyDatesProjSupplier($projID);
    $projectYears = getYears($keydates_proj[0],$keydates_proj[2]);
    $projectDates = createProjectDates($keydates_proj[0],$keydates_proj[2]);

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

    $nbUCS = 0;

    foreach ($scope as $measID => $list_ucs) {
        $nbUCS+=sizeof($list_ucs);
        foreach ($list_ucs as $ucID) {
            $implemSchedule = $schedules['implem'][$ucID];
            $opexSchedule = $schedules['opex'][$ucID];
            $revenuesSchedule = isset($schedules['revenues'][$ucID]) ? $schedules['revenues'][$ucID] : [];

            $implemRepart = getRepartPercImplem($implemSchedule,$projectDates);

            $capex = getTotCapexByUC($projID,$ucID);
            $capexPerMonth_new = calcCapexPerMonth($implemRepart,$capex);
            $capexTot_new = calcCapexTot($capexPerMonth_new,$projectYears);
            $capexPerMonth = add_arrays($capexPerMonth,$capexPerMonth_new);
            $capexTot = add_arrays($capexTot,$capexTot_new);

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
        }
    }

    $list_selFS = getListSelFS($scenID);
    $list_selLB = getListLoansAndBonds($scenID);
    $list_selOthers = getListOthers($scenID);
    $list_selEntities = getEntities($list_selLB,$list_selOthers);

    $list_FS_noentity = getFStoInclude($list_selEntities,$list_selFS,$list_FS);
    $list_FS_noentity_LB = $list_FS_noentity[0];
    $list_FS_noentity_others = $list_FS_noentity[1];
    

    $datesLB = getDatesLB($list_selLB,$list_FS_noentity_LB);
    $years_LB = array_merge(['All Years'],$datesLB[3]);
    $funding_target = getFundingTarget($scenID);
    $cashInflow = calcCashInflow($datesLB,$years_LB,$funding_target,$list_selLB,$list_FS_noentity_LB);
    $termSources = [5,7]; // here are the IDs of "Term Sources" (Loans & Bonds -> Term) --> it must correspond to the DB
    $revSources = [6,8]; // here are the IDs of "Revolving Sources" (Loans & Bonds -> Revolving) --> it must correspond to the DB
    $reimbTerm = calcReimbTerm($datesLB,$years_LB,$funding_target,$list_selLB,$list_FS_noentity_LB,$termSources);
    $reimbRev = calcReimbRev($datesLB,$years_LB,$funding_target,$list_selLB,$list_FS_noentity_LB,$revSources);
    $netDebtTerm = calcNetDebt($datesLB,$years_LB,$cashInflow,$reimbTerm,$list_selLB,$list_FS_noentity_LB,$termSources);
    $netDebtRev = calcNetDebt($datesLB,$years_LB,$cashInflow,$reimbRev,$list_selLB,$list_FS_noentity_LB,$revSources);
    $interestTerm = calcInterest($datesLB,$years_LB,$netDebtTerm,$list_selLB,$list_FS_noentity_LB,$termSources);
    $interestRev = calcInterest($datesLB,$years_LB,$netDebtRev,$list_selLB,$list_FS_noentity_LB,$revSources);
    $totalTerm = calcTotalLB($datesLB,$years_LB,$list_selLB,$list_FS_noentity_LB,$cashInflow,$reimbTerm,$netDebtTerm,$interestTerm,$termSources);
    $totalRev = calcTotalLB($datesLB,$years_LB,$list_selLB,$list_FS_noentity_LB,$cashInflow,$reimbRev,$netDebtRev,$interestRev,$revSources);
    $funding_target = getFundingTarget($scenID);

    $temp = calcFundingRessources($funding_target,$list_selFS,$list_selEntities,$years_LB);
    $funding_ressources = $temp[0];
    $years = $temp[1];
    return ['capex'=>$capexTot,'implem'=>$implemTot,'opex'=>$opexTot,'revenues'=>$revenuesTot,'cashreleasing'=>$cashreleasingTot,'years'=>$years,'interestTerm'=>$interestTerm,'interestRev'=>$interestRev,'reimbTerm'=>$reimbTerm,'reimbRev'=>$reimbRev,'funding_ressources'=>$funding_ressources];
}

function prereq_compFinScen(){
    if(isset($_SESSION['selScenarios'])){
        echo "<script>prereq_compFinScen(true);</script>";
    }  
}