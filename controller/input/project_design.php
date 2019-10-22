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
        } else {
            header('Location: ?A=project_design&A2=measures');
        }
    } else {
        echo $twig->render('/input/project_design_steps/measures.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu','username'=>$user[1]));
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
        } else {
            header('Location: ?A=project_design&A2=criteria');
        }
    } else {
        echo $twig->render('/input/project_design_steps/criteria.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu','username'=>$user[1]));
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
        } else {
            //header('Location: ?A=project_design&A2=geography');
        }
    } else {
        echo $twig->render('/input/project_design_steps/geography.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu','username'=>$user[1]));
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
            $list_selDLT = getListSelDLTs($ucmID);
            $repart_crit = calcRepartCrit($list_selCritCat,$list_selCrit);
            $pertCrit = getPertCrit($list_ucs,$list_selCrit);
            $pertDLT = getPertDLT($list_ucs,$list_selDLT);
            $list_sel = [];
            foreach (getListSelUC($ucm[0]) as $value) {
                array_push($list_sel,$value[0]);
            }
            //var_dump($pertCrit);
            echo $twig->render('/input/project_design_steps/use_case.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu',"selected"=>$ucm[1],'username'=>$user[1],'ucs'=>$list_ucs,'sel_critCat'=>$list_selCritCat,'sel_crit'=>$list_selCrit,'sel_DLTs'=>$list_selDLT,'repart_crit'=>$repart_crit,'pertCrit'=>$pertCrit,'pertDLT'=>$pertDLT,'list_sel'=>$list_sel));
        } else {
            header('Location: ?A=project_design&A2=use_case');
        }
    } else {
        echo $twig->render('/input/project_design_steps/use_case.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu','username'=>$user[1]));
    }
}

function uc_selected($list_idDLT=[]){
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
            header('Location: ?A=project_design&A2=confirm_uc_select&ucmID='.$ucmID);
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
            echo $twig->render('/input/project_design_steps/confirm_uc_select.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu',"selected"=>$ucm[1],'username'=>$user[1],'list_selUC'=>$list_selUC));
        } else {
            header('Location: ?A=project_design&A2=use_case&A3=confirm');
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
            echo $twig->render('/input/project_design_steps/rating.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu',"selected"=>$ucm[1],'username'=>$user[1]));
        } else {
            header('Location: ?A=project_design&A2=rating');
        }
    } else {
        echo $twig->render('/input/project_design_steps/rating.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu','username'=>$user[1]));
    }
}



// ---------------------------------------- SCORING ----------------------------------------

function scoring($twig,$is_connected,$ucmID=0){
    $user = getUser($_SESSION['username']);
    if($ucmID!=0){
        if(getUCMByID($ucmID,$user[0])){
            $ucm = getUCMByID($ucmID,$user[0]);
            echo $twig->render('/input/project_design_steps/scoring.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu',"selected"=>$ucm[1],'username'=>$user[1]));
        } else {
            header('Location: ?A=project_design&A2=scoring');
        }
    } else {
        echo $twig->render('/input/project_design_steps/scoring.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu','username'=>$user[1]));
    }
}



// ---------------------------------------- GLOBAL SCORE ----------------------------------------

function global_score($twig,$is_connected,$ucmID=0){
    $user = getUser($_SESSION['username']);
    if($ucmID!=0){
        if(getUCMByID($ucmID,$user[0])){
            $ucm = getUCMByID($ucmID,$user[0]);
            echo $twig->render('/input/project_design_steps/global_score.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu',"selected"=>$ucm[1],'username'=>$user[1]));
        } else {
            header('Location: ?A=project_design&A2=global_score');
        }
    } else {
        echo $twig->render('/input/project_design_steps/global_score.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3],'ucmID'=>$ucmID,'part'=>'Use Cases Menu','username'=>$user[1]));
    }
}
