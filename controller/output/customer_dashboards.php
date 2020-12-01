<?php

function prereq_dashbords(){
    if(isset($_GET['A2'])){
        echo "
        
        <script>prereq_dashbords();</script>";
    }
}

function getItemMonthlyRevenues($itemData,$proj_start_date, $proj_end_date){

}

function getCutomserRevenueItemByMonth($projID,$ucID){
    // return the list of the revenues by month of the items of a UC    
    $keydates_proj = getKeyDatesProjSupplier($projID);
    $list=[];
    $revenues = getListSelRevenues($projID,$ucID);
    $projectDates = createProjectDates($keydates_proj[0],$keydates_proj[2]);

    foreach ($revenues as $itemID => $revenue) {
        $schedule = getProjetSchedule($projID,$ucID);
        if(isset($schedule[0]) && isset($revenue['volume']) && $revenue['volume']>0){
            //$schedule = $schedule[0];
            $rev_start = date_create($revenue['revenue_start_date'])->format("m/Y");
            $rev_end = date_create($schedule['uc_end'])->format("m/Y");
    
            //var_dump($revenue);
            $ramp_up_end = new DateTime($revenue['revenue_start_date']);
            $ramp_up_duration =$revenue['ramp_up_duration'];
            //var_dump($ramp_up_end);
            $ramp_up_end->modify("+$ramp_up_duration months");
            //var_dump($ramp_up_end);
            $ramp_up_end = $ramp_up_end->format('m/Y');
            //var_dump($ramp_up_end);
            $revenueSchedule = getRevenueRepartition($keydates_proj[0], $rev_start, $ramp_up_end, $rev_end, $projectDates);
            $i=0;
            foreach ($revenueSchedule as $date => $prop) {
                $list[$itemID][$date] = $prop * $revenue['unit_rev'] *$revenue['volume']*pow(1+$revenue['anVarVol'],$i/12)*pow(1+$revenue['anVarRev'],$i/12) ;
                $i++;
            }
        }
    }
    return $list;
    
}

function getRevenueRepartition($projStart,$rev_start, $ramp_up_end, $rev_end, $projectDates){
    $repart=[];

    //var_dump($projStart);
    $nb_lag = difMonthsBounds($rev_start, $projStart);
    $nb_ramp_up = difMonthsBounds($ramp_up_end, $rev_start)+$nb_lag;
    $nb_run = difMonthsBounds($rev_end, $ramp_up_end)+$nb_ramp_up;

    //var_dump($ramp_up_end);
    //var_dump($rev_start);

    //var_dump($nb_ramp_up);
    //var_dump($nb_run);
    //var_dump($projectDates);
    for($i = 0; $i<$nb_lag; $i++){
        $repart[$projectDates[$i]] = 0;
    }
    for($i = $nb_lag; $i<$nb_ramp_up; $i++){
        $repart[$projectDates[$i]] = $i/$nb_ramp_up*1;
    }
    for($i = $nb_ramp_up;$i<$nb_run; $i++ ){
        //var_dump($projectDates[$i], $i);
        //var_dump($nb_ramp_up);
        $repart[$projectDates[$i]] = 1;
    }
    for($i = $nb_run; $i<count($projectDates);$i++){
        $repart[$projectDates[$i]]=0;
    }
    return $repart;

}

