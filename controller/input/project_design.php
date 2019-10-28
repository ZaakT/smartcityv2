<?php

require_once('model/model.php');



// ---------------------------------------- PROJECT DESIGN ----------------------------------------

function project_design($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/project_design.twig',array('is_connected'=>$is_connected,'username'=>$user[1],'is_admin'=>$user[3])); 
}



// ---------------------------------------- USE CASES MENU ----------------------------------------

function ucm($twig,$is_connected,$isTaken=false){
    $user = getUser($_SESSION['username']);
    $list_ucms = getListUCMS($user[0]);
    //var_dump($list_ucms);
    echo $twig->render('/input/project_design_steps/ucm.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'ucms'=>$list_ucms,'isTaken'=>$isTaken,'part'=>'Use Cases Menu','username'=>$user[1])); 
}

function create_ucm($twig,$is_connected,$post){
    $name = $post['name'];
    $description = isset($post['description']) ? $post['description'] : "";
    $user = getUser($_SESSION['username']);
    $idUser = $user[0];
    $ucmInfos = [$name,$description,$idUser];
    if(!empty(getUCM($idUser,$name))){
        ucm($twig,$is_connected,true);
    } else {
        insertUCM($ucmInfos);
        header('Location: ?A=project_design&A2=ucm');
    }
}

function delete_ucm($twig,$is_connected,$idUCM){
    // var_dump($idUCM);
    deleteUCM($idUCM);
    header('Location: ?A=project_design&A2=ucm');
}



// ---------------------------------------- MEASURES ----------------------------------------

function measures($twig,$is_connected,$ucmID=0){
    $user = getUser($_SESSION['username']);
    if($ucmID!=0){
        if(getUCMByID($ucmID,$user[0])){
            $ucm = getUCMByID($ucmID,$user[0]);
            $list_measures = getListMeasures();
            $list_sel = [];
            foreach (getListSelMeas($ucm[0]) as $value) {
                array_push($list_sel,$value[0]);
            }
            //var_dump($list_sel);
            echo $twig->render('/input/project_design_steps/measures.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu',"selected"=>$ucm[1],'username'=>$user[1],'measures'=>$list_measures,'list_sel'=>$list_sel));
            prereq_ProjectDesign();
        } else {
            header('Location: ?A=project_design&A2=measures');
        }
    } else {
        echo $twig->render('/input/project_design_steps/measures.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu','username'=>$user[1]));
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
            $list_criteria = getListCriteria();
            $list_critCategories = getListCritCat() ;
            $list_sel = [];
            foreach (getListSelCrit($ucm[0]) as $value) {
                array_push($list_sel,$value[0]);
            }
            //var_dump($list_sel);
            //var_dump($list_criteria);
            echo $twig->render('/input/project_design_steps/criteria.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu',"selected"=>$ucm[1],'username'=>$user[1],'criteria'=>$list_criteria,'list_sel'=>$list_sel,'categories'=>$list_critCategories));
            prereq_ProjectDesign();
        } else {
            header('Location: ?A=project_design&A2=criteria');
        }
    } else {
        echo $twig->render('/input/project_design_steps/criteria.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu','username'=>$user[1]));
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
                if(!in_array($selCrit[3],$listSelCritCatID)){
                    array_push($listSelCritCatID,intval($selCrit[3]));
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
            echo $twig->render('/input/project_design_steps/geography.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu',"selected"=>$ucm[1],'username'=>$user[1],'DLTs'=>$list_DLTs,'list_sel'=>$list_sel));
            prereq_ProjectDesign();
        } else {
            //header('Location: ?A=project_design&A2=geography');
        }
    } else {
        echo $twig->render('/input/project_design_steps/geography.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu','username'=>$user[1]));
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
            $list_ucs = getUC($list_measID);
            $list_selCritCat = getListSelCritCat($ucmID);
            $list_selCrit = getListSelCrit($ucmID);
            $repart_crit = calcRepartCrit($list_selCritCat,$list_selCrit);
            $list_selDLT = getListSelDLTs($ucmID);
            $guidCrit = getGuidCrit($list_ucs,$list_selCrit);
            //var_dump($guidCrit);
            $pertDLT = getPertDLT($list_ucs,$list_selDLT);
            $list_sel = [];
            foreach (getListSelUC($ucm[0]) as $value) {
                array_push($list_sel,$value[0]);
            }
            //var_dump($list_sel);
            echo $twig->render('/input/project_design_steps/use_case.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu',"selected"=>$ucm[1],'username'=>$user[1],'ucs'=>$list_ucs,'sel_critCat'=>$list_selCritCat,'sel_crit'=>$list_selCrit,'sel_DLTs'=>$list_selDLT,'repart_crit'=>$repart_crit,'guidCrit'=>$guidCrit,'pertDLT'=>$pertDLT,'list_sel'=>$list_sel));
            prereq_ProjectDesign();
        } else {
            //header('Location: ?A=project_design&A2=use_case');
        }
    } else {
        echo $twig->render('/input/project_design_steps/use_case.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu','username'=>$user[1]));
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
            echo $twig->render('/input/project_design_steps/confirm_uc_select.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu',"selected"=>$ucm[1],'username'=>$user[1],'list_selUC'=>$list_selUC));
            prereq_ProjectDesign();
        } else {
            header('Location: ?A=project_design&A2=use_case');
        }
    } else {
        echo $twig->render('/input/project_design_steps/confirm_uc_select.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu','username'=>$user[1]));
    }
}

