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

function dashboards_project_details($twig,$is_connected, $projID,$post=[]){
    if($projID!=0){
        $user = getUser($_SESSION['username']);
        if(getProjByID($projID,$user[0])){
            $proj = getProjByID($projID,$user[0]);
            //var_dump($post);
            $selZones = [];

            

            $proj = getProjByID($projID,$user[0]);
            $measures = getListMeasures();
            $ucs = getListUCs();
            $scope = getListSelScope($projID);

            $schedules = getListSelDates($projID);
            $keydates_proj = getKeyDatesProj($schedules,$scope);
            $projectYears = getYears($keydates_proj[0],$keydates_proj[2]);
            
            //GET ZONE RATIO
            $selZones = [];
            foreach ($post as $key => $value) {
                if($key=="use_case"){
                    $ucID =  intval($value);
                } else {
                    array_push($selZones,intval($key));
                }
            }

            $list_zones = getListZones();
            //var_dump($list_zones);
            $selZonesInfos = getInfosZones($selZones,$list_zones);
            $sortedZones = sort_zones($list_zones);
            $sortedSelZones = sort_zones($selZonesInfos);
            $selZones = checkIntegrity($selZones,$sortedSelZones,$sortedZones);
            $selZonesInfos = getInfosZones($selZones,$list_zones);



                    
                                        //ZONE SELECTION
            $listSelZones = getListSelZones($projID);
            //var_dump($selZones, $listSelZones);
                            
            foreach($listSelZones as $id => $zone) {
                $listSelZones[$id]['hasChildren'] = false;
            }
            foreach($listSelZones as $id => $zone) {
                if ( array_key_exists($zone['parent'],$listSelZones) ) {
                    $listSelZones[$zone['parent']]['hasChildren'] = true;
                }   
            }  
            $projectDates = createProjectDates($keydates_proj[0],$keydates_proj[2]);


            foreach ($scope as $measID => $list_ucs) {
                foreach ($list_ucs as $ucID) {

                $implemSchedule = $schedules['implem'][$ucID];
                $opexSchedule = $schedules['opex'][$ucID];
                $revenuesSchedule = isset($schedules['revenues'][$ucID]) ? $schedules['revenues'][$ucID] : [];

                $implemRepart = getRepartPercImplem($implemSchedule,$projectDates);
                $capex = getTotCapexByUC($projID,$ucID);
                $capexPerMonth[$ucID] = calcCapexPerMonth($implemRepart,$capex);
                $capexTot[$ucID] = calcCapexTot($capexPerMonth[$ucID],$projectYears); //ok

                $implem = getTotImplemByUC($projID,$ucID);
                $implemPerMonth[$ucID] = calcImplemPerMonth($implemRepart,$implem);
                $implemTot[$ucID] = calcImplemTot($implemPerMonth[$ucID],$projectYears); //ok
                
                $opexRepart = getRepartPercOpex($opexSchedule,$projectDates);
                $opexValues = getOpexValues($projID,$ucID);
                $opexPerMonth[$ucID] = calcOpexPerMonth2($opexRepart,$opexValues);
                $opexTot2[$ucID] = calcOpexTot($opexPerMonth[$ucID],$projectYears); //ok

                if(scheduleFilled($revenuesSchedule) && !empty($revenuesSchedule)){
                    $revenuesRepart = getRepartPercRevenues($revenuesSchedule,$projectDates);
                    //var_dump($revenuesRepart);
                    $revenuesValues = getRevenuesValues($projID,$ucID);
                    $revenuesPerMonth[$ucID] = calcRevenuesPerMonth2($revenuesRepart,$revenuesValues);
                    $revenuesTot2[$ucID] = calcRevenuesTot($revenuesPerMonth[$ucID],$projectYears); //ok
                } else {
                    $revenuesPerMonth[$ucID] = array_fill_keys($projectDates,0);
                    $revenuesTot2[$ucID] = calcRevenuesTot($revenuesPerMonth[$ucID],$projectYears); //ok
                }

                $cashreleasingValues = getCashReleasingValues($projID,$ucID);
                $cashreleasingValuesMonth[$ucID] = calcCashReleasingPerMonth2($opexRepart,$cashreleasingValues);
                $cashreleasingTot2[$ucID] = calcCashReleasingTot($cashreleasingValuesMonth[$ucID],$projectYears); //ok
                
                $widercashValues = getWiderCashValues($projID,$ucID);
                $widercashValuesMonth[$ucID] = calcWiderCashPerMonth2($opexRepart,$widercashValues);
                $widercashTot2[$ucID] = calcWiderCashTot($widercashValuesMonth[$ucID],$projectYears); //ok

                $netcashPerMonth[$ucID] = calcNetCashPerMonth($projectDates,$capexPerMonth[$ucID],$implemPerMonth[$ucID],$opexPerMonth[$ucID],$revenuesPerMonth[$ucID],$cashreleasingValuesMonth[$ucID]); //ok
                $netcashTot[$ucID] = calcNetCashTot($netcashPerMonth[$ucID][0],$projectYears); //ok

                $netsoccashPerMonth[$ucID] = calcNetSocCashPerMonth($projectDates,$capexPerMonth[$ucID],$implemPerMonth[$ucID],$opexPerMonth[$ucID],$revenuesPerMonth[$ucID],$cashreleasingValuesMonth[$ucID],$widercashValuesMonth[$ucID]);
                $netsoccashTot[$ucID] = calcNetSocCashTot($netsoccashPerMonth[$ucID][0],$projectYears); //ok

                $dr_year = getListSelDiscountRate($projID);
                $dr_month = pow(1+($dr_year/100),1/12)-1;

                $netcashPerMonth[$ucID][1] = $netcashPerMonth[$ucID][1] ? date_format(date_create_from_format('m/Y',$netcashPerMonth[$ucID][1]), 'M/Y') : '';
                $cumulnetcashPerMonth[$ucID] = $netcashPerMonth[$ucID][2];
                $netsoccashPerMonth[$ucID][1] = $netsoccashPerMonth[$ucID][1] ? date_format(date_create_from_format('m/Y',$netsoccashPerMonth[$ucID][1]), 'M/Y') : '';
                $cumulnetsoccashPerMonth[$ucID] = $netsoccashPerMonth[$ucID][2];

                
                
                $cumultNetCash[$ucID] = calcNetCashTot($netcashPerMonth[$ucID][0],$projectYears)[1];
                $cumulNetSocCash[$ucID] = calcNetSocCashTot($netsoccashPerMonth[$ucID][0],$projectYears)[1];

                $list_nbUC = getNbUC($projID,$ucID);
                //var_dump($list_nbUC, $selZones);

                    

            }}
            //var_dump($capexPerMonth);
            $uc_check_completed = check_if_UC_is_completed($projID,$scope);
            


            $devises = getListDevises();
            $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
            $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];

            echo $twig->render('/output/customer_dashboards_steps/project_details.twig',array(
                'is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,
                'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],
                'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],

                'scope'=>$scope,"years"=>$projectYears,'projectDates'=>$projectDates,'capex'=>$capexTot,'capexMonth'=>$capexPerMonth,'list_sel'=>$listSelZones
                ,'implem'=>$implemTot,'implemMonth'=>$implemPerMonth,'opexMonth'=>$opexPerMonth,'opex'=>$opexTot2,'revenues'=>$revenuesTot2,
                'revenuesMonth'=>$revenuesPerMonth,'cashreleasingMonth'=>$cashreleasingValuesMonth,'cashreleasing'=>$cashreleasingTot2,'ucs'=>$ucs
                ,'widercash'=>$widercashTot2, 'widercashMonth'=>$widercashValuesMonth, 'netcash'=>$netcashTot, 'netcashPerMonth'=>$netcashPerMonth
                ,'cumulnetcashTot'=>$cumultNetCash, 'cumulnetcashPerMonth'=>$cumulnetcashPerMonth,'cumulnetsoccashPerMonth'=>$cumulnetsoccashPerMonth
                ,'netsoccash'=>$netsoccashTot,'netsoccashPerMonth'=>$netsoccashPerMonth,'cumulnetsoccashTot'=>$cumulNetSocCash, 'uc_completed'=>$uc_check_completed)); 
                
            
                prereq_dashbords();

        } else {
            throw new Exception("This project doesn't exist !");
        }
    } else {
        throw new Exception("No Project selected !");
    }
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
            echo $twig->render('/output/customer_dashboards_steps/use_case_details.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'years'=>$projectYears, 'selDevSym'=>$selDevSym,'selScope'=>$selScope,'selDevName'=>$selDevName,'ucs'=>$list_ucs, 'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'projects'=>$list_projects)); 
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