function getNetCumulatedCash($projID, $scope, $projectYears, $side, $periode="year"){

    
    $lastYear = $projectYears[array_key_last($projectYears)];
    foreach ($projectYears as $yearKey) {
        if($yearKey!="tot"){
            $net_cumulated_cash[$yearKey]=0;
        }
    }
    foreach ($scope as $i => $value) {
        for($j = 0; $j<count($scope[$i]); $j++){
            $ucID = $scope[$i][$j];
            // Cash-out Capex
           $capex_from_nttTot = getCashOutYear($projID, $ucID, $projectYears, $scope, "from_ntt","capex", $side, $periode);
       
           $capex_from_outside_nttTot = getCashOutYear($projID, $ucID, $projectYears, $scope, "from_outside_ntt","capex", $side, $periode);
 
            //Cash-out Opex
        
           $opex_from_nttTot =  getCashOutYear($projID, $ucID, $projectYears, $scope, "from_ntt","opex", $side, $periode);
           $opex_from_outside_nttTot = getCashOutYear($projID, $ucID, $projectYears, $scope, "from_outside_ntt","opex", $side, $periode);
       
           $opex_internalTot =  getCashOutYear($projID, $ucID, $projectYears, $scope, "internal","opex", $side, $periode);
       
        
            //Cash-out Deployment 
        
        
           $implem_from_nttTot = getCashOutYear($projID, $ucID, $projectYears, $scope, "from_ntt","implem", $side, $periode);
           $implem_from_outside_nttTot = getCashOutYear($projID, $ucID, $projectYears, $scope, "from_outside_ntt","implem", $side, $periode);
           $implem_internalTot = getCashOutYear($projID, $ucID, $projectYears, $scope, "internal","implem", $side, $periode);
       
            //Cash-in 
            if($side == "customer"){
                //Cash-in : Revenues
                $revenues = getCashInMonthYear($projID, $ucID, $projectYears, $scope, "revenues", $side, $periode);
        
                //Cash-in : Cash Realeasing Benefits
                $cash_realeasing_benefits = getCashInMonthYear($projID, $ucID, $projectYears, $scope, "cash_realeasing_benefits", $side, $periode);
        
                //Cash-in : Cash Realeasing Benefits
                $wider_cash_benefits = getCashInMonthYear($projID, $ucID, $projectYears, $scope, "wider_cash_benefits", $side, $periode);
            }elseif($side == "supplier"){
                $equipment = getCashInMonthYear($projID, $ucID, $projectYears, $scope, "equipment", $side, $periode);
                $deployment = getCashInMonthYear($projID, $ucID, $projectYears, $scope, "deployment", $side, $periode);
                $operating = getCashInMonthYear($projID, $ucID, $projectYears, $scope, "operating", $side, $periode);
            }
        

            foreach ($projectYears as $yearKey) {
                if($yearKey!="tot"){
                    if($side !="supplier"){
                        $net_cumulated_cash[$yearKey] += $revenues[$yearKey]+ $cash_realeasing_benefits[$yearKey] - ($capex_from_nttTot[$yearKey] + $capex_from_outside_nttTot[$yearKey] + $opex_from_nttTot[$yearKey]+$opex_from_outside_nttTot[$yearKey]+$opex_internalTot[$yearKey] + $implem_from_nttTot[$yearKey]+$implem_from_outside_nttTot[$yearKey]+$implem_internalTot[$yearKey]); 
                    }else{
                        $net_cumulated_cash[$yearKey] += $equipment[$yearKey]+ $deployment[$yearKey] + $operating[$yearKey] - ($capex_from_nttTot[$yearKey] + $capex_from_outside_nttTot[$yearKey] + $implem_internalTot[$yearKey]+$implem_from_outside_nttTot[$yearKey] + $opex_internalTot[$yearKey]+$opex_from_outside_nttTot[$yearKey]); 
                    }
                }
            }
        }
    }
    foreach($projectYears as $yearKey){
        if($yearKey != $lastYear){
            $net_cumulated_cash[$yearKey+1] += $net_cumulated_cash[$yearKey];
        }
    }
    return $net_cumulated_cash;
}
function getPropKeyDates($scope,$projID, $keydates_uc, $keydates_proj){
    $propKeyDates=[];
    $projectStart = $keydates_proj[0];
    $projEnd= $keydates_proj[2];
    $projDuration = difMonthsBounds($projEnd, $projectStart);
    foreach ($scope as $measID => $list_ucs) {
        foreach ($list_ucs as $ucID) {
            if($ucID != -1){$scheduleDates = getProjetSchedule($projID, $ucID);
                $uc_end = date_create($scheduleDates["uc_end"])->format("m/Y");
                if($scheduleDates && $uc_end != "11/-0001"){
                    $depDuration =  $scheduleDates["deployment_duration"];
                    $depStart = $keydates_uc[$ucID]["startdate"];
                    $propKeyDates[$ucID]["lagProp"] = difMonthsBounds($depStart, $projectStart)/$projDuration * 100;
                    $propKeyDates[$ucID]["deploymentProp"] = $depDuration/$projDuration * 100;
                    $propKeyDates[$ucID]["lag2Porp"] =  (difMonthsBounds($projEnd, $uc_end)) /$projDuration * 100;
                    $propKeyDates[$ucID]["runProp"] =  100 - $propKeyDates[$ucID]["lagProp"] - $propKeyDates[$ucID]["deploymentProp"] - $propKeyDates[$ucID]["lag2Porp"];
                    
                    $exp = explode("/", $depStart);
                    $dep_end = new DateTime($exp[1]."-".$exp[0]."-01");
                    $dep_end->modify("+$depDuration months");
                    $dep_end = $dep_end->format('m/Y');


                    $propKeyDates[$ucID]["lag_end"]=$depStart;
                    $propKeyDates[$ucID]["dep_end"]=$dep_end;
                    $propKeyDates[$ucID]["uc_end"]=$uc_end;
                }

            }else{
                $propKeyDates[$ucID]["lagProp"] = 0;
                $propKeyDates[$ucID]["deploymentProp"] = difMonthsBounds($keydates_proj[1], $projectStart) / $projDuration * 100;
                $propKeyDates[$ucID]["runProp"] = 100 - $propKeyDates[$ucID]["deploymentProp"];
                $propKeyDates[$ucID]["lag2Porp"] = 0;
                $propKeyDates[$ucID]["project_start"]=$projectStart;
                $propKeyDates[$ucID]["dep_end"]=$keydates_proj[1];
                $propKeyDates[$ucID]["projEnd"]=$projEnd;
            }
            
        }
    }
    return $propKeyDates;

}


