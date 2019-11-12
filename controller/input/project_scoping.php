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
            $listSelScope = getListSelScope($projID);
            //var_dump($listSelScope);
            echo $twig->render('/input/project_scoping_steps/scope.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'projID'=>$projID,'part'=>'Project',"selected"=>$proj[1],'username'=>$user[1],'measures'=>$list_measures,'ucs'=>$list_ucs,'list_sel'=>$listSelScope)); 
            prereq_ProjectScoping();
        } else {
            header('Location: ?A=project_scoping&A2=scope');
        }
    } else {
        echo $twig->render('/input/project_scoping_steps/scope.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'projID'=>$projID,'part'=>'Project','username'=>$user[1]));
        prereq_ProjectScoping();
    }
}

function scope_selected($post){
    if($post){
        if(isset($_SESSION['projID'])){
            $projID = $_SESSION['projID'];
            $list_scope = [];
            foreach ($post as $key => $value) {
                //var_dump($post);
                if(isset($key)){
                    //var_dump($list_scope);
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
            //var_dump($list_scope);
            $listSelScope = getListSelScope($projID);
            //var_dump(empty($listSelScope));
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


// ---------------------------------------- PERIMETER ----------------------------------------

function perimeter($twig,$is_connected,$projID=0){
    $user = getUser($_SESSION['username']);
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            $proj = getProjByID($projID,$user[0]);
            $list_zones = getListZones();
            $repart_zones = sort_zones($list_zones);
            //var_dump($list_zones);
            //var_dump($repart_zones);
            $listSelZones = getListSelZones($projID);
            //var_dump($listSelZones);
            echo $twig->render('/input/project_scoping_steps/perimeter.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],"zones"=>$repart_zones,'list_sel'=>$listSelZones)); 
            prereq_ProjectScoping();
        } else {
            header('Location: ?A=project_scoping&A2=perimeter');
        }
    } else {
        echo $twig->render('/input/project_scoping_steps/perimeter.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'projID'=>$projID,'part'=>'Project','username'=>$user[1]));
        prereq_ProjectScoping();
    }
}

function sort_zones($list){
    $res = [[0=>[]]];
    $copy = [];
    foreach ($list as $id => $data) {
        $copy[$id] = $data;
    }
    while(!empty($list)){
        //var_dump($list);
        $temp = [];
        foreach ($list as $id => $data) {
            if(array_key_exists($data['parent'],end($res))){
                $id_parent = $data['parent'];
                if(isset(end($res)[$data['parent']]['name'])){
                    $name_parent = end($res)[$data['parent']]['name'];
                    $data['parent'] = [$id_parent,$name_parent];
                    $data = ['id'=>$id]+$data;
                } else {
                    $name_parent = "";
                    $data['parent'] = [$id_parent,$name_parent];
                }
                $data = ['id'=>$id]+$data+['hasChildren'=>hasChildren($id,$copy)];
                $temp[$id] = $data;
                unset($list[$id]);
            }
        }
        if(!empty($temp)){
            array_push($res,$temp);
        }
    }
    unset($res[0]);
    return $res;
}

function hasChildren($id,$list){
    foreach ($list as $key => $value) {
        if($value['parent']==$id){
            return true;
        }
    }
    return false;
}

function perimeter_selected($post){
    if($post){
        if(isset($_SESSION['projID'])){
            $projID = $_SESSION['projID'];
            $list_zones = [];
            foreach ($post as $key => $value) {
                if(isset($key)){
                    $temp = explode("_",$key);
                    if(count($temp)==1){
                        array_push($list_zones,intval($temp[0]));
                    }
                }
            }
            //var_dump($list_zones);
            $listSelZones = getListSelZones($projID);
            //var_dump(empty($listSelZones));
            if(empty($listSelZones)){
                insertSelZones($projID,$list_zones);
            } else {
                deleteSelZones($projID);
                insertSelZones($projID,$list_zones);
            }
            //var_dump($listSelZones);
            update_ModifDate_proj($projID);            
            header('Location: ?A=project_scoping&A2=size&projID='.$projID);

        } else {
            throw new Exception("No Project selected !");
        }
    } else {
        throw new Exception("No Zone selected !");
    }
}


// ---------------------------------------- SIZE ----------------------------------------

function size($twig,$is_connected,$projID=0){
    $user = getUser($_SESSION['username']);
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            $proj = getProjByID($projID,$user[0]);
            $selPerimeter = getListSelZones($projID);
            $repart_perimeter = sort_zones($selPerimeter);
            $list_ucs = getListUCs();
            $measures = getListMeasures();
            $selScope = getListSelScope($projID);
            $listMag = getListMag();
            $listSelSizes = getListSelSizes($projID);
            //var_dump($listSelSizes);
            //var_dump($selScope);
            //var_dump($listMag);
            echo $twig->render('/input/project_scoping_steps/size.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],"perimeter"=>$repart_perimeter,'scope'=>$selScope,'ucs'=>$list_ucs,'mags'=>$listMag,'list_sel'=>$listSelSizes,'measures'=>$measures)); 
            prereq_ProjectScoping();
        } else {
            header('Location: ?A=project_scoping&A2=size');
        }
    } else {
        echo $twig->render('/input/project_scoping_steps/size.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'projID'=>$projID,'part'=>'Project','username'=>$user[1]));
        prereq_ProjectScoping();
    }
}

function size_selected($post){
    if($post){
        if(isset($_SESSION['projID'])){
            $projID = $_SESSION['projID'];
            $list_sizes = [];
            //var_dump($post);
            foreach ($post as $key => $value) {
                if(isset($key)){
                    $temp = explode("_",$key);
                    $id_uc = intval($temp[1]);
                    $id_zone = intval($temp[2]);
                    $id_mag = intval($value);
                    if(array_key_exists($id_zone,$list_sizes)){
                        $list_sizes[$id_zone] += [$id_uc => $id_mag];
                    } else{
                        $list_sizes[$id_zone] = [$id_uc => $id_mag];
                    }
                }
            }
            //var_dump($list_sizes);
            $listSelSizes = getListSelSizes($projID);
            //var_dump(empty($listSelSizes));
            if(empty($listSelSizes)){
                insertSelSizes($projID,$list_sizes);
            } else {
                deleteSelSizes($projID);
                insertSelSizes($projID,$list_sizes);
            }
            //var_dump($listSelSizes);
            update_ModifDate_proj($projID);            
            header('Location: ?A=project_scoping&A2=volumes&projID='.$projID);

        } else {
            throw new Exception("No Project selected !");
        }
    } else {
        throw new Exception("No Size selected !");
    }
}

// ---------------------------------------- VOLUMES ----------------------------------------

function volumes($twig,$is_connected,$projID=0){
    $user = getUser($_SESSION['username']);
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            $proj = getProjByID($projID,$user[0]);
            $selPerimeter = getListSelZones($projID);
            $repart_perimeter = sort_zones($selPerimeter);
            $list_ucs = getListUCs();
            $selScope = getListSelScope($projID);
            $list_measures = getListMeasures();
            //var_dump($list_measures);
            $listMag = getListMag();
            $selSizes = getListSelSizes($projID);
            $components = getComponents();
            $nbCompoPerZone = getNbCompoPerZone();
            $ratio=getRatio();
            //var_dump($nbUCs);
            $listSelVolumes = getListSelVolumes($projID);
            echo $twig->render('/input/project_scoping_steps/volumes.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'sizes'=>$selSizes,'scope'=>$selScope,'perimeter'=>$repart_perimeter,'ucs'=>$list_ucs,'measures'=>$list_measures,'mags'=>$listMag,"components"=>$components,'compo_per_zone'=>$nbCompoPerZone,'ratio'=>$ratio,'list_sel'=>$listSelVolumes)); 
            prereq_ProjectScoping();
        } else {
            header('Location: ?A=project_scoping&A2=volumes');
        }
    } else {
        echo $twig->render('/input/project_scoping_steps/volumes.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'projID'=>$projID,'part'=>'Project','username'=>$user[1]));
        prereq_ProjectScoping();
    }
}


function volumes_selected($post=[]){
    if($post){
        if(isset($_SESSION['projID'])){
            $projID = $_SESSION['projID'];
            $list_volumes = getVolumesFromPost($post);
            //var_dump($post);
            var_dump($list_volumes);
            $listSelVolumes = getListSelVolumes($projID);
            //var_dump(empty($listSelVolumes));
            if(empty($listSelVolumes)){
                insertSelVolumes($projID,$list_volumes);
            } else {
                deleteSelVolumes($projID);
                insertSelVolumes($projID,$list_volumes);
            }
            //var_dump($listSelVolumes);
            update_ModifDate_proj($projID);            
            header('Location: ?A=project_scoping&A2=schedule&projID='.$projID);

        } else {
            throw new Exception("No Project selected !");
        }
    } else {
        throw new Exception("No Volume selected !");
    }
}

function getVolumesFromPost($post){
    $list_volumes = [];
    foreach ($post as $key => $value) {
        if(isset($key)){
            $temp = explode('_',$key);
            $type = $temp[1];
            //$id_comp = intval($temp[2]);
            $id_uc = intval($temp[3]);
            $id_zone = intval($temp[4]);
            //var_dump($temp);
            if(array_key_exists($id_zone,$list_volumes)){
                if(array_key_exists($id_uc,$list_volumes[$id_zone])){
                    if($type=='nb'){
                        $list_volumes[$id_zone][$id_uc] += ['nb_compo'=>intval($value)];
                    } else if ($type=='nbuc') {                            
                        $list_volumes[$id_zone][$id_uc] += ['nb_per_uc'=>intval($value)];
                    } else {
                        throw new Exception("There is an error with inputs names");
                    }
                } else {
                    if($type=='nb'){
                        $list_volumes[$id_zone] += [$id_uc=>['nb_compo'=>intval($value)]];
                    } else if ($type=='nbuc') {                            
                        $list_volumes[$id_zone] += [$id_uc=>['nb_per_uc'=>intval($value)]];
                    } else {
                        throw new Exception("There is an error with inputs names");
                    }
                }
            } else {
                if($type=='nb'){
                    $list_volumes[$id_zone] = [$id_uc=>['nb_compo'=>intval($value)]];
                } else if ($type=='nbuc') {                            
                    $list_volumes[$id_zone] = [$id_uc=>['nb_per_uc'=>intval($value)]];
                } else {
                    throw new Exception("There is an error with inputs names");
                }
            }
        }
    }
    return $list_volumes;
}

// ---------------------------------------- SCHEDULE ----------------------------------------

function schedule($twig,$is_connected,$projID=0){
    $user = getUser($_SESSION['username']);
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            $proj = getProjByID($projID,$user[0]);
            
            $list_ucs = getListUCs();
            $list_measures = getListMeasures();
            $selScope = getListSelScope($projID);

            echo $twig->render('/input/project_scoping_steps/schedule.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'scope'=>$selScope,'ucs'=>$list_ucs,'meas'=>$list_measures)); 
            prereq_ProjectScoping();
        } else {
            header('Location: ?A=project_scoping&A2=schedule');
        }
    } else {
        echo $twig->render('/input/project_scoping_steps/schedule.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'projID'=>$projID,'part'=>'Project','username'=>$user[1]));
        prereq_ProjectScoping();
    }
}

function schedules_selected($post){
    if($post){
        if(isset($_SESSION['projID'])){
            $projID = $_SESSION['projID'];
            $list_dates = getDatesFromPost($post);
            //var_dump($post);
            //var_dump($list_dates);
            $listSelDates = getListSelDates($projID);
            if(empty($listSelDates)){
                insertSelDates($projID,$list_dates);
            } else {
                deleteSelDates($projID);
                insertSelDates($projID,$list_dates);
            }
            //var_dump($listSelDates);
            update_ModifDate_proj($projID);            
            header('Location: ?A=project_scoping&A2=discount_rate&projID='.$projID);
        } else {
            throw new Exception("No Project selected !");
        }
    } else {
        throw new Exception("No Date selected !");
    }
}

function getDatesFromPost($post){
    $list_dates = [];
    foreach ($post as $key => $value) {
        if(isset($key) and $value){
            $temp = explode('_',$key);
            //var_dump($temp);
            //var_dump($value);
            $part = $temp[1];
            $date_label = $temp[2];
            $id_uc = intval($temp[3]);
            $date_input = explode('/',$value);
            $date = date_create($date_input[1]."-".$date_input[0]."-01")->format('Y-m-d H:i:s');
            //var_dump($date->format('m/Y'));
            if(array_key_exists($part,$list_dates)){
                if(array_key_exists($id_uc,$list_dates[$part])){
                    $list_dates[$part][$id_uc] += [$date_label=>$date];
                } else {
                    $list_dates[$part][$id_uc] = [$date_label=>$date];
                }
            } else {
                $list_dates[$part] = [$id_uc => [$date_label=>$date]];
            }
        }
        //var_dump($list_dates['implem'][7]);
    }
    return $list_dates;
}

// ---------------------------------------- DISCOUNT RATE ----------------------------------------

function discount_rate($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/project_scoping_steps/discount_rate.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2])); 
}


// ---------------------------------------- CHECK PRE-REQ ----------------------------------------
function prereq_ProjectScoping(){
    if(isset($_SESSION['projID'])){
        echo "<script>prereq_ProjectScoping1(true);</script>";
        $projID = $_SESSION['projID'];
        $selScope = getListSelScope($projID);
        $selPerimeter = getListSelZones($projID);
        $selSizes = getListSelSizes($projID);

        if(!empty($selScope)){
            echo "<script>prereq_ProjectScoping2(true);</script>";
            if (!empty($selPerimeter)) {
                echo "<script>prereq_ProjectScoping3(true);</script>";
                if(!empty($selSizes)){
                    echo "<script>prereq_ProjectScoping4(true);</script>";
                }
            }
        }
    }

}