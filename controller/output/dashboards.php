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


// ------------------------------- COST BENEFITS PER USE CASE -------------------------------

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
            prereq_Dashboards();
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

                $scope = getListSelScope($projID);

                $schedules = getListSelDates($projID);
                $keydates_proj = getKeyDatesProj($schedules,$scope);
                $projectYears = getYears($keydates_proj[0],$keydates_proj[2]);
                $projectDates = createProjectDates($keydates_proj[0],$keydates_proj[2]);

                $implemSchedule = $schedules['implem'][$ucID];
                $opexSchedule = $schedules['opex'][$ucID];
                $revenuesSchedule = isset($schedules['revenues'][$ucID]) ? $schedules['revenues'][$ucID] : [];

                $uc_stardate = $implemSchedule['startdate'];
                $uc_implem_enddate = $implemSchedule['100date'];
                $uc_enddate = $opexSchedule['enddate'];
                $keydates_uc = [$uc_stardate,$uc_implem_enddate,$uc_enddate];

                $implemRepart = getRepartPercImplem($implemSchedule,$projectDates);
                $capex = getTotCapexByUC($projID,$ucID);
                $capexPerMonth = calcCapexPerMonth($implemRepart,$capex);
                $capexTot = calcCapexTot($capexPerMonth,$projectYears);
                $implem = getTotImplemByUC($projID,$ucID);
                $implemPerMonth = calcImplemPerMonth($implemRepart,$implem);
                $implemTot = calcImplemTot($implemPerMonth,$projectYears);
                
                $opexRepart = getRepartPercOpex($opexSchedule,$projectDates);
                $opexValues = getOpexValues($projID,$ucID);
                $opexPerMonth = calcOpexPerMonth2($opexRepart,$opexValues);
                $opexTot2 = calcOpexTot($opexPerMonth,$projectYears);

                if(!empty($revenuesSchedule)){
                    $revenuesRepart = getRepartPercRevenues($revenuesSchedule,$projectDates);
                    //var_dump($revenuesRepart);
                    $revenuesValues = getRevenuesValues($projID,$ucID);
                    $revenuesPerMonth = calcRevenuesPerMonth2($revenuesRepart,$revenuesValues);
                    $revenuesTot2 = calcRevenuesTot($revenuesPerMonth,$projectYears);
                } else {
                    $revenuesPerMonth = array_fill_keys($projectDates,0);
                    $revenuesTot2 = calcRevenuesTot($revenuesPerMonth,$projectYears);
                }

                $cashreleasingValues = getCashReleasingValues($projID,$ucID);
                $cashreleasingValuesMonth = calcCashReleasingPerMonth2($opexRepart,$cashreleasingValues);
                $cashreleasingTot2 = calcCashReleasingTot($cashreleasingValuesMonth,$projectYears);
                
                $widercashValues = getWiderCashValues($projID,$ucID);
                $widercashValuesMonth = calcWiderCashPerMonth2($opexRepart,$widercashValues);
                $widercashTot2 = calcWiderCashTot($widercashValuesMonth,$projectYears);

                $netcashPerMonth = calcNetCashPerMonth($projectDates,$capexPerMonth,$implemPerMonth,$opexPerMonth,$revenuesPerMonth,$cashreleasingValuesMonth);
                $netcashTot = calcNetCashTot($netcashPerMonth[0],$projectYears);

                $netsoccashPerMonth = calcNetSocCashPerMonth($projectDates,$capexPerMonth,$implemPerMonth,$opexPerMonth,$revenuesPerMonth,$cashreleasingValuesMonth,$widercashValuesMonth);
                $netsoccashTot = calcNetSocCashTot($netsoccashPerMonth[0],$projectYears);

                $ratingNonCash = getNonCashRating($projID,$ucID);
                $ratingRisks = getRisksRating($projID,$ucID);

                $dr_year = getListSelDiscountRate($projID);
                $dr_month = pow(1+($dr_year/100),1/12)-1;
                $npv = calcNPV($dr_month,$netcashPerMonth[0]);
                $socnpv = calcNPV($dr_month,$netsoccashPerMonth[0]);


                $list_nbUC = getNbUC($projID,$ucID);
                $ratioByVolume = getRatioByVolume($list_nbUC,$selZones);
                /* var_dump($selZones);
                var_dump($list_nbUC);
                var_dump($ratioByVolume); */
                
                echo $twig->render('/output/dashboards_items/cbuc_output.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],"years"=>$projectYears,'part2'=>"Use Case",'selected2'=>$uc['name'],'zones'=>$sortedSelZones,'capex'=>$capexTot,'implem'=>$implemTot,'opex'=>$opexTot2,'revenues'=>$revenuesTot2,'cashreleasing'=>$cashreleasingTot2,'widercash'=>$widercashTot2,'netcash'=>$netcashTot[0],'netsoccash'=>$netsoccashTot[0],'ratio_zones'=>$ratioByVolume,'keydates_uc'=>$keydates_uc,'keydates_proj'=>$keydates_proj,'breakeven'=>$netcashPerMonth[1],'soc_breakeven'=>$netsoccashPerMonth[1],'noncash_rating'=>$ratingNonCash,'npv'=>$npv,'socnpv'=>$socnpv,'risks_rating'=>$ratingRisks));
                prereq_Dashboards();
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

function getKeyDatesProj($schedules,$scope){
    foreach ($scope as $measID => $list_ucs) {
        foreach ($list_ucs as $ucID) {
            $implemSchedule = $schedules['implem'][$ucID];
            $opexSchedule = $schedules['opex'][$ucID];
            //var_dump($ucID,$implemSchedule,$opexSchedule);

            if(!isset($proj_startdate)){
                $proj_startdate = $implemSchedule['startdate'];
            } else{
                $tab_new = explode('/',$implemSchedule['startdate']);
                $date_new = date_create_from_format('m/Y',$tab_new[0].'/'.$tab_new[1]);
   
                $tab_old = explode('/',$proj_startdate);
                $date_old = date_create_from_format('m/Y',$tab_old[0].'/'.$tab_old[1]);

                if($date_new < $date_old){
                    $proj_startdate = $tab_new[0]."/".$tab_new[1];
                }
            }

            if(!isset($proj_implem_enddate)){
                $proj_implem_enddate = $implemSchedule['100date'];
            } else{
                $tab_new = explode('/',$implemSchedule['100date']);
                $date_new = date_create_from_format('m/Y',$tab_new[0].'/'.$tab_new[1]);
   
                $tab_old = explode('/',$proj_implem_enddate);
                $date_old = date_create_from_format('m/Y',$tab_old[0].'/'.$tab_old[1]);

                if($date_new > $date_old){
                    $proj_implem_enddate = $tab_new[0]."/".$tab_new[1];
                }
            }

            if(!isset($proj_enddate)){
                $proj_enddate = $opexSchedule['enddate'];
            } else{
                $tab_new = explode('/',$opexSchedule['enddate']);
                $date_new = date_create_from_format('m/Y',$tab_new[0].'/'.$tab_new[1]);
   
                $tab_old = explode('/',$proj_enddate);
                $date_old = date_create_from_format('m/Y',$tab_old[0].'/'.$tab_old[1]);

                if($date_new > $date_old){
                    $proj_enddate = $tab_new[0]."/".$tab_new[1];
                }
            }
        }
    }
    return [$proj_startdate,$proj_implem_enddate,$proj_enddate];
}

function calcNPV($dr,$netcash){
    $i = 0;
    $NPV = 0;
    foreach ($netcash as $date => $value) {
        $i++;
        $NPV += $value/pow((1+$dr),$i);
    }
    return $NPV;
}

function getRatioByVolume($list_nbUC,$selZones){
    $nbSel = 0;
    foreach ($list_nbUC as $id_zone => $nbUC) {
        if(in_array($id_zone,$selZones)){
            //var_dump($id_zone);
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

function createProjectDates($startdate,$enddate){
    $list = [];
    $startdate = explode('/',$startdate);
    //$startdate = date_create_from_format('m/Y',$startdate[0].'/'.$startdate[1]);
    $startdate = new DateTime($startdate[1]."-".$startdate[0]."-01");

    $enddate = explode('/',$enddate);
    //$enddate = date_create_from_format('m/Y',$enddate[0].'/'.$enddate[1]);
    $enddate = new DateTime($enddate[1]."-".$enddate[0]."-01");

    $interval = new DateInterval('P1M');

    $period = new DatePeriod($startdate, $interval, $enddate->add($interval));
    foreach ($period as $date) {
        $temp = $date->format("m/Y");
        //var_dump($temp,$date);
        array_push($list,$temp);
    }
    return $list;
}

function getRepartPercImplem($compo_dates,$proj_dates){
    $list = [];

    $startdate_proj = explode('/',$proj_dates[0]);
    $startdate_proj = date_create_from_format('m/Y',$startdate_proj[0].'/'.$startdate_proj[1]);

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

    $nb0 = intval($startdate->diff($startdate_proj)->y*12 + $startdate->diff($startdate_proj)->m);

    $nb25 = intval($date25->diff($startdate)->y*12 + $date25->diff($startdate)->m)+1;
    $ratio25 = 25/$nb25;
    $nb50 = intval($date50->diff($date25)->y*12 + $date50->diff($date25)->m);
    $ratio50 = 25/$nb50;
    $nb75 = intval($date75->diff($date50)->y*12 + $date75->diff($date50)->m);
    $ratio75 = 25/$nb75;
    $nb100 = intval($date100->diff($date75)->y*12 + $date100->diff($date75)->m);
    $ratio100 = 25/$nb100;
    
    if($nb0!=0){
        for ($i=0; $i < $nb0 ; $i++) { 
            $list[$proj_dates[$i]] = 0;
        }
        for ($i=$nb0; $i < $nb0+$nb25 ; $i++) { 
            $list[$proj_dates[$i]] = $list[$proj_dates[$i-1]] + $ratio25;
        }
    } else {
        $list[$proj_dates[0]] = $ratio25;
        for ($i=1; $i < $nb0+$nb25 ; $i++) { 
            $list[$proj_dates[$i]] = $list[$proj_dates[$i-1]] + $ratio25;
        }
    }
    for ($i=$nb0+$nb25; $i < $nb0+$nb25+$nb50 ; $i++) { 
        $list[$proj_dates[$i]] = $list[$proj_dates[$i-1]] + $ratio50;
    }
    for ($i=$nb0+$nb25+$nb50; $i < $nb0+$nb25+$nb50+$nb75 ; $i++) { 
        $list[$proj_dates[$i]] = $list[$proj_dates[$i-1]] + $ratio75;
    }
    for ($i=$nb0+$nb25+$nb50+$nb75; $i < $nb0+$nb25+$nb50+$nb75+$nb100 ; $i++) { 
        $list[$proj_dates[$i]] = $list[$proj_dates[$i-1]] + $ratio100;
    }
    for ($i=$nb0+$nb25+$nb50+$nb75+$nb100; $i < sizeof($proj_dates) ; $i++) { 
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

    //var_dump($compo_dates);
    $startdate_proj = explode('/',$proj_dates[0]);
    $startdate_proj = date_create_from_format('m/Y',$startdate_proj[0].'/'.$startdate_proj[1]);

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

    $nb0 = intval($startdate_proj->diff($startdate,true)->y*12 + $startdate_proj->diff($startdate,true)->m);
    $nb25 = intval($date25->diff($startdate)->y*12+$date25->diff($startdate)->m)+1;
    $ratio25 = 25/$nb25;
    $nb50 = intval($date50->diff($date25)->y*12+$date50->diff($date25)->m);
    $ratio50 = 25/$nb50;
    $nb75 = intval($date75->diff($date50)->y*12+$date75->diff($date50)->m);
    $ratio75 = 25/$nb75;
    $nb100 = intval($date100->diff($date75)->y*12+$date100->diff($date75)->m);
    $ratio100 = 25/$nb100;
    $nb_end = intval($enddate->diff($date100,true)->y*12 + $enddate->diff($date100,true)->m);
    
    for ($i=0; $i < $nb0 ; $i++) { 
        $list[$proj_dates[$i]] = 0;
    }
    for ($i=$nb0; $i < $nb0+$nb25 ; $i++) { 
        $list[$proj_dates[$i]] = $list[$proj_dates[$i-1]] + $ratio25;
    }
    for ($i=$nb0+$nb25; $i < $nb0+$nb25+$nb50 ; $i++) { 
        $list[$proj_dates[$i]] = $list[$proj_dates[$i-1]] + $ratio50;
    }
    for ($i=$nb0+$nb25+$nb50; $i < $nb0+$nb25+$nb50+$nb75 ; $i++) { 
        $list[$proj_dates[$i]] = $list[$proj_dates[$i-1]] + $ratio75;
    }
    for ($i=$nb0+$nb25+$nb50+$nb75; $i < $nb0+$nb25+$nb50+$nb75+$nb100 ; $i++) { 
        $list[$proj_dates[$i]] = $list[$proj_dates[$i-1]] + $ratio100;
    }
    for ($i=$nb0+$nb25+$nb50+$nb75+$nb100; $i < $nb0+$nb25+$nb50+$nb75+$nb100+$nb_end; $i++) { 
        $list[$proj_dates[$i]] = 100; //attention date diff 
    }
    for ($i=$nb0+$nb25+$nb50+$nb75+$nb100+$nb_end; $i < sizeof($proj_dates) ; $i++) { 
        $list[$proj_dates[$i]] = 0; //attention date diff 
    }
    //var_dump($list);
    return $list;
}

function calcOpexPerMonth2($opexRepart,$opexValues){
    $list = [];
    $i = 0;
    $prec_percent = 0;
    $prec_date = "";
    //var_dump($opexRepart);
    foreach ($opexRepart as $date => $percent) {
        $opexTot = 0;
        $i++;
        if($percent==100 and $prec_percent==100){
            $list[$date] = $list[$prec_date];
        } else {
            foreach ($opexValues as $id_item => $values) {
                $opexTot += $values['cost']*pow($values['an_var_vol'],$i-1)*pow($values['an_var_unitcost'],$i-1);
            }
            $list[$date] = $opexTot*$percent/100;
        }
        $prec_percent = $percent;
        $prec_date = $date;
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

    //var_dump($compo_dates);
    $startdate_proj = explode('/',$proj_dates[0]);
    $startdate_proj = date_create_from_format('m/Y',$startdate_proj[0].'/'.$startdate_proj[1]);

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

    $nb0 = intval($startdate_proj->diff($startdate,true)->y*12 + $startdate_proj->diff($startdate,true)->m);
    $nb25 = intval($date25->diff($startdate)->y*12+$date25->diff($startdate)->m)+1;
    $ratio25 = 25/$nb25;
    $nb50 = intval($date50->diff($date25)->y*12+$date50->diff($date25)->m);
    $ratio50 = 25/$nb50;
    $nb75 = intval($date75->diff($date50)->y*12+$date75->diff($date50)->m);
    $ratio75 = 25/$nb75;
    $nb100 = intval($date100->diff($date75)->y*12+$date100->diff($date75)->m);
    $ratio100 = 25/$nb100;
    $nb_end = intval($enddate->diff($date100,true)->y*12 + $enddate->diff($date100,true)->m);
    
    for ($i=0; $i < $nb0 ; $i++) { 
        $list[$proj_dates[$i]] = 0;
    }
    for ($i=$nb0; $i < $nb0+$nb25 ; $i++) { 
        $list[$proj_dates[$i]] = $list[$proj_dates[$i-1]] + $ratio25;
    }
    for ($i=$nb0+$nb25; $i < $nb0+$nb25+$nb50 ; $i++) { 
        $list[$proj_dates[$i]] = $list[$proj_dates[$i-1]] + $ratio50;
    }
    for ($i=$nb0+$nb25+$nb50; $i < $nb0+$nb25+$nb50+$nb75 ; $i++) { 
        $list[$proj_dates[$i]] = $list[$proj_dates[$i-1]] + $ratio75;
    }
    for ($i=$nb0+$nb25+$nb50+$nb75; $i < $nb0+$nb25+$nb50+$nb75+$nb100 ; $i++) { 
        $list[$proj_dates[$i]] = $list[$proj_dates[$i-1]] + $ratio100;
    }
    for ($i=$nb0+$nb25+$nb50+$nb75+$nb100; $i < $nb0+$nb25+$nb50+$nb75+$nb100+$nb_end ; $i++) { 
        $list[$proj_dates[$i]] = 100;
    }
    for ($i=$nb0+$nb25+$nb50+$nb75+$nb100; $i < sizeof($proj_dates) ; $i++) { 
        $list[$proj_dates[$i]] = 0;
    }
    //var_dump($list);
    return $list;
}

function calcRevenuesPerMonth2($revenuesRepart,$revenuesValues){
    $list = [];
    $i = 0;
    $prec_percent = 0;
    $prec_date = "";
    //var_dump($revenuesRepart);
    foreach ($revenuesRepart as $date => $percent) {
        $revenuesTot = 0;
        $i++;
        if($percent==100 and $prec_percent==100){
            $list[$date] = $list[$prec_date];
        } else {
            foreach ($revenuesValues as $id_item => $values) {
                $revenuesTot += $values['revenues']*pow($values['an_var_vol'],$i-1)*pow($values['an_var_unitcost'],$i-1);
            }
            $list[$date] = $revenuesTot*$percent/100;
        }
        $prec_percent = $percent;
        $prec_date = $date;
    }
    //var_dump($list);
    return $list;
}

function calcRevenuesTot($revenuesPerMonth,$projectYears){
    //var_dump($revenuesPerMonth,$projectYears);
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

function calcCashReleasingPerMonth2($cashreleasingRepart,$cashreleasingValues){
    $list = [];
    $i = 0;
    $prec_percent = 0;
    $prec_date = "";
    //var_dump($cashreleasingRepart);
    foreach ($cashreleasingRepart as $date => $percent) {
        $cashreleasingTot = 0;
        $i++;
        if($percent==100 and $prec_percent==100){
            $list[$date] = $list[$prec_date];
        } else {
            foreach ($cashreleasingValues as $id_item => $values) {
                $cashreleasingTot += $values['baseline']*pow($values['an_var_vol'],$i-1)*pow($values['an_var_unitcost'],$i-1)-$values['target'];
            }
            $list[$date] = $cashreleasingTot*$percent/100;
        }
        $prec_percent = $percent;
        $prec_date = $date;
    }
    //var_dump($list);
    return $list;
}

function calcCashReleasingTot($cashreleasingPerMonth,$projectYears){
    $list = ['tot'=>0];
    foreach ($projectYears as $year) {
        $list[$year]=0;
    }
    foreach ($cashreleasingPerMonth as $date => $value) {
        $temp = explode('/',$date);
        $year = $temp[1];
        $list[$year] += $value;
    }
    $list['tot']=array_sum($list);
    //var_dump($list);
    return $list;
}


function calcWiderCashPerMonth2($widercashRepart,$widercashValues){
    $list = [];
    $i = 0;
    $prec_percent = 0;
    $prec_date = "";
    //var_dump($widercashRepart);
    foreach ($widercashRepart as $date => $percent) {
        $widercashTot = 0;
        $i++;
        if($percent==100 and $prec_percent==100){
            $list[$date] = $list[$prec_date];
        } else {
            foreach ($widercashValues as $id_item => $values) {
                $widercashTot += $values['baseline']*pow($values['an_var_vol'],$i-1)*pow($values['an_var_unitcost'],$i-1)-$values['target'];
            }
            $list[$date] = $widercashTot*$percent/100;
        }
        $prec_percent = $percent;
        $prec_date = $date;
    }
    //var_dump($list);
    return $list;
}

function calcWiderCashTot($widercashPerMonth,$projectYears){
    $list = ['tot'=>0];
    foreach ($projectYears as $year) {
        $list[$year]=0;
    }
    foreach ($widercashPerMonth as $date => $value) {
        $temp = explode('/',$date);
        $year = $temp[1];
        $list[$year] += $value;
    }
    $list['tot']=array_sum($list);
    //var_dump($list);
    return $list;
}

function calcNetCashPerMonth($dates,$A,$B,$C,$D,$E){
    // E + D - A - B - C
    // A = capex, B = implem, C = opex, D = revenues, E = cash releasing
    foreach ($dates as $date) {
        $list[$date] = $E[$date] + $D[$date] - $A[$date] - $B[$date] - $C[$date];
    }
    $breakeven = "";
    $cumul = 0;
    $list2 = [];
    foreach ($list as $date => $val) { //attention faire en valeurs cumulées
        $cumul += $val;
        $list2[$date] = $cumul;
        if($cumul>=0){
            $breakeven = $date;
            break;
        }
    }
    //var_dump($list2);
    return [$list,$breakeven,$list2];
}

function calcNetCashTot($netcashPerMonth,$projectYears){
    $list = ['tot'=>0];
    $list2 = [];
    foreach ($projectYears as $year) {
        $list[$year]=0;
        $list2[$year]=0;
    }
    foreach ($netcashPerMonth as $date => $value) {
        $temp = explode('/',$date);
        $year = $temp[1];
        $list[$year] += $value;
    }
    $cumul = 0;
    foreach ($list as $year => $value) {
        if($year!="tot"){
            $cumul += $value;
            $list2[$year] = $cumul;
        }
    }
    $list['tot']=array_sum($list);
    return [$list,$list2];
}

function calcNetSocCashPerMonth($dates,$A,$B,$C,$D,$E,$F){
    // F + E + D - A - B - C
    // A = capex, B = implem, C = opex, D = revenues, E = cash releasing, F = wider cash
    foreach ($dates as $date) {
        $list[$date] = $F[$date] + $E[$date] + $D[$date] - $A[$date] - $B[$date] - $C[$date];
    }
    $breakeven = "";
    $cumul = 0;
    $list2=[];
    foreach ($list as $date => $val) { //attention faire en valeurs cumulées
        $cumul += $val;
        $list2[$date] = $cumul;
        if($cumul>=0){
            $breakeven = $date;
            break;
        }
    }
    return [$list,$breakeven,$list2];
}

function calcNetSocCashTot($netsoccashPerMonth,$projectYears){
    $list = ['tot'=>0];
    $list2 = [];
    foreach ($projectYears as $year) {
        $list[$year]=0;
        $list2[$year]=0;
    }
    foreach ($netsoccashPerMonth as $date => $value) {
        $temp = explode('/',$date);
        $year = $temp[1];
        $list[$year] += $value;
    }
    $cumul = 0;
    foreach ($list as $year => $value) {
        if($year!="tot"){
            $cumul += $value;
            $list2[$year] = $cumul;
        }
    }
    $list['tot']=array_sum($list);
    return [$list,$list2];
}


// ------------------------------- COST BENEFITS ALL USE CASES -------------------------------

function cost_benefits_all($twig,$is_connected,$projID){
    if($projID!=0){
        $user = getUser($_SESSION['username']);
        if(getProjByID($projID,$user[0])){
            $proj = getProjByID($projID,$user[0]);
            $scope = getListSelScope($projID);
            
            $schedules = getListSelDates($projID);
            $keydates_proj = getKeyDatesProj($schedules,$scope);
            $projectYears = getYears($keydates_proj[0],$keydates_proj[2]);
            $projectDates = createProjectDates($keydates_proj[0],$keydates_proj[2]);
            
            // For each UC
            // -> get schedules
            // -> calc repartitions (% / month)
            // -> calc values PER MONTH & TOT
            // -> increment capex, implem, .... PER MONTH & TOT

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

            $ratingNonCash = -1;
            $ratingRisks = -1;

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

                    if(!empty($revenuesSchedule)){
                        $revenuesRepart = getRepartPercRevenues($revenuesSchedule,$projectDates);
                        $revenuesValues = getRevenuesValues($projID,$ucID);
                        $revenuesPerMonth_new = calcRevenuesPerMonth2($revenuesRepart,$revenuesValues);
                        $revenuesTot_new = calcRevenuesTot($revenuesPerMonth_new,$projectYears);
                        $revenuesPerMonth = add_arrays($revenuesPerMonth,$revenuesPerMonth_new);
                        $revenuesTot = add_arrays($revenuesTot,$revenuesTot_new);
                    } else {
                        $revenuesPerMonth = array_fill_keys($projectDates,0);
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

                }
            }

            $netcashPerMonth = calcNetCashPerMonth($projectDates,$capexPerMonth,$implemPerMonth,$opexPerMonth,$revenuesPerMonth,$cashreleasingPerMonth);
            //var_dump($netcashPerMonth);
            $netcashTot = calcNetCashTot($netcashPerMonth[0],$projectYears);
            $breakeven = $netcashPerMonth[1];
            $cumulnetcashPerMonth = $netcashPerMonth[2];
            $cumulnetcashTot = $netcashTot[1];

            $netsoccashPerMonth = calcNetSocCashPerMonth($projectDates,$capexPerMonth,$implemPerMonth,$opexPerMonth,$revenuesPerMonth,$cashreleasingPerMonth,$widercashPerMonth);
            $netsoccashTot = calcNetSocCashTot($netsoccashPerMonth[0],$projectYears);
            $soc_breakeven = $netsoccashPerMonth[1];
            $cumulnetsoccashPerMonth = $netsoccashPerMonth[2];
            $cumulnetsoccashTot = $netsoccashTot[1];

            $ratingNonCash = $ratingNonCash/$nbUCS;
            $ratingRisks = $ratingRisks/$nbUCS;

            //var_dump($netcashPerMonth);
            //var_dump($netcashTot);

            $dr_year = getListSelDiscountRate($projID);
            $dr_month = pow(1+($dr_year/100),1/12)-1;
            $npv = calcNPV($dr_month,$netcashPerMonth[0]);
            $socnpv = calcNPV($dr_month,$netsoccashPerMonth[0]);

            echo $twig->render('/output/dashboards_items/cost_benefits_all.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'projectDates'=>$projectDates,'years'=>$projectYears,'keydates_proj'=>$keydates_proj,'capexMonth'=>$capexPerMonth,'capexTot'=>$capexTot,'implemMonth'=>$implemPerMonth,'implemTot'=>$implemTot,'opexMonth'=>$opexPerMonth,'opexTot'=>$opexTot,'revenuesMonth'=>$revenuesPerMonth,'revenuesTot'=>$revenuesTot,'cashreleasingMonth'=>$cashreleasingPerMonth,'cashreleasingTot'=>$cashreleasingTot,'widercashMonth'=>$widercashPerMonth,'widercashTot'=>$widercashTot,'netcashPerMonth'=>$netcashPerMonth[0],'netcashTot'=>$netcashTot[0],'netsoccashPerMonth'=>$netsoccashPerMonth[0],'netsoccashTot'=>$netsoccashTot[0],'breakeven'=>$breakeven,'soc_breakeven'=>$soc_breakeven,'cumulnetcashPerMonth'=>$cumulnetcashPerMonth,'cumulnetsoccashPerMonth'=>$cumulnetsoccashPerMonth,'cumulnetcashTot'=>$cumulnetcashTot,'cumulnetsoccashTot'=>$cumulnetsoccashTot,'ratingNonCash'=>$ratingNonCash,'ratingRisks'=>$ratingRisks,'npv'=>$npv,'socnpv'=>$socnpv));
            prereq_Dashboards();
        } else {
            throw new Exception("This project doesn't exist !");
        }
    } else {
        throw new Exception("No Project selected !");
    }
}

function add_arrays($a,$b){
    $list = [];
    if(empty($a)){
        return $b;
    } else if (empty($b)){
        return $a;
    } else if (empty($a)&&empty($b)){
        return [];
    } else {
        foreach ($a as $key => $value) {
            if(isset($b[$key])){
                $list[$key] = $value + $b[$key];
            } else {
                throw new Exception("Not the same keys in the arrays !");
            }
        }
    }
    return $list;
}

// ------------------------------- BUDGET PER USE CASE -------------------------------

function budget_uc($twig,$is_connected,$projID=0){
    $user = getUser($_SESSION['username']);
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            $proj = getProjByID($projID,$user[0]);
            $measures = getListMeasures();
            $ucs = getListUCs();
            $scope = getListSelScope($projID);
            //var_dump($list_ucs);
            echo $twig->render('/output/dashboards_items/budget_uc.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'measures'=>$measures,'ucs'=>$ucs,'scope'=>$scope));
            prereq_Dashboards();
        } else {
            throw new Exception("This Project doesn't exist !");
        }
    } else {
        header('Location: ?A=dashboards&A2=project_out');
    }
}

function budget_uc_output($twig,$is_connected,$projID,$post=[]){
    if($post and isset($post['use_case'])){
        if($projID!=0){
            $user = getUser($_SESSION['username']);
            if(getProjByID($projID,$user[0])){
                $proj = getProjByID($projID,$user[0]);
                $ucID = intval($post['use_case']);
                $uc = getUCByID($ucID);
                $selScope = getListSelScope($projID);

                $schedules = getListSelDates($projID);
                $keydates_proj = getKeyDatesProj($schedules,$selScope);
                $projectYears = getYears($keydates_proj[0],$keydates_proj[2]);
                $projectDates = createProjectDates($keydates_proj[0],$keydates_proj[2]);
                
                $implemSchedule = $schedules['implem'][$ucID];
                $opexSchedule = $schedules['opex'][$ucID];
                $revenuesSchedule = isset($schedules['revenues'][$ucID]) ? $schedules['revenues'][$ucID] : [];

                /* $uc_stardate = $implemSchedule['startdate'];
                $uc_implem_enddate = $implemSchedule['100date'];
                $uc_enddate = $opexSchedule['enddate'];
                $keydates_uc = [$uc_stardate,$uc_implem_enddate,$uc_enddate]; */

                $implemRepart = getRepartPercImplem($implemSchedule,$projectDates);
                //var_dump($implemRepart);
                $capex = getTotCapexByUC($projID,$ucID);
                $capexPerMonth = calcCapexPerMonth($implemRepart,$capex);
                //var_dump($capexPerMonth);
                $capexTot = calcCapexTot($capexPerMonth,$projectYears);
                $implem = getTotImplemByUC($projID,$ucID);
                $implemPerMonth = calcImplemPerMonth($implemRepart,$implem);
                $implemTot = calcImplemTot($implemPerMonth,$projectYears);
                
                $opexRepart = getRepartPercOpex($opexSchedule,$projectDates);
                $opexValues = getOpexValues($projID,$ucID);
                $opexPerMonth = calcOpexPerMonth2($opexRepart,$opexValues);
                $opexTot2 = calcOpexTot($opexPerMonth,$projectYears);

                if(!empty($revenuesSchedule)){
                    $revenuesRepart = getRepartPercRevenues($revenuesSchedule,$projectDates);
                    //var_dump($revenuesRepart);
                    $revenuesValues = getRevenuesValues($projID,$ucID);
                    $revenuesPerMonth = calcRevenuesPerMonth2($revenuesRepart,$revenuesValues);
                    $revenuesTot2 = calcRevenuesTot($revenuesPerMonth,$projectYears);
                } else {
                    $revenuesPerMonth = array_fill_keys($projectDates,0);
                    $revenuesTot2 = calcRevenuesTot($revenuesPerMonth,$projectYears);
                }

                $cashreleasingValues = getCashReleasingValues($projID,$ucID);
                $cashreleasingValuesMonth = calcCashReleasingPerMonth2($opexRepart,$cashreleasingValues);
                $cashreleasingTot2 = calcCashReleasingTot($cashreleasingValuesMonth,$projectYears);
                
                $capexAmortization = calcCapexAmort($capexPerMonth,getCapexAmort($projID,$ucID),$projectDates,$projectYears);
                
                $baseline_crb = getBaselineCRB($projID,$ucID);
                $netProjectCost = calcNetProjectCost($projectYears,$implemTot,$opexTot2,$revenuesTot2,$capexAmortization);
                $baselineOpCost = calcBaselineOpCost($projectYears,$baseline_crb,$cashreleasingTot2);
                $budgetCost = add_arrays($netProjectCost,$baselineOpCost);

                $OB = calcOB($projectYears,$budgetCost);
                $OBYI = $OB[0];
                $OBCI = $OB[1];

                $CRV = getCRV($projectYears,$capexTot,$capexAmortization);

                echo $twig->render('/output/dashboards_items/budget_uc_output.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'part2'=>"Use Case",'selected2'=>$uc['name'],'years'=>$projectYears,'implem'=>$implemTot,'opex'=>$opexTot2,'revenues'=>$revenuesTot2,'netProjectCost'=>$netProjectCost,'baselineOpCost'=>$baselineOpCost,'budgetCost'=>$budgetCost,'capexAmort'=>$capexAmortization,'OBYI'=>$OBYI,'OBCI'=>$OBCI,'CRV'=>$CRV));
                prereq_Dashboards();
            } else {
                throw new Exception("This project doesn't exist !");
            }
        } else {
            throw new Exception("No Project selected !");
        }
    } else {
        throw new Exception("No UC selected !");
    }
}

function calcCapexAmort($capex,$periods,$projectDates,$projectYears){
    //var_dump($capex);
    $list = array_fill_keys($projectDates,0);
    foreach ($periods as $id_item => $period){
        $list2 = array_fill_keys($projectDates,0);
        $period *= 12;
        foreach ($capex as $date => $value){
            $list3 = array_fill_keys($projectDates,0);
            if($value!=0){
                $temp = $period != 0 ? $value/$period : 0;
                $start = array_search($date,$projectDates);
                $end = $start+$period;
                $end = $end < sizeof($projectDates) ? $end : sizeof($projectDates)-1;
                for ($i=$start; $i < $end; $i++) { 
                    $list3[$projectDates[$i]] += $temp;
                }
                //var_dump($list3);
            }
            $list2 = add_arrays($list2,$list3);
        }
        $list = add_arrays($list,$list2);
    }
    $list_tot = [];
    foreach ($projectYears as $year) {
        $list_tot[$year]=0;
    }
    foreach ($list as $date => $value) {
        $temp = explode('/',$date);
        $year = $temp[1];
        $list_tot[$year] += $value;
    }
    //var_dump($list_tot);
    return $list_tot;
}

function getCRV($years,$capexTot,$capexAmort){
    $list = [];
    $cumul1 = 0;
    $cumul2 = 0;
    foreach ($years as $year){
        $cumul1 += $capexTot[$year];
        $cumul2 += $capexAmort[$year];
        $list[$year] = $cumul1 - $cumul2;
    }
    return $list;
}

function calcOB($years,$budgetCost){
    $OBYI = [];
    $OBCI = [];
    $cumul = 0;
    foreach ($years as $year) {
        $value = $budgetCost[$year] - $budgetCost['current'];
        $cumul += $value;
        $OBYI[$year] = $value;
        $OBCI[$year] = $cumul;
    }
    return [$OBYI,$OBCI];
}

function calcNetProjectCost($years,$a,$b,$c,$d){
    // a + b - c + d
    // a : implem, b : opex, c : revenues, d : capex_amortization
    $list = [];
    $list['current'] = 0;
    foreach ($years as $year) {
        $list[$year] = $a[$year] + $b[$year] - $c[$year] + $d[$year];
    }
    return $list;
}

function calcBaselineOpCost($years,$baseline_crb,$crb){
    // current = baseline CRB * 12
    $list = [];
    $list['current'] = $baseline_crb*12;
    foreach ($years as $year) {
        $list[$year] = $list['current']-$crb[$year];
    }
    return $list;
}


// ------------------------------- BUDGET ALL USE CASES -------------------------------

function budget_all($twig,$is_connected,$projID){
    if($projID!=0){
        $user = getUser($_SESSION['username']);
        if(getProjByID($projID,$user[0])){
            $proj = getProjByID($projID,$user[0]);
            $scope = getListSelScope($projID);
            
            $schedules = getListSelDates($projID);
            $keydates_proj = getKeyDatesProj($schedules,$scope);
            $projectYears = getYears($keydates_proj[0],$keydates_proj[2]);
            $projectDates = createProjectDates($keydates_proj[0],$keydates_proj[2]);
            
            // For each UC
            // -> get schedules
            // -> calc repartitions (% / month)
            // -> calc values PER MONTH & TOT
            // -> calc Budget Values
            // -> increment Values

            $implemTot_all = [];
            $opexTot_all = [];
            $revenuesTot_all = [];
            $capexAmortTot_all = [];
            $netProjectCost = [];
            $baselineOpCost = [];
            $CRV = [];
            $capexAmort_all = [];

            foreach ($scope as $measID => $list_ucs) {
                foreach ($list_ucs as $ucID) {
                    $implemSchedule = $schedules['implem'][$ucID];
                    $opexSchedule = $schedules['opex'][$ucID];
                    $revenuesSchedule = isset($schedules['revenues'][$ucID]) ? $schedules['revenues'][$ucID] : [];

                    $implemRepart = getRepartPercImplem($implemSchedule,$projectDates);
                    $capex = getTotCapexByUC($projID,$ucID);
                    $capexPerMonth = calcCapexPerMonth($implemRepart,$capex);
                    $capexTot = calcCapexTot($capexPerMonth,$projectYears);
                    $implem = getTotImplemByUC($projID,$ucID);
                    $implemPerMonth = calcImplemPerMonth($implemRepart,$implem);
                    $implemTot = calcImplemTot($implemPerMonth,$projectYears);
                    $implemTot_all = add_arrays($implemTot_all,$implemTot);
                    
                    $opexRepart = getRepartPercOpex($opexSchedule,$projectDates);
                    $opexValues = getOpexValues($projID,$ucID);
                    $opexPerMonth = calcOpexPerMonth2($opexRepart,$opexValues);
                    $opexTot2 = calcOpexTot($opexPerMonth,$projectYears);
                    $opexTot_all = add_arrays($opexTot_all,$opexTot2);

                    if(!empty($revenuesSchedule)){
                        $revenuesRepart = getRepartPercRevenues($revenuesSchedule,$projectDates);
                        $revenuesValues = getRevenuesValues($projID,$ucID);
                        $revenuesPerMonth = calcRevenuesPerMonth2($revenuesRepart,$revenuesValues);
                        $revenuesTot2 = calcRevenuesTot($revenuesPerMonth,$projectYears);
                        $revenuesTot_all = add_arrays($revenuesTot_all,$revenuesTot2);
                    } else {
                        $revenuesPerMonth = array_fill_keys($projectDates,0);
                        $revenuesTot2 = calcRevenuesTot($revenuesPerMonth,$projectYears);
                        $revenuesTot_all = add_arrays($revenuesTot_all,$revenuesTot2);
                    }

                    $cashreleasingValues = getCashReleasingValues($projID,$ucID);
                    $cashreleasingValuesMonth = calcCashReleasingPerMonth2($opexRepart,$cashreleasingValues);
                    $cashreleasingTot2 = calcCashReleasingTot($cashreleasingValuesMonth,$projectYears);
                    
                    $capexAmortization = calcCapexAmort($capexPerMonth,getCapexAmort($projID,$ucID),$projectDates,$projectYears);
                    $capexAmort_all = add_arrays($capexAmort_all,$capexAmortization);
                    
                    $baseline_crb = getBaselineCRB($projID,$ucID);
                    $netProjectCost_old = calcNetProjectCost($projectYears,$implemTot,$opexTot2,$revenuesTot2,$capexAmortization);
                    $netProjectCost = add_arrays($netProjectCost,$netProjectCost_old);
                    $baselineOpCost_old = calcBaselineOpCost($projectYears,$baseline_crb,$cashreleasingTot2);
                    $baselineOpCost = add_arrays($baselineOpCost,$baselineOpCost_old);
                    

                    $CRV_old = getCRV($projectYears,$capexTot,$capexAmortization);
                    $CRV = add_arrays($CRV,$CRV_old);
                }
            }
            $budgetCost = add_arrays($netProjectCost,$baselineOpCost);
            $OB = calcOB($projectYears,$budgetCost);
            $OBYI = $OB[0];
            $OBCI = $OB[1];
            
            echo $twig->render('/output/dashboards_items/budget_all.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'projectDates'=>$projectDates,'years'=>$projectYears,'implem'=>$implemTot_all,'opex'=>$opexTot_all,'revenues'=>$revenuesTot_all,'netProjectCost'=>$netProjectCost,'baselineOpCost'=>$baselineOpCost,'budgetCost'=>$budgetCost,'capexAmort'=>$capexAmort_all,'OBYI'=>$OBYI,'OBCI'=>$OBCI,'CRV'=>$CRV));
            prereq_Dashboards();
        } else {
            throw new Exception("This project doesn't exist !");
        }
    } else {
        throw new Exception("No Project selected !");
    }
}


// ------------------------------- BANKABILITY -------------------------------

function bankability($twig,$is_connected,$projID=0){
    $user = getUser($_SESSION['username']);
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            $proj = getProjByID($projID,$user[0]);
            $measures = getListMeasures();
            $ucs = getListUCs();
            $scope = getListSelScope($projID);
            //var_dump($list_ucs);
            echo $twig->render('/output/dashboards_items/bankability.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'measures'=>$measures,'ucs'=>$ucs,'scope'=>$scope));
            prereq_Dashboards();
        } else {
            throw new Exception("This Project doesn't exist !");
        }
    } else {
        header('Location: ?A=dashboards&A2=project_out');
    }
}

function bankability_output($twig,$is_connected,$projID,$post=[]){
    if($post){
        if($projID!=0){
            $user = getUser($_SESSION['username']);
            if(getProjByID($projID,$user[0])){
                $proj = getProjByID($projID,$user[0]);
                $meas = getListMeasures();
                $ucs = getListUCs();
                $scope = getListSelScope($projID);
                $selUCS = [];
                foreach ($post as $ucID => $value) {
                    array_push($selUCS,$ucID);
                }
            
                $schedules = getListSelDates($projID);
                $keydates_proj = getKeyDatesProj($schedules,$scope);
                //$projectYears = getYears($keydates_proj[0],$keydates_proj[2]);
                $projectDates = createProjectDates($keydates_proj[0],$keydates_proj[2]);

                $fin_ROI = array_fill_keys($selUCS,["value"=>0,"score"=>0]);
                $fin_payback = array_fill_keys($selUCS,["value"=>0,"score"=>0]);
                $fin_score = array_fill_keys($selUCS,0);

                $soc_ROI = array_fill_keys($selUCS,["value"=>0,"score"=>0]);
                $soc_payback = array_fill_keys($selUCS,["value"=>0,"score"=>0]);
                $noncash = array_fill_keys($selUCS,["value"=>0,"score"=>0]);
                $risk = array_fill_keys($selUCS,["value"=>0,"score"=>0]);
                $soc_score = array_fill_keys($selUCS,0);

                foreach ($selUCS as $ucID) {

                    $implemSchedule = $schedules['implem'][$ucID];
                    $opexSchedule = $schedules['opex'][$ucID];
                    $revenuesSchedule = isset($schedules['revenues'][$ucID]) ? $schedules['revenues'][$ucID] : [];

                    $implemRepart = getRepartPercImplem($implemSchedule,$projectDates);

                    $capex = getTotCapexByUC($projID,$ucID);
                    $capexPerMonth = calcCapexPerMonth($implemRepart,$capex);

                    $implem = getTotImplemByUC($projID,$ucID);
                    $implemPerMonth = calcImplemPerMonth($implemRepart,$implem);
                    
                    $opexRepart = getRepartPercOpex($opexSchedule,$projectDates);
                    $opex = getOpexValues($projID,$ucID);
                    $opexPerMonth = calcOpexPerMonth2($opexRepart,$opex);

                    if(!empty($revenuesSchedule)){
                        $revenuesRepart = getRepartPercRevenues($revenuesSchedule,$projectDates);
                        $revenuesValues = getRevenuesValues($projID,$ucID);
                        $revenuesPerMonth = calcRevenuesPerMonth2($revenuesRepart,$revenuesValues);
                    } else {
                        $revenuesPerMonth = array_fill_keys($projectDates,0);
                    }

                    $cashreleasingValues = getCashReleasingValues($projID,$ucID);
                    $cashreleasingPerMonth = calcCashReleasingPerMonth2($opexRepart,$cashreleasingValues);
                    
                    $widercashValues = getWiderCashValues($projID,$ucID);
                    $widercashPerMonth= calcWiderCashPerMonth2($opexRepart,$widercashValues);

                    $dr_year = getListSelDiscountRate($projID);
                    $dr_month = pow(1+($dr_year/100),1/12)-1;

                    $sum_capex_implem = add_arrays($capexPerMonth,$implemPerMonth);

                    $netcashPerMonth = calcNetCashPerMonth($projectDates,$capexPerMonth,$implemPerMonth,$opexPerMonth,$revenuesPerMonth,$cashreleasingPerMonth);
                    $NPV1 = calcNPV($dr_month,$netcashPerMonth[0]);
                    $NPV2 = calcNPV($dr_month,$sum_capex_implem);

                    $netsoccashPerMonth = calcNetSocCashPerMonth($projectDates,$capexPerMonth,$implemPerMonth,$opexPerMonth,$revenuesPerMonth,$cashreleasingPerMonth,$widercashPerMonth);
                    $SOCNPV1 = calcNPV($dr_month,$netsoccashPerMonth[0]);
                    $SOCNPV2 = calcNPV($dr_month,$sum_capex_implem);


                    $fin_ROI[$ucID]["value"] = calcROI($NPV1,$NPV2);
                    $fin_ROI[$ucID]["score"] = calcROI_score($fin_ROI[$ucID]["value"]);
                    $fin_payback[$ucID]["value"] = calcPayback($netcashPerMonth)[0];
                    $fin_payback[$ucID]["score"] = calcPayback_score($fin_payback[$ucID]["value"]/100);
                    $fin_score[$ucID] = calcMoyFinBankability($fin_ROI[$ucID]["score"],$fin_payback[$ucID]["score"]);

                    $soc_ROI[$ucID]["value"] = calcROI($SOCNPV1,$SOCNPV2);
                    $soc_ROI[$ucID]["score"] = calcROI_score($soc_ROI[$ucID]["value"]);
                    $soc_payback[$ucID]["value"] = calcPayback($netsoccashPerMonth)[0];
                    $soc_payback[$ucID]["score"] = calcPayback_score($soc_payback[$ucID]["value"]/100);
                    $noncash[$ucID]["value"] = getNonCashRating($projID,$ucID);
                    $noncash[$ucID]["score"] = calcNoncash_score($noncash[$ucID]["value"]);
                    $risk[$ucID]["value"] = getRisksRating($projID,$ucID);
                    $risk[$ucID]["score"] = calcRisk_score($risk[$ucID]["value"]);
                    $soc_score[$ucID] = calcMoySocBankability($soc_ROI[$ucID]["score"],$soc_payback[$ucID]["score"],$noncash[$ucID]["score"],$risk[$ucID]["score"]);
                }

                $fin_data = setFinData($selUCS,$fin_ROI,$fin_payback,$fin_score);
                $fin_data = transformForChart($fin_data);

                $soc_data = setSocData($selUCS,$soc_ROI,$soc_payback,$noncash,$risk,$soc_score);
                $soc_data = transformForChart($soc_data);
                //var_dump($soc_data);

                echo $twig->render('/output/dashboards_items/bankability_output.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'meas'=>$meas,'ucs'=>$ucs,'scope'=>$scope,'selUCS'=>$selUCS,'fin_ROI'=>$fin_ROI,'fin_payback'=>$fin_payback,'fin_score'=>$fin_score,'soc_ROI'=>$soc_ROI,'soc_payback'=>$soc_payback,'noncash'=>$noncash,'risk'=>$risk,'soc_score'=>$soc_score,'fin_data'=>$fin_data,'soc_data'=>$soc_data));
                prereq_Dashboards();
            } else {
                throw new Exception("This project doesn't exist !");
            }
        } else {
            throw new Exception("No Project selected !");
        }
    } else {
        throw new Exception("No UC selected !");
    }
}

function transformForChart($list_data){
    //var data = {"Return per £ invested":1,"Payback / Project Duration":2,"Financial Bankability Score":5};
    $list = [];
    foreach ($list_data as $ucID => $data) {
        $ret = "{";
        $nbData = sizeof($data);
        $i = 0;
        foreach ($data as $key => $value) {
            $i++;
            $ret .= "'".$key."'";
            $ret .= ':';
            $ret .= number_format($value,2,'.',',');
            if($i < $nbData){
                $ret .= ',';
            }
        }
        $ret .= "}";
        $list[$ucID] = $ret;
    }
    return $list;
}

function setFinData($selUCS,$ROI,$payback,$fin_score){
    $list = [];
    foreach ($selUCS as $ucID) {
        $list[$ucID] = ["Return per £ invested"=>$ROI[$ucID]['score'],"Payback / Project Duration"=>$payback[$ucID]['score'],"Financial Bankability Score"=>$fin_score[$ucID]];
    }
    return $list;
}

function setSocData($selUCS,$ROI,$payback,$noncash,$risk,$soc_score){
    $list = [];
    foreach ($selUCS as $ucID) {
        /* $noncash_score = $noncash[$ucID]['score'] != -1 ? $noncash[$ucID]['score'] : 0;
        $risk_score = $risk[$ucID]['score'] != -1 ? $risk[$ucID]['score'] : 0; */
        $list[$ucID] = ['Return per £ invested'=>$ROI[$ucID]['score'],"Payback / Project Duration"=>$payback[$ucID]['score'],"Risks"=>$risk[$ucID]['score'],"Non Cash Benefits Rating"=>$noncash[$ucID]['score'] ,"Societal Bankability Score"=>$soc_score[$ucID]];
    }
    return $list;
}

function calcROI($NPV1,$NPV2){
    $ROI = $NPV2 != 0 ? $NPV1/$NPV2 - 1 : 0;
    return $ROI;
}

function calcROI_score($ROI){
    if($ROI>2)
        $ROI_score = 10;
    elseif($ROI<=2&&$ROI>1.9)
        $ROI_score = 9;
    elseif($ROI<=1.9&&$ROI>1.8)
        $ROI_score = 8;
    elseif($ROI<=1.8&&$ROI>1.7)
        $ROI_score = 7;
    elseif($ROI<=1.7&&$ROI>1.6)
        $ROI_score = 6;
    elseif($ROI<=1.6&&$ROI>1.4)
        $ROI_score = 5;
    elseif($ROI<=1.4&&$ROI>1.3)
        $ROI_score = 4;
    elseif($ROI<=1.3&&$ROI>1.2)
        $ROI_score = 3;
    elseif($ROI<=1.2&&$ROI>1.1)
        $ROI_score = 2;
    elseif($ROI<=1.1&&$ROI>1)
        $ROI_score = 1;
    elseif($ROI<=1)
        $ROI_score = 0;
    return $ROI_score;
}

function calcPayback($netcash){
    $period = 0;
    $netcash_cumul = $netcash[2];
    //var_dump($netcash_cumul);
    $period_tot = sizeof($netcash_cumul);
    foreach ($netcash_cumul as $date => $value) {
        if($value <= 0){
            $period++;
        } else {
            break;
        }
    }
    $payback = $period_tot!=0 ? $period/$period_tot : 0;
    return [$payback,$period];
}

function calcPayback_score($payback){
    if($payback>1||$payback==0)
        $payback_score = 0;
    elseif($payback<=1&&$payback>0.92)
        $payback_score = 1;
    elseif($payback<=0.92&&$payback>0.88)
        $payback_score = 2;
    elseif($payback<=0.88&&$payback>0.8)
        $payback_score = 3;
    elseif($payback<=0.8&&$payback>0.71)
        $payback_score = 4;
    elseif($payback<=0.71&&$payback>0.59)
        $payback_score = 5;
    elseif($payback<=0.59&&$payback>0.49)
        $payback_score = 6;
    elseif($payback<=0.49&&$payback>0.41)
        $payback_score = 7;
    elseif($payback<=0.41&&$payback>0.33)
        $payback_score = 8;
    elseif($payback<=0.33&&$payback>0.25)
        $payback_score = 9;
    elseif($payback<=0.25)
        $payback_score = 10;
    return $payback_score;
}

function calcRisk_score($risk){
    if($risk>7)
        $risk_score = 0;
    elseif($risk<=7&&$risk>6.6)
        $risk_score = 1;
    elseif($risk<=6.6&&$risk>6.1)
        $risk_score = 2;
    elseif($risk<=6.1&&$risk>5.6)
        $risk_score = 3;
    elseif($risk<=5.6&&$risk>5.1)
        $risk_score = 4;
    elseif($risk<=5.1&&$risk>4.6)
        $risk_score = 5;
    elseif($risk<=4.6&&$risk>4.2)
        $risk_score = 6;
    elseif($risk<=4.2&&$risk>3.8)
        $risk_score = 7;
    elseif($risk<=3.8&&$risk>3.4)
        $risk_score = 8;
    elseif($risk<=3.4&&$risk>3)
        $risk_score = 9;
    elseif($risk<=3&&$risk>0)
        $risk_score = 10;
    else
        $risk_score = -1;
    return $risk_score;
}

function calcNoncash_score($noncash){
    if($noncash>7)
        $noncash_score = 10;
    elseif($noncash<=7&&$noncash>6.6)
        $noncash_score = 9;
    elseif($noncash<=6.6&&$noncash>6.1)
        $noncash_score = 8;
    elseif($noncash<=6.1&&$noncash>5.6)
        $noncash_score = 7;
    elseif($noncash<=5.6&&$noncash>5.1)
        $noncash_score = 6;
    elseif($noncash<=5.1&&$noncash>4.6)
        $noncash_score = 5;
    elseif($noncash<=4.6&&$noncash>4.2)
        $noncash_score = 4;
    elseif($noncash<=4.2&&$noncash>3.8)
        $noncash_score = 3;
    elseif($noncash<=3.8&&$noncash>3.4)
        $noncash_score = 2;
    elseif($noncash<=3.4&&$noncash>3)
        $noncash_score = 1;
    elseif($noncash<=3&&$noncash>0)
        $noncash_score = 0;
    else
        $noncash_score = -1;
    return $noncash_score;
}

function calcMoyFinBankability($ROI,$payback){
    $coef_ROI = 1;
    $coef_payback = 1;
    return ($coef_ROI*$ROI + $coef_payback*$payback) / ($coef_ROI + $coef_payback);
}

function calcMoySocBankability($ROI,$payback,$noncash,$risk){
    $coef_ROI = 1;
    $coef_payback = 1;
    $coef_noncash = $noncash!=-1 ? 1 : 0;
    $coef_risk = $risk!=-1 ? 1 : 0;
    return ($coef_ROI*$ROI + $coef_payback*$payback + $coef_noncash*$noncash + $coef_risk*$risk) / ($coef_ROI + $coef_payback + $coef_noncash + $coef_risk);
}


function bankability_output2($twig,$is_connected,$projID=0,$post=[]){
    if($post){
        $user = getUser($_SESSION['username']);
        if($projID!=0){
            if(getProjByID($projID,$user[0])){
                $proj = getProjByID($projID,$user[0]);
                $measures = getListMeasures();
                $ucs = getListUCs();
                $scope = getListSelScope($projID);
                $selUCS = [];
                foreach ($post as $key => $value) {
                    array_push($selUCS,intval($value));
                }
                
                $schedules = getListSelDates($projID);
                $keydates_proj = getKeyDatesProj($schedules,$scope);
                $projectYears = getYears($keydates_proj[0],$keydates_proj[2]);
                $projectDates = createProjectDates($keydates_proj[0],$keydates_proj[2]);
                
                $capexList = ['tot'=>0];
                //var_dump($capexList);

                $fin_ROI = array_fill_keys($selUCS,["value"=>0,"score"=>0]);
                $fin_payback = array_fill_keys($selUCS,["value"=>0,"score"=>0]);
                $fin_score = array_fill_keys($selUCS,0);

                $soc_ROI = array_fill_keys($selUCS,["value"=>0,"score"=>0]);
                $soc_payback = array_fill_keys($selUCS,["value"=>0,"score"=>0]);
                $noncash = array_fill_keys($selUCS,["value"=>0,"score"=>0]);
                $risk = array_fill_keys($selUCS,["value"=>0,"score"=>0]);
                $soc_score = array_fill_keys($selUCS,0);

                foreach ($selUCS as $ucID) {

                    $implemSchedule = $schedules['implem'][$ucID];
                    $opexSchedule = $schedules['opex'][$ucID];
                    $revenuesSchedule = isset($schedules['revenues'][$ucID]) ? $schedules['revenues'][$ucID] : [];

                    $implemRepart = getRepartPercImplem($implemSchedule,$projectDates);

                    $capex = getTotCapexByUC($projID,$ucID);
                    $capexPerMonth = calcCapexPerMonth($implemRepart,$capex);
                    $capexTot = calcCapexTot($capexPerMonth,$projectYears);
                    $capexList['tot'] += $capexTot['tot'];
                    $capexList[$ucID]['value'] = $capexTot['tot'];

                    $implem = getTotImplemByUC($projID,$ucID);
                    $implemPerMonth = calcImplemPerMonth($implemRepart,$implem);
                    
                    $opexRepart = getRepartPercOpex($opexSchedule,$projectDates);
                    $opex = getOpexValues($projID,$ucID);
                    $opexPerMonth = calcOpexPerMonth2($opexRepart,$opex);

                    if(!empty($revenuesSchedule)){
                        $revenuesRepart = getRepartPercRevenues($revenuesSchedule,$projectDates);
                        $revenuesValues = getRevenuesValues($projID,$ucID);
                        $revenuesPerMonth = calcRevenuesPerMonth2($revenuesRepart,$revenuesValues);
                    } else {
                        $revenuesPerMonth = array_fill_keys($projectDates,0);
                    }

                    $cashreleasingValues = getCashReleasingValues($projID,$ucID);
                    $cashreleasingPerMonth = calcCashReleasingPerMonth2($opexRepart,$cashreleasingValues);
                    
                    $widercashValues = getWiderCashValues($projID,$ucID);
                    $widercashPerMonth= calcWiderCashPerMonth2($opexRepart,$widercashValues);

                    $dr_year = getListSelDiscountRate($projID);
                    $dr_month = pow(1+($dr_year/100),1/12)-1;

                    $sum_capex_implem = add_arrays($capexPerMonth,$implemPerMonth);

                    $netcashPerMonth = calcNetCashPerMonth($projectDates,$capexPerMonth,$implemPerMonth,$opexPerMonth,$revenuesPerMonth,$cashreleasingPerMonth);
                    $NPV1 = calcNPV($dr_month,$netcashPerMonth[0]);
                    $NPV2 = calcNPV($dr_month,$sum_capex_implem);

                    $netsoccashPerMonth = calcNetSocCashPerMonth($projectDates,$capexPerMonth,$implemPerMonth,$opexPerMonth,$revenuesPerMonth,$cashreleasingPerMonth,$widercashPerMonth);
                    $SOCNPV1 = calcNPV($dr_month,$netsoccashPerMonth[0]);
                    $SOCNPV2 = calcNPV($dr_month,$sum_capex_implem);


                    $fin_ROI[$ucID]["value"] = calcROI($NPV1,$NPV2);
                    $fin_ROI[$ucID]["score"] = calcROI_score($fin_ROI[$ucID]["value"]);
                    $fin_payback[$ucID]["value"] = calcPayback($netcashPerMonth)[0];
                    $fin_payback[$ucID]["score"] = calcPayback_score($fin_payback[$ucID]["value"]/100);
                    $fin_score[$ucID] = calcMoyFinBankability($fin_ROI[$ucID]["score"],$fin_payback[$ucID]["score"]);

                    $soc_ROI[$ucID]["value"] = calcROI($SOCNPV1,$SOCNPV2);
                    $soc_ROI[$ucID]["score"] = calcROI_score($soc_ROI[$ucID]["value"]);
                    $soc_payback[$ucID]["value"] = calcPayback($netsoccashPerMonth)[0];
                    $soc_payback[$ucID]["score"] = calcPayback_score($soc_payback[$ucID]["value"]/100);
                    $noncash[$ucID]["value"] = getNonCashRating($projID,$ucID);
                    $noncash[$ucID]["score"] = calcNoncash_score($noncash[$ucID]["value"]);
                    $risk[$ucID]["value"] = getRisksRating($projID,$ucID);
                    $risk[$ucID]["score"] = calcRisk_score($risk[$ucID]["value"]);
                    $soc_score[$ucID] = calcMoySocBankability($soc_ROI[$ucID]["score"],$soc_payback[$ucID]["score"],$noncash[$ucID]["score"],$risk[$ucID]["score"]);
                }
                foreach ($capexList as $key => $value) {
                    if($key != 'tot'){
                        $capexList[$key]['weight'] = $capexList['tot']!=0 ? 100*$value['value']/$capexList['tot'] : 0;
                    }
                }
                $weighted_scores = getWeightedScores($fin_score,$soc_score,$capexList);
                //var_dump($weighted_scores);


                echo $twig->render('/output/dashboards_items/bankability_output2.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'measures'=>$measures,'ucs'=>$ucs,'scope'=>$scope,'selUCS'=>$selUCS,'capex'=>$capexList,'weighted_scores'=>$weighted_scores));
                prereq_Dashboards();
            } else {
                throw new Exception("This Project doesn't exist !");
            }
        } else {
            header('Location: ?A=dashboards&A2=project_out');
        }
    } else {
        throw new Exception("There is no UC selected !");
    }
}

function getWeightedScores($fin_score,$soc_score,$capexList){
    /* $list = []; */
    //weighted_scores = {1:{'fin':1,'soc':2},2:{'fin':1,'soc':2},3:{'fin':1,'soc':2}};
    $ret = "{";
    $i = 0;
    foreach ($capexList as $key => $tab) {
        $i++;
        if($key != 'tot'){
            $ucID = $key;
            $weight = $tab['weight'];
            $fin_value = $weight*$fin_score[$ucID]/100;
            $soc_value = $weight*$soc_score[$ucID]/100;
            /* $list[$ucID]['fin'] = $weight*$fin_value/100;
            $list[$ucID]['soc'] = $weight*$soc_value/100; */
            
            $ret .= $key.":{'fin':".$fin_value.",'soc':".$soc_value."}";
            
            if($i < sizeof($capexList)){
                $ret .= ",";
            }
        }
    }
    $ret .= "}";
    return $ret;
}

// ----------------------------------- FINANCING -----------------------------------

function financing_out($twig,$is_connected,$projID=0){
    $user = getUser($_SESSION['username']);
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            $proj = getProjByID($projID,$user[0]);
            $measures = getListMeasures();
            $ucs = getListUCs();
            $scope = getListSelScope($projID);
            //var_dump($list_ucs);
            echo $twig->render('/output/dashboards_items/financing_out.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'measures'=>$measures,'ucs'=>$ucs,'scope'=>$scope));
            prereq_Dashboards();
        } else {
            throw new Exception("This Project doesn't exist !");
        }
    } else {
        header('Location: ?A=dashboards&A2=project_out');
    }
}

// ------------------------------- PROJECT DASHBOARD -------------------------------

function project_dashboard($twig,$is_connected,$projID=0){
    $user = getUser($_SESSION['username']);
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            $proj = getProjByID($projID,$user[0]);
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

                    if(!empty($revenuesSchedule)){
                        $revenuesRepart = getRepartPercRevenues($revenuesSchedule,$projectDates);
                        $revenuesValues = getRevenuesValues($projID,$ucID);
                        $revenuesPerMonth_new = calcRevenuesPerMonth2($revenuesRepart,$revenuesValues);
                        $revenuesTot_new = calcRevenuesTot($revenuesPerMonth_new,$projectYears);
                        $revenuesPerMonth = add_arrays($revenuesPerMonth,$revenuesPerMonth_new);
                        $revenuesTot = add_arrays($revenuesTot,$revenuesTot_new);
                    } else {
                        $revenuesPerMonth = array_fill_keys($projectDates,0);
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
            $scores = getWeightedScores2($fin_score,$soc_score,$capexList);

            //var_dump($scores);

            echo $twig->render('/output/dashboards_items/project_dashboard.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'measures'=>$measures,'ucs'=>$ucs,'scope'=>$scope,'volumes'=>$volumes,'keydates_uc'=>$keydates_uc,'projectDates'=>$projectDates,'years'=>$projectYears,'netProjectCost'=>$netProjectCost,'baselineOpCost'=>$baselineOpCost,'budgetCost'=>$budgetCost,'OBYI'=>$OBYI,'CRV'=>$CRV,'capex'=>$capexTot['tot'],"netcash"=>$netcashTot[0]['tot'],"netsoccash"=>$netsoccashTot[0]['tot'],'noncash'=>$ratingNonCash,'risk'=>$ratingRisks,'npv'=>$NPV,'socnpv'=>$SOCNPV,'ROI'=>$ROI,'SOCROI'=>$SOCROI,'payback'=>$payback,'socpayback'=>$socpayback,'scores'=>$scores));
            prereq_Dashboards();
        } else {
            throw new Exception("This Project doesn't exist !");
        }
    } else {
        header('Location: ?A=dashboards&A2=project_out');
    }
}

function getWeightedScores2($fin_score,$soc_score,$capexList){
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
    $ret = "[";
    $i=0;
    foreach(array_values($list) as $value){
        $i++;
        $ret .= $value;
        if($i < sizeof(array_values($list))){
            $ret .= ",";
        }
    }
    $ret .= "]";
    return $ret;
}
// ---------------------------------------- CHECK PRE-REQ ----------------------------------------
function prereq_Dashboards(){
    if(isset($_SESSION['projID'])){
        $projID = $_SESSION['projID'];
        echo "<script>prereq_dashboards(true);</script>";
    }
}