function dashboards_summary($twig,$is_connected, $projID, $sideBarName, $side){
    $GLOBALS['useFiltre2']= true;
    $user = getUser($_SESSION['username']);
    $list_projects = getListProjects($user[0]);

    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            //try{
                $bankabilityData = array('target'=>getDealCriteriaInputNogoTarget($projID, "target"), 'nogo'=>getDealCriteriaInputNogoTarget($projID, "nogo"));


                $proj = getProjByID($projID,$user[0]); 
                $ucs = getListUCs();
                $scope = getListSelScope($projID);

                unset($GLOBALS['useFiltre2']);
                $GLOBALS['useFiltre']= true;
                $scopeUCSelection = getListSelScope($projID);
                $GLOBALS['useFiltre2']= true;
                unset($GLOBALS['useFiltre']);
                

           
                
                $schedules = getListSelDates($projID);
                //print_r($schedules);
                $keydates_uc = get_keydates_uc($scope,$projID,$schedules);
                //var_dump($keydates_uc );
                $uc_check_completed = check_if_UC_is_completed($projID,$scope);
                


                $keydates_proj = getKeyDatesProjSupplier($projID);
                $projectYears = getYears($keydates_proj[0],$keydates_proj[2]);
                $projectDates = createProjectDates($keydates_proj[0],$keydates_proj[2]);
                $ItemsPerMonthAndTot = calcCBItemsPerMonthAndTot($scope, $schedules, $projectDates, $projID, $projectYears, $side);//PB
                $netcashPerMonth = calcNetCashPerMonth($projectDates,$ItemsPerMonthAndTot['capex']['perMonth'],$ItemsPerMonthAndTot['implem']['perMonth'],$ItemsPerMonthAndTot['opex']['perMonth'],$ItemsPerMonthAndTot['revenues']['perMonth'],$ItemsPerMonthAndTot['cashreleasing']['perMonth']);
                if($side != "supplier"){
                    $netsoccashPerMonth = calcNetSocCashPerMonth($projectDates,$ItemsPerMonthAndTot['capex']['perMonth'],$ItemsPerMonthAndTot['implem']['perMonth'],$ItemsPerMonthAndTot['opex']['perMonth'],$ItemsPerMonthAndTot['revenues']['perMonth'],$ItemsPerMonthAndTot['cashreleasing']['perMonth'],$ItemsPerMonthAndTot['widercash']['perMonth']);
                }
                             
                $netcashTot = calcNetCashTot($netcashPerMonth[0],$projectYears);
                $cumulnetcashTot = getNetCumulatedCash($projID, $scope, $projectYears, $side);//$netcashTot[1]; 
                if($side != "supplier"){
                    $netsoccashTot = calcNetSocCashTot($netsoccashPerMonth[0],$projectYears);
                    $cumulnetsoccashTot = $netsoccashTot[1];
                }else{
                    $cumulnetsoccashTot=[];
                }


                $revenueSum = 0;
                $cash_realeasing_benefitsSum = 0;
                $wider_cash_benefitsSum = 0;
                $ucsBenefits=[];
                $titles=[];
                foreach ($scope as $measID => $list_ucs) {
                    foreach ($list_ucs as $ucID) {
                        array_push($titles,  $ucs[$ucID]['name']);
                        $implem = getTotImplemByUC($projID,$ucID, $side);
                        $implemSchedule = $schedules['implem'][$ucID];
                        $implemRepart = getRepartPercImplem($implemSchedule,$projectDates);
                        $capex = getTotCapexByUC($projID,$ucID, $side);
                        $capexPerMonth_new = calcCapexPerMonth($implemRepart,$capex);
                        $implemPerMonth_new = calcImplemPerMonth($implemRepart,$implem);
                        $sum_capex_implem = add_arrays($capexPerMonth_new,$implemPerMonth_new);
                        array_push($ucsBenefits, getCashInMonthYear($projID, $ucID, $projectYears, $scope, "revenues", $side)['tot']); // A CHANGER
                        $revenueSum+=$ucsBenefits[count($ucsBenefits)-1];
                        if($side != "supplier"){
                            $cash_realeasing_benefitsSum+= getCashInMonthYear($projID, $ucID, $projectYears, $scope, "cash_realeasing_benefits", $side)['tot'];
                            $wider_cash_benefitsSum += getCashInMonthYear($projID, $ucID, $projectYears, $scope, "wider_cash_benefits", $side)['tot'];
                        }
                    }
                }

                $temp = getSelectedUseCases($user[0], $projID);
                foreach ($scope as $measID => $listUcs) {
                    foreach ($listUcs as $ucID) {
                        $seletedUC[$measID."_".$ucID]=isset($temp[$measID."_".$ucID]);
                    }
                }

                $dr_year = getListSelDiscountRate($projID);
                $dr_month = pow(1+($dr_year/100),1/12)-1;
                $npv2 = calcNPV($dr_month,$sum_capex_implem);
                // npv
                $fin_npv = calcNPV($dr_month,$netcashPerMonth[0]); 
                if($side != "supplier"){
                    $soc_npv = calcNPV($dr_month,$netsoccashPerMonth[0]);
                }
                $fin_societal_npv = 0;
                $soc_societal_npv = 0;

                
                //roi
                $fin_roi = calcROI($fin_npv,$npv2);     
                if($side != "supplier"){
                    $soc_roi = calcROI($soc_npv,$npv2);
                }
                $fin_societal_roi = 0;
                $soc_societal_roi = 0;

                //payback            
                $fin_payback = calcPayback($netcashPerMonth)[1];
                if($side != "supplier"){
                    $soc_payback = calcPayback($netsoccashPerMonth)[1];
                }
                $fin_societal_payback = 0;
                $soc_societal_payback = 0;

                //
                $nqb = calcRatingNonCash($projID, $scope);
                $rating_risks = calcRatingRisks($projID, $scope);

                $cahsOutTot = calcCashOut($ItemsPerMonthAndTot['capex']['perMonth'],$ItemsPerMonthAndTot['implem']['perMonth'],$ItemsPerMonthAndTot['opex']['perMonth']);
                
                if($side != "supplier"){
                    $soc_operating_margin = array_sum($cahsOutTot) == 0 ? 0 : round(($cumulnetsoccashTot[array_key_last($cumulnetsoccashTot) ])/array_sum($cahsOutTot) * 100, 2);
                }
                $fin_operating_margin = array_sum($cahsOutTot) == 0 ? 0 : round(($cumulnetcashTot[array_key_last($cumulnetcashTot) ])/array_sum($cahsOutTot) * 100, 2);
                
                if($side != "supplier"){
                    $bankability_cacl = array(
                        'fin_societal_npv'=>$fin_societal_npv,
                        'soc_societal_npv'=>$soc_societal_npv,
                        'fin_societal_roi'=>$fin_societal_roi,
                        'soc_societal_roi'=>$soc_societal_roi,
                        'fin_societal_payback'=>$fin_societal_payback,
                        'soc_societal_payback'=>$soc_societal_payback,                    
                        'fin_npv'=>$fin_npv,
                        'soc_npv'=>$soc_npv,
                        'fin_roi'=>$fin_roi,
                        'soc_roi'=>$soc_roi,
                        'fin_payback'=>$fin_payback,
                        'soc_payback'=>$soc_payback,
                        'nqb'=>$nqb,
                        'rating_risks'=>$rating_risks       
                    );
                }else{
                    $bankability_cacl = array(
                        'fin_societal_npv'=>$fin_societal_npv,
                        'fin_societal_roi'=>$fin_societal_roi,
                        'fin_societal_payback'=>$fin_societal_payback,
                        'soc_societal_payback'=>$soc_societal_payback,                    
                        'fin_npv'=>$fin_npv,
                        'fin_roi'=>$fin_roi,
                        'fin_payback'=>$fin_payback,
                        'nqb'=>$nqb,
                        'rating_risks'=>$rating_risks,
                        'fin_operating_margin'=>$fin_operating_margin        
                    );
                }
                foreach($bankability_cacl as $key => $value){
                    $bankability_cacl[$key] = round($value, 2);
                }
                
            /*}
            catch(\Throwable $th){
                header('Location: ?A='.$sideBarName);
            }*/

            
            //Distinction de cas entre supp et cust !!!
            if($side == "customer"){
                $repartition_of_benefits = array("titles"=>["Revenues", "Cash Releasing Benefits", "Wider Cash Benefits"], 
                "data"=>[
                    $revenueSum,
                    $cash_realeasing_benefitsSum,
                    $wider_cash_benefitsSum]);
            }else{
                $repartition_of_benefits = array("titles"=>$titles, 
                "data"=>$ucsBenefits);
            }
            $list_cat = getListUCsCat();
            $list_measures = getListMeasures();
            $propKeyDates = getPropKeyDates($scope,$projID, $keydates_uc, $keydates_proj);
            echo $twig->render('/output/customer_dashboards_steps/summary.twig',array(
                'is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,
                'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1], 'sideBarName'=>$sideBarName,
                'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'projects'=>$list_projects,
                'ucs'=>$ucs,'scope'=>$scope,'keydates_uc'=>$keydates_uc,'uc_completed'=>$uc_check_completed,
                'years'=>$projectYears,'cumulnetcashTot'=>$cumulnetcashTot,'cumulnetsoccashTot'=>$cumulnetsoccashTot, "propKeyDates"=>$propKeyDates,
                'bankability_target'=> $bankabilityData, "bankability_cacl"=>$bankability_cacl, 'repartition_of_benefits'=> $repartition_of_benefits,
                'seletedUC'=>$seletedUC, "scopeUCSelection"=>$scopeUCSelection,'measures'=>$list_measures, 'list_cat'=>$list_cat
            ));
            prereq_dashbords();
            
        }
    }
    unset($GLOBALS['useFiltre2']);
}

