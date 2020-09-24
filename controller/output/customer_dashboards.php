<?php

function prereq_dashbords(){
    if(isset($_GET['A2'])){
        echo "
        
        <script>prereq_dashbords();</script>";
    }
}


function dashboards_summary($twig,$is_connected, $projID, $sideBarName, $side){
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
                $proj = getProjByID($projID,$user[0]);
                $ucs = getListUCs();
                $scope = getListSelScope($projID);
                

           
                
                $schedules = getListSelDates($projID);
                //print_r($schedules);
                $keydates_uc = get_keydates_uc($scope,$projID,$schedules);
                $uc_check_completed = check_if_UC_is_completed($projID,$scope);


                $keydates_proj = getKeyDatesProj($schedules,$scope);
                $projectYears = getYears($keydates_proj[0],$keydates_proj[2]);
                $projectDates = createProjectDates($keydates_proj[0],$keydates_proj[2]);
                $ItemsPerMonthAndTot = calcCBItemsPerMonthAndTot($scope, $schedules, $projectDates, $projID, $projectYears, $side);//PB
                $netcashPerMonth = calcNetCashPerMonth($projectDates,$ItemsPerMonthAndTot['capex']['perMonth'],$ItemsPerMonthAndTot['implem']['perMonth'],$ItemsPerMonthAndTot['opex']['perMonth'],$ItemsPerMonthAndTot['revenues']['perMonth'],$ItemsPerMonthAndTot['cashreleasing']['perMonth']);
                $netsoccashPerMonth = calcNetSocCashPerMonth($projectDates,$ItemsPerMonthAndTot['capex']['perMonth'],$ItemsPerMonthAndTot['implem']['perMonth'],$ItemsPerMonthAndTot['opex']['perMonth'],$ItemsPerMonthAndTot['revenues']['perMonth'],$ItemsPerMonthAndTot['cashreleasing']['perMonth'],$ItemsPerMonthAndTot['widercash']['perMonth']);
                
                $netcashTot = calcNetCashTot($netcashPerMonth[0],$projectYears);
                $cumulnetcashTot = $netcashTot[1]; 
                $netsoccashTot = calcNetSocCashTot($netsoccashPerMonth[0],$projectYears);
                $cumulnetsoccashTot = $netsoccashTot[1];


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
                        array_push($ucsBenefits, array_sum(getCashInMonthYear($projID, $ucID, $projectYears, $scope, "revenues", $side)));
                        $revenueSum+=$ucsBenefits[count($ucsBenefits)-1];
                        $cash_realeasing_benefitsSum+=array_sum( getCashInMonthYear($projID, $ucID, $projectYears, $scope, "cash_realeasing_benefits", $side));
                        $wider_cash_benefitsSum += array_sum(getCashInMonthYear($projID, $ucID, $projectYears, $scope, "wider_cash_benefits", $side));
                    }
                }

                $dr_year = getListSelDiscountRate($projID);
                $dr_month = pow(1+($dr_year/100),1/12)-1;
                $npv2 = calcNPV($dr_month,$sum_capex_implem);
                // npv
                $fin_npv = calcNPV($dr_month,$netcashPerMonth[0]); 
                $soc_npv = calcNPV($dr_month,$netsoccashPerMonth[0]);
                $fin_societal_npv = 0;
                $soc_societal_npv = 0;

                
                //roi
                $fin_roi = calcROI($fin_npv,$npv2);     
                $soc_roi = calcROI($soc_npv,$npv2);
                $fin_societal_roi = 0;
                $soc_societal_roi = 0;

                //payback            
                $fin_payback = calcPayback($netcashPerMonth)[1];
                $soc_payback = calcPayback($netsoccashPerMonth)[1];
                $fin_societal_payback = 0;
                $soc_societal_payback = 0;

                //
                $nqb = calcRatingNonCash($projID, $scope);
                $rating_risks = calcRatingRisks($projID, $scope);

                $cahsOutTot = calcCashOut($ItemsPerMonthAndTot['capex']['perMonth'],$ItemsPerMonthAndTot['implem']['perMonth'],$ItemsPerMonthAndTot['opex']['perMonth']);
                $fin_operating_margin =round(($cumulnetcashTot[array_key_last($cumulnetcashTot) ])/array_sum($cahsOutTot) * 100, 2);
                $soc_operating_margin = round(($cumulnetsoccashTot[array_key_last($cumulnetsoccashTot) ])/array_sum($cahsOutTot) * 100, 2);

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
                    'rating_risks'=>$rating_risks,
                    'fin_operating_margin'=>$fin_operating_margin,
                    'soc_operating_margin'=>$soc_operating_margin         
                );
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
            

            echo $twig->render('/output/customer_dashboards_steps/summary.twig',array(
                'is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,
                'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1], 'sideBarName'=>$sideBarName,
                'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'projects'=>$list_projects,
                'ucs'=>$ucs,'scope'=>$scope,'keydates_uc'=>$keydates_uc,'uc_completed'=>$uc_check_completed,
                'years'=>$projectYears,'cumulnetcashTot'=>$cumulnetcashTot,'cumulnetsoccashTot'=>$cumulnetsoccashTot,
                'bankability_target'=> $bankabilityData, "bankability_cacl"=>$bankability_cacl, 'repartition_of_benefits'=> $repartition_of_benefits
            ));
            prereq_dashbords();
            
        }
    }
}

