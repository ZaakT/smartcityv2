<?php
function dashboards_summary($twig,$is_connected, $projID){
    $user = getUser($_SESSION['username']);
    $list_projects = getListProjects($user[0]);

    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            $proj = getProjByID($projID,$user[0]);
            $ucs = getListUCs();
            $scope = getListSelScope($projID);
            
            $schedules = getListSelDates($projID);
            $keydates_uc = get_keydates_uc($scope,$projID,$schedules);
            $uc_check_completed = check_if_UC_is_completed($projID,$scope);


            $keydates_proj = getKeyDatesProj($schedules,$scope);
            $projectYears = getYears($keydates_proj[0],$keydates_proj[2]);
            $projectDates = createProjectDates($keydates_proj[0],$keydates_proj[2]);
            $ItemsPerMonthAndTot = calcCBItemsPerMonthAndTot($scope, $schedules, $projectDates, $projID, $projectYears);
            $netcashPerMonth = calcNetCashPerMonth($projectDates,$ItemsPerMonthAndTot['capex']['perMonth'],$ItemsPerMonthAndTot['implem']['perMonth'],$ItemsPerMonthAndTot['opex']['perMonth'],$ItemsPerMonthAndTot['revenues']['perMonth'],$ItemsPerMonthAndTot['cashreleasing']['perMonth']);
            $netsoccashPerMonth = calcNetSocCashPerMonth($projectDates,$ItemsPerMonthAndTot['capex']['perMonth'],$ItemsPerMonthAndTot['implem']['perMonth'],$ItemsPerMonthAndTot['opex']['perMonth'],$ItemsPerMonthAndTot['revenues']['perMonth'],$ItemsPerMonthAndTot['cashreleasing']['perMonth'],$ItemsPerMonthAndTot['widercash']['perMonth']);
            
            $netcashTot = calcNetCashTot($netcashPerMonth[0],$projectYears);
            $cumulnetcashTot = $netcashTot[1]; 
            $netsoccashTot = calcNetSocCashTot($netsoccashPerMonth[0],$projectYears);
            $cumulnetsoccashTot = $netsoccashTot[1];

            //prereq_dashbords();
            echo $twig->render('/output/customer_dashboards_steps/summary.twig',array(
                'is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,
                'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],
                'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'projects'=>$list_projects,
                'ucs'=>$ucs,'scope'=>$scope,'keydates_uc'=>$keydates_uc,'uc_completed'=>$uc_check_completed,
                'years'=>$projectYears,'cumulnetcashTot'=>$cumulnetcashTot,'cumulnetsoccashTot'=>$cumulnetsoccashTot
             ));
        }
    }
}

function dashboards_project_details($twig,$is_connected, $projID){
    $user = getUser($_SESSION['username']);
    $list_projects = getListProjects($user[0]);
    

    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            $proj = getProjByID($projID,$user[0]);

            //prereq_dashbords();
            echo $twig->render('/output/customer_dashboards_steps/project_details.twig',array(
                'is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,
                'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],
                'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'projects'=>$list_projects)); 

        }
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
            $proj = getProjByID($projID,$user[0]);            echo '<script type="text/javascript" src="../../public/assets/js/custom/Customer BC/prereq_dashbords.js"></script>';
            prereq_dashbords();
            echo $twig->render('/output/customer_dashboards_steps/use_case_details.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'projects'=>$list_projects)); 

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
            //prereq_dashbords();
            echo $twig->render('/output/customer_dashboards_steps/non_monetizable.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'projects'=>$list_projects)); 

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
            //prereq_dashbords();
            echo $twig->render('/output/customer_dashboards_steps/qualitative.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'projects'=>$list_projects)); 

        }
    }
}