function save_uc_selection_filter($twig,$is_connected, $post, $sideBarName){
    $user = getUser($_SESSION['username']);
    $projID = getProjID();
    unSelectAllUseCasConfirmation($user[0], $projID);
    foreach($post as $key=>$value){
        $key = explode("_", $key);
        selectUseCaseConfirmation($user[0], $projID, $key[1], $key[0]);
    }
    //var_dump('Location: ?A='.$sideBarName.'&A2=summary');
    header('Location: ?A='.$sideBarName.'&A2=summary');

}

// --- Project Details
function dashboards_project_details($twig,$is_connected, $projID, $sideBarName, $side){
    $GLOBALS['useFiltre2'] = true;
    if($projID!=0){
        $user = getUser($_SESSION['username']);
        if(getProjByID($projID,$user[0])){
            
            $proj = getProjByID($projID,$user[0]); 
            $scope = getListSelScope($projID);
            $list_ucs = getListUCs();
            $selScope = getListSelScope($projID);
            $schedules = getListSelDates($projID);
            $keydates_proj = getKeyDatesProjSupplier($projID);
            $projectYears = getYears($keydates_proj[0],$keydates_proj[2]); 

            $devises = getListDevises();
            $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
            $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
            
            $ucsData= getUcsData($projID,$selScope, $projectYears, $scope, $side); 

            $projData = [$ucsData[0]];
            $projData[0][0]=0;
            // We sum the data off UC to have the data of the project
            for($i=1; $i<count($ucsData); $i++){//we begin with $1=1 because we did the $i=0 in the 2 last lines.
                for($j=1;$j<count($ucsData[0]);$j++){// we begin with $1=1 to pass the ucID
                    for($k=0;$k<count($ucsData[0][1]);$k++){
                        $projData[0][$j][$k]+=$ucsData[$i][$j][$k];
                    }
                }
            }
            $months = getMonthsProj($projID, $scope);
            echo $twig->render('/output/customer_dashboards_steps/project_details.twig',array(
                'is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,
                'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],
                'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],"data"=>$projData, "sideBarName"=> $sideBarName,
                'scope'=>$scope,"years"=>$projectYears, "side"=>$side, "months"=>$months)); 
                
            
                prereq_dashbords();

        } else {
            throw new Exception("This project doesn't exist !");
        }
    } else {
        throw new Exception("No Project selected !");
    }
    unset($GLOBALS['useFiltre2']);
}

function getUcsData($projID,$selScope, $projectYears, $scope, $side){
    //return a list of all data needed in Case Details
    $list = [] ;
    foreach ($selScope as $i => $value) {
        for($j = 0; $j<count($selScope[$i]); $j++){
            $ucID = $selScope[$i][$j];
            array_push($list, getUcData($projID,$ucID, $projectYears, $scope, $side));
        }
    }
    
    return $list;
}

function xpexSubTot($projID,$ucID, $implemRepart, $projectYears, $type, $origine, $projectDates=[], $schedules=[], $side="projDev", $periode = "year"){
    if($periode != "year" and $periode!="month"){
        throw new Exception("Wrong perdiode !");
    }
    if($side != "supplier" && $side != "customer" && $side != "projDev" ){throw new Exception("Wrong side");}
    if($type == "capex"){
        $xpex =  getTotXpexByUCAndOrigine($projID,$ucID, $type, $origine, $side);
        if($side != "projDev"){
            //$xpex += getTotXpexByUCAndOrigine($projID,$ucID, $type, $origine, "projDev");
        }

        $capexPerMonth = calcCapexPerMonth($implemRepart,$xpex);
        if($periode == "month"){
            return $capexPerMonth;
        }
        return calcCapexTot($capexPerMonth,$projectYears);
    }elseif($type == "opex"){
        $opexSchedule = $schedules['opex'][$ucID];
        $opexRepart = getRepartPercOpex($opexSchedule,$projectDates);
        $opexValues =getOpexValuesOrigine($projID,$ucID, $origine, $side);
        $opexPerMonth = calcOpexPerMonth2($opexRepart,$opexValues);
        if($periode == "month"){
            return $opexPerMonth;
        }
        return calcOpexTot($opexPerMonth,$projectYears);
    }elseif($type=="implem"){
        $xpex =  getTotXpexByUCAndOrigine($projID,$ucID, $type, $origine, $side);
        $implemPerMonth = calcImplemPerMonth($implemRepart,$xpex);
        if($periode == "month"){
            return $implemPerMonth;
        }
        return calcImplemTot($implemPerMonth,$projectYears);
    }
    
}

function getMonthsProj($projID, $scope){
    
    $schedules = getListSelDates($projID);
    $keydates_proj = getKeyDatesProjSupplier($projID);
    $keydates_proj[0] = date_format(date_create_from_format('m/Y',$keydates_proj[0]), 'M/Y');
    $keydates_proj[1] = date_format(date_create_from_format('m/Y',$keydates_proj[1]), 'M/Y');
    $keydates_proj[2] = date_format(date_create_from_format('m/Y',$keydates_proj[2]), 'M/Y');
    $projectDates = createProjectDates($keydates_proj[0],$keydates_proj[2]);
    foreach ($projectDates as $key => $date) {
        $projectDates[$key]= date_format(date_create_from_format('m/Y',$date), 'M/Y');
    }
    return $projectDates;
}

