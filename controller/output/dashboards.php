<?php

require_once('model/model.php');


function dashboards($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/output/dashboards.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}


// ---------------------------------------- PROJECT ----------------------------------------

function project_out($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    $list_projects = getListProjects($user[0]);
    if(isset($_SESSION['projID'])){
        unset($_SESSION['projID']);
    }
    //var_dump($list_projects);
    echo $twig->render('/output/dashboards_items/project_out.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projects'=>$list_projects)); 
}

function cost_benefits_uc($twig,$is_connected,$projID=0){
    $user = getUser($_SESSION['username']);
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            $proj = getProjByID($projID,$user[0]);
            $measures = getListMeasures();
            $ucs = getListUCs();
            $scope = getListSelScope($projID);
            $list_zones = getListZones();
            $repart_zones = sort_zones($list_zones);
            //var_dump($list_zones);
            //var_dump($repart_zones);
            $listSelZones = getListSelZones($projID);
            //var_dump($list_ucs);
            echo $twig->render('/output/dashboards_items/cost_benefits_uc.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'measures'=>$measures,'ucs'=>$ucs,'scope'=>$scope,'zones'=>$repart_zones,'list_sel'=>$listSelZones));
            //prereq_CostBenefits();
        } else {
            throw new Exception("This Project doesn't exist !");
        }
    } else {
        header('Location: ?A=dashboards&A2=project_out');
    }
}

