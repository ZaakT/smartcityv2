<?php

function prereq_dashbords(){
    if(isset($_GET['A2'])){
        echo "
        
        <script>prereq_dashbords();</script>";
    }
}
function dashboards_summary($twig,$is_connected, $projID, $sidebarname){
    $user = getUser($_SESSION['username']);
    $list_projects = getListProjects($user[0]);

    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            try{
                $bankabilityData = array('target'=>getDealCriteriaInputNogoTarget($projID, "target"), 'nogo'=>getDealCriteriaInputNogoTarget($projID, "nogo"));


                $proj = getProjByID($projID,$user[0]); 
                $proj = getProjByID($projID,$user[0]);
                $ucs = getListUCs();
                $scope = getListSelScope($projID);
                

           
                
                $schedules = getListSelDates($projID);
                $keydates_uc = get_keydates_uc($scope,$projID,$schedules);
                $uc_check_completed = check_if_UC_is_completed($projID,$scope);


                $keydates_proj = getKeyDatesProj($schedules,$scope);
                $projectYears = getYears($keydates_proj[0],$keydates_proj[2]);
                $projectDates = createProjectDates($keydates_proj[0],$keydates_proj[2]);
                $ItemsPerMonthAndTot = calcCBItemsPerMonthAndTot($scope, $schedules, $projectDates, $projID, $projectYears);//PB
                $netcashPerMonth = calcNetCashPerMonth($projectDates,$ItemsPerMonthAndTot['capex']['perMonth'],$ItemsPerMonthAndTot['implem']['perMonth'],$ItemsPerMonthAndTot['opex']['perMonth'],$ItemsPerMonthAndTot['revenues']['perMonth'],$ItemsPerMonthAndTot['cashreleasing']['perMonth']);
                $netsoccashPerMonth = calcNetSocCashPerMonth($projectDates,$ItemsPerMonthAndTot['capex']['perMonth'],$ItemsPerMonthAndTot['implem']['perMonth'],$ItemsPerMonthAndTot['opex']['perMonth'],$ItemsPerMonthAndTot['revenues']['perMonth'],$ItemsPerMonthAndTot['cashreleasing']['perMonth'],$ItemsPerMonthAndTot['widercash']['perMonth']);
                
                $netcashTot = calcNetCashTot($netcashPerMonth[0],$projectYears);
                $cumulnetcashTot = $netcashTot[1]; 
                $netsoccashTot = calcNetSocCashTot($netsoccashPerMonth[0],$projectYears);
                $cumulnetsoccashTot = $netsoccashTot[1];


                foreach ($scope as $measID => $list_ucs) {
                    foreach ($list_ucs as $ucID) {

                        $implem = getTotImplemByUC($projID,$ucID);
                        $implemSchedule = $schedules['implem'][$ucID];
                        $implemRepart = getRepartPercImplem($implemSchedule,$projectDates);
                        $capex = getTotCapexByUC($projID,$ucID);
                        $capexPerMonth_new = calcCapexPerMonth($implemRepart,$capex);
                        $implemPerMonth_new = calcImplemPerMonth($implemRepart,$implem);
                        $sum_capex_implem = add_arrays($capexPerMonth_new,$implemPerMonth_new);
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
            }
            catch(\Throwable $th){
                header('?A=' + $sidebarname);
            }
            $repartition_of_benefits = array("titles"=>["Revenues", "Cash Releasing Benefits", "Wider Cash Benefits"], "data"=>[10, 17, 21]);


            echo $twig->render('/output/customer_dashboards_steps/summary.twig',array(
                'is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,
                'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1], 'sideBarName'=>$sidebarname,
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
function dashboards_project_details($twig,$is_connected, $projID,$post=[]){
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
            
            $ucsData= getUcsData($projID,$selScope, $projectYears, $scope); 

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
                'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],"data"=>$projData,

                'scope'=>$scope,"years"=>$projectYears)); 
                
            
                prereq_dashbords();

        } else {
            throw new Exception("This project doesn't exist !");
        }
    } else {
        throw new Exception("No Project selected !");
    }
}

function getUcsData($projID,$selScope, $projectYears, $scope){
    //return a list of all data needed in Case Details
    $list = [] ;
    for($i = 1; $i<=count($selScope); $i++ ){
        for($j = 0; $j<count($selScope[$i]); $j++){
            $ucID = $selScope[$i][$j];
            array_push($list, getUcData($projID,$ucID, $projectYears, $scope));
        }
    }
    

    return $list;
}

function xpexSubTot($projID,$ucID, $implemRepart, $projectYears, $type, $origine, $projectDates=[], $schedules=[]){
    
    if($type == "capex"){
        $xpex =  getTotXpexByUCAndOrigine($projID,$ucID, $type, $origine);
        $capexPerMonth = calcCapexPerMonth($implemRepart,$xpex);
        return calcCapexTot($capexPerMonth,$projectYears);
    }elseif($type == "opex"){
        $opexSchedule = $schedules['opex'][$ucID];
        $opexRepart = getRepartPercOpex($opexSchedule,$projectDates);
        $opexValues =getOpexValuesOrigine($projID,$ucID, $origine);
        $opexPerMonth = calcOpexPerMonth2($opexRepart,$opexValues);
        return calcOpexTot($opexPerMonth,$projectYears);
    }elseif($type=="implem"){
        $xpex =  getTotXpexByUCAndOrigine($projID,$ucID, $type, $origine);
        $implemPerMonth = calcImplemPerMonth($implemRepart,$xpex);
        return calcImplemTot($implemPerMonth,$projectYears);
    }
    
}

function getUcData($projID, $ucID, $projectYears, $scope){
    // return the data needed for the table Use Case Details for the ucID passed in argument.
    $list = [$ucID];

    $schedules = getListSelDates($projID);
    $keydates_proj = getKeyDatesProj($schedules,$scope);
    $keydates_proj[0] = date_format(date_create_from_format('m/Y',$keydates_proj[0]), 'M/Y');
    $keydates_proj[1] = date_format(date_create_from_format('m/Y',$keydates_proj[1]), 'M/Y');
    $keydates_proj[2] = date_format(date_create_from_format('m/Y',$keydates_proj[2]), 'M/Y');
    $projectDates = createProjectDates($keydates_proj[0],$keydates_proj[2]);
    $implemSchedule = $schedules['implem'][$ucID];
    $implemRepart = getRepartPercImplem($implemSchedule,$projectDates);
    // Cash-out Capex



    $capex_from_nttTot = xpexSubTot($projID,$ucID, $implemRepart, $projectYears, "capex", "from_ntt", $projectDates);
    $capex_from_outside_nttTot = xpexSubTot($projID,$ucID, $implemRepart, $projectYears, "capex", "from_outside_ntt", $projectDates);

    //Cash-out Opex
    $opexSchedule = $schedules['opex'][$ucID];
    $opexRepart = getRepartPercOpex($opexSchedule,$projectDates);
    $opexValues = getOpexValues($projID,$ucID);
    $opexPerMonth = calcOpexPerMonth2($opexRepart,$opexValues);
    $opexTot = calcOpexTot($opexPerMonth,$projectYears);

    $opex_from_nttTot = xpexSubTot($projID,$ucID, $opexRepart, $projectYears, "opex", "from_ntt", $projectDates, $schedules);
    $opex_from_outside_nttTot = xpexSubTot($projID,$ucID, $opexRepart, $projectYears, "opex", "from_outside_ntt", $projectDates, $schedules);
    $opex_internalTot = xpexSubTot($projID,$ucID, $opexRepart, $projectYears, "opex", "internal", $projectDates, $schedules);

    //Cash-out Deployment 


    $implem_from_nttTot = xpexSubTot($projID,$ucID, $implemRepart, $projectYears, "implem", "from_ntt", $projectDates);
    $implem_from_outside_nttTot = xpexSubTot($projID,$ucID, $implemRepart, $projectYears, "implem", "from_outside_ntt", $projectDates);
    $implem_internalTot = xpexSubTot($projID,$ucID, $implemRepart, $projectYears, "implem", "internal", $projectDates);


    for ($i = 0; $i<count($projectYears); $i++){
        array_push($list, getDataYear($projID, $ucID, $projectYears[$i],  $capex_from_nttTot, $capex_from_outside_nttTot, 
        $implem_from_nttTot,  $implem_from_outside_nttTot,  $implem_internalTot, 
        $opex_from_nttTot,  $opex_from_outside_nttTot,  $opex_internalTot));
    }
    return $list;

}

function getDataYear($projID, $ucID, $year,  $capex_from_nttTot, $capex_from_outside_nttTot, $implem_from_nttTot,  $implem_from_outside_nttTot,  $implem_internalTot,  $opex_from_nttTot,  $opex_from_outside_nttTot,  $opex_internalTot){
    //return the data for the uc corresponding to the year.
    $capexTot = $capex_from_nttTot[$year] + $capex_from_outside_nttTot[$year];
    $implemTot =  $implem_from_nttTot[$year]+$implem_from_outside_nttTot[$year]+$implem_internalTot[$year];
    $opexTot =  $opex_from_nttTot[$year]+$opex_from_outside_nttTot[$year]+$opex_internalTot[$year];

    $cash_in = 0 /*+ $UC_revenues[$year]+ $CRB[$year] + $WCB[$year]*/;
    $cash_out = $capexTot + $opexTot + $implemTot ;
    $netCash = $cash_in-$cash_out;
    
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
        20, 
            30, 
            40, 
            50, 
        $netCash, 
        70, 
        80, 
        90
    ];

}