// --- Project Details
function dashboards_project_details($twig,$is_connected, $projID, $sideBarName, $side){
    if($projID!=0){
        $user = getUser($_SESSION['username']);
        if(getProjByID($projID,$user[0])){
            
            $proj = getProjByID($projID,$user[0]); 
            $scope = getListSelScope($projID);
            $list_ucs = getListUCs();
            $selScope = getListSelScope($projID);
            $schedules = getListSelDates($projID);
            $keydates_proj = getKeyDatesProj($schedules,$scope);
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


            echo $twig->render('/output/customer_dashboards_steps/project_details.twig',array(
                'is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,
                'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],
                'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],"data"=>$projData, "sideBarName"=> $sideBarName,
                'scope'=>$scope,"years"=>$projectYears, "side"=>$side)); 
                
            
                prereq_dashbords();

        } else {
            throw new Exception("This project doesn't exist !");
        }
    } else {
        throw new Exception("No Project selected !");
    }
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


function getCashOutYear($projID, $ucID, $projectYears, $scope, $origine, $item, $side = "projDev", $periode = "year"){
    if($side != "supplier" && $side != "customer" && $side != "projDev" ){throw new Exception("Wrong side");}

    if($periode != "year" and $periode!="month"){
        throw new Exception("Wrong perdiode !");
    }
    $schedules = getListSelDates($projID);
    $keydates_proj = getKeyDatesProj($schedules,$scope);
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
        if($periode == "month"){
            return $opexPerMonth;
        }
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
    $keydates_proj = getKeyDatesProj($schedules,$scope);
    $keydates_proj[0] = date_format(date_create_from_format('m/Y',$keydates_proj[0]), 'M/Y');
    $keydates_proj[1] = date_format(date_create_from_format('m/Y',$keydates_proj[1]), 'M/Y');
    $keydates_proj[2] = date_format(date_create_from_format('m/Y',$keydates_proj[2]), 'M/Y');
    $projectDates = createProjectDates($keydates_proj[0],$keydates_proj[2]);
    if($item == "revenues"){
        
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
    }elseif($item == "qualitative"){

    }
}
function getUcData($projID, $ucID, $projectYears, $scope, $side){
    // return the data needed for the table Use Case Details for the ucID passed in argument.
    $list = [$ucID];

    // Cash-out Capex
    $capex_from_nttTot = getCashOutYear($projID, $ucID, $projectYears, $scope, "from_ntt","capex", $side);
    if($side == "customer"){
        $capex_from_outside_nttTot = getCashOutYear($projID, $ucID, $projectYears, $scope, "from_outside_ntt","capex", $side);
    }

    //Cash-out Opex

    $opex_from_nttTot =  getCashOutYear($projID, $ucID, $projectYears, $scope, "from_ntt","opex", $side);
    $opex_from_outside_nttTot = getCashOutYear($projID, $ucID, $projectYears, $scope, "from_outside_ntt","opex", $side);
    if($side == "customer"){
        $opex_internalTot =  getCashOutYear($projID, $ucID, $projectYears, $scope, "internal","opex", $side);
    }

    //Cash-out Deployment 


    $implem_from_nttTot = getCashOutYear($projID, $ucID, $projectYears, $scope, "from_ntt","implem", $side);
    $implem_from_outside_nttTot = getCashOutYear($projID, $ucID, $projectYears, $scope, "from_outside_ntt","implem", $side);
    if($side == "customer"){
        $implem_internalTot = getCashOutYear($projID, $ucID, $projectYears, $scope, "internal","implem", $side);
    }
    //Cash-in 
    if($side == "customer"){
        //Cash-in : Revenues
        $revenues = getCashInMonthYear($projID, $ucID, $projectYears, $scope, "revenues", $side);

        //Cash-in : Cash Realeasing Benefits
        $cash_realeasing_benefits = getCashInMonthYear($projID, $ucID, $projectYears, $scope, "cash_realeasing_benefits", $side);

        //Cash-in : Cash Realeasing Benefits
        $wider_cash_benefits = getCashInMonthYear($projID, $ucID, $projectYears, $scope, "wider_cash_benefits", $side);
    }elseif($side == "supplier"){
        // A revoir !!!
        $equipement = getCashInMonthYear($projID, $ucID, $projectYears, $scope, "revenues", $side);
        $deployment = getCashInMonthYear($projID, $ucID, $projectYears, $scope, "cash_realeasing_benefits", $side);
        $operating = getCashInMonthYear($projID, $ucID, $projectYears, $scope, "wider_cash_benefits", $side);
    }


    for ($i = 0; $i<count($projectYears); $i++){
        if($side ==  "customer"){
            array_push($list, getDataYearCustomer($projID, $ucID,$projectYears, $projectYears[$i],  $capex_from_nttTot, $capex_from_outside_nttTot, 
            $implem_from_nttTot,  $implem_from_outside_nttTot,  $implem_internalTot, 
            $opex_from_nttTot,  $opex_from_outside_nttTot,  $opex_internalTot, 
            $revenues, $cash_realeasing_benefits, $wider_cash_benefits));
        }elseif($side == "supplier"){
            array_push($list, getDataYearSupplier($projID, $ucID,$projectYears, $projectYears[$i],  $capex_from_nttTot, 
            $implem_from_nttTot,  $implem_from_outside_nttTot, 
            $opex_from_nttTot,  $opex_from_outside_nttTot, 
            $equipement, $deployment, $operating));
        }
    }
    return $list;

}
function getDataYearSupplier($projID, $ucID,$projectYears, $year,  $capex_from_nttTot,  
$implem_from_outside_nttTot,  $implem_from_nttTot,  $opex_from_nttTot,  $opex_from_outside_nttTot, 
$equipement, $deployment, $operating){
    //return the data for the uc corresponding to the year.
    $capexTot = $capex_from_nttTot[$year];
    $implemTot =  $implem_from_nttTot[$year]+$implem_from_outside_nttTot[$year];
    $opexTot =  $opex_from_nttTot[$year]+$opex_from_outside_nttTot[$year];


    $cash_in =  $equipement[$year]+ $deployment[$year] + $operating[$year];
    $cash_out = $capexTot + $opexTot + $implemTot ;
    $netCash = $cash_in-$cash_out;


    $net_cumulated_cash = $netCash;
    foreach ($projectYears as $yearKey) {
        if($year>$yearKey && $yearKey!="tot"){
            $net_cumulated_cash += $equipement[$yearKey]+ $deployment[$yearKey] + $operating[$yearKey] - ($capex_from_nttTot[$yearKey] + $implem_from_nttTot[$yearKey]+$implem_from_outside_nttTot[$yearKey] + $opex_from_nttTot[$yearKey]+$opex_from_outside_nttTot[$yearKey]); 
        
        }
    }
    
    return [
        $cash_out, 
            $capex_from_nttTot[$year], 
            $implemTot, 
                $implem_from_nttTot[$year], 
                $implem_from_outside_nttTot[$year], 
            $opexTot, 
                $opex_from_nttTot[$year], 
                $opex_from_outside_nttTot[$year], 
        $cash_in, 
            $equipement[$year], 
            $deployment[$year], 
            $operating[$year], 
        $netCash, 
        $net_cumulated_cash
    ];

}
function getDataYearCustomer($projID, $ucID,$projectYears, $year,  $capex_from_nttTot, $capex_from_outside_nttTot, $implem_from_nttTot,  
$implem_from_outside_nttTot,  $implem_internalTot,  $opex_from_nttTot,  $opex_from_outside_nttTot,  $opex_internalTot, 
$UC_revenues, $cash_realeasing_benefits, $wider_cash_benefits){
    //return the data for the uc corresponding to the year.
    $capexTot = $capex_from_nttTot[$year] + $capex_from_outside_nttTot[$year];
    $implemTot =  $implem_from_nttTot[$year]+$implem_from_outside_nttTot[$year]+$implem_internalTot[$year];
    $opexTot =  $opex_from_nttTot[$year]+$opex_from_outside_nttTot[$year]+$opex_internalTot[$year];


    $cash_in =  $UC_revenues[$year]+ $cash_realeasing_benefits[$year] + $wider_cash_benefits[$year];
    $cash_out = $capexTot + $opexTot + $implemTot ;
    $netCash = $cash_in-$cash_out;

    $net_societal_cash = $wider_cash_benefits[$year] + $netCash;

    $net_cumulated_cash = $netCash;
    $wider_cumulated_cash_benefits = $wider_cash_benefits[$year];
    foreach ($projectYears as $yearKey) {
        if($year>$yearKey && $yearKey!="tot"){
            $net_cumulated_cash += $UC_revenues[$yearKey]+ $cash_realeasing_benefits[$yearKey] + $wider_cash_benefits[$yearKey] - ($capex_from_nttTot[$yearKey] + $capex_from_outside_nttTot[$yearKey] + $opex_from_nttTot[$yearKey]+$opex_from_outside_nttTot[$yearKey]+$opex_internalTot[$yearKey] + $implem_from_nttTot[$yearKey]+$implem_from_outside_nttTot[$yearKey]+$implem_internalTot[$yearKey]); 
            $wider_cumulated_cash_benefits += $wider_cash_benefits[$yearKey];
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
            $keydates_proj = getKeyDatesProj($schedules,$scope);
            $projectYears = getYears($keydates_proj[0],$keydates_proj[2]);  
            $ucsData= getUcsData($projID, $selScope, $projectYears, $scope, $side);    
            //print_r($ucsData);   
            echo $twig->render('/output/customer_dashboards_steps/use_case_details.twig',array('is_connected'=>$is_connected,'devises'=>$devises,
            'years'=>$projectYears, 'selDevSym'=>$selDevSym, "data"=>$ucsData,'selScope'=>$selScope,'selDevName'=>$selDevName,'ucs'=>$list_ucs, 
            'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'projects'=>$list_projects, 
            "sideBarName"=>$sideBarName, "side"=>$side)); 
            prereq_dashbords();
        }
    }
}

function difMounthsBounds($d1, $d2){
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
            $difMounthsBounds = difMounthsBounds($implemSchedule[$after], $implemSchedule[$before]);
            $difMounthsBeforeYear = difMounthsBounds("01/$year", $implemSchedule[$before]);
            return $i/count($implemSchedule)+$difMounthsBeforeYear/$difMounthsBounds;
        }
    }
}

function getQualitativeYearEvolution($projID,$ucID){

    $QuantifiableItemList = getListSelQuantifiable($projID,$ucID);
    $scope = getListSelScope($projID);
    $schedules = getListSelDates($projID);
    $keydates_proj = getKeyDatesProj($schedules,$scope);

    
    
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
            $keydates_proj = getKeyDatesProj($schedules,$scope);
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
}

function dashboards_qualitative($twig,$is_connected, $projID){
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
}

