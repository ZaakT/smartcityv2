<?php

require_once('model/model.php');



// ---------------------------------------- PROJECT DESIGN ----------------------------------------

function project_design($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/input/project_design.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'username'=>$user[1],'is_admin'=>$user[3])); 
}



// ---------------------------------------- USE CASES MENU ----------------------------------------

function ucm($twig,$is_connected,$isTaken=false){
    $user = getUser($_SESSION['username']);
    $list_ucms = getListUCMS($user[0]);
    //var_dump($list_ucms);
    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/input/project_design_steps/ucm.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3],'ucms'=>$list_ucms,'isTaken'=>$isTaken,'part'=>'Use Cases Menu','username'=>$user[1])); 
}

function create_ucm($post){
    $name = $post['name'];
    $description = isset($post['description']) ? $post['description'] : "";
    $user = getUser($_SESSION['username']);
    $idUser = $user[0];
    $ucmInfos = [$name,$description,$idUser];
    if(!empty(getUCM($idUser,$name))){
        header('Location: ?A=project_design&A2=ucm&isTaken=true');
    } else {
        insertUCM($ucmInfos);
        header('Location: ?A=project_design&A2=ucm');
    }
}

function delete_ucm($idUCM){
    //var_dump(intval($idUCM));
    deleteUCM(intval($idUCM));
    header('Location: ?A=project_design&A2=ucm');
}



// ---------------------------------------- MEASURES ----------------------------------------

function measures($twig,$is_connected,$ucmID=0){
    $user = getUser($_SESSION['username']);
    if($ucmID!=0){
        if(getUCMByID($ucmID,$user[0])){
            $ucm = getUCMByID($ucmID,$user[0]);
            $list_measures = getListMeasures();
            //var_dump($list_measures);
            $list_sel = getListSelMeas($ucm[0]);
            //var_dump($list_sel);
            $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/input/project_design_steps/measures.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu',"selected"=>$ucm[1],'username'=>$user[1],'measures'=>$list_measures,'list_sel'=>$list_sel));
            prereq_ProjectDesign();
        } else {
            header('Location: ?A=project_design&A2=measures');
        }
    } else {
        $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/input/project_design_steps/measures.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu','username'=>$user[1]));
        prereq_ProjectDesign();
    }
}

function measures_selected($list_measID=[]){
    if($list_measID){
        if(isset($_SESSION['ucmID'])){
            $ucmID = $_SESSION['ucmID'];
            //var_dump(empty(getListSelMeas($ucmID)));
            if(empty(getListSelMeas($ucmID))){
                insertSelMeas($ucmID,$list_measID);
            } else {
                deleteSelMeas($ucmID);
                insertSelMeas($ucmID,$list_measID);
            }
            //var_dump($list_measID);
            update_ModifDate_ucm($ucmID);
            header('Location: ?A=project_design&A2=criteria&ucmID='.$ucmID);
        } else {
            throw new Exception("No UCM selected !");
        }
    } else {
        throw new Exception("No measure selected !");
    }
}



// ---------------------------------------- CRITERIA ----------------------------------------

function criteria($twig,$is_connected,$ucmID=0){
    $user = getUser($_SESSION['username']);
    if($ucmID!=0){
        if(getUCMByID($ucmID,$user[0])){
            $ucm = getUCMByID($ucmID,$user[0]);
            $list_criteria = getListCrit();
            $list_critCategories = getListCritCat() ;
            $list_sel = [];
            foreach (getListSelCrit($ucm[0]) as $value) {
                array_push($list_sel,$value[0]);
            }
            //var_dump($list_sel);
            //var_dump($list_criteria);
            $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/input/project_design_steps/criteria.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu',"selected"=>$ucm[1],'username'=>$user[1],'criteria'=>$list_criteria,'list_sel'=>$list_sel,'categories'=>$list_critCategories));
            prereq_ProjectDesign();
        } else {
            header('Location: ?A=project_design&A2=criteria');
        }
    } else {
        $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/input/project_design_steps/criteria.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu','username'=>$user[1]));
        prereq_ProjectDesign();
    }
}