function getCashOutYear($projID, $ucID, $projectYears, $scope, $origine, $item, $side = "projDev", $periode = "year"){
    if($side != "supplier" && $side != "customer" && $side != "projDev" ){throw new Exception("Wrong side");}

    if($periode != "year" and $periode!="month"){
        throw new Exception("Wrong perdiode !");
    }
    $schedules = getListSelDates($projID);
    $keydates_proj = getKeyDatesProjSupplier($projID);
    $keydates_proj[0] = date_format(date_create_from_format('m/Y',$keydates_proj[0]), 'M/Y');
    $keydates_proj[1] = date_format(date_create_from_format('m/Y',$keydates_proj[1]), 'M/Y');
    $keydates_proj[2] = date_format(date_create_from_format('m/Y',$keydates_proj[2]), 'M/Y');
    $projectDates = createProjectDates($keydates_proj[0],$keydates_proj[2]);
    $implemSchedule = $schedules['implem'][$ucID];
    $implemRepart = getRepartPercImplem($implemSchedule,$projectDates);

    if($item == "capex" or $item == "implem"){
        return xpexSubTot($projID,$ucID, $implemRepart, $projectYears, $item, $origine, $projectDates, $schedules, $side, $periode);
    }elseif($item == "opex"){
        $opexSchedule = $schedules['opex'][$ucID];
        $opexRepart = getRepartPercOpex($opexSchedule,$projectDates);
        $opexValues = getOpexValues($projID,$ucID, $side);
        $opexPerMonth = calcOpexPerMonth2($opexRepart,$opexValues);
        $opexTot = calcOpexTot($opexPerMonth,$projectYears);

        return xpexSubTot($projID,$ucID, $implemRepart, $projectYears, $item, $origine, $projectDates, $schedules, $side, $periode);
    }
}

function getCashInMonthYear($projID, $ucID, $projectYears, $scope, $item,$side, $periode="year"){
    if($periode != "year" and $periode!="month"){
        throw new Exception("Wrong perdiode !");
    }
    if($side != "supplier" && $side != "customer" && $side != "projDev" ){throw new Exception("Wrong side");}
    $schedules = getListSelDates($projID);
    $keydates_proj = getKeyDatesProjSupplier($projID);
    $keydates_proj[0] = date_format(date_create_from_format('m/Y',$keydates_proj[0]), 'M/Y');
    $keydates_proj[1] = date_format(date_create_from_format('m/Y',$keydates_proj[1]), 'M/Y');
    $keydates_proj[2] = date_format(date_create_from_format('m/Y',$keydates_proj[2]), 'M/Y');
    $projectDates = createProjectDates($keydates_proj[0],$keydates_proj[2]);
    if($side != "supplier"){
        if($item == "revenues" && $side == "projDev"){
        
            $revenuesSchedule = isset($schedules['revenues'][$ucID]) ? $schedules['revenues'][$ucID] : [];
            if(scheduleFilled($revenuesSchedule) && !empty($revenuesSchedule)){
                $revenuesRepart = getRepartPercRevenues($revenuesSchedule,$projectDates);
                $revenuesValues = getRevenuesValues($projID,$ucID, $side);
                $revenuesPerMonth = calcRevenuesPerMonth2($revenuesRepart,$revenuesValues);
            } else {
                $revenuesPerMonth = array_fill_keys($projectDates,0);
            }
            if($periode == "month"){
                return $revenuesPerMonth;
            }
            return calcRevenuesTot($revenuesPerMonth,$projectYears); //ok
    
        }elseif($item == "revenues" && $side == "customer"){
            $ItemRevenuesPerMonth = getCutomserRevenueItemByMonth($projID,$ucID);
            foreach ($projectDates as $date) {
                $revenuesPerMonth[$date] = 0;
                foreach ($ItemRevenuesPerMonth as $revenue) {
                    $revenuesPerMonth[$date]+=$revenue[$date];
                }
            }
            if($periode == "month"){
                return $revenuesPerMonth;
            }
            return calcRevenuesTot($revenuesPerMonth,$projectYears); //ok
    
        }elseif($item == "cash_realeasing_benefits"){
            
            $opexSchedule = $schedules['opex'][$ucID];
            $opexRepart = getRepartPercOpex($opexSchedule,$projectDates);
            $cashreleasingValues = getCashReleasingValues($projID,$ucID);
            $cashreleasingValuesMonth = calcCashReleasingPerMonth2($opexRepart,$cashreleasingValues);
            if($periode == "month"){
                return $cashreleasingValuesMonth;
            }
            return calcCashReleasingTot($cashreleasingValuesMonth,$projectYears); //ok
        }elseif($item == "wider_cash_benefits"){
    
            $opexSchedule = $schedules['opex'][$ucID];
            $opexRepart = getRepartPercOpex($opexSchedule,$projectDates);
            $cashreleasingValues = getCashReleasingValues($projID,$ucID);
    
            $widercashValues = getWiderCashValues($projID,$ucID);
            $widercashValuesMonth = calcWiderCashPerMonth2($opexRepart,$widercashValues);
            if($periode == "month"){
                return $widercashValuesMonth;
            }
            return calcWiderCashTot($widercashValuesMonth,$projectYears);
        }
    }else{
        if($item == "equipment" || $item== "deployment" || $item== "operating" || $item == "revenues"){
            //var_dump("dans le if :$item");

            $implemSchedule = $schedules['implem'][$ucID];
            if($item == "equipment" || $item== "deployment"){
                //var_dump("if 1");
                //getSupplierRevenueItemByMonth($projID,$ucID, $item);
                $implemRepart = getRepartPercImplem($implemSchedule,$projectDates);
                $revenuesTot = getTotSupplierRevenuesByUC($projID,$ucID, $item);
                $revenuesPerMonth = calcCapexPerMonth($implemRepart,$revenuesTot);

            }elseif($item== "operating"){
                //var_dump("if 2");

                $revenuesRepart = getRepartPercRevenues($implemSchedule,$projectDates);
                $revenuesValues = getSupplierRevenuesValues($projID,$ucID, $item);
                $revenuesPerMonth = calcRevenuesPerMonth2($revenuesRepart,$revenuesValues);
            }elseif($item== "revenues"){
                //var_dump("if 2");

                $deployment = getCashInMonthYear($projID, $ucID, $projectYears, $scope, "deployment", $side, $periode);
                $equipment = getCashInMonthYear($projID, $ucID, $projectYears, $scope, "equipment", $side, $periode);
                $operating = getCashInMonthYear($projID, $ucID, $projectYears, $scope, "operating", $side, $periode);
                $list = [];
                foreach ($deployment as $date => $value) {
                    $list[$date]=$deployment[$date]+$equipment[$date]+$operating[$date];
                }
                return $list;
            }else {

                $revenuesPerMonth = array_fill_keys($projectDates,0);
            }
            if($periode == "month"){
                return $revenuesPerMonth;
            }
            //var_dump(calcRevenuesTot($revenuesPerMonth,$projectYears));
            return calcRevenuesTot($revenuesPerMonth,$projectYears); //ok
        }
    }
    //throw new Exception("0 Error in getCashInMonthYear() : $item");
}

