<?php

require_once('model/model.php');

// -- Project Scoping
function project_scoping($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/project_scoping.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2])); 
}

// --- Project Scoping Steps

// ---------------------------------------- PROJECT ----------------------------------------
function project($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    $list_projects = getListProjects($user[0]);
    //var_dump($list_projects);
    echo $twig->render('/input/project_scoping_steps/project.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projects'=>$list_projects)); 
}

function create_proj($twig,$is_connected,$post){
    $name = $post['name'];
    $description = isset($post['description']) ? $post['description'] : "";
    $user = getUser($_SESSION['username']);
    $idUser = $user[0];
    $projInfos = [$name,$description,$idUser];
    if(!empty(getProj($idUser,$name))){
        project($twig,$is_connected,true);
    } else {
        insertProj($projInfos);
        header('Location: ?A=project_scoping&A2=project');
    }
}

function delete_proj($idProj){
    // var_dump($idProj);
    deleteProj($idProj);
    header('Location: ?A=project_scoping&A2=project');
}

// ---------------------------------------- SCOPE ----------------------------------------

function scope($twig,$is_connected,$projID=0){
    $user = getUser($_SESSION['username']);
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            $proj = getProjByID($projID,$user[0]);
            $list_measures = getListMeasures();
            $list_ucs = getListUCs();
            echo $twig->render('/input/project_scoping_steps/scope.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'projID'=>$projID,'part'=>'Project',"selected"=>$proj[1],'username'=>$user[1],'measures'=>$list_measures,'ucs'=>$list_ucs)); 
            //prereq_ProjectScoping();
        } else {
            header('Location: ?A=project_scoping&A2=scope');
        }
    } else {
        echo $twig->render('/input/project_scoping_steps/scope.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'projID'=>$projID,'part'=>'Project','username'=>$user[1]));
        //prereq_ProjectScoping();
    }
}

function scope_selected($post){
    if($post){
        if(isset($_SESSION['projID'])){
            $projID = $_SESSION['projID'];
            $list_scope = [];
            foreach ($_POST as $key => $value) {
                if(isset($key)){
                    var_dump($list_scope);
                    $temp = explode("_",$key);
                    //var_dump($temp);
                    if($temp[0]=="meas"){
                        $id_meas = intval($temp[1]);
                        $list_scope[$id_meas] = [];
                    }
                    else if($temp[0]=="uc"){
                        $id_meas = intval($temp[1]);
                        $id_uc = intval($temp[2]);
                        array_push($list_scope[$id_meas],$id_uc);
                    }
                }
            }
            var_dump($list_scope);
            $listSelScope = getListSelScope($projID);
            var_dump(empty($listSelScope));
            if(empty($listSelScope)){
                insertSelScope($projID,$list_scope);
            } else {
                deleteSelScope($projID);
                insertSelScope($projID,$list_scope);
            }
            //var_dump($listSelScope);
            update_ModifDate_proj($projID);            
            header('Location: ?A=project_scoping&A2=perimeter&projID='.$projID);

        } else {
            throw new Exception("No Project selected !");
        }
    } else {
        throw new Exception("No Use Case / Measure selected !");
    }
}

function perimeter($twig,$is_connected,$projID=0){
    $user = getUser($_SESSION['username']);
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            $proj = getProjByID($projID,$user[0]);
            $list_zones = getListZones();
            //var_dump($list_zones);
            echo $twig->render('/input/project_scoping_steps/perimeter.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],"zones"=>$list_zones)); 
        } else {
            header('Location: ?A=project_scoping&A2=perimeter');
        }
    } else {
        echo $twig->render('/input/project_scoping_steps/perimeter.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'projID'=>$projID,'part'=>'Project','username'=>$user[1]));
        //prereq_ProjectScoping();
    }
}

function size($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/project_scoping_steps/size.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2])); 
}

function volumes($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/project_scoping_steps/volumes.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2])); 
}

function schedule($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/project_scoping_steps/schedule.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2])); 
}

function discount_rate($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/project_scoping_steps/discount_rate.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2])); 
}


// ---------------------------------------- CHECK PRE-REQ ----------------------------------------
/*function prereq_ProjectScoping(){
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
        $rates = getListInputedRates($ucmID);
        if(!empty($list_selMeas) && !empty($list_selCrit) && !empty($list_selCritCat) && !empty($list_selDLT)){
            echo "<script>prereq_ProjectDesign2(true);</script>";
            if (!empty($list_selUC)) {
                echo "<script>prereq_ProjectDesign3(true);</script>";
                if(!empty($rates)){
                    echo "<script>prereq_ProjectDesign4(true);</script>";
                    try{
                        $ranks = calcRanks($rates,$orderUC);
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

}*/