function criteria_selected($list_critID=[]){
    if($list_critID){
        if(isset($_SESSION['ucmID'])){
            $ucmID = $_SESSION['ucmID'];
            $listSelCrit = getListSelCrit($ucmID);
            //var_dump("listSelCrit :");
            //var_dump($listSelCrit);
            if(empty($listSelCrit)){
                insertSelCrit($ucmID,$list_critID);
            } else {
                deleteSelCrit($ucmID);
                insertSelCrit($ucmID,$list_critID);
            }
            $listSelCrit = getListSelCrit($ucmID);
            $listSelCritCatID = [];
            foreach ($listSelCrit as $selCrit) {
                //var_dump($selCrit);
                if(!in_array($selCrit['id_cat'],$listSelCritCatID)){
                    array_push($listSelCritCatID,intval($selCrit['id_cat']));
                }
            }
            //var_dump("listSelCritCatID :");
            //var_dump($listSelCritCatID);
            $listSelCritCat = getListSelCritCat($ucmID);
            //var_dump("listSelCritCat :");
            //var_dump($listSelCritCat);
            if(empty($listSelCritCat)){
                insertSelCritCat($ucmID,$listSelCritCatID);
            } else {
                deleteSelCritCat($ucmID);
                insertSelCritCat($ucmID,$listSelCritCatID);
            }
            update_ModifDate_ucm($ucmID);
            header('Location: ?A=project_design&A2=geography&ucmID='.$ucmID);
        } else {
            throw new Exception("No UCM selected !");
        }
    } else {
        throw new Exception("No Criterion selected !");
    }
}


// ---------------------------------------- GEOGRAPHY ----------------------------------------

function geography($twig,$is_connected,$ucmID=0){
    $user = getUser($_SESSION['username']);
    if($ucmID!=0){
        if(getUCMByID($ucmID,$user[0])){
            $ucm = getUCMByID($ucmID,$user[0]);
            $list_DLTs = getListDLTs();
            $list_sel = [];
            foreach (getListSelDLTs($ucm[0]) as $value) {
                array_push($list_sel,$value[0]);
            }
            //var_dump($list_sel);
            //var_dump($list_DLTs);
            $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/input/project_design_steps/geography.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu',"selected"=>$ucm[1],'username'=>$user[1],'DLTs'=>$list_DLTs,'list_sel'=>$list_sel));
            prereq_ProjectDesign();
        } else {
            //header('Location: ?A=project_design&A2=geography');
        }
    } else {
        $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/input/project_design_steps/geography.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu','username'=>$user[1]));
        prereq_ProjectDesign();
    }
}

function geo_selected($list_idDLT=[]){
    if($list_idDLT){
        if(isset($_SESSION['ucmID'])){
            $ucmID = $_SESSION['ucmID'];
            $listSelDLT = getListSelDLTs($ucmID);
            //var_dump(empty($listSelDLT));
            if(empty($listSelDLT)){
                insertSelDLTs($ucmID,$list_idDLT);
            } else {
                deleteSelDLTs($ucmID);
                insertSelDLTs($ucmID,$list_idDLT);
            }
            update_ModifDate_ucm($ucmID);
            header('Location: ?A=project_design&A2=use_case&ucmID='.$ucmID);
        } else {
            throw new Exception("No UCM selected !");
        }
    } else {
        throw new Exception("No District Location Type selected !");
    }
}


// ---------------------------------------- USE CASES ----------------------------------------

function use_case($twig,$is_connected,$ucmID=0){
    $user = getUser($_SESSION['username']);
    if($ucmID!=0){
        if(getUCMByID($ucmID,$user[0])){
            $ucm = getUCMByID($ucmID,$user[0]);
            $list_selMeas = getListSelMeas($ucmID);
            $list_measID = [];
            foreach ($list_selMeas as $meas) {
                array_push($list_measID,$meas[0]);
            }
            $list_cat = getListUCsCat();
            $ucs = getListUCs();
            $list_ucs = getUC($list_selMeas);
            $list_selCritCat = getListSelCritCat($ucmID);
            $list_selCrit = getListSelCrit($ucmID);
            $list_meas = getListMeasures();
            $repart_selCrit = calcRepartCrit($list_selCritCat,$list_selCrit);
            $list_selDLT = getListSelDLTs($ucmID);
            $guidCrit = getGuidCrit($list_ucs,$list_selCrit);
            $pertDLT = getPertDLT($list_ucs,$list_selDLT);
            $list_sel = [];
            foreach (getListSelUC($ucm[0]) as $value) {
                array_push($list_sel,$value[0]);
            }
            /* var_dump($list_ucs);
            //var_dump($ucs);
            //var_dump($list_cat); */

            $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/input/project_design_steps/use_case.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu',"selected"=>$ucm[1],'username'=>$user[1],'ucs'=>$list_ucs,'sel_critCat'=>$list_selCritCat,'sel_crit'=>$list_selCrit,'sel_DLTs'=>$list_selDLT,'repart_selCrit'=>$repart_selCrit,'guidCrit'=>$guidCrit,'pertDLT'=>$pertDLT,'list_sel'=>$list_sel,'cat'=>$list_cat,'ucs_all'=>$ucs,'sel_meas'=>$list_selMeas,'meas'=>$list_meas));
            prereq_ProjectDesign();
        } else {
            //header('Location: ?A=project_design&A2=use_case');
        }
    } else {
        $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/input/project_design_steps/use_case.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu','username'=>$user[1]));
        prereq_ProjectDesign();
    }
}