function dashboards_use_case_details($twig,$is_connected, $projID){
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
            $ucsData= getUcsData($projID, $selScope, $projectYears, $scope);    
            //print_r($ucsData);   
            echo $twig->render('/output/customer_dashboards_steps/use_case_details.twig',array('is_connected'=>$is_connected,'devises'=>$devises,
            'years'=>$projectYears, 'selDevSym'=>$selDevSym, "data"=>$ucsData,'selScope'=>$selScope,'selDevName'=>$selDevName,'ucs'=>$list_ucs, 'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'projects'=>$list_projects)); 
            prereq_dashbords();
        }
    }
}

function dashboards_non_monetizable($twig,$is_connected, $projID){
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
            $schedules = getListSelDates($projID);
            $keydates_proj = getKeyDatesProj($schedules,$scope);
            $projectYears = getYears($keydates_proj[0],$keydates_proj[2]); 
            $data = array(
                "1"=>[
                    ["item 5", 10, 5, 7, 8],
                    ["item 3", 123, 154, 144, 130],
                    ["item 7", 3, 14, 15, 9]
                ],
                "3"=>[
                    ["item 2",1024, 512, 256, 128],
                    ["item 13", 169, 12, 15, 0]
                ]);

            echo $twig->render('/output/customer_dashboards_steps/non_monetizable.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,
            'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'projects'=>$list_projects,
            'selScope'=>$selScope, 'ucs'=>$ucs, 'years'=>$projectYears, 'data'=>$data)); 
            prereq_dashbords();
        }
    }
}

function dashboards_qualitative($twig,$is_connected, $projID){
    $user = getUser($_SESSION['username']);
    $list_projects = getListProjects($user[0]);

    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            $proj = getProjByID($projID,$user[0]); 
            $selScope = getListSelScope($projID);
            $ucs = getListUCs();    
            
            $data = array(
                "1"=>[
                    ["item 5", 10],
                    ["item 3", 1],
                    ["item 7", 3],
                    ["item 42", 5]
                ],
                "3"=>[
                    ["item 2",1],
                    ["item 13", 6]
                ]);

            echo $twig->render('/output/customer_dashboards_steps/qualitative.twig',array('is_connected'=>$is_connected,
            'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],
            'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'projects'=>$list_projects, "selScope"=>$selScope,"ucs"=>$ucs,
            'data'=>$data )); 
            prereq_dashbords();
        }
    }
}