function getUcDataYearMonth($projID, $ucID, $projectYears, $scope, $side, $periode, $list){

    
    if($periode != "year" and $periode!="month"){
        throw new Exception("Wrong perdiode !");
    }
     // Cash-out Capex
     $capex_from_nttTot = getCashOutYear($projID, $ucID, $projectYears, $scope, "from_ntt","capex", $side, $periode);

    $capex_from_outside_nttTot = getCashOutYear($projID, $ucID, $projectYears, $scope, "from_outside_ntt","capex", $side, $periode);


 
     //Cash-out Opex
 
    $opex_from_nttTot =  getCashOutYear($projID, $ucID, $projectYears, $scope, "from_ntt","opex", $side, $periode);
    $opex_from_outside_nttTot = getCashOutYear($projID, $ucID, $projectYears, $scope, "from_outside_ntt","opex", $side, $periode);

    $opex_internalTot =  getCashOutYear($projID, $ucID, $projectYears, $scope, "internal","opex", $side, $periode);

 
     //Cash-out Deployment 
 
 
    $implem_from_nttTot = getCashOutYear($projID, $ucID, $projectYears, $scope, "from_ntt","implem", $side, $periode);
    $implem_from_outside_nttTot = getCashOutYear($projID, $ucID, $projectYears, $scope, "from_outside_ntt","implem", $side, $periode);
    $implem_internalTot = getCashOutYear($projID, $ucID, $projectYears, $scope, "internal","implem", $side, $periode);

     //Cash-in 
     if($side == "customer"){
         //Cash-in : Revenues
         $revenues = getCashInMonthYear($projID, $ucID, $projectYears, $scope, "revenues", $side, $periode);
         //Cash-in : Cash Realeasing Benefits
         $cash_realeasing_benefits = getCashInMonthYear($projID, $ucID, $projectYears, $scope, "cash_realeasing_benefits", $side, $periode);
 
         //Cash-in : Cash Realeasing Benefits
         $wider_cash_benefits = getCashInMonthYear($projID, $ucID, $projectYears, $scope, "wider_cash_benefits", $side, $periode);
     }elseif($side == "supplier"){
        $equipment = getCashInMonthYear($projID, $ucID, $projectYears, $scope, "equipment", $side, $periode);
        $deployment = getCashInMonthYear($projID, $ucID, $projectYears, $scope, "deployment", $side, $periode);
        $operating = getCashInMonthYear($projID, $ucID, $projectYears, $scope, "operating", $side, $periode);
     }
 
    //var_dump($capex_from_nttTot);
    $dates = array_keys($capex_from_nttTot);
    if($dates[0]=='tot'){
        unset($dates[0]);
    }
    if($periode == "month"){
        //var_dump($dates);
        //var_dump($opex_from_nttTot);
    }
    //var_dump($opex_from_nttTot);
     foreach($dates as $key=>$date){
         if($side ==  "customer"){
             array_push($list, getDataYearCustomer($projID, $ucID,$dates, $date,  $capex_from_nttTot, $capex_from_outside_nttTot, 
             $implem_from_nttTot,  $implem_from_outside_nttTot,  $implem_internalTot, 
             $opex_from_nttTot,  $opex_from_outside_nttTot,  $opex_internalTot, 
             $revenues, $cash_realeasing_benefits, $wider_cash_benefits, $periode));
         }elseif($side == "supplier"){
             array_push($list, getDataYearSupplier($projID, $ucID,$dates, $date,  $capex_from_outside_nttTot, 
             $implem_from_nttTot,  $implem_from_outside_nttTot,  $implem_internalTot, 
             $opex_from_nttTot,  $opex_from_outside_nttTot,  $opex_internalTot, 
             $equipment, $deployment, $operating, $periode));
         }
     }
     return $list;
}

function getUcData($projID, $ucID, $projectYears, $scope, $side){
    // return the data needed for the table Use Case Details for the ucID passed in argument.
    $list = [$ucID];

    if($side ==  "customer"){
        $list[1] = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    }elseif($side == "supplier"){
        $list[1] = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    }
    $list = getUcDataYearMonth($projID, $ucID, $projectYears, $scope, $side, "year", $list);
    foreach ($list as $yearKey => $yearValues) {
        if(gettype($yearValues)=="array"){
            foreach ($yearValues as $itemKey => $value) {
                $list[1][$itemKey]+=$value;
            }
        }
    }
    $list = getUcDataYearMonth($projID, $ucID, $projectYears, $scope, $side, "month", $list);
    return $list;

}