function uc_selected($twig,$is_connected,$list_idDLT=[]){
    if($list_idDLT){
        if(isset($_SESSION['ucmID'])){
            $ucmID = $_SESSION['ucmID'];
            $listSelUC = getListSelUC($ucmID);
            //var_dump(empty($listSelUC));
            if(empty($listSelUC)){
                insertSelUC($ucmID,$list_idDLT);
            } else {
                deleteSelUC($ucmID);
                insertSelUC($ucmID,$list_idDLT);
            }
            //var_dump($listSelUC);
            update_ModifDate_ucm($ucmID);
            confirm_uc_select($twig,$is_connected,$ucmID);
        } else {
            throw new Exception("No UCM selected !");
        }
    } else {
        throw new Exception("No Use Case selected !");
    }
}

function confirm_uc_select($twig,$is_connected,$ucmID=0){
    $user = getUser($_SESSION['username']);
    if($ucmID!=0){
        if(getUCMByID($ucmID,$user[0])){
            $ucm = getUCMByID($ucmID,$user[0]);
            $list_selUC = getListSelUC($ucmID);
            //var_dump($list_selUC);
            update_ModifDate_ucm($ucmID);
            $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/input/project_design_steps/confirm_uc_select.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu',"selected"=>$ucm[1],'username'=>$user[1],'list_selUC'=>$list_selUC));
            prereq_ProjectDesign();
        } else {
            header('Location: ?A=project_design&A2=use_case');
        }
    } else {
        $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/input/project_design_steps/confirm_uc_select.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu','username'=>$user[1]));
    }
}

function calcRepartCrit($list_cat,$list_crit){
    $res = [];
    foreach ($list_cat as $cat) {
        $count = 0;
        foreach ($list_crit as $crit) {
            if($cat['id']==$crit['id_cat']){
                $count++;
            }
        }
        $res[$cat['id']] = $count;
    }
    //var_dump($res);
    return $res;
}


// ---------------------------------------- RATING ----------------------------------------

function rating($twig,$is_connected,$ucmID=0){
    $user = getUser($_SESSION['username']);
    if($ucmID!=0){
        if(getUCMByID($ucmID,$user[0])){
            $ucm = getUCMByID($ucmID,$user[0]);
            $measures = getListMeasures();
            $list_selUC = getListSelUC($ucmID);
            $list_cat = getListUCsCat();
            $ucs = getListUCs();
            $list_selMeas = getListSelMeas($ucmID);
            $repart_ucs = calcRepartUC($list_selMeas,$list_selUC,$measures);
            $list_selCritCat = getListSelCritCat($ucmID);
            $list_selCrit = getListSelCrit($ucmID);
            $repart_selCrit = calcRepartCrit($list_selCritCat,$list_selCrit);
            $guidCrit = getGuidCrit($list_selUC,$list_selCrit);
            $orderUC = [];
            foreach ($list_selUC as $uc) {
                array_push($orderUC,intval($uc[0]));
            }
            
            $listInputedRates = getListInputedRates($ucmID);

            $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/input/project_design_steps/rating.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu',"selected"=>$ucm[1],'username'=>$user[1],'sel_ucs'=>$list_selUC,'sel_meas'=>$list_selMeas,'repart_ucs'=>$repart_ucs,'repart_selCrit'=>$repart_selCrit,'sel_critCat'=>$list_selCritCat,'sel_crit'=>$list_selCrit,'guidCrit'=>$guidCrit,'rates'=>$listInputedRates,'meas'=>$measures,'ucs_all'=>$ucs,'cat'=>$list_cat));
            prereq_ProjectDesign();
        } else {
            header('Location: ?A=project_design&A2=rating');
        }
    } else {
        $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/input/project_design_steps/rating.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu','username'=>$user[1]));
        prereq_ProjectDesign();
    }
}