function cbuc_output($twig,$is_connected,$projID,$post=[]){
    if($post){
        if($projID!=0){
            $user = getUser($_SESSION['username']);
            if(getProjByID($projID,$user[0])){
                $proj = getProjByID($projID,$user[0]);
                //var_dump($post);
                $selZones = [];
                foreach ($post as $key => $value) {
                    if($key=="use_case"){
                        $ucID =  intval($value);
                    } else {
                        array_push($selZones,intval($key));
                    }
                }
                $uc = getUCByID($ucID);

                $list_zones = getListZones();
                $selZonesInfos = getInfosZones($selZones,$list_zones);
                $sortedZones = sort_zones($list_zones);
                $sortedSelZones = sort_zones($selZonesInfos);
                $selZones = checkIntegrity($selZones,$sortedSelZones,$sortedZones);
                $selZonesInfos = getInfosZones($selZones,$list_zones);

                $schedules = getListSelDates($projID);
                $implemSchedule = $schedules['implem'][$ucID];
                $opexSchedule = $schedules['opex'][$ucID];
                $revenuesSchedule = $schedules['revenues'][$ucID];
                $kd_startdate = $implemSchedule['startdate'];
                $kd_implem_enddate = $implemSchedule['100date'];
                $kd_project_enddate = $opexSchedule['enddate'];
                $keydates = [$kd_startdate,$kd_implem_enddate,$kd_project_enddate];
                $projectYears = getYears($kd_startdate,$kd_project_enddate);
                $projectDates = createProjectDates($projectYears);

                $implemRepart = getRepartPercImplem($implemSchedule,$projectDates);
                $opexRepart = getRepartPercOpex($opexSchedule,$projectDates);
                $revenuesRepart = getRepartPercRevenues($revenuesSchedule,$projectDates);

                $capex = getTotCapexByUC($projID,$ucID);
                $capexPerMonth = calcCapexPerMonth($implemRepart,$capex);
                $capexTot = calcCapexTot($capexPerMonth,$projectYears);

                $implem = getTotImplemByUC($projID,$ucID);
                $implemPerMonth = calcImplemPerMonth($implemRepart,$implem);
                $implemTot = calcImplemTot($implemPerMonth,$projectYears);
                
                $opex = getTotOpexByUC($projID,$ucID);
                $opexPerMonth = calcOpexPerMonth($opexRepart,$opex);
                $opexTot = calcOpexTot($opexPerMonth,$projectYears);
                
                $revenues = getTotRevenuesByUC($projID,$ucID);
                $revenuesPerMonth = calcRevenuesPerMonth($revenuesRepart,$revenues);
                $revenuesTot = calcRevenuesTot($revenuesPerMonth,$projectYears);

                $list_nbUC = getNbUC($projID,$ucID);
                $ratioByVolume = getRatioByVolume($list_nbUC,$selZones);
                /* var_dump($selZones);
                var_dump($list_nbUC);
                var_dump($ratioByVolume); */
                
                echo $twig->render('/output/dashboards_items/cbuc_output.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],"years"=>$projectYears,'part2'=>"Use Case",'selected2'=>$uc['name'],'zones'=>$sortedSelZones,'capex'=>$capexTot,'implem'=>$implemTot,'opex'=>$opexTot,'revenues'=>$revenuesTot,'ratio_zones'=>$ratioByVolume));
            } else {
                throw new Exception("This project doesn't exist !");
            }
        } else {
            throw new Exception("No Project selected !");
        }
    } else {
        throw new Exception("No Zone selected !");
    }
}

function getRatioByVolume($list_nbUC,$selZones){
    $nbSel = 0;
    foreach ($list_nbUC as $id_zone => $nbUC) {
        if(in_array($id_zone,$selZones)){
            $nbSel+= $nbUC;
        }
    }
    //var_dump($nbSel,array_sum($list_nbUC));
    return $nbSel/array_sum($list_nbUC);
}

function getYears($startdate,$enddate){
    //var_dump($startdate,$enddate);
    $list = [];
    $startyear = intval(explode('/',$startdate)[1]);
    $endyear = intval(explode('/',$enddate)[1]);
    //var_dump($startyear,$endyear);
    for ($i=$startyear; $i <= $endyear ; $i++) { 
        array_push($list,$i);
    }
    return $list;
}

function createProjectDates($years){
    $list = [];
    foreach ($years as $year) {
        for ($j=1; $j <= 12 ; $j++){
            $m =  strlen(strval($j)) == 2 ? strval($j) :  "0".strval($j);
            $y = strval($year);
            array_push($list,$m.'/'.$y);
            //array_push($list,['month'=>strval($j),'year'=>strval($year)]);
        }
    }
    return $list;
}

function getRepartPercImplem($compo_dates,$proj_dates){
    $list = [];

    $startdate = explode('/',$compo_dates['startdate']);
    $startdate = date_create_from_format('m/Y',$startdate[0].'/'.$startdate[1]);

    $date25 = explode('/',$compo_dates['25date']);
    $date25 = date_create_from_format('m/Y',$date25[0].'/'.$date25[1]);

    $date50 = explode('/',$compo_dates['50date']);
    $date50 = date_create_from_format('m/Y',$date50[0].'/'.$date50[1]);

    $date75 = explode('/',$compo_dates['75date']);
    $date75 = date_create_from_format('m/Y',$date75[0].'/'.$date75[1]);
    
    $date100 = explode('/',$compo_dates['100date']);
    $date100 = date_create_from_format('m/Y',$date100[0].'/'.$date100[1]);
    
    $nb25 = intval($date25->diff($startdate)->format('%m'))+1;
    $ratio25 = 25/$nb25;
    $nb50 = intval($date50->diff($date25)->format('%m'));
    $ratio50 = 25/$nb50;
    $nb75 = intval($date75->diff($date50)->format('%m'));
    $ratio75 = 25/$nb75;
    $nb100 = intval($date100->diff($date75)->format('%m'));
    $ratio100 = 25/$nb100;
    
    $list[$proj_dates[0]] = $ratio25;
    for ($i=1; $i < $nb25 ; $i++) { 
        $list[$proj_dates[$i]] = $list[$proj_dates[$i-1]] + $ratio25;
    }
    for ($i=$nb25; $i < $nb25+$nb50 ; $i++) { 
        $list[$proj_dates[$i]] = $list[$proj_dates[$i-1]] + $ratio50;
    }
    for ($i=$nb25+$nb50; $i < $nb25+$nb50+$nb75 ; $i++) { 
        $list[$proj_dates[$i]] = $list[$proj_dates[$i-1]] + $ratio75;
    }
    for ($i=$nb25+$nb50+$nb75; $i < $nb25+$nb50+$nb75+$nb100 ; $i++) { 
        $list[$proj_dates[$i]] = $list[$proj_dates[$i-1]] + $ratio100;
    }
    for ($i=$nb25+$nb50+$nb75+$nb100; $i < sizeof($proj_dates) ; $i++) { 
        $list[$proj_dates[$i]] = 0;
    }
    //var_dump($list);
    return $list;
}

function calcCapexPerMonth($implemRepart,$capexTot){
    $list = [];
    foreach ($implemRepart as $date => $percent) {
        $list[$date] = $percent!=0 ? $capexTot*$percent/100 - array_sum($list) : 0;
    }
    return $list;
}

function calcCapexTot($capexPerMonth,$projectYears){
    $list = ['tot'=>0];
    foreach ($projectYears as $year) {
        $list[$year]=0;
    }
    foreach ($capexPerMonth as $date => $value) {
        $temp = explode('/',$date);
        $year = $temp[1];
        $list[$year] += $value;
    }
    $list['tot']=array_sum($list);
    //var_dump($list);
    return $list;
}

function calcImplemPerMonth($implemRepart,$implemTot){
    $list = [];
    foreach ($implemRepart as $date => $percent) {
        $list[$date] = $percent!=0 ? $implemTot*$percent/100 - array_sum($list) : 0;
    }
    return $list;
}

function calcImplemTot($implemPerMonth,$projectYears){
    $list = ['tot'=>0];
    foreach ($projectYears as $year) {
        $list[$year]=0;
    }
    foreach ($implemPerMonth as $date => $value) {
        $temp = explode('/',$date);
        $year = $temp[1];
        $list[$year] += $value;
    }
    $list['tot']=array_sum($list);
    //var_dump($list);
    return $list;
}


function getRepartPercOpex($compo_dates,$proj_dates){
    $list = [];

    $startdate = explode('/',$compo_dates['startdate']);
    $startdate = date_create_from_format('m/Y',$startdate[0].'/'.$startdate[1]);

    $date25 = explode('/',$compo_dates['25date']);
    $date25 = date_create_from_format('m/Y',$date25[0].'/'.$date25[1]);

    $date50 = explode('/',$compo_dates['50date']);
    $date50 = date_create_from_format('m/Y',$date50[0].'/'.$date50[1]);

    $date75 = explode('/',$compo_dates['75date']);
    $date75 = date_create_from_format('m/Y',$date75[0].'/'.$date75[1]);
    
    $date100 = explode('/',$compo_dates['100date']);
    $date100 = date_create_from_format('m/Y',$date100[0].'/'.$date100[1]);
    
    $enddate = explode('/',$compo_dates['enddate']);
    $enddate = date_create_from_format('m/Y',$enddate[0].'/'.$enddate[1]);
    
    $nb25 = intval($date25->diff($startdate)->format('%m'))+1;
    $ratio25 = 25/$nb25;
    $nb50 = intval($date50->diff($date25)->format('%m'));
    $ratio50 = 25/$nb50;
    $nb75 = intval($date75->diff($date50)->format('%m'));
    $ratio75 = 25/$nb75;
    $nb100 = intval($date100->diff($date75)->format('%m'));
    $ratio100 = 25/$nb100;
    
    $list[$proj_dates[0]] = $ratio25;
    for ($i=1; $i < $nb25 ; $i++) { 
        $list[$proj_dates[$i]] = $list[$proj_dates[$i-1]] + $ratio25;
    }
    for ($i=$nb25; $i < $nb25+$nb50 ; $i++) { 
        $list[$proj_dates[$i]] = $list[$proj_dates[$i-1]] + $ratio50;
    }
    for ($i=$nb25+$nb50; $i < $nb25+$nb50+$nb75 ; $i++) { 
        $list[$proj_dates[$i]] = $list[$proj_dates[$i-1]] + $ratio75;
    }
    for ($i=$nb25+$nb50+$nb75; $i < $nb25+$nb50+$nb75+$nb100 ; $i++) { 
        $list[$proj_dates[$i]] = $list[$proj_dates[$i-1]] + $ratio100;
    }
    for ($i=$nb25+$nb50+$nb75+$nb100; $i < sizeof($proj_dates) ; $i++) { 
        $list[$proj_dates[$i]] = 100;
    }
    /* var_dump($list);
    var_dump($compo_dates); */
    return $list;
}

function calcOpexPerMonth($opexRepart,$opexTot){
    $list = [];
    foreach ($opexRepart as $date => $percent) {
        $list[$date] = $opexTot*$percent/100;
    }
    //var_dump($list);
    return $list;
}

function calcOpexTot($opexPerMonth,$projectYears){
    $list = ['tot'=>0];
    foreach ($projectYears as $year) {
        $list[$year]=0;
    }
    foreach ($opexPerMonth as $date => $value) {
        $temp = explode('/',$date);
        $year = $temp[1];
        $list[$year] += $value;
    }
    $list['tot']=array_sum($list);
    //var_dump($list);
    return $list;
}


function getRepartPercRevenues($compo_dates,$proj_dates){
    $list = [];

    $startdate = explode('/',$compo_dates['startdate']);
    $startdate = date_create_from_format('m/Y',$startdate[0].'/'.$startdate[1]);

    $date25 = explode('/',$compo_dates['25date']);
    $date25 = date_create_from_format('m/Y',$date25[0].'/'.$date25[1]);

    $date50 = explode('/',$compo_dates['50date']);
    $date50 = date_create_from_format('m/Y',$date50[0].'/'.$date50[1]);

    $date75 = explode('/',$compo_dates['75date']);
    $date75 = date_create_from_format('m/Y',$date75[0].'/'.$date75[1]);
    
    $date100 = explode('/',$compo_dates['100date']);
    $date100 = date_create_from_format('m/Y',$date100[0].'/'.$date100[1]);
    
    $enddate = explode('/',$compo_dates['enddate']);
    $enddate = date_create_from_format('m/Y',$enddate[0].'/'.$enddate[1]);
    
    $nb25 = intval($date25->diff($startdate)->format('%m'))+1;
    $ratio25 = 25/$nb25;
    $nb50 = intval($date50->diff($date25)->format('%m'));
    $ratio50 = 25/$nb50;
    $nb75 = intval($date75->diff($date50)->format('%m'));
    $ratio75 = 25/$nb75;
    $nb100 = intval($date100->diff($date75)->format('%m'));
    $ratio100 = 25/$nb100;
    
    $list[$proj_dates[0]] = $ratio25;
    for ($i=1; $i < $nb25 ; $i++) { 
        $list[$proj_dates[$i]] = $list[$proj_dates[$i-1]] + $ratio25;
    }
    for ($i=$nb25; $i < $nb25+$nb50 ; $i++) { 
        $list[$proj_dates[$i]] = $list[$proj_dates[$i-1]] + $ratio50;
    }
    for ($i=$nb25+$nb50; $i < $nb25+$nb50+$nb75 ; $i++) { 
        $list[$proj_dates[$i]] = $list[$proj_dates[$i-1]] + $ratio75;
    }
    for ($i=$nb25+$nb50+$nb75; $i < $nb25+$nb50+$nb75+$nb100 ; $i++) { 
        $list[$proj_dates[$i]] = $list[$proj_dates[$i-1]] + $ratio100;
    }
    for ($i=$nb25+$nb50+$nb75+$nb100; $i < sizeof($proj_dates) ; $i++) { 
        $list[$proj_dates[$i]] = 100;
    }
    /* var_dump($list);
    var_dump($compo_dates); */
    return $list;
}

function calcRevenuesPerMonth($revenuesRepart,$revenuesTot){
    $list = [];
    foreach ($revenuesRepart as $date => $percent) {
        $list[$date] = $revenuesTot*$percent/100;
    }
    return $list;
}

function calcRevenuesTot($revenuesPerMonth,$projectYears){
    $list = ['tot'=>0];
    foreach ($projectYears as $year) {
        $list[$year]=0;
    }
    foreach ($revenuesPerMonth as $date => $value) {
        $temp = explode('/',$date);
        $year = $temp[1];
        $list[$year] += $value;
    }
    $list['tot']=array_sum($list);
    //var_dump($list);
    return $list;
}











function cost_benefits_all($twig,$is_connected,$projID=0){
    $user = getUser($_SESSION['username']);
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            $proj = getProjByID($projID,$user[0]);
            //var_dump($list_ucs);
            echo $twig->render('/output/dashboards_items/cost_benefits_all.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1]));
            //prereq_CostBenefits();
        } else {
            throw new Exception("This Project doesn't exist !");
        }
    } else {
        header('Location: ?A=dashboards&A2=project_out');
    }
}