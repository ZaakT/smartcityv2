<?php

require_once('model/model.php');

// -- Cost Benefits
function cost_benefits($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/cost_benefits_in.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}


// --- Cost Benefits Steps

// ---------------------------------------- PROJECT ----------------------------------------

function project_cb($twig,$is_connected,$projID=0){
    $user = getUser($_SESSION['username']);
    $list_projects = getListProjects($user[0]);
    //var_dump($list_projects);
    echo $twig->render('/input/cost_benefits_steps/project.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projects'=>$list_projects)); 
}


// ---------------------------------------- USE CASE ----------------------------------------

function use_case_cb($twig,$is_connected,$projID=0){
    $user = getUser($_SESSION['username']);
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            $proj = getProjByID($projID,$user[0]);
            $list_measures = getListMeasures();
            $list_ucs = getListUCs();
            $selScope = getListSelScope($projID);
            //var_dump($list_ucs);
            echo $twig->render('/input/cost_benefits_steps/use_case.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'selScope'=>$selScope,'ucs'=>$list_ucs,'measures'=>$list_measures));
        } else {
            header('Location: ?A=cost_benefits&A2=use_case_cb');
        }
    } else {
        echo $twig->render('/input/cost_benefits_steps/use_case.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'username'=>$user[1]));
    }
}


// ---------------------------------------- CAPEX ----------------------------------------

function capex($twig,$is_connected,$projID=0,$ucID=0,$isTaken=false){
    $user = getUser($_SESSION['username']);
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            if($ucID!=0){
                if(getUCByID($ucID)){
                    $proj = getProjByID($projID,$user[0]);
                    $uc = getUCByID($ucID);
                    $list_capex_advice = getListCapexAdvice($ucID);   
                    $list_capex_user = getListCapexUser($projID,$ucID);                    
                    echo $twig->render('/input/cost_benefits_steps/capex.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project","selected"=>$proj[1],'part2'=>"Use Case",'selected2'=>$uc[1],'projID'=>$projID,'ucID'=>$ucID,"capex_advice"=>$list_capex_advice,"capex_user"=>$list_capex_user,'isTaken'=>$isTaken));
                } else {
                    throw new Exception("This Use Case doesn't exist !");
                }
            } else {
                header('Location: ?A=cost_benefits&A2=use_case_cb');
            }
        } else {
            throw new Exception("This Project doesn't exist !");
        }
    } else {
        header('Location: ?A=cost_benefits&A2=use_case_cb');
    }
}

function create_capex($twig,$is_connected,$post){
    if(isset($_SESSION['projID'])){
        $projID = $_SESSION['projID'];
        if(isset($_SESSION['ucID'])){
            $ucID = $_SESSION['ucID'];
            $name = $post['name'];
            $description = isset($post['description']) ? $post['description'] : "";
            $capex_infos = ["name"=>$name,"description"=>$description];
            //var_dump(getCapexUserItem($projID,$ucID,$name));
            if(!empty(getCapexUserItem($projID,$ucID,$name))){
                capex($twig,$is_connected,$projID,$ucID,true);
            } else {
                insertCapexUser($projID,$ucID,$capex_infos);
                header('Location: ?A=cost_benefits&A2=capex&projID='.$projID.'&ucID='.$ucID);
            }
        } else {
            throw new Exception("There is no UC selected !");
        }
    } else {
        throw new Exception("There is no Project selected !");
    }
}

function delete_capex_user($idCapex){
    //var_dump(intval($idCapex));
    if(isset($_SESSION['projID'])){
        $projID = $_SESSION['projID'];
        if(isset($_SESSION['ucID'])){
            $ucID = $_SESSION['ucID'];
            deleteCapexUser(intval($idCapex));
            header('Location: ?A=cost_benefits&A2=capex&projID='.$projID.'&ucID='.$ucID);
        } else {
            throw new Exception("There is no UC selected !");
        }
    } else {
        throw new Exception("There is no Project selected !");
    }
}

function capex_selected($twig,$is_connected,$post=[]){
    if($post){
        if(isset($_SESSION['projID'])){
            $projID = $_SESSION['projID'];
            if(isset($_SESSION['ucID'])){
                $ucID = $_SESSION['ucID'];
                $list_selCapex = [];
                foreach ($post as $id => $value) {
                    array_push($list_selCapex,$id);
                }
                //var_dump($list_selCapex);
                if(empty(getListSelCapex($projID,$ucID))){
                    insertSelCapex($projID,$ucID,$list_selCapex);
                } else {
                    deleteSelCapex($projID,$ucID);
                    insertSelCapex($projID,$ucID,$list_selCapex);
                }
                update_ModifDate_proj($projID);
                capex_input($twig,$is_connected,$projID,$ucID);
            } else {
                throw new Exception("There is no UC selected !");
            }
        } else {
            throw new Exception("There is no Project selected !");
        }
    } else {
        throw new Exception("No Capex item selected !");
    }
}

function capex_input($twig,$is_connected,$projID=0,$ucID=0){
    $user = getUser($_SESSION['username']);
    if($projID!=0 and $ucID!=0){
        if(getProjByID($projID,$user[0]) and getUCByID($ucID)){
            $proj = getProjByID($projID,$user[0]);
            $uc = getUCByID($ucID);
            $list_selCapex = getListSelCapex($projID,$ucID);
            //var_dump($list_selCapex);
            $list_capex_advice = getListCapexAdvice($ucID); 
            $list_sel_capex_advice = getListSelByType($list_selCapex,$list_capex_advice);
            //var_dump($list_sel_capex_advice);
            $list_capex_user = getListCapexUser($projID,$ucID);
            $compo = getCompoByUC($ucID);
            $list_ratio = getRatioCompo($list_sel_capex_advice,$compo['id']);
            //var_dump($list_ratio);
            echo $twig->render('/input/cost_benefits_steps/capex_input.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project","selected"=>$proj[1],'part2'=>"Use Case",'selected2'=>$uc[1],'projID'=>$projID,'ucID'=>$ucID,"capex_advice"=>$list_capex_advice,"capex_user"=>$list_capex_user,"selCapex"=>$list_selCapex,'compo'=>$compo,'ratio'=>$list_ratio));
        } else {
            header('Location: ?A=cost_benefits&A2=project');
        }
    } else {
        throw new Exception("There is no project or use case selected !");
    }
}

function getListSelByType($list_sel,$list_all){
    $list = [];
    foreach ($list_all as $id_item => $data) {
        if (array_key_exists($id_item,$list_sel)){
            array_push($list,$id_item);
        }
    }
    return $list;
}

// ---------------------------------------- IMPLEM ----------------------------------------

function implem($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/cost_benefits_steps/implem.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}


// ---------------------------------------- OPEX----------------------------------------

function opex($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/cost_benefits_steps/opex.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}


// ---------------------------------------- REVENUES----------------------------------------

function revenues($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/cost_benefits_steps/revenues.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}


// ---------------------------------------- CASH RELEASING ----------------------------------------

function cashreleasing($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/cost_benefits_steps/cashreleasing.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}


// ---------------------------------------- WIDER CASH ----------------------------------------

function widercash($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/cost_benefits_steps/widercash.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}


// ---------------------------------------- NON CASH ----------------------------------------

function noncash($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/cost_benefits_steps/noncash.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}


// ---------------------------------------- RISKS----------------------------------------

function risks($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/cost_benefits_steps/risks.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}