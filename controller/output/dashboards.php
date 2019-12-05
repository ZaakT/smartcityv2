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
                $opexValuesMonth = calcOpexPerMonth2($opexRepart,$opexValues);
                $opexTot2 = calcOpexTot($opexValuesMonth,$projectYears);

                if(!empty($revenuesSchedule)){
                    $revenuesRepart = getRepartPercRevenues($revenuesSchedule,$projectDates);
                    //var_dump($revenuesRepart);
                    $revenuesValues = getRevenuesValues($projID,$ucID);
                    $revenuesValuesMonth = calcRevenuesPerMonth2($revenuesRepart,$revenuesValues);
                    $revenuesTot2 = calcRevenuesTot($revenuesValuesMonth,$projectYears);
                } else {
                    $revenuesValuesMonth = array_fill_keys($projectDates,0);
                    $revenuesTot2 = calcRevenuesTot($revenuesValuesMonth,$projectYears);
                }

                $cashreleasingValues = getCashReleasingValues($projID,$ucID);
                $cashreleasingValuesMonth = calcCashReleasingPerMonth2($opexRepart,$cashreleasingValues);
                $cashreleasingTot2 = calcCashReleasingTot($cashreleasingValuesMonth,$projectYears);
                
                $widercashValues = getWiderCashValues($projID,$ucID);
                $widercashValuesMonth = calcWiderCashPerMonth2($opexRepart,$widercashValues);
                $widercashTot2 = calcWiderCashTot($widercashValuesMonth,$projectYears);

                $netcashPerMonth = calcNetCashPerMonth($projectDates,$capexPerMonth,$implemPerMonth,$opexValuesMonth,$revenuesValuesMonth,$cashreleasingValuesMonth);
                $netcashTot = calcNetCashTot($netcashPerMonth[0],$projectYears);

                $netsoccashPerMonth = calcNetSocCashPerMonth($projectDates,$capexPerMonth,$implemPerMonth,$opexValuesMonth,$revenuesValuesMonth,$cashreleasingValuesMonth,$widercashValuesMonth);
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
                
                echo $twig->render('/output/dashboards_items/cbuc_output.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],"years"=>$projectYears,'part2'=>"Use Case",'selected2'=>$uc['name'],'zones'=>$sortedSelZones,'capex'=>$capexTot,'implem'=>$implemTot,'opex'=>$opexTot2,'revenues'=>$revenuesTot2,'cashreleasing'=>$cashreleasingTot2,'widercash'=>$widercashTot2,'netcash'=>$netcashTot,'netsoccash'=>$netsoccashTot,'ratio_zones'=>$ratioByVolume,'keydates_uc'=>$keydates_uc,'keydates_proj'=>$keydates_proj,'breakeven'=>$netcashPerMonth[1],'soc_breakeven'=>$netsoccashPerMonth[1],'noncash_rating'=>$ratingNonCash,'npv'=>$npv,'socnpv'=>$socnpv,'risks_rating'=>$ratingRisks));
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
    foreach ($list as $date => $val) { //attention faire en valeurs cumulées
        $cumul += $val;
        if($cumul>=0){
            $breakeven = $date;
            break;
        }
    }
    return [$list,$breakeven];
}

function calcNetCashTot($netcashPerMonth,$projectYears){
    $list = ['tot'=>0];
    foreach ($projectYears as $year) {
        $list[$year]=0;
    }
    foreach ($netcashPerMonth as $date => $value) {
        $temp = explode('/',$date);
        $year = $temp[1];
        $list[$year] += $value;
    }
    $list['tot']=array_sum($list);
    //var_dump($list);
    return $list;
}

function calcNetSocCashPerMonth($dates,$A,$B,$C,$D,$E,$F){
    // F + E + D - A - B - C
    // A = capex, B = implem, C = opex, D = revenues, E = cash releasing, F = wider cash
    foreach ($dates as $date) {
        $list[$date] = $F[$date] + $E[$date] + $D[$date] - $A[$date] - $B[$date] - $C[$date];
    }
    $breakeven = "";
    $cumul = 0;
    foreach ($list as $date => $val) { //attention faire en valeurs cumulées
        $cumul += $val;
        if($cumul>=0){
            $breakeven = $date;
            break;
        }
    }
    return [$list,$breakeven];
}

function calcNetSocCashTot($netsoccashPerMonth,$projectYears){
    $list = ['tot'=>0];
    foreach ($projectYears as $year) {
        $list[$year]=0;
    }
    foreach ($netsoccashPerMonth as $date => $value) {
        $temp = explode('/',$date);
        $year = $temp[1];
        $list[$year] += $value;
    }
    $list['tot']=array_sum($list);
    //var_dump($list);
    return $list;
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
            

            echo $twig->render('/output/dashboards_items/cost_benefits_all.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'projectDates'=>$projectDates,'years'=>$projectYears,'keydates_proj'=>$keydates_proj));
        } else {
            throw new Exception("This project doesn't exist !");
        }
    } else {
        throw new Exception("No Project selected !");
    }
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
            //prereq_CostBenefits();
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
                $years = ['2010',"2011","2012"];
                echo $twig->render('/output/dashboards_items/budget_uc_output.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'part2'=>"Use Case",'selected2'=>$uc['name'],'years'=>$years));
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


// ------------------------------- BUDGET ALL USE CASES -------------------------------

function budget_all($twig,$is_connected,$projID){
    if($projID!=0){
        $user = getUser($_SESSION['username']);
        if(getProjByID($projID,$user[0])){
            $proj = getProjByID($projID,$user[0]);
            $selScope = getListSelScope($projID);
            $projectDates = ["01/2010","02/2010","03/2010","01/2011","02/2011","03/2011","01/2012","02/2012","03/2012"];
            $years = ['2010',"2011","2012"];
            
            echo $twig->render('/output/dashboards_items/budget_all.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'projectDates'=>$projectDates,'years'=>$years));
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
            //prereq_CostBenefits();
        } else {
            throw new Exception("This Project doesn't exist !");
        }
    } else {
        header('Location: ?A=dashboards&A2=project_out');
    }
}

function bankability_output($twig,$is_connected,$projID,$post=[]){
    if($post and isset($post['use_case'])){
        if($projID!=0){
            $user = getUser($_SESSION['username']);
            if(getProjByID($projID,$user[0])){
                $proj = getProjByID($projID,$user[0]);
                $meas = getListMeasures();
                $ucs = getListUCs();
                $scope = getListSelScope($projID);
                var_dump($post);
                echo $twig->render('/output/dashboards_items/bankability_output.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'meas'=>$meas,'ucs'=>$ucs,'scope'=>$scope));
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