function calcRepartCrit($list_cat,$list_crit){
    $res = [];
    foreach ($list_cat as $cat) {
        $count = 0;
        foreach ($list_crit as $crit) {
            if($cat[0]==$crit[3]){
                $count++;
            }
        }
        $res[$cat[0]] = $count;
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
            $list_selUC = getListSelUC($ucmID);
            $list_selMeas = getListSelMeas($ucmID);
            $repart_ucs = calcRepartUC($list_selMeas,$list_selUC);
            $list_selCritCat = getListSelCritCat($ucmID);
            $list_selCrit = getListSelCrit($ucmID);
            $repart_crit = calcRepartCrit($list_selCritCat,$list_selCrit);
            $guidCrit = getGuidCrit($list_selUC,$list_selCrit);
            $listInputedRates = getListInputedRates($ucmID);
            //var_dump($guidCrit);
            echo $twig->render('/input/project_design_steps/rating.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu',"selected"=>$ucm[1],'username'=>$user[1],'sel_ucs'=>$list_selUC,'sel_meas'=>$list_selMeas,'repart_ucs'=>$repart_ucs,'repart_crit'=>$repart_crit,'sel_critCat'=>$list_selCritCat,'sel_crit'=>$list_selCrit,'guidCrit'=>$guidCrit,'rates'=>$listInputedRates));
            prereq_ProjectDesign();
        } else {
            header('Location: ?A=project_design&A2=rating');
        }
    } else {
        echo $twig->render('/input/project_design_steps/rating.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu','username'=>$user[1]));
        prereq_ProjectDesign();
    }
}

function calcRepartUC($list_meas,$list_ucs){
    $res = [];
    foreach ($list_meas as $meas) {
        $count = 0;
        foreach ($list_ucs as $uc) {
            if($meas[1]==$uc[3]){
                $count++;
            }
        }
        $res[$meas[0]] = $count;
    }
    //var_dump($res);
    return $res;
}

function rates_inputed($post){
    if($post){
        if(isset($_SESSION['ucmID'])){
            $ucmID = $_SESSION['ucmID'];
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
            //var_dump($list_rates);
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
            $list_selMeas = getListSelMeas($ucmID);
            $list_selCritCat = getListSelCritCat($ucmID);
            $list_selCrit = getListSelCrit($ucmID);
            $repart_crit = calcRepartCrit($list_selCritCat,$list_selCrit);
            $rank = [1];
            $scores = [1];
            if($rank && $scores){
                echo $twig->render('/input/project_design_steps/scoring.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu',"selected"=>$ucm[1],'username'=>$user[1],'ranks'=>$rank,'scores'=>$scores,'sel_ucs'=>$list_selUC,'repart_crit'=>$repart_crit,'sel_critCat'=>$list_selCritCat,'sel_crit'=>$list_selCrit));
                prereq_ProjectDesign();
            } else {
                throw new Exception("There is a probleme with Ranks or Scores, please contact an administrator.");
            }
        } else {
            header('Location: ?A=project_design&A2=scoring');
        }
    } else {
        echo $twig->render('/input/project_design_steps/scoring.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu','username'=>$user[1]));
        prereq_ProjectDesign();
    }
}



// ---------------------------------------- GLOBAL SCORE ----------------------------------------

function global_score($twig,$is_connected,$ucmID=0){
    $user = getUser($_SESSION['username']);
    if($ucmID!=0){
        if(getUCMByID($ucmID,$user[0])){
            $ucm = getUCMByID($ucmID,$user[0]);
            echo $twig->render('/input/project_design_steps/global_score.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu',"selected"=>$ucm[1],'username'=>$user[1]));
            prereq_ProjectDesign();
        } else {
            header('Location: ?A=project_design&A2=global_score');
        }
    } else {
        echo $twig->render('/input/project_design_steps/global_score.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu','username'=>$user[1]));
        prereq_ProjectDesign();
    }
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
        $list_selDLT = getListSelDLTs($ucmID);
        //$list_rate = getRates($ucmID);
        if(!empty($list_selMeas) && !empty($list_selCrit) && !empty($list_selCritCat) && !empty($list_selDLT)){
            echo "<script>prereq_ProjectDesign2(true);</script>";
            if (!empty($list_selUC)) {
                echo "<script>prereq_ProjectDesign3(true);</script>";
            }
        }
    }

}