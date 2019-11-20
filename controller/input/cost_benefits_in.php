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
                    $list_selCapex = getListSelCapex($projID,$ucID);          
                    //var_dump($list_selCapex);
                    echo $twig->render('/input/cost_benefits_steps/capex.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project","selected"=>$proj[1],'part2'=>"Use Case",'selected2'=>$uc[1],'projID'=>$projID,'ucID'=>$ucID,"capex_advice"=>$list_capex_advice,"capex_user"=>$list_capex_user,'isTaken'=>$isTaken,'selCapex'=>$list_selCapex));
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
                $selCapex = [];
                foreach ($post as $id => $value) {
                    array_push($selCapex,$id);
                }
                $selCapex_old = getListSelCapex($projID,$ucID);
                $selCapex_old_id = getKeys($selCapex_old);
                $selCapex_diff_rm = array_diff($selCapex_old_id,$selCapex);
                $selCapex_diff_add = array_diff($selCapex,$selCapex_old_id);
                //var_dump($selCapex_diff_rm);
                //var_dump($selCapex_diff_add);
                if(empty($selCapex_old)){
                    insertSelCapex($projID,$ucID,$selCapex);
                } else if (!empty($selCapex_old)) {
                    deleteSelCapex($projID,$ucID,$selCapex_diff_rm);
                    insertSelCapex($projID,$ucID,$selCapex_diff_add);
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
            $period_inputed = getPeriodInputed($projID,$ucID);
            $list_selCapex = getListSelCapex($projID,$ucID);
            //var_dump($list_selCapex);
            $list_capex_advice = getListCapexAdvice($ucID); 
            $list_sel_capex_advice = getListSelByType($list_selCapex,$list_capex_advice);
            //var_dump($list_sel_capex_advice);
            $list_capex_user = getListCapexUser($projID,$ucID);
            $compo = getCompoByUC($ucID);
            $nb_compo = getNbTotalCompo($compo['id']);
            $nb_uc = getNbTotalUC($projID,$ucID);
            //var_dump($nb_compo,$nb_uc);
            $list_ratio = getRatioCompoCapex($list_sel_capex_advice,$compo['id']);
            //var_dump($list_ratio);
            echo $twig->render('/input/cost_benefits_steps/capex_input.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project","selected"=>$proj[1],'part2'=>"Use Case",'selected2'=>$uc[1],'projID'=>$projID,'ucID'=>$ucID,"capex_advice"=>$list_capex_advice,"capex_user"=>$list_capex_user,"selCapex"=>$list_selCapex,'compo'=>$compo,'ratio'=>$list_ratio,'period_inputed'=>$period_inputed,'nb_compo'=>$nb_compo,'nb_uc'=>$nb_uc));
        } else {
            header('Location: ?A=cost_benefits&A2=project');
        }
    } else {
        throw new Exception("There is no project or use case selected !");
    }
}

function capex_inputed($post){
    if($post){
        if(isset($_SESSION['projID'])){
            $projID = $_SESSION['projID'];
            if(isset($_SESSION['ucID'])){
                $ucID = $_SESSION['ucID'];
                $list = [];
                foreach ($post as $key => $value) {
                    if($key=='capex_period_input'){
                        $period = intval($value);
                    } else {
                        $temp = explode('_',$key);
                        if($temp[0]=="vol"){
                            if(array_key_exists($temp[1],$list)){
                                $list[$temp[1]] += ['volume'=>$value];
                            } else {
                                $list[$temp[1]] = ['volume'=>$value];
                            }
                        } else if($temp[0]=="cost"){
                            if(array_key_exists($temp[1],$list)){
                                $list[$temp[1]] += ['unit_cost'=>$value];
                            } else {
                                $list[$temp[1]] = ['unit_cost'=>$value];
                            }
                        }
                    }
                }
                insertCapexInputed($projID,$ucID,$list);
                insertPeriodInputed($projID,$ucID,$period);
                update_ModifDate_proj($projID);
                header('Location: ?A=cost_benefits&A2=implem&projID='.$projID.'&ucID='.$ucID);
            } else {
                throw new Exception("There is no UC selected !");
            }
        } else {
            throw new Exception("There is no Project selected !");
        }
    } else {
        throw new Exception("There is no data inputed !");
    }
}