function getDataYearSupplier($projID, $ucID,$projectYears, $year,  $capex_from_nttTot, 
$implem_from_nttTot, $implem_from_outside_nttTot,  $implem_internalTot,  
$opex_from_nttTot, $opex_from_outside_nttTot,  $opex_internalTot, 
$equipment, $deployment, $operating, $periode){
    //return the data for the uc corresponding to the year.
    $capexTot = $capex_from_nttTot[$year];
    $implemTot =  $implem_internalTot[$year]+$implem_from_outside_nttTot[$year];
    $opexTot =  $opex_internalTot[$year]+$opex_from_outside_nttTot[$year];


    $cash_in =  $equipment[$year]+ $deployment[$year] + $operating[$year];
    $cash_out = $capexTot + $opexTot + $implemTot ;
    $netCash = $cash_in-$cash_out;


    $net_cumulated_cash = $netCash;

    $expYear = explode("/", $year); 
    foreach ($projectYears as $yearKey) {
        $exp = explode("/", $yearKey);
        if((($year>$yearKey &&  $periode == "year") || ($periode == "month" && ($expYear[1]>$exp[1] || ($expYear[1]==$exp[1] && $expYear[0]>$exp[0]) ))) && $yearKey!="tot"){
            $net_cumulated_cash += $equipment[$yearKey]+ $deployment[$yearKey] + $operating[$yearKey] - ($capex_from_nttTot[$yearKey] + $implem_internalTot[$yearKey]+$implem_from_outside_nttTot[$yearKey] + $opex_internalTot[$yearKey]+$opex_from_outside_nttTot[$yearKey]); 

        }
        if($year==$yearKey){
        break;
    }
    }
    
    return [
        $cash_in, 
            $equipment[$year], 
            $deployment[$year], 
            $operating[$year], 
        $cash_out, 
            $capex_from_nttTot[$year], 
            $implemTot, 
                $implem_internalTot[$year],
                $implem_from_outside_nttTot[$year],
            $opexTot, 
                $opex_internalTot[$year],
                $opex_from_outside_nttTot[$year],
        $netCash, 
        $net_cumulated_cash
    ];

}
function getDataYearCustomer($projID, $ucID,$projectYears, $year,  $capex_from_nttTot, $capex_from_outside_nttTot, $implem_from_nttTot,  
$implem_from_outside_nttTot,  $implem_internalTot,  $opex_from_nttTot,  $opex_from_outside_nttTot,  $opex_internalTot, 
$UC_revenues, $cash_realeasing_benefits, $wider_cash_benefits, $periode){
    //return the data for the uc corresponding to the year.
    $capexTot = $capex_from_nttTot[$year] + $capex_from_outside_nttTot[$year];
    $implemTot =  $implem_from_nttTot[$year]+$implem_from_outside_nttTot[$year]+$implem_internalTot[$year];
    $opexTot =  $opex_from_nttTot[$year]+$opex_from_outside_nttTot[$year]+$opex_internalTot[$year];


    $cash_in =  $UC_revenues[$year]+ $cash_realeasing_benefits[$year] +  $wider_cash_benefits[$year];
    $cash_out = $capexTot + $opexTot + $implemTot ;
    $netCash = $UC_revenues[$year]+ $cash_realeasing_benefits[$year]-$cash_out ;

    $net_societal_cash = $wider_cash_benefits[$year] + $netCash;

    $net_cumulated_cash = 0;
    $wider_cumulated_cash_benefits = 0;
    $expYear = explode("/", $year); 
    foreach ($projectYears as $yearKey) {
        $exp = explode("/", $yearKey);
        if((($year>$yearKey &&  $periode == "year") || ($periode == "month" && ($expYear[1]>$exp[1] || ($expYear[1]==$exp[1] && $expYear[0]>$exp[0]) ))) && $yearKey!="tot"){
            $net_cumulated_cash += $UC_revenues[$yearKey]+ $cash_realeasing_benefits[$yearKey] - ($capex_from_nttTot[$yearKey] + $capex_from_outside_nttTot[$yearKey] + $opex_from_nttTot[$yearKey]+$opex_from_outside_nttTot[$yearKey]+$opex_internalTot[$yearKey] + $implem_from_nttTot[$yearKey]+$implem_from_outside_nttTot[$yearKey]+$implem_internalTot[$yearKey]); 
            $wider_cumulated_cash_benefits += $wider_cash_benefits[$yearKey];
        }
        if($year==$yearKey){
        break;
        }
    }
    $net_cumulated_societal_cash = $net_cumulated_cash + $wider_cumulated_cash_benefits;

    
    return [
        $cash_out, 
            $capexTot, 
                $capex_from_nttTot[$year], 
                $capex_from_outside_nttTot[$year], 
            $implemTot, 
                $implem_from_nttTot[$year], 
                $implem_from_outside_nttTot[$year], 
                $implem_internalTot[$year], 
            $opexTot, 
                $opex_from_nttTot[$year], 
                $opex_from_outside_nttTot[$year], 
                $opex_internalTot[$year],  
        $cash_in, 
            $UC_revenues[$year], 
            $cash_realeasing_benefits[$year], 
            $wider_cash_benefits[$year], 
        $netCash, 
        $net_cumulated_cash, 
        $net_societal_cash, 
        $net_cumulated_societal_cash
    ];

}

function dashboards_use_case_details($twig,$is_connected, $projID, $sideBarName, $side){
    $GLOBALS['useFiltre2']= true;
    $user = getUser($_SESSION['username']);
    $list_projects = getListProjects($user[0]);

    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            $proj = getProjByID($projID,$user[0]);  
            $scope = getListSelScope($projID);
            
            $list_ucs = getListUCs();
            $selScope = getListSelScope($projID);
            $schedules = getListSelDates($projID);
            $keydates_proj = getKeyDatesProjSupplier($projID);
            $projectYears = getYears($keydates_proj[0],$keydates_proj[2]);  
            $ucsData= getUcsData($projID, $selScope, $projectYears, $scope, $side);    
            

            /*foreach ($selScope as $measID => $listUcs) {
                foreach ($listUcs as $ucID) {
                    if(!hasSchedule($projID, $ucID)){
                        $list_ucs[$ucID]['name'].= " (no Data)";

                    }
                }
            }*/
            //print_r($ucsData);   
            
            $months = getMonthsProj($projID, $scope);
            echo $twig->render('/output/customer_dashboards_steps/use_case_details.twig',array('is_connected'=>$is_connected,'devises'=>$devises,
            'years'=>$projectYears, 'selDevSym'=>$selDevSym, "data"=>$ucsData,'selScope'=>$selScope,'selDevName'=>$selDevName,'ucs'=>$list_ucs, 
            'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'projects'=>$list_projects, 
            "sideBarName"=>$sideBarName, "side"=>$side, "months"=>$months)); 
            prereq_dashbords();
        }
    }
    unset($GLOBALS['useFiltre2']);
}

function difMonthsBounds($d1, $d2){
    return (explode("/",$d1)[1]-explode("/",$d2)[1])*12+explode("/",$d1)[0]-explode("/",$d2)[0];
}

