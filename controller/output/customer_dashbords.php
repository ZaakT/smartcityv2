<?php

function prereq_dashbords(){
    if(isset($_GET['A2'])){
        echo "
        
        <script>prereq_dashbords();</script>";
    }
}
function dashboards_summary($twig,$is_connected, $projID){
    $user = getUser($_SESSION['username']);
    $list_projects = getListProjects($user[0]);

    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            try{
                
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
            }
            catch(\Throwable $th){
                header('?A=customer_dashboards');
            }

            echo $twig->render('/output/customer_dashboards_steps/summary.twig',array(
                'is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,
                'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],
                'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'projects'=>$list_projects,
                'ucs'=>$ucs,'scope'=>$scope,'keydates_uc'=>$keydates_uc,'uc_completed'=>$uc_check_completed,
                'years'=>$projectYears,'cumulnetcashTot'=>$cumulnetcashTot,'cumulnetsoccashTot'=>$cumulnetsoccashTot
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
    $cash_out = $capexTot + $opexTot + $implemTot ;
    
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
        60, 
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
            echo $twig->render('/output/customer_dashboards_steps/use_case_details.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'years'=>$projectYears, 'selDevSym'=>$selDevSym, "data"=>$ucsData,'selScope'=>$selScope,'selDevName'=>$selDevName,'ucs'=>$list_ucs, 'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'projects'=>$list_projects)); 
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
            echo $twig->render('/output/customer_dashboards_steps/non_monetizable.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'projects'=>$list_projects)); 
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
            echo $twig->render('/output/customer_dashboards_steps/qualitative.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'projects'=>$list_projects)); 
            prereq_dashbords();
        }
    }
}