function getKeys($list){
    $list_ret = [];
    foreach ($list as $key => $value) {
        array_push($list_ret,$key);
    }
    return $list_ret;
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

function implem($twig,$is_connected,$projID=0,$ucID=0,$isTaken=false){
    $user = getUser($_SESSION['username']);
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            if($ucID!=0){
                if(getUCByID($ucID)){
                    $proj = getProjByID($projID,$user[0]);
                    $uc = getUCByID($ucID);
                    $list_implem_advice = getListImplemAdvice($ucID);   
                    $list_implem_user = getListImplemUser($projID,$ucID);    
                    $list_selImplem = getListSelImplem($projID,$ucID);          
                    //var_dump($list_selImplem);
                    echo $twig->render('/input/cost_benefits_steps/implem.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project","selected"=>$proj[1],'part2'=>"Use Case",'selected2'=>$uc[1],'projID'=>$projID,'ucID'=>$ucID,"implem_advice"=>$list_implem_advice,"implem_user"=>$list_implem_user,'isTaken'=>$isTaken,'selImplem'=>$list_selImplem));
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

function create_implem($twig,$is_connected,$post){
    if(isset($_SESSION['projID'])){
        $projID = $_SESSION['projID'];
        if(isset($_SESSION['ucID'])){
            $ucID = $_SESSION['ucID'];
            $name = $post['name'];
            $description = isset($post['description']) ? $post['description'] : "";
            $implem_infos = ["name"=>$name,"description"=>$description];
            //var_dump(getImplemUserItem($projID,$ucID,$name));
            if(!empty(getImplemUserItem($projID,$ucID,$name))){
                implem($twig,$is_connected,$projID,$ucID,true);
            } else {
                insertImplemUser($projID,$ucID,$implem_infos);
                header('Location: ?A=cost_benefits&A2=implem&projID='.$projID.'&ucID='.$ucID);
            }
        } else {
            throw new Exception("There is no UC selected !");
        }
    } else {
        throw new Exception("There is no Project selected !");
    }
}

function delete_implem_user($idImplem){
    //var_dump(intval($idImplem));
    if(isset($_SESSION['projID'])){
        $projID = $_SESSION['projID'];
        if(isset($_SESSION['ucID'])){
            $ucID = $_SESSION['ucID'];
            deleteImplemUser(intval($idImplem));
            header('Location: ?A=cost_benefits&A2=implem&projID='.$projID.'&ucID='.$ucID);
        } else {
            throw new Exception("There is no UC selected !");
        }
    } else {
        throw new Exception("There is no Project selected !");
    }
}

function implem_selected($twig,$is_connected,$post=[]){
    if($post){
        if(isset($_SESSION['projID'])){
            $projID = $_SESSION['projID'];
            if(isset($_SESSION['ucID'])){
                $ucID = $_SESSION['ucID'];
                $selImplem = [];
                foreach ($post as $id => $value) {
                    array_push($selImplem,$id);
                }
                $selImplem_old = getListSelImplem($projID,$ucID);
                $selImplem_old_id = getKeys($selImplem_old);
                $selImplem_diff_rm = array_diff($selImplem_old_id,$selImplem);
                $selImplem_diff_add = array_diff($selImplem,$selImplem_old_id);
                //var_dump($selImplem_diff_rm);
                //var_dump($selImplem_diff_add);
                if(empty($selImplem_old)){
                    insertSelImplem($projID,$ucID,$selImplem);
                } else if (!empty($selImplem_old)) {
                    deleteSelImplem($projID,$ucID,$selImplem_diff_rm);
                    insertSelImplem($projID,$ucID,$selImplem_diff_add);
                }
                update_ModifDate_proj($projID);
                implem_input($twig,$is_connected,$projID,$ucID);
            } else {
                throw new Exception("There is no UC selected !");
            }
        } else {
            throw new Exception("There is no Project selected !");
        }
    } else {
        throw new Exception("No Implem item selected !");
    }
}

function implem_input($twig,$is_connected,$projID=0,$ucID=0){
    $user = getUser($_SESSION['username']);
    if($projID!=0 and $ucID!=0){
        if(getProjByID($projID,$user[0]) and getUCByID($ucID)){
            $proj = getProjByID($projID,$user[0]);
            $uc = getUCByID($ucID);
            $list_selImplem = getListSelImplem($projID,$ucID);
            //var_dump($list_selImplem);
            $list_implem_advice = getListImplemAdvice($ucID); 
            $list_sel_implem_advice = getListSelByType($list_selImplem,$list_implem_advice);
            //var_dump($list_sel_implem_advice);
            $list_implem_user = getListImplemUser($projID,$ucID);
            $compo = getCompoByUC($ucID);
            $list_ratio = getRatioCompoImplem($list_sel_implem_advice,$compo['id']);
            //var_dump($list_ratio);
            echo $twig->render('/input/cost_benefits_steps/implem_input.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project","selected"=>$proj[1],'part2'=>"Use Case",'selected2'=>$uc[1],'projID'=>$projID,'ucID'=>$ucID,"implem_advice"=>$list_implem_advice,"implem_user"=>$list_implem_user,"selImplem"=>$list_selImplem,'compo'=>$compo,'ratio'=>$list_ratio));
        } else {
            header('Location: ?A=cost_benefits&A2=project');
        }
    } else {
        throw new Exception("There is no project or use case selected !");
    }
}

function implem_inputed($post){
    if($post){
        if(isset($_SESSION['projID'])){
            $projID = $_SESSION['projID'];
            if(isset($_SESSION['ucID'])){
                $ucID = $_SESSION['ucID'];
                $list = [];
                foreach ($post as $key => $value) {
                    $temp = explode('_',$key);
                    if($temp[0]=="vol"){
                        if(array_key_exists($temp[1],$list)){
                            $list[$temp[1]] += ['volume'=>$value];
                        } else {
                            $list[$temp[1]] = ['volume'=>$value];
                        }
                    } else if($temp[0]=="cost"){
                        if(array_key_exists($temp[1],$list)){
                            $list[$temp[1]] += ['unit_cost'=>$value];
                        } else {
                            $list[$temp[1]] = ['unit_cost'=>$value];
                        }
                    }
                }
                insertImplemInputed($projID,$ucID,$list);
                update_ModifDate_proj($projID);
                header('Location: ?A=cost_benefits&A2=opex&projID='.$projID.'&ucID='.$ucID);
            } else {
                throw new Exception("There is no UC selected !");
            }
        } else {
            throw new Exception("There is no Project selected !");
        }
    } else {
        throw new Exception("There is no data inputed !");
    }
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