function getDateProportion($implemSchedule, $year){
    $before = $implemSchedule["startdate"];
    $after;
    $i=0;
    foreach($implemSchedule as $key=>$date){
        
        if(!isset($after)){
            if(explode("/", $date)[1]>=$year){// we found the first date after the year selected
                $after = $key;
            }else{
                $before = $key;
            }
        }else{
            $i++;
        }

    }
    if(!isset($after)){
        return 1;
    }
    else{
        if($after == "startdate"){
            return 0;
        }else{
            $difMonthsBounds = difMonthsBounds($implemSchedule[$after], $implemSchedule[$before]);
            $difMonthsBeforeYear = difMonthsBounds("01/$year", $implemSchedule[$before]);
            return $i/count($implemSchedule)+$difMonthsBeforeYear/$difMonthsBounds;
        }
    }
}

function getQualitativeYearEvolution($projID,$ucID){

    $QuantifiableItemList = getListSelQuantifiable($projID,$ucID);
    $scope = getListSelScope($projID);
    $schedules = getListSelDates($projID);
    $keydates_proj = getKeyDatesProjSupplier($projID);

    
    
    $projectYears = getYears($keydates_proj[0],$keydates_proj[2]); 

    $implemSchedule=$schedules["implem"][$ucID];
    $QualitativeYearEvolution=[];
    foreach($QuantifiableItemList as $key=>$item){
        $QualitativeYearEvolution[$key]=[];
        if(count($item)>0){
            $startYear = explode("/",$implemSchedule['startdate'])[1];
            $volume = $item["volume"];
            $anVarVol = $item["anVarVol"]/100;
            $vol_red = -$item["vol_red"]/100;
            foreach($projectYears as $year){
                $QualitativeYearEvolution[$key][$year] =pow(1+$anVarVol, intval($year)-intval($startYear))*(1+getDateProportion($implemSchedule, $year)*$vol_red)*$volume;
                $QualitativeYearEvolution[$key][$year] = round($QualitativeYearEvolution[$key][$year], 2);
            }
        }
    }
    return $QualitativeYearEvolution;
}

function dashboards_non_monetizable($twig,$is_connected, $projID){
    $GLOBALS['useFiltre2']= true;
    $side="customer";
    $user = getUser($_SESSION['username']);
    $list_projects = getListProjects($user[0]);

    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            $proj = getProjByID($projID,$user[0]);
            $scope = getListSelScope($projID);
            $ucs = getListUCs();
            $selScope = getListSelScope($projID);
            if(isset($selScope[0])){unset($selScope[0]); }
            $schedules = getListSelDates($projID);
            $keydates_proj = getKeyDatesProjSupplier($projID);
            $projectYears = getYears($keydates_proj[0],$keydates_proj[2]); 

            foreach ($selScope as $measID => $list_ucs) {
                foreach ($list_ucs as $ucID) {
                    $QualitativeYearEvolution = getQualitativeYearEvolution($projID,$ucID);
                    $QuantifiableItemList = getListSelQuantifiable($projID,$ucID);
                    $nonQuantifiableNames = getListQuantifiableItems($ucID);
                    $data[$ucID] = [];
                    foreach($QuantifiableItemList as $key=>$item){
                        if($nonQuantifiableNames[$key]['unit']!=""){
                            array_push($data[$ucID], array_merge([$nonQuantifiableNames[$key]['name']." (".$nonQuantifiableNames[$key]['unit'].")"], $QualitativeYearEvolution[$key]));
                        }
                        else{
                            array_push($data[$ucID], array_merge([$nonQuantifiableNames[$key]['name']], $QualitativeYearEvolution[$key]));
                        
                        }

                        
                    }
                    if(empty($data[$ucID])){
                        $ucs[$ucID]['name'].=" (no data to show)";
                    }
                }
            }
            /*
            $data = array(
                "1"=>[
                    ["item 5", 10, 5, 7, 8],
                    ["item 3", 123, 154, 144, 130],
                    ["item 7", 3, 14, 15, 9]
                ],
                "3"=>[
                    ["item 2",1024, 512, 256, 128],
                    ["item 13", 169, 12, 15, 0]
                ]);*/

            echo $twig->render('/output/customer_dashboards_steps/non_monetizable.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,
            'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'projects'=>$list_projects,
            'selScope'=>$selScope, 'ucs'=>$ucs, 'years'=>$projectYears, 'data'=>$data)); 
            prereq_dashbords();
        }
    }
    unset($GLOBALS['useFiltre2']);
}

function dashboards_qualitative($twig,$is_connected, $projID){
    $GLOBALS['useFiltre2']= true;
    $side="customer";
    $user = getUser($_SESSION['username']);
    $list_projects = getListProjects($user[0]);

    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            $proj = getProjByID($projID,$user[0]); 
            $selScope = getListSelScope($projID);
            if(isset($selScope[0])){unset($selScope[0]); }
            $data = [];
            $ucs = getListUCs();    
            foreach ($selScope as $measID => $list_ucs) {
                foreach ($list_ucs as $ucID) {
                    $nonCashItemList = getListSelNonCash($projID,$ucID);
                    $nonCashItemNames = getListNoncashItems($ucID);
                    $data[$ucID] = [];
                    $nonCashMean = 0;
                    $nbNonCash = 0;
                    foreach($nonCashItemList as $key=>$item){
                        $nbNonCash++;
                        $value = $item["exp_impact"]*$item["prob"]/100;
                        array_push($data[$ucID], [$nonCashItemNames[$key]['name'], $value]);
                        $nonCashMean += $value;
                    }
                    if($nbNonCash>0){
                        $nonCashMean = $nonCashMean/$nbNonCash;
                        array_push($data[$ucID], ["Mean", $nonCashMean]);
                    }else{
                        $ucs[$ucID]['name'].=" (no data to show)";
                    }
                
                }
            }
            /*$data = array(
                "1"=>[
                    ["item 5", 10],
                    ["item 3", 1],
                    ["item 7", 3],
                    ["item 42", 5]
                ],
                "3"=>[
                    ["item 2",1],
                    ["item 13", 6]
                ]);*/

            echo $twig->render('/output/customer_dashboards_steps/qualitative.twig',array('is_connected'=>$is_connected,
            'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],
            'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'projects'=>$list_projects, "selScope"=>$selScope,"ucs"=>$ucs,
            'data'=>$data )); 
            prereq_dashbords();
        }
    }
    unset($GLOBALS['useFiltre2']);
}