function calcRepartUC($list_meas,$list_ucs,$measures){
    $res = [];
    foreach ($list_meas as $meas) {
        $count = 0;
        foreach ($list_ucs as $uc) {
            if($measures[$meas]['name']==$uc[3]){
                $count++;
            }
        }
        $res[$meas] = $count;
    }
    //var_dump($res);
    return $res;
}

function rates_inputed($post){
    if($post){
        if(isset($_SESSION['ucmID'])){
            $ucmID = $_SESSION['ucmID'];
            $list_selUC = getListSelUC($ucmID);
            $orderUC = [];
            foreach ($list_selUC as $uc) {
                array_push($orderUC,intval($uc[0]));
            }
            $list_selCrit = getListSelCrit($ucmID);
            //var_dump($list_selCrit);
            $listInputedRates = getListInputedRates($ucmID);
            //var_dump(empty($listSelUC));
            $list_rates = [];
            //var_dump($post);
            foreach ($post as $key => $value) {
                if(isset($key)){
                    $IDs = explode("_",$key);
                    $ucID = intval($IDs[0]);
                    $critID = intval($IDs[1]);
                    if(array_key_exists($ucID,$list_rates)){
                        $list_rates[$ucID]+=[$critID=>intval($value)];
                    }
                    else {
                        $list_rates[$ucID]=[$critID=>intval($value)];
                    }
                }
            }
            //var_dump($list_rates);
            if(empty($listInputedRates)){
                insertRates($ucmID,$list_rates);
            } else {
                deleteRates($ucmID);
                insertRates($ucmID,$list_rates);
            }
            update_ModifDate_ucm($ucmID);
            header('Location: ?A=project_design&A2=scoring&ucmID='.$ucmID);
        } else {
            throw new Exception("No UCM selected !");
        }
    } else {
        throw new Exception("No rate inputed !");
    }
}

// ---------------------------------------- SCORING ----------------------------------------

function scoring($twig,$is_connected,$ucmID=0){
    $user = getUser($_SESSION['username']);
    if($ucmID!=0){
        if(getUCMByID($ucmID,$user[0])){
            $ucm = getUCMByID($ucmID,$user[0]);
            $list_selUC = getListSelUC($ucmID);
            $orderUC = [];
            foreach ($list_selUC as $uc) {
                array_push($orderUC,intval($uc[0]));
            }
            //var_dump($orderUC);
            $list_selCritCat = getListSelCritCat($ucmID);
            $list_selCrit = getListSelCrit($ucmID);
            $orderCrit = [];
            foreach ($list_selCrit as $crit) {
                array_push($orderCrit,intval($crit['id']));
            }
            //var_dump($orderCrit);
            $repart_selCrit = calcRepartCrit($list_selCritCat,$list_selCrit);
            $rates = getListInputedRates($ucmID);
            $ranks = calcRanks($rates,$orderUC,$orderCrit);
            $scores = calcScores($ranks,$repart_selCrit,count($list_selUC),$orderUC);
            /* var_dump($rates);
            //var_dump($list_selCrit);
            //var_dump($ranks); */
            if($ranks && $scores){
                $devises = getListDevises();
                $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
                $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
                
                echo $twig->render('/input/project_design_steps/scoring.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu',"selected"=>$ucm[1],'username'=>$user[1],'ranks'=>$ranks,'scores'=>$scores,'sel_ucs'=>$list_selUC,'repart_selCrit'=>$repart_selCrit,'sel_critCat'=>$list_selCritCat,'sel_crit'=>$list_selCrit));
                prereq_ProjectDesign();
            } else {
                throw new Exception("There is a probleme with Ranks or Scores, please contact an administrator.");
            }
        } else {
            header('Location: ?A=project_design&A2=scoring');
        }
    } else {
        $devises = getListDevises();
        $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
        $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
        echo $twig->render('/input/project_design_steps/scoring.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu','username'=>$user[1]));
        prereq_ProjectDesign();
    }
}

function calcRanks($rates,$orderUC,$orderCrit){
    $rates_by_crit = [];
    foreach ($rates as $idUC => $dicCritRates) {
        foreach ($dicCritRates as $idCrit => $rate) {
            //var_dump(strval($idUC."/".$idCrit."/".$rate));
            if(array_key_exists($idCrit,$rates_by_crit)){
                $rates_by_crit[$idCrit]=[$idUC=>intval($rate)]+$rates_by_crit[$idCrit];
            }
            else {
                $rates_by_crit[$idCrit]=[$idUC=>intval($rate)];
            }
        }
    }
    //var_dump($rates_by_crit);
    //ksort($rates_by_crit);
    //var_dump($rates_by_crit);
    $ranks = [];
    foreach ($rates_by_crit as $idCrit => $dicUCsRates) {
        arsort($dicUCsRates);
        $rank = 1;
        $old_rate = 0;
        $counter = 0;
        foreach ($dicUCsRates as $idUC => $rate) {
            $counter++;
            if($rate != $old_rate){
                $rank = $counter;
            }
            $old_rate = $rate;

            if(array_key_exists($idCrit,$ranks)){
                $ranks[$idCrit]=[$idUC=>intval($rank)]+$ranks[$idCrit];
            }
            else {
                $ranks[$idCrit]=[$idUC=>intval($rank)];
            }
        }

    }
    $ret = [];
    foreach ($ranks as $idCrit => $dicUCsRates) {
        uksort($dicUCsRates, function($key1, $key2) use ($orderUC) {
            return (array_search($key1, $orderUC) > array_search($key2, $orderUC));
        });
        $ret[$idCrit] = $dicUCsRates;
    }
    //$ret = array_reverse($ret,true);
    uksort($ret, function($key1, $key2) use ($orderCrit) {
        return (array_search($key1, $orderCrit) > array_search($key2, $orderCrit));
    });
    //var_dump($ret);
    return $ret;
}

function calcScores($ranks,$repart_selCrit,$n,$orderUC){
    //var_dump($orderUC);
    //var_dump($repart_selCrit);
    $scores = [];
    //var_dump($ranks);
    foreach ($ranks as $idCrit => $dicUCsRates) {
        $idCat = getCatByCrit($idCrit);
        uksort($dicUCsRates, function($key1, $key2) use ($orderUC) {
            return (array_search($key1, $orderUC) > array_search($key2, $orderUC));
        });
        foreach ($dicUCsRates as $idUC => $rank) {
            if(array_key_exists($idCat,$scores)){
                if (array_key_exists($idUC,$scores[$idCat])){
                    //var_dump($scores[$idCat],$idUC);
                    $scores[$idCat][$idUC] += intval($rank);
                } else {
                    $scores[$idCat] += [$idUC=>intval($rank)];
                }
            } else {
                //var_dump($scores);
                $scores[$idCat]=[$idUC=>intval($rank)];
            }
        }
    }
    //var_dump($orderUC);
    foreach ($repart_selCrit as $idCat => $nbCrit) {
        //var_dump($dicUCsRates);
        foreach ($orderUC as $idUC) {
            $sum = isset($scores[$idCat][$idUC]) ? $scores[$idCat][$idUC] : 0;
            //var_dump($sum);
            $scores[$idCat][$idUC] = number_format(10*(1 - ($sum-$nbCrit)/($n-1)/$nbCrit),2);
        }
    }
    //var_dump($scores);
    return $scores;
}

// ---------------------------------------- GLOBAL SCORE ----------------------------------------

function global_score($twig,$is_connected,$ucmID=0,$post=[]){
    $user = getUser($_SESSION['username']);
    if($ucmID!=0){
        if(getUCMByID($ucmID,$user[0])){
            //var_dump($post);
            
            $ucm = getUCMByID($ucmID,$user[0]);
            $list_critCat = getListCritCat();
            $list_crit = getListCrit();
            $repart_crit = calcRepartCrit($list_critCat,$list_crit);
            $list_selCritCat = getListSelCritCat($ucmID);
            $list_selCrit = getListSelCrit($ucmID);
            $orderCrit = [];
            foreach ($list_selCrit as $crit) {
                array_push($orderCrit,intval($crit['id']));
            }
            $repart_selCrit = calcRepartCrit($list_selCritCat,$list_selCrit);
            if(!empty($post)){
                update_ModifDate_ucm($ucmID);
                $weights_table = [];
                foreach ($post as $idCritCat => $weight) {
                    $weights_table[$idCritCat]=intval($weight);
                }
            } else {
                $weights_table = getListWeights($ucmID);
                //var_dump(array_filter($weights_table,function($k){return $k!=0;},ARRAY_FILTER_USE_BOTH));
                if(empty(array_filter($weights_table,function($k){return $k!=0;},ARRAY_FILTER_USE_BOTH))){
                    $weights_table = calcDefaultWeights($list_selCritCat);
                }
            }
            insertCritCatWeights($ucmID,$weights_table);
            //var_dump($weights_table);

            $list_selUC = getListSelUC($ucmID);
            $orderUC = [];
            foreach ($list_selUC as $uc) {
                array_push($orderUC,intval($uc[0]));
            }

            $rates = getListInputedRates($ucmID);
            $ranks = calcRanks($rates,$orderUC,$orderCrit);
            $scores = calcScores($ranks,$repart_selCrit,count($list_selUC),$orderUC);

            $globalScores = calcGlobalScores($scores,$weights_table,$list_selUC);
            $devises = getListDevises();
            $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
            $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
            echo $twig->render('/input/project_design_steps/global_score.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu',"selected"=>$ucm[1],'username'=>$user[1],'sel_critCat'=>$list_selCritCat,'repart_selCrit'=>$repart_selCrit,'repart_crit'=>$repart_crit,'globalScores'=>$globalScores,'sel_ucs'=>$list_selUC,'weights_table'=>$weights_table));
            prereq_ProjectDesign();
        } else {
            header('Location: ?A=project_design&A2=global_score');
        }
    } else {
        $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/input/project_design_steps/global_score.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu','username'=>$user[1]));
        prereq_ProjectDesign();
    }
}

function calcDefaultWeights($sel_critCat){
    $res = [];
    $n = count($sel_critCat);
    //var_dump($sel_critCat);
    $ref = intval(100/$n);
    $lastID = intval(end($sel_critCat)['id']);
    //var_dump($lastID);
    foreach ($sel_critCat as $it => $critCat) {
        $res[$critCat['id']]=$ref;
    }
    $lastValue = 100-(array_sum($res)-$res[$lastID]);
    $res[$lastID] = $lastValue;
    //var_dump($res);
    return $res;
}

function calcGlobalScores($scores,$weights_table){
    $globalScores = [];
    foreach ($scores as $idCritCat => $dic_UC_Score) {
        foreach ($dic_UC_Score as $idUC => $score){
            $globalScore = number_format($weights_table[$idCritCat]*$score/100,2);
            if (array_key_exists($idUC,$globalScores)){
                $globalScores[$idUC] += $globalScore;
            } else {
                $globalScores[$idUC] = $globalScore;
            }
        }
    }
    //var_dump($globalScores);
    return $globalScores;
}


// ---------------------------------------- CHECK PRE-REQ ----------------------------------------
function prereq_ProjectDesign(){
    if(isset($_SESSION['ucmID'])){
            echo "<script>prereq_ProjectDesign1(true);</script>";
        $ucmID = $_SESSION['ucmID'];
        $list_selMeas = getListSelMeas($ucmID);
        $list_selUC = getListSelUC($ucmID);
        $list_selCrit = getListSelCrit($ucmID);
        $list_selCritCat = getListSelCritCat($ucmID);
        $repart_selCrit = calcRepartCrit($list_selCritCat,$list_selCrit);
        $list_selDLT = getListSelDLTs($ucmID);
        $orderUC = [];
        foreach ($list_selUC as $uc) {
            array_push($orderUC,intval($uc[0]));
        }
        $orderCrit = [];
        foreach ($list_selCrit as $crit) {
            array_push($orderCrit,intval($crit['id']));
        }
        $rates = getListInputedRates($ucmID);
        if(!empty($list_selMeas) && !empty($list_selCrit) && !empty($list_selCritCat) && !empty($list_selDLT)){
                echo "<script>prereq_ProjectDesign2(true);</script>";
            if (!empty($list_selUC)) {
                    echo "<script>prereq_ProjectDesign3(true);</script>";
                if(!empty($rates)){
                        echo "<script>prereq_ProjectDesign4(true);</script>";
                    try{
                        $ranks = calcRanks($rates,$orderUC,$orderCrit);
                        $scores = calcScores($ranks,$repart_selCrit,count($list_selUC),$orderUC);
                        if(!empty($scores)){
                                echo "<script>prereq_ProjectDesign5(true);</script>";
                        }
                    }
                    finally{
                        //do nothing
                    }
                }
            }
        }
    }
}