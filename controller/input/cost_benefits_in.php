<?php

require_once('model/model.php');

// -- Cost Benefits
function cost_benefits($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/input/cost_benefits_in.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3]));
}


// --- Cost Benefits Steps

function title(){
    if(isset($_GET['d'])){
        echo '- Input -\n Cost Benefits';
    }
    else{
        echo '- Customer BC -\n Input Use Case';
    }

}

// ---------------------------------------- PROJECT ----------------------------------------

function project_cb($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    $list_projects = getListProjects($user[0]);
    //var_dump($list_projects);
    if(isset($_SESSION['projID'])){
        unset($_SESSION['projID']);
    }
    //var_dump($list_projects);
    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/input/cost_benefits_steps/project.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projects'=>$list_projects)); 
}


// ---------------------------------------- USE CASE ----------------------------------------

function use_case_cb($twig,$is_connected,$projID=0){
    $user = getUser($_SESSION['username']);
    if($projID!=0){
        if(isset($_SESSION['ucID'])){
            unset($_SESSION['ucID']);
        }
        if(getProjByID($projID,$user[0])){
            $proj = getProjByID($projID,$user[0]);
            $list_measures = getListMeasures();
            $list_ucs = getListUCs();
            $selScope = getListSelScope($projID);
            //var_dump($list_ucs);
            $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
            
            echo $twig->render('/input/cost_benefits_steps/use_case.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'selScope'=>$selScope,'ucs'=>$list_ucs,'measures'=>$list_measures));
            prereq_CostBenefits();
        } else {
            header('Location: ?A=cost_benefits&A2=use_case_cb');
        }
    } else {
        $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
        
        echo $twig->render('/input/cost_benefits_steps/use_case.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1]));
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
                    //var_dump($list_capex_advice);   
                    $list_capex_user = getListCapexUser($projID,$ucID);    
                    $list_selCapex = getListSelCapex($projID,$ucID);          
                    //var_dump($list_selCapex);
                    $devises = getListDevises();
                    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
                    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
                    
                    echo $twig->render('/input/cost_benefits_steps/capex.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project","selected"=>$proj[1],'part2'=>"Use Case",'selected2'=>$uc[1],'projID'=>$projID,'ucID'=>$ucID,"capex_advice"=>$list_capex_advice,"capex_user"=>$list_capex_user,'isTaken'=>$isTaken,'selCapex'=>$list_selCapex));
                    prereq_CostBenefits();
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
                header('Location: ?A=cost_benefits&A2=capex&projID='.$projID.'&ucID='.$ucID.'&isTaken=true');
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
                updateCB($projID,0);
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
/* 
INPUT:  ID du projet, et id du UC
OUTPUT: capex_input.twig
user = id, username, is_admin
proj = name description discount_rate weight_bank weight_bank_soc creation_date modif_date id_user scoping cb
uc = id name description id_meas id_cat
list_selCapex = id_item,unit_cost,volume,period

*/
    $user = getUser($_SESSION['username']);
    if($projID!=0 and $ucID!=0){
        if(getProjByID($projID,$user[0]) and getUCByID($ucID)){
            $proj = getProjByID($projID,$user[0]);
            $uc = getUCByID($ucID);
                //var_dump($uc);
            $list_selCapex = getListSelCapex($projID,$ucID);
            //var_dump($list_selCapex);
            $list_capex_advice = getListCapexAdvice($ucID); 
                //var_dump($list_capex_advice);
            $list_sel_capex_advice = getListSelByType($list_selCapex,$list_capex_advice);
            $list_capex_user = getListCapexUser($projID,$ucID);
            $compo = getCompoByUC($ucID);

            $nb_compo = 0;
            $selectedZones = getListSelZones($projID);
            foreach ($selectedZones as $key => $value) {
                if (!hasChildren($key,$selectedZones)) {
                    $nb_compo += getNbTotalCompoForSelectedZone($compo['id'], $key);
                }
                
            }     

            $nb_uc = getNbTotalUC($projID,$ucID);
                 //var_dump($nb_uc);
            $list_ratio = getRatioCompoCapex($list_sel_capex_advice,$compo['id']);
                 //var_dump($list_ratio);
            $devises = getListDevises();
            
            $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
            $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
            
            echo $twig->render('/input/cost_benefits_steps/capex_input.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project","selected"=>$proj[1],'part2'=>"Use Case",'selected2'=>$uc[1],'projID'=>$projID,'ucID'=>$ucID,"capex_advice"=>$list_capex_advice,"capex_user"=>$list_capex_user,"selCapex"=>$list_selCapex,'compo'=>$compo,'ratio'=>$list_ratio,'nb_compo'=>$nb_compo,'nb_uc'=>$nb_uc));
            prereq_CostBenefits();
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
                    } else if($temp[0]=="period"){
                        if(array_key_exists($temp[1],$list)){
                            $list[$temp[1]] += ['period'=>$value];
                        } else {
                            $list[$temp[1]] = ['period'=>$value];
                        }
                    }
                }
                insertCapexInputed($projID,$ucID,$list);
                update_ModifDate_proj($projID);
                updateCB($projID,0);
                header('Location: ?A=cost_benefits&A2=implem&projID='.$projID.'&ucID='.$ucID);
            } else {
                throw new Exception("There is no UC selected !");
            }
        } else {
            throw new Exception("There is no Project selected !");
        }
    } else {
        throw new Exception("There is no data input !");
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

function delete_selection_capex($projID=0,$ucID=0){
    $user = getUser($_SESSION['username']);
    if($projID!=0 and $ucID!=0){
        if(getProjByID($projID,$user[0]) and getUCByID($ucID)){
            deleteAllSelCapex($projID,$ucID);
            header('Location: ?A=cost_benefits&A2=implem&projID='.$projID.'&ucID='.$ucID);
        } else {
            header('Location: ?A=cost_benefits&A2=project');
        }
    } else {
        throw new Exception("There is no project or use case selected !");
    }
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
                    $devises = getListDevises();
                    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
                    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
                    
                    echo $twig->render('/input/cost_benefits_steps/implem.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project","selected"=>$proj[1],'part2'=>"Use Case",'selected2'=>$uc[1],'projID'=>$projID,'ucID'=>$ucID,"implem_advice"=>$list_implem_advice,"implem_user"=>$list_implem_user,'isTaken'=>$isTaken,'selImplem'=>$list_selImplem));
                    prereq_CostBenefits();
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
                header('Location: ?A=cost_benefits&A2=implem&projID='.$projID.'&ucID='.$ucID.'&isTaken=true');
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
                updateCB($projID,0);
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

            $nb_compo = 0;
            $selectedZones = getListSelZones($projID);
            foreach ($selectedZones as $key => $value) {
                if (!hasChildren($key,$selectedZones)) {
                    $nb_compo += getNbTotalCompoForSelectedZone($compo['id'], $key);
                }
                
            }    

            $nb_uc = getNbTotalUC($projID,$ucID);
            $list_ratio = getRatioCompoImplem($list_sel_implem_advice,$compo['id']);
            //var_dump($list_ratio);
            $devises = getListDevises();
            $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
            $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
            
            echo $twig->render('/input/cost_benefits_steps/implem_input.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project","selected"=>$proj[1],'part2'=>"Use Case",'selected2'=>$uc[1],'projID'=>$projID,'ucID'=>$ucID,"implem_advice"=>$list_implem_advice,"implem_user"=>$list_implem_user,"selImplem"=>$list_selImplem,'compo'=>$compo,'ratio'=>$list_ratio,'nb_compo'=>$nb_compo,'nb_uc'=>$nb_uc));
            prereq_CostBenefits();
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
                updateCB($projID,0);
                header('Location: ?A=cost_benefits&A2=opex&projID='.$projID.'&ucID='.$ucID);
            } else {
                throw new Exception("There is no UC selected !");
            }
        } else {
            throw new Exception("There is no Project selected !");
        }
    } else {
        throw new Exception("There is no data input !");
    }
}

function delete_selection_implem($projID=0,$ucID=0){
    $user = getUser($_SESSION['username']);
    if($projID!=0 and $ucID!=0){
        if(getProjByID($projID,$user[0]) and getUCByID($ucID)){
            deleteAllSelImplem($projID,$ucID);
            header('Location: ?A=cost_benefits&A2=opex&projID='.$projID.'&ucID='.$ucID);
        } else {
            header('Location: ?A=cost_benefits&A2=project');
        }
    } else {
        throw new Exception("There is no project or use case selected !");
    }
}


// ---------------------------------------- OPEX ----------------------------------------

function opex($twig,$is_connected,$projID=0,$ucID=0,$isTaken=false){
    $user = getUser($_SESSION['username']);
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            if($ucID!=0){
                if(getUCByID($ucID)){
                    $proj = getProjByID($projID,$user[0]);
                    $uc = getUCByID($ucID);
                    $list_opex_advice = getListOpexAdvice($ucID);   
                    $list_opex_user = getListOpexUser($projID,$ucID);    
                    $list_selOpex = getListSelOpex($projID,$ucID);          
                    //var_dump($list_selOpex);
                    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/input/cost_benefits_steps/opex.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project","selected"=>$proj[1],'part2'=>"Use Case",'selected2'=>$uc[1],'projID'=>$projID,'ucID'=>$ucID,"opex_advice"=>$list_opex_advice,"opex_user"=>$list_opex_user,'isTaken'=>$isTaken,'selOpex'=>$list_selOpex));
                    prereq_CostBenefits();
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

function create_opex($twig,$is_connected,$post){
    if(isset($_SESSION['projID'])){
        $projID = $_SESSION['projID'];
        if(isset($_SESSION['ucID'])){
            $ucID = $_SESSION['ucID'];
            $name = $post['name'];
            $description = isset($post['description']) ? $post['description'] : "";
            $opex_infos = ["name"=>$name,"description"=>$description];
            //var_dump(getOpexUserItem($projID,$ucID,$name));
            if(!empty(getOpexUserItem($projID,$ucID,$name))){
                header('Location: ?A=cost_benefits&A2=opex&projID='.$projID.'&ucID='.$ucID.'&isTaken=true');
            } else {
                insertOpexUser($projID,$ucID,$opex_infos);
                header('Location: ?A=cost_benefits&A2=opex&projID='.$projID.'&ucID='.$ucID);
            }
        } else {
            throw new Exception("There is no UC selected !");
        }
    } else {
        throw new Exception("There is no Project selected !");
    }
}

function delete_opex_user($idOpex){
    //var_dump(intval($idOpex));
    if(isset($_SESSION['projID'])){
        $projID = $_SESSION['projID'];
        if(isset($_SESSION['ucID'])){
            $ucID = $_SESSION['ucID'];
            deleteOpexUser(intval($idOpex));
            header('Location: ?A=cost_benefits&A2=opex&projID='.$projID.'&ucID='.$ucID);
        } else {
            throw new Exception("There is no UC selected !");
        }
    } else {
        throw new Exception("There is no Project selected !");
    }
}

function opex_selected($twig,$is_connected,$post=[]){
    if($post){
        if(isset($_SESSION['projID'])){
            $projID = $_SESSION['projID'];
            if(isset($_SESSION['ucID'])){
                $ucID = $_SESSION['ucID'];
                $selOpex = [];
                foreach ($post as $id => $value) {
                    array_push($selOpex,$id);
                }
                $selOpex_old = getListSelOpex($projID,$ucID);
                $selOpex_old_id = getKeys($selOpex_old);
                $selOpex_diff_rm = array_diff($selOpex_old_id,$selOpex);
                $selOpex_diff_add = array_diff($selOpex,$selOpex_old_id);
                //var_dump($selOpex_diff_rm);
                //var_dump($selOpex_diff_add);
                if(empty($selOpex_old)){
                    insertSelOpex($projID,$ucID,$selOpex);
                } else if (!empty($selOpex_old)) {
                    deleteSelOpex($projID,$ucID,$selOpex_diff_rm);
                    insertSelOpex($projID,$ucID,$selOpex_diff_add);
                }
                update_ModifDate_proj($projID);
                opex_input($twig,$is_connected,$projID,$ucID);
                updateCB($projID,0);
            } else {
                throw new Exception("There is no UC selected !");
            }
        } else {
            throw new Exception("There is no Project selected !");
        }
    } else {
        throw new Exception("No Opex item selected !");
    }
}

function opex_input($twig,$is_connected,$projID=0,$ucID=0){
    $user = getUser($_SESSION['username']);
    if($projID!=0 and $ucID!=0){
        if(getProjByID($projID,$user[0]) and getUCByID($ucID)){
            $proj = getProjByID($projID,$user[0]);
            $uc = getUCByID($ucID);
            $list_selOpex = getListSelOpex($projID,$ucID);
            //var_dump($list_selOpex);
            $list_opex_advice = getListOpexAdvice($ucID); 
            $list_sel_opex_advice = getListSelByType($list_selOpex,$list_opex_advice);
            //var_dump($list_sel_opex_advice);
            $list_opex_user = getListOpexUser($projID,$ucID);
            $compo = getCompoByUC($ucID);            
            
            $nb_compo = 0;
            $selectedZones = getListSelZones($projID);
            foreach ($selectedZones as $key => $value) {
                if (!hasChildren($key,$selectedZones)) {
                    $nb_compo += getNbTotalCompoForSelectedZone($compo['id'], $key);
                }
                
            }    
            
            $nb_uc = getNbTotalUC($projID,$ucID);
            $list_ratio = getRatioCompoOpex($list_sel_opex_advice,$compo['id']);
            //var_dump($list_ratio);
            $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/input/cost_benefits_steps/opex_input.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project","selected"=>$proj[1],'part2'=>"Use Case",'selected2'=>$uc[1],'projID'=>$projID,'ucID'=>$ucID,"opex_advice"=>$list_opex_advice,"opex_user"=>$list_opex_user,"selOpex"=>$list_selOpex,'compo'=>$compo,'ratio'=>$list_ratio,'nb_compo'=>$nb_compo,'nb_uc'=>$nb_uc));
            prereq_CostBenefits();
        } else {
            header('Location: ?A=cost_benefits&A2=project');
        }
    } else {
        throw new Exception("There is no project or use case selected !");
    }
}

function opex_inputed($post){
    if($post){
        if(isset($_SESSION['projID'])){
            $projID = $_SESSION['projID'];
            if(isset($_SESSION['ucID'])){
                $ucID = $_SESSION['ucID'];
                $list = [];
                foreach ($post as $key => $value) {
                    $temp = explode('_',$key);
                    //var_dump($temp);
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
                    } else if($temp[0]=="anVarVol"){
                        if(array_key_exists($temp[1],$list)){
                            $list[$temp[1]] += ['anVarVol'=>$value];
                        } else {
                            $list[$temp[1]] = ['anVarVol'=>$value];
                        }
                    } else if($temp[0]=="anVarCost"){
                        if(array_key_exists($temp[1],$list)){
                            $list[$temp[1]] += ['anVarCost'=>$value];
                        } else {
                            $list[$temp[1]] = ['anVarCost'=>$value];
                        }
                    }
                }
                insertOpexInputed($projID,$ucID,$list);
                update_ModifDate_proj($projID);
                updateCB($projID,0);
                
                $revSchedule = getRevenuesSchedule($projID,$ucID);
                $hasSchedule = !$revSchedule ? $revSchedule : true;
                $next_page = $hasSchedule ? "revenues" : "cashreleasing";
                header('Location: ?A=cost_benefits&A2='.$next_page.'&projID='.$projID.'&ucID='.$ucID);
            } else {
                throw new Exception("There is no UC selected !");
            }
        } else {
            throw new Exception("There is no Project selected !");
        }
    } else {
        throw new Exception("There is no data input !");
    }
}

function delete_selection_opex($projID=0,$ucID=0){
    $user = getUser($_SESSION['username']);
    if($projID!=0 and $ucID!=0){
        if(getProjByID($projID,$user[0]) and getUCByID($ucID)){
            deleteAllSelOpex($projID,$ucID);
            $revSchedule = getRevenuesSchedule($projID,$ucID);
            $hasSchedule = !$revSchedule ? $revSchedule : true;
            $next_page = $hasSchedule ? "revenues" : "cashreleasing";
            header('Location: ?A=cost_benefits&A2='.$next_page.'&projID='.$projID.'&ucID='.$ucID);
        } else {
            header('Location: ?A=cost_benefits&A2=project');
        }
    } else {
        throw new Exception("There is no project or use case selected !");
    }
}


// ---------------------------------------- REVENUES ----------------------------------------

function revenues($twig,$is_connected,$projID=0,$ucID=0,$isTaken=false){
    $user = getUser($_SESSION['username']);
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            if($ucID!=0){
                if(getUCByID($ucID)){
                    $proj = getProjByID($projID,$user[0]);
                    $uc = getUCByID($ucID);
                    $revSchedule = getRevenuesSchedule($projID,$ucID);
                    $hasSchedule = !$revSchedule ? $revSchedule : true;
                    if($hasSchedule){
                        $list_revenues_advice = getListRevenuesAdvice($ucID);   
                        $list_revenues_user = getListRevenuesUser($projID,$ucID);    
                        $list_selRevenues = getListSelRevenues($projID,$ucID);          
                        //var_dump($list_selRevenues);
                        $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/input/cost_benefits_steps/revenues.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project","selected"=>$proj[1],'part2'=>"Use Case",'selected2'=>$uc[1],'projID'=>$projID,'ucID'=>$ucID,"revenues_advice"=>$list_revenues_advice,"revenues_user"=>$list_revenues_user,'isTaken'=>$isTaken,'selRevenues'=>$list_selRevenues));
                        prereq_CostBenefits();
                    } else {
                        header('Location: ?A=cost_benefits&A2=cashreleasing&projID='.$projID.'&ucID='.$ucID);
                    }
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

function create_revenues($twig,$is_connected,$post){
    if(isset($_SESSION['projID'])){
        $projID = $_SESSION['projID'];
        if(isset($_SESSION['ucID'])){
            $ucID = $_SESSION['ucID'];
            $name = $post['name'];
            $description = isset($post['description']) ? $post['description'] : "";
            $revenues_infos = ["name"=>$name,"description"=>$description];
            if(!empty(getRevenuesUserItem($projID,$ucID,$name))){
                header('Location: ?A=cost_benefits&A2=revenues&projID='.$projID.'&ucID='.$ucID.'&isTaken=true');
            } else {
                insertRevenuesUser($projID,$ucID,$revenues_infos);
                header('Location: ?A=cost_benefits&A2=revenues&projID='.$projID.'&ucID='.$ucID);
            }
        } else {
            throw new Exception("There is no UC selected !");
        }
    } else {
        throw new Exception("There is no Project selected !");
    }
}

function delete_revenues_user($idRevenues){
    //var_dump(intval($idRevenues));
    if(isset($_SESSION['projID'])){
        $projID = $_SESSION['projID'];
        if(isset($_SESSION['ucID'])){
            $ucID = $_SESSION['ucID'];
            deleteRevenuesUser(intval($idRevenues));
            header('Location: ?A=cost_benefits&A2=revenues&projID='.$projID.'&ucID='.$ucID);
        } else {
            throw new Exception("There is no UC selected !");
        }
    } else {
        throw new Exception("There is no Project selected !");
    }
}

function revenues_selected($twig,$is_connected,$post=[]){
    if($post){
        if(isset($_SESSION['projID'])){
            $projID = $_SESSION['projID'];
            if(isset($_SESSION['ucID'])){
                $ucID = $_SESSION['ucID'];
                $selRevenues = [];
                foreach ($post as $id => $value) {
                    array_push($selRevenues,$id);
                }
                $selRevenues_old = getListSelRevenues($projID,$ucID);
                $selRevenues_old_id = getKeys($selRevenues_old);
                $selRevenues_diff_rm = array_diff($selRevenues_old_id,$selRevenues);
                $selRevenues_diff_add = array_diff($selRevenues,$selRevenues_old_id);
                //var_dump($selRevenues_diff_rm);
                //var_dump($selRevenues_diff_add);
                if(empty($selRevenues_old)){
                    insertSelRevenues($projID,$ucID,$selRevenues);
                } else if (!empty($selRevenues_old)) {
                    deleteSelRevenues($projID,$ucID,$selRevenues_diff_rm);
                    insertSelRevenues($projID,$ucID,$selRevenues_diff_add);
                }
                update_ModifDate_proj($projID);
                revenues_input($twig,$is_connected,$projID,$ucID);
                updateCB($projID,0);
            } else {
                throw new Exception("There is no UC selected !");
            }
        } else {
            throw new Exception("There is no Project selected !");
        }
    } else {
        throw new Exception("No Revenues item selected !");
    }
}

function revenues_input($twig,$is_connected,$projID=0,$ucID=0){
    $user = getUser($_SESSION['username']);
    if($projID!=0 and $ucID!=0){
        if(getProjByID($projID,$user[0]) and getUCByID($ucID)){
            $proj = getProjByID($projID,$user[0]);
            $uc = getUCByID($ucID);
            $list_selRevenues = getListSelRevenues($projID,$ucID);
            //var_dump($list_selRevenues);
            $list_revenues_advice = getListRevenuesAdvice($ucID); 
            $list_sel_revenues_advice = getListSelByType($list_selRevenues,$list_revenues_advice);
            //var_dump($list_sel_revenues_advice);
            $list_revenues_user = getListRevenuesUser($projID,$ucID);
            $compo = getCompoByUC($ucID);
            
            $nb_compo = 0;
            $selectedZones = getListSelZones($projID);
            foreach ($selectedZones as $key => $value) {
                if (!hasChildren($key,$selectedZones)) {
                    $nb_compo += getNbTotalCompoForSelectedZone($compo['id'], $key);
                }
                
            } 
            $nb_uc = getNbTotalUC($projID,$ucID);
            $list_ratio = getRatioCompoRevenues($list_sel_revenues_advice,$compo['id']);
            //var_dump($list_ratio);
            $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/input/cost_benefits_steps/revenues_input.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project","selected"=>$proj[1],'part2'=>"Use Case",'selected2'=>$uc[1],'projID'=>$projID,'ucID'=>$ucID,"revenues_advice"=>$list_revenues_advice,"revenues_user"=>$list_revenues_user,"selRevenues"=>$list_selRevenues,'compo'=>$compo,'ratio'=>$list_ratio,'nb_compo'=>$nb_compo,'nb_uc'=>$nb_uc));
            prereq_CostBenefits();
        } else {
            header('Location: ?A=cost_benefits&A2=project');
        }
    } else {
        throw new Exception("There is no project or use case selected !");
    }
}

function revenues_inputed($post){
    if($post){
        if(isset($_SESSION['projID'])){
            $projID = $_SESSION['projID'];
            if(isset($_SESSION['ucID'])){
                $ucID = $_SESSION['ucID'];
                $list = [];
                foreach ($post as $key => $value) {
                    $temp = explode('_',$key);
                    //var_dump($temp);
                    if($temp[0]=="vol"){
                        if(array_key_exists($temp[1],$list)){
                            $list[$temp[1]] += ['volume'=>$value];
                        } else {
                            $list[$temp[1]] = ['volume'=>$value];
                        }
                    } else if($temp[0]=="rev"){
                        if(array_key_exists($temp[1],$list)){
                            $list[$temp[1]] += ['unit_rev'=>$value];
                        } else {
                            $list[$temp[1]] = ['unit_rev'=>$value];
                        }
                    } else if($temp[0]=="anVarVol"){
                        if(array_key_exists($temp[1],$list)){
                            $list[$temp[1]] += ['anVarVol'=>$value];
                        } else {
                            $list[$temp[1]] = ['anVarVol'=>$value];
                        }
                    } else if($temp[0]=="anVarRev"){
                        if(array_key_exists($temp[1],$list)){
                            $list[$temp[1]] += ['anVarRev'=>$value];
                        } else {
                            $list[$temp[1]] = ['anVarRev'=>$value];
                        }
                    }
                }
                insertRevenuesInputed($projID,$ucID,$list);
                update_ModifDate_proj($projID);
                updateCB($projID,0);
                header('Location: ?A=cost_benefits&A2=cashreleasing&projID='.$projID.'&ucID='.$ucID);
            } else {
                throw new Exception("There is no UC selected !");
            }
        } else {
            throw new Exception("There is no Project selected !");
        }
    } else {
        throw new Exception("There is no data input !");
    }
}

function delete_selection_revenues($projID=0,$ucID=0){
    $user = getUser($_SESSION['username']);
    if($projID!=0 and $ucID!=0){
        if(getProjByID($projID,$user[0]) and getUCByID($ucID)){
            deleteAllSelRevenues($projID,$ucID);
            header('Location: ?A=cost_benefits&A2=cashreleasing&projID='.$projID.'&ucID='.$ucID);
        } else {
            header('Location: ?A=cost_benefits&A2=project');
        }
    } else {
        throw new Exception("There is no project or use case selected !");
    }
}




// ---------------------------------------- CASH RELEASING ----------------------------------------

function cashreleasing($twig,$is_connected,$projID=0,$ucID=0,$isTaken=false){
    $user = getUser($_SESSION['username']);
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            if($ucID!=0){
                if(getUCByID($ucID)){
                    $proj = getProjByID($projID,$user[0]);
                    $uc = getUCByID($ucID);
                    $list_cashreleasing_advice = getListCashReleasingAdvice($ucID);   
                    $list_cashreleasing_user = getListCashReleasingUser($projID,$ucID);    
                    $list_selCashReleasing = getListSelCashReleasing($projID,$ucID);          
                    //var_dump($list_cashreleasing_advice);
                    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/input/cost_benefits_steps/cashreleasing.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project","selected"=>$proj[1],'part2'=>"Use Case",'selected2'=>$uc[1],'projID'=>$projID,'ucID'=>$ucID,"cashreleasing_advice"=>$list_cashreleasing_advice,"cashreleasing_user"=>$list_cashreleasing_user,'isTaken'=>$isTaken,'selCashReleasing'=>$list_selCashReleasing));
                    prereq_CostBenefits();
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

function create_cashreleasing($twig,$is_connected,$post){
    if(isset($_SESSION['projID'])){
        $projID = $_SESSION['projID'];
        if(isset($_SESSION['ucID'])){
            $ucID = $_SESSION['ucID'];
            $name = $post['name'];
            $description = isset($post['description']) ? $post['description'] : "";
            $cashreleasing_infos = ["name"=>$name,"description"=>$description];
            //var_dump(getCashReleasingUserItem($projID,$ucID,$name));
            if(!empty(getCashReleasingUserItem($projID,$ucID,$name))){
                header('Location: ?A=cost_benefits&A2=cashreleasing&projID='.$projID.'&ucID='.$ucID.'&isTaken=true');
            } else {
                insertCashReleasingUser($projID,$ucID,$cashreleasing_infos);
                header('Location: ?A=cost_benefits&A2=cashreleasing&projID='.$projID.'&ucID='.$ucID);
            }
        } else {
            throw new Exception("There is no UC selected !");
        }
    } else {
        throw new Exception("There is no Project selected !");
    }
}

function delete_cashreleasing_user($idCashReleasing){
    //var_dump(intval($idCashReleasing));
    if(isset($_SESSION['projID'])){
        $projID = $_SESSION['projID'];
        if(isset($_SESSION['ucID'])){
            $ucID = $_SESSION['ucID'];
            deleteCashReleasingUser(intval($idCashReleasing));
            header('Location: ?A=cost_benefits&A2=cashreleasing&projID='.$projID.'&ucID='.$ucID);
        } else {
            throw new Exception("There is no UC selected !");
        }
    } else {
        throw new Exception("There is no Project selected !");
    }
}

function cashreleasing_selected($twig,$is_connected,$post=[]){
    if($post){
        if(isset($_SESSION['projID'])){
            $projID = $_SESSION['projID'];
            if(isset($_SESSION['ucID'])){
                $ucID = $_SESSION['ucID'];
                $selCashReleasing = [];
                foreach ($post as $id => $value) {
                    array_push($selCashReleasing,$id);
                }
                $selCashReleasing_old = getListSelCashReleasing($projID,$ucID);
                $selCashReleasing_old_id = getKeys($selCashReleasing_old);
                $selCashReleasing_diff_rm = array_diff($selCashReleasing_old_id,$selCashReleasing);
                $selCashReleasing_diff_add = array_diff($selCashReleasing,$selCashReleasing_old_id);
                //var_dump($selCashReleasing_diff_rm);
                //var_dump($selCashReleasing_diff_add);
                if(empty($selCashReleasing_old)){
                    insertSelCashReleasing($projID,$ucID,$selCashReleasing);
                } else if (!empty($selCashReleasing_old)) {
                    deleteSelCashReleasing($projID,$ucID,$selCashReleasing_diff_rm);
                    insertSelCashReleasing($projID,$ucID,$selCashReleasing_diff_add);
                }
                update_ModifDate_proj($projID);
                cashreleasing_input($twig,$is_connected,$projID,$ucID);
                updateCB($projID,0);
            } else {
                throw new Exception("There is no UC selected !");
            }
        } else {
            throw new Exception("There is no Project selected !");
        }
    } else {
        throw new Exception("No CashReleasing item selected !");
    }
}

function cashreleasing_input($twig,$is_connected,$projID=0,$ucID=0){
    $user = getUser($_SESSION['username']);
    if($projID!=0 and $ucID!=0){
        if(getProjByID($projID,$user[0]) and getUCByID($ucID)){
            $proj = getProjByID($projID,$user[0]);
            $uc = getUCByID($ucID);
            $list_selCashReleasing = getListSelCashReleasing($projID,$ucID);
            //var_dump($list_selCashReleasing);
            $list_cashreleasing_advice = getListCashReleasingAdvice($ucID); 
            $list_sel_cashreleasing_advice = getListSelByType($list_selCashReleasing,$list_cashreleasing_advice);
            //var_dump($list_sel_cashreleasing_advice);
            $list_cashreleasing_user = getListCashReleasingUser($projID,$ucID);
            $compo = getCompoByUC($ucID);
            
            $nb_compo = 0;
            $selectedZones = getListSelZones($projID);
            foreach ($selectedZones as $key => $value) {
                if (!hasChildren($key,$selectedZones)) {
                    $nb_compo += getNbTotalCompoForSelectedZone($compo['id'], $key);
                }
                
            } 
            $nb_uc = getNbTotalUC($projID,$ucID);
            $list_ratio = getRatioCompoCashReleasing($list_sel_cashreleasing_advice,$compo['id']);
            //var_dump($list_ratio);
            $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/input/cost_benefits_steps/cashreleasing_input.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project","selected"=>$proj[1],'part2'=>"Use Case",'selected2'=>$uc[1],'projID'=>$projID,'ucID'=>$ucID,"cashreleasing_advice"=>$list_cashreleasing_advice,"cashreleasing_user"=>$list_cashreleasing_user,"selCashReleasing"=>$list_selCashReleasing,'compo'=>$compo,'ratio'=>$list_ratio,'nb_compo'=>$nb_compo,'nb_uc'=>$nb_uc));
            prereq_CostBenefits();
        } else {
            header('Location: ?A=cost_benefits&A2=project');
        }
    } else {
        throw new Exception("There is no project or use case selected !");
    }
}

function cashreleasing_inputed($post){
    if($post){
        if(isset($_SESSION['projID'])){
            $projID = $_SESSION['projID'];
            if(isset($_SESSION['ucID'])){
                $ucID = $_SESSION['ucID'];
                $list = getListCashRelFromPost($post);
                insertCashReleasingInputed($projID,$ucID,$list);
                update_ModifDate_proj($projID);
                updateCB($projID,0);
                header('Location: ?A=cost_benefits&A2=widercash&projID='.$projID.'&ucID='.$ucID);
            } else {
                throw new Exception("There is no UC selected !");
            }
        } else {
            throw new Exception("There is no Project selected !");
        }
    } else {
        throw new Exception("There is no data input !");
    }
}

function getListCashRelFromPost($post){
    $list = [];
    foreach ($post as $key => $value) {
        $temp = explode('_',$key);
        //var_dump($temp);
        if($temp[0]=="vol"){
            if(array_key_exists($temp[1],$list)){
                $list[$temp[1]] += ['volume'=>$value];
            } else {
                $list[$temp[1]] = ['volume'=>$value];
            }
        } else if($temp[0]=="unitIndic"){
            if(array_key_exists($temp[1],$list)){
                $list[$temp[1]] += ['unit_indic'=>$value];
            } else {
                $list[$temp[1]] = ['unit_indic'=>$value];
            }
        } else if($temp[0]=="anVarVol"){
            if(array_key_exists($temp[1],$list)){
                $list[$temp[1]] += ['anVarVol'=>$value];
            } else {
                $list[$temp[1]] = ['anVarVol'=>$value];
            }
        } else if($temp[0]=="anVarCost"){
            if(array_key_exists($temp[1],$list)){
                $list[$temp[1]] += ['anVarCost'=>$value];
            } else {
                $list[$temp[1]] = ['anVarCost'=>$value];
            }
        } else if($temp[0]=="volRed"){
            if(array_key_exists($temp[1],$list)){
                $list[$temp[1]] += ['vol_red'=>$value];
            } else {
                $list[$temp[1]] = ['vol_red'=>$value];
            }
        } else if($temp[0]=="unitCostRed"){
            if(array_key_exists($temp[1],$list)){
                $list[$temp[1]] += ['unit_cost_red'=>$value];
            } else {
                $list[$temp[1]] = ['unit_cost_red'=>$value];
            }
        } else if($temp[0]=="unitCost"){
            if(array_key_exists($temp[1],$list)){
                $list[$temp[1]] += ['unit_cost'=>$value];
            } else {
                $list[$temp[1]] = ['unit_cost'=>$value];
            }
        }
    }
    return $list;
}

function delete_selection_cashreleasing($projID=0,$ucID=0){
    $user = getUser($_SESSION['username']);
    if($projID!=0 and $ucID!=0){
        if(getProjByID($projID,$user[0]) and getUCByID($ucID)){
            deleteAllSelCashReleasing($projID,$ucID);
            header('Location: ?A=cost_benefits&A2=widercash&projID='.$projID.'&ucID='.$ucID);
        } else {
            header('Location: ?A=cost_benefits&A2=project');
        }
    } else {
        throw new Exception("There is no project or use case selected !");
    }
}



// ---------------------------------------- WIDER CASH ----------------------------------------

function widercash($twig,$is_connected,$projID=0,$ucID=0,$isTaken=false){
    $user = getUser($_SESSION['username']);
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            if($ucID!=0){
                if(getUCByID($ucID)){
                    $proj = getProjByID($projID,$user[0]);
                    $uc = getUCByID($ucID);
                    $list_widercash_advice = getListWiderCashAdvice($ucID);   
                    $list_widercash_user = getListWiderCashUser($projID,$ucID);    
                    $list_selWiderCash = getListSelWiderCash($projID,$ucID);          
                    //var_dump($list_selWiderCash);
                    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/input/cost_benefits_steps/widercash.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project","selected"=>$proj[1],'part2'=>"Use Case",'selected2'=>$uc[1],'projID'=>$projID,'ucID'=>$ucID,"widercash_advice"=>$list_widercash_advice,"widercash_user"=>$list_widercash_user,'isTaken'=>$isTaken,'selWiderCash'=>$list_selWiderCash));
                    prereq_CostBenefits();
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

function create_widercash($twig,$is_connected,$post){
    if(isset($_SESSION['projID'])){
        $projID = $_SESSION['projID'];
        if(isset($_SESSION['ucID'])){
            $ucID = $_SESSION['ucID'];
            $name = $post['name'];
            $description = isset($post['description']) ? $post['description'] : "";
            $widercash_infos = ["name"=>$name,"description"=>$description];
            //var_dump(getWiderCashUserItem($projID,$ucID,$name));
            if(!empty(getWiderCashUserItem($projID,$ucID,$name))){
                header('Location: ?A=cost_benefits&A2=widercash&projID='.$projID.'&ucID='.$ucID.'&isTaken=true');
            } else {
                insertWiderCashUser($projID,$ucID,$widercash_infos);
                header('Location: ?A=cost_benefits&A2=widercash&projID='.$projID.'&ucID='.$ucID);
            }
        } else {
            throw new Exception("There is no UC selected !");
        }
    } else {
        throw new Exception("There is no Project selected !");
    }
}

function delete_widercash_user($idWiderCash){
    //var_dump(intval($idWiderCash));
    if(isset($_SESSION['projID'])){
        $projID = $_SESSION['projID'];
        if(isset($_SESSION['ucID'])){
            $ucID = $_SESSION['ucID'];
            deleteWiderCashUser(intval($idWiderCash));
            header('Location: ?A=cost_benefits&A2=widercash&projID='.$projID.'&ucID='.$ucID);
        } else {
            throw new Exception("There is no UC selected !");
        }
    } else {
        throw new Exception("There is no Project selected !");
    }
}

function widercash_selected($twig,$is_connected,$post=[]){
    if($post){
        if(isset($_SESSION['projID'])){
            $projID = $_SESSION['projID'];
            if(isset($_SESSION['ucID'])){
                $ucID = $_SESSION['ucID'];
                $selWiderCash = [];
                foreach ($post as $id => $value) {
                    array_push($selWiderCash,$id);
                }
                $selWiderCash_old = getListSelWiderCash($projID,$ucID);
                $selWiderCash_old_id = getKeys($selWiderCash_old);
                $selWiderCash_diff_rm = array_diff($selWiderCash_old_id,$selWiderCash);
                $selWiderCash_diff_add = array_diff($selWiderCash,$selWiderCash_old_id);
                //var_dump($selWiderCash_diff_rm);
                //var_dump($selWiderCash_diff_add);
                if(empty($selWiderCash_old)){
                    insertSelWiderCash($projID,$ucID,$selWiderCash);
                } else if (!empty($selWiderCash_old)) {
                    deleteSelWiderCash($projID,$ucID,$selWiderCash_diff_rm);
                    insertSelWiderCash($projID,$ucID,$selWiderCash_diff_add);
                }
                update_ModifDate_proj($projID);
                updateCB($projID,0);
                widercash_input($twig,$is_connected,$projID,$ucID);
            } else {
                throw new Exception("There is no UC selected !");
            }
        } else {
            throw new Exception("There is no Project selected !");
        }
    } else {
        throw new Exception("No WiderCash item selected !");
    }
}

function widercash_input($twig,$is_connected,$projID=0,$ucID=0){
    $user = getUser($_SESSION['username']);
    if($projID!=0 and $ucID!=0){
        if(getProjByID($projID,$user[0]) and getUCByID($ucID)){
            $proj = getProjByID($projID,$user[0]);
            $uc = getUCByID($ucID);
            $list_selWiderCash = getListSelWiderCash($projID,$ucID);
            //var_dump($list_selWiderCash);
            $list_widercash_advice = getListWiderCashAdvice($ucID); 
            $list_sel_widercash_advice = getListSelByType($list_selWiderCash,$list_widercash_advice);
            //var_dump($list_sel_widercash_advice);
            $list_widercash_user = getListWiderCashUser($projID,$ucID);
            $compo = getCompoByUC($ucID);
            
            $nb_compo = 0;
            $selectedZones = getListSelZones($projID);
            foreach ($selectedZones as $key => $value) {
                if (!hasChildren($key,$selectedZones)) {
                    $nb_compo += getNbTotalCompoForSelectedZone($compo['id'], $key);
                }
                
            } 
            $nb_uc = getNbTotalUC($projID,$ucID);
            $list_ratio = getRatioCompoWiderCash($list_sel_widercash_advice,$compo['id']);
            //var_dump($list_ratio);
            $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/input/cost_benefits_steps/widercash_input.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project","selected"=>$proj[1],'part2'=>"Use Case",'selected2'=>$uc[1],'projID'=>$projID,'ucID'=>$ucID,"widercash_advice"=>$list_widercash_advice,"widercash_user"=>$list_widercash_user,"selWiderCash"=>$list_selWiderCash,'compo'=>$compo,'ratio'=>$list_ratio,'nb_compo'=>$nb_compo,'nb_uc'=>$nb_uc));
            prereq_CostBenefits();
        } else {
            header('Location: ?A=cost_benefits&A2=project');
        }
    } else {
        throw new Exception("There is no project or use case selected !");
    }
}

function widercash_inputed($post){
    if($post){
        if(isset($_SESSION['projID'])){
            $projID = $_SESSION['projID'];
            if(isset($_SESSION['ucID'])){
                $ucID = $_SESSION['ucID'];
                $list = getListWiderCashFromPost($post);
                insertWiderCashInputed($projID,$ucID,$list);
                update_ModifDate_proj($projID);
                updateCB($projID,0);
                header('Location: ?A=cost_benefits&A2=noncash&projID='.$projID.'&ucID='.$ucID);
            } else {
                throw new Exception("There is no UC selected !");
            }
        } else {
            throw new Exception("There is no Project selected !");
        }
    } else {
        throw new Exception("There is no data input !");
    }
}

function getListWiderCashFromPost($post){
    $list = [];
    foreach ($post as $key => $value) {
        $temp = explode('_',$key);
        //var_dump($temp);
        if($temp[0]=="vol"){
            if(array_key_exists($temp[1],$list)){
                $list[$temp[1]] += ['volume'=>$value];
            } else {
                $list[$temp[1]] = ['volume'=>$value];
            }
        } else if($temp[0]=="unitIndic"){
            if(array_key_exists($temp[1],$list)){
                $list[$temp[1]] += ['unit_indic'=>$value];
            } else {
                $list[$temp[1]] = ['unit_indic'=>$value];
            }
        } else if($temp[0]=="anVarVol"){
            if(array_key_exists($temp[1],$list)){
                $list[$temp[1]] += ['anVarVol'=>$value];
            } else {
                $list[$temp[1]] = ['anVarVol'=>$value];
            }
        } else if($temp[0]=="anVarCost"){
            if(array_key_exists($temp[1],$list)){
                $list[$temp[1]] += ['anVarCost'=>$value];
            } else {
                $list[$temp[1]] = ['anVarCost'=>$value];
            }
        } else if($temp[0]=="volRed"){
            if(array_key_exists($temp[1],$list)){
                $list[$temp[1]] += ['vol_red'=>$value];
            } else {
                $list[$temp[1]] = ['vol_red'=>$value];
            }
        } else if($temp[0]=="unitCostRed"){
            if(array_key_exists($temp[1],$list)){
                $list[$temp[1]] += ['unit_cost_red'=>$value];
            } else {
                $list[$temp[1]] = ['unit_cost_red'=>$value];
            }
        } else if($temp[0]=="unitCost"){
            if(array_key_exists($temp[1],$list)){
                $list[$temp[1]] += ['unit_cost'=>$value];
            } else {
                $list[$temp[1]] = ['unit_cost'=>$value];
            }
        }
    }
    return $list;
}

function delete_selection_widercash($projID=0,$ucID=0){
    $user = getUser($_SESSION['username']);
    if($projID!=0 and $ucID!=0){
        if(getProjByID($projID,$user[0]) and getUCByID($ucID)){
            deleteAllSelWiderCash($projID,$ucID);
            header('Location: ?A=cost_benefits&A2=noncash&projID='.$projID.'&ucID='.$ucID);
        } else {
            header('Location: ?A=cost_benefits&A2=project');
        }
    } else {
        throw new Exception("There is no project or use case selected !");
    }
}


// ---------------------------------------- QUANTIFIABLE NON MONETIZABLE BENEFITS ----------------------------------------

function quantifiableBenefits($twig,$is_connected,$projID=0,$ucID=0,$isTaken=false){
    $user = getUser($_SESSION['username']);
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            if($ucID!=0){
                if(getUCByID($ucID)){
                    $proj = getProjByID($projID,$user[0]);
                    $uc = getUCByID($ucID);
                    $list_quantifiable_advice = getListQuantifiableAdvice($ucID);   //remplacer les fonctions!!
                    $list_quantifiable_user = getListQuantifiableUser($projID,$ucID);    
                    $list_selQuantifiable = getListSelQuantifiable($projID,$ucID);          
                    //var_dump($list_selWiderCash);
                    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/input/cost_benefits_steps/quantifiable.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project","selected"=>$proj[1],'part2'=>"Use Case",'selected2'=>$uc[1],'projID'=>$projID,'ucID'=>$ucID,"quantifiable_advice"=>$list_quantifiable_advice,"quantifiable_user"=>$list_quantifiable_user,'isTaken'=>$isTaken,'selQuantifiable'=>$list_selQuantifiable));
                    prereq_CostBenefits();
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

function create_quantifiable($twig,$is_connected,$post){
    if(isset($_SESSION['projID'])){
        $projID = $_SESSION['projID'];
        if(isset($_SESSION['ucID'])){
            $ucID = $_SESSION['ucID'];
            $name = $post['name'];
            $description = isset($post['description']) ? $post['description'] : "";
            $quantifiable_infos = ["name"=>$name,"description"=>$description];
            //var_dump(getQuantifiableUserItem($projID,$ucID,$name));
            if(!empty(getQuantifiableUserItem($projID,$ucID,$name))){
                header('Location: ?A=cost_benefits&A2=quantifiable&projID='.$projID.'&ucID='.$ucID.'&isTaken=true');
            } else {
                insertQuantifiableUser($projID,$ucID,$quantifiable_infos);
                header('Location: ?A=cost_benefits&A2=quantifiable&projID='.$projID.'&ucID='.$ucID);
            }
        } else {
            throw new Exception("There is no UC selected !");
        }
    } else {
        throw new Exception("There is no Project selected !");
    }
}

function delete_quantifiable_user($idQuantifiable){
    //var_dump(intval($idQuantifiable));
    if(isset($_SESSION['projID'])){
        $projID = $_SESSION['projID'];
        if(isset($_SESSION['ucID'])){
            $ucID = $_SESSION['ucID'];
            deleteQuantifiableUser(intval($idQuantifiable));
            header('Location: ?A=cost_benefits&A2=quantifiable&projID='.$projID.'&ucID='.$ucID);
        } else {
            throw new Exception("There is no UC selected !");
        }
    } else {
        throw new Exception("There is no Project selected !");
    }
}

function quantifiable_selected($twig,$is_connected,$post=[]){
    if($post){
        if(isset($_SESSION['projID'])){
            $projID = $_SESSION['projID'];
            if(isset($_SESSION['ucID'])){
                $ucID = $_SESSION['ucID'];
                $selQuantifiable = [];
                foreach ($post as $id => $value) {
                    array_push($selQuantifiable,$id);
                }
                $selQuantifiable_old = getListSelQuantifiable($projID,$ucID);
                $selQuantifiable_old_id = getKeys($selQuantifiable_old);
                $selQuantifiable_diff_rm = array_diff($selQuantifiable_old_id,$selQuantifiable);
                $selQuantifiable_diff_add = array_diff($selQuantifiable,$selQuantifiable_old_id);
                //var_dump($selQuantifiable_diff_rm);
                //var_dump($selQuantifiable_diff_add);
                if(empty($selQuantifiable_old)){
                    insertSelQuantifiable($projID,$ucID,$selQuantifiable);
                } else if (!empty($selQuantifiable_old)) {
                    deleteSelQuantifiable($projID,$ucID,$selQuantifiable_diff_rm);
                    insertSelQuantifiable($projID,$ucID,$selQuantifiable_diff_add);
                }
                update_ModifDate_proj($projID);
                updateCB($projID,0);
                quantifiable_input($twig,$is_connected,$projID,$ucID);
            } else {
                throw new Exception("There is no UC selected !");
            }
        } else {
            throw new Exception("There is no Project selected !");
        }
    } else {
        throw new Exception("No Quantifiable item selected !");
    }
}

function quantifiable_input($twig,$is_connected,$projID=0,$ucID=0){
    $user = getUser($_SESSION['username']);
    if($projID!=0 and $ucID!=0){
        if(getProjByID($projID,$user[0]) and getUCByID($ucID)){
            $proj = getProjByID($projID,$user[0]);
            $uc = getUCByID($ucID);
            $list_selQuantifiable = getListSelQuantifiable($projID,$ucID);
            //var_dump($list_selQuantifiable);
            $list_quantifiable_advice = getListQuantifiableAdvice($ucID); 
            $list_sel_quantifiable_advice = getListSelByType($list_selQuantifiable,$list_quantifiable_advice);
            //var_dump($list_sel_quantifiable_advice);
            $list_quantifiable_user = getListQuantifiableUser($projID,$ucID);
            $compo = getCompoByUC($ucID);
            
            $nb_compo = 0;
            $selectedZones = getListSelZones($projID);
            foreach ($selectedZones as $key => $value) {
                if (!hasChildren($key,$selectedZones)) {
                    $nb_compo += getNbTotalCompoForSelectedZone($compo['id'], $key);
                }
                
            } 
            $nb_uc = getNbTotalUC($projID,$ucID);
            //var_dump($list_ratio);
            $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/input/cost_benefits_steps/quantifiable_input.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project","selected"=>$proj[1],'part2'=>"Use Case",'selected2'=>$uc[1],'projID'=>$projID,'ucID'=>$ucID,"quantifiable_advice"=>$list_quantifiable_advice,"quantifiable_user"=>$list_quantifiable_user,"selQuantifiable"=>$list_selQuantifiable,'compo'=>$compo,'nb_compo'=>$nb_compo,'nb_uc'=>$nb_uc));
            prereq_CostBenefits();
        } else {
            header('Location: ?A=cost_benefits&A2=project');
        }
    } else {
        throw new Exception("There is no project or use case selected !");
    }
}

function quantifiable_inputed($post){
    if($post){
        if(isset($_SESSION['projID'])){
            $projID = $_SESSION['projID'];
            if(isset($_SESSION['ucID'])){
                $ucID = $_SESSION['ucID'];
                $list = getListQuantifiableFromPost($post);
                insertQuantifiableInputed($projID,$ucID,$list);
                update_ModifDate_proj($projID);
                updateCB($projID,0);
                header('Location: ?A=cost_benefits&A2=noncash&projID='.$projID.'&ucID='.$ucID);
            } else {
                throw new Exception("There is no UC selected !");
            }
        } else {
            throw new Exception("There is no Project selected !");
        }
    } else {
        throw new Exception("There is no data input !");
    }
}

function getListQuantifiableFromPost($post){
    $list = [];
    foreach ($post as $key => $value) {
        $temp = explode('_',$key);
        //var_dump($temp);
        if($temp[0]=="vol"){
            if(array_key_exists($temp[1],$list)){
                $list[$temp[1]] += ['volume'=>$value];
            } else {
                $list[$temp[1]] = ['volume'=>$value];
            }
        } else if($temp[0]=="unitIndic"){
            if(array_key_exists($temp[1],$list)){
                $list[$temp[1]] += ['unit_indic'=>$value];
            } else {
                $list[$temp[1]] = ['unit_indic'=>$value];
            }
        } else if($temp[0]=="anVarVol"){
            if(array_key_exists($temp[1],$list)){
                $list[$temp[1]] += ['anVarVol'=>$value];
            } else {
                $list[$temp[1]] = ['anVarVol'=>$value];
            }
        } else if($temp[0]=="anVarCost"){
            if(array_key_exists($temp[1],$list)){
                $list[$temp[1]] += ['anVarCost'=>$value];
            } else {
                $list[$temp[1]] = ['anVarCost'=>$value];
            }
        } else if($temp[0]=="volRed"){
            if(array_key_exists($temp[1],$list)){
                $list[$temp[1]] += ['vol_red'=>$value];
            } else {
                $list[$temp[1]] = ['vol_red'=>$value];
            }
        } else if($temp[0]=="unitCostRed"){
            if(array_key_exists($temp[1],$list)){
                $list[$temp[1]] += ['unit_cost_red'=>$value];
            } else {
                $list[$temp[1]] = ['unit_cost_red'=>$value];
            }
        } else if($temp[0]=="unitCost"){
            if(array_key_exists($temp[1],$list)){
                $list[$temp[1]] += ['unit_cost'=>$value];
            } else {
                $list[$temp[1]] = ['unit_cost'=>$value];
            }
        }
    }
    return $list;
}

function delete_selection_quantifiable($projID=0,$ucID=0){
    $user = getUser($_SESSION['username']);
    if($projID!=0 and $ucID!=0){
        if(getProjByID($projID,$user[0]) and getUCByID($ucID)){
            deleteAllSelQuantifiable($projID,$ucID);
            header('Location: ?A=cost_benefits&A2=noncash&projID='.$projID.'&ucID='.$ucID);
        } else {
            header('Location: ?A=cost_benefits&A2=project');
        }
    } else {
        throw new Exception("There is no project or use case selected !");
    }
}


// ---------------------------------------- NON CASH ----------------------------------------

function noncash($twig,$is_connected,$projID=0,$ucID=0,$isTaken=false){
    $user = getUser($_SESSION['username']);
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            if($ucID!=0){
                if(getUCByID($ucID)){
                    $proj = getProjByID($projID,$user[0]);
                    $uc = getUCByID($ucID);
                    $list_noncash_advice = getListNonCashAdvice($ucID);   
                    $list_noncash_user = getListNonCashUser($projID,$ucID);    
                    $list_selNonCash = getListSelNonCash($projID,$ucID);          
                    //var_dump($list_selNonCash);
                    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/input/cost_benefits_steps/noncash.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project","selected"=>$proj[1],'part2'=>"Use Case",'selected2'=>$uc[1],'projID'=>$projID,'ucID'=>$ucID,"noncash_advice"=>$list_noncash_advice,"noncash_user"=>$list_noncash_user,'isTaken'=>$isTaken,'selNonCash'=>$list_selNonCash));
                    prereq_CostBenefits();
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

function create_noncash($twig,$is_connected,$post){
    if(isset($_SESSION['projID'])){
        $projID = $_SESSION['projID'];
        if(isset($_SESSION['ucID'])){
            $ucID = $_SESSION['ucID'];
            $name = $post['name'];
            $description = isset($post['description']) ? $post['description'] : "";
            $noncash_infos = ["name"=>$name,"description"=>$description];
            //var_dump(getNonCashUserItem($projID,$ucID,$name));
            if(!empty(getNonCashUserItem($projID,$ucID,$name))){
                header('Location: ?A=cost_benefits&A2=noncash&projID='.$projID.'&ucID='.$ucID.'&isTaken=true');
            } else {
                insertNonCashUser($projID,$ucID,$noncash_infos);
                header('Location: ?A=cost_benefits&A2=noncash&projID='.$projID.'&ucID='.$ucID);
            }
        } else {
            throw new Exception("There is no UC selected !");
        }
    } else {
        throw new Exception("There is no Project selected !");
    }
}

function delete_noncash_user($idNonCash){
    //var_dump(intval($idNonCash));
    if(isset($_SESSION['projID'])){
        $projID = $_SESSION['projID'];
        if(isset($_SESSION['ucID'])){
            $ucID = $_SESSION['ucID'];
            deleteNonCashUser(intval($idNonCash));
            header('Location: ?A=cost_benefits&A2=noncash&projID='.$projID.'&ucID='.$ucID);
        } else {
            throw new Exception("There is no UC selected !");
        }
    } else {
        throw new Exception("There is no Project selected !");
    }
}

function noncash_selected($twig,$is_connected,$post=[]){
    if($post){
        if(isset($_SESSION['projID'])){
            $projID = $_SESSION['projID'];
            if(isset($_SESSION['ucID'])){
                $ucID = $_SESSION['ucID'];
                $selNonCash = [];
                foreach ($post as $id => $value) {
                    array_push($selNonCash,$id);
                }
                $selNonCash_old = getListSelNonCash($projID,$ucID);
                $selNonCash_old_id = getKeys($selNonCash_old);
                $selNonCash_diff_rm = array_diff($selNonCash_old_id,$selNonCash);
                $selNonCash_diff_add = array_diff($selNonCash,$selNonCash_old_id);
                //var_dump($selNonCash_diff_rm);
                //var_dump($selNonCash_diff_add);
                if(empty($selNonCash_old)){
                    insertSelNonCash($projID,$ucID,$selNonCash);
                } else if (!empty($selNonCash_old)) {
                    deleteSelNonCash($projID,$ucID,$selNonCash_diff_rm);
                    insertSelNonCash($projID,$ucID,$selNonCash_diff_add);
                }
                update_ModifDate_proj($projID);
                updateCB($projID,0);
                noncash_input($twig,$is_connected,$projID,$ucID);
            } else {
                throw new Exception("There is no UC selected !");
            }
        } else {
            throw new Exception("There is no Project selected !");
        }
    } else {
        throw new Exception("No NonCash item selected !");
    }
}

function noncash_input($twig,$is_connected,$projID=0,$ucID=0){
    $user = getUser($_SESSION['username']);
    if($projID!=0 and $ucID!=0){
        if(getProjByID($projID,$user[0]) and getUCByID($ucID)){
            $proj = getProjByID($projID,$user[0]);
            $uc = getUCByID($ucID);
            $list_selNonCash = getListSelNonCash($projID,$ucID);
            //var_dump($list_selNonCash);
            $list_noncash_advice = getListNonCashAdvice($ucID); 
            //$list_sel_noncash_advice = getListSelByType($list_selNonCash,$list_noncash_advice);
            //var_dump($list_sel_noncash_advice);
            $list_noncash_user = getListNonCashUser($projID,$ucID);
            $compo = getCompoByUC($ucID);
            
            $nb_compo = 0;
            $selectedZones = getListSelZones($projID);
            foreach ($selectedZones as $key => $value) {
                if (!hasChildren($key,$selectedZones)) {
                    $nb_compo += getNbTotalCompoForSelectedZone($compo['id'], $key);
                }
                
            } 
            $nb_uc = getNbTotalUC($projID,$ucID);
            //var_dump($list_ratio);
            $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/input/cost_benefits_steps/noncash_input.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project","selected"=>$proj[1],'part2'=>"Use Case",'selected2'=>$uc[1],'projID'=>$projID,'ucID'=>$ucID,"noncash_advice"=>$list_noncash_advice,"noncash_user"=>$list_noncash_user,"selNonCash"=>$list_selNonCash,'compo'=>$compo,'nb_compo'=>$nb_compo,'nb_uc'=>$nb_uc));
            prereq_CostBenefits();
        } else {
            header('Location: ?A=cost_benefits&A2=project');
        }
    } else {
        throw new Exception("There is no project or use case selected !");
    }
}

function noncash_inputed($post){
    if($post){
        if(isset($_SESSION['projID'])){
            $projID = $_SESSION['projID'];
            if(isset($_SESSION['ucID'])){
                $ucID = $_SESSION['ucID'];
                $list = getListNonCashFromPost($post);
                insertNonCashInputed($projID,$ucID,$list);
                update_ModifDate_proj($projID);
                updateCB($projID,0);
                header('Location: ?A=cost_benefits&A2=risks&projID='.$projID.'&ucID='.$ucID);
            } else {
                throw new Exception("There is no UC selected !");
            }
        } else {
            throw new Exception("There is no Project selected !");
        }
    } else {
        throw new Exception("There is no data input !");
    }
}

function getListNonCashFromPost($post){
    $list = [];
    foreach ($post as $key => $value) {
        $temp = explode('_',$key);
        //var_dump($temp);
        if($temp[0]=="impact"){
            if(array_key_exists($temp[1],$list)){
                $list[$temp[1]] += ['exp_impact'=>$value];
            } else {
                $list[$temp[1]] = ['exp_impact'=>$value];
            }
        } else if($temp[0]=="prob"){
            if(array_key_exists($temp[1],$list)){
                $list[$temp[1]] += ['prob'=>$value];
            } else {
                $list[$temp[1]] = ['prob'=>$value];
            }
        } 
    }
    return $list;
}

function delete_selection_noncash($projID=0,$ucID=0){
    $user = getUser($_SESSION['username']);
    if($projID!=0 and $ucID!=0){
        if(getProjByID($projID,$user[0]) and getUCByID($ucID)){
            deleteAllSelNonCash($projID,$ucID);
            header('Location: ?A=cost_benefits&A2=risks&projID='.$projID.'&ucID='.$ucID);
        } else {
            header('Location: ?A=cost_benefits&A2=project');
        }
    } else {
        throw new Exception("There is no project or use case selected !");
    }
}


// ---------------------------------------- RISKS ----------------------------------------

function risks($twig,$is_connected,$projID=0,$ucID=0,$isTaken=false){
    $user = getUser($_SESSION['username']);
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            if($ucID!=0){
                if(getUCByID($ucID)){
                    $proj = getProjByID($projID,$user[0]);
                    $uc = getUCByID($ucID);
                    $list_risks_advice = getListRisksAdvice($ucID);   
                    $list_risks_user = getListRiskUser($projID,$ucID);    
                    $list_selRisks = getListSelRisks($projID,$ucID);          
                    //var_dump($list_selRisks);
                    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/input/cost_benefits_steps/risks.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project","selected"=>$proj[1],'part2'=>"Use Case",'selected2'=>$uc[1],'projID'=>$projID,'ucID'=>$ucID,"risks_advice"=>$list_risks_advice,"risks_user"=>$list_risks_user,'isTaken'=>$isTaken,'selRisks'=>$list_selRisks));
                    prereq_CostBenefits();
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

function create_risk($twig,$is_connected,$post){
    if(isset($_SESSION['projID'])){
        $projID = $_SESSION['projID'];
        if(isset($_SESSION['ucID'])){
            $ucID = $_SESSION['ucID'];
            $name = $post['name'];
            $description = isset($post['description']) ? $post['description'] : "";
            $risks_infos = ["name"=>$name,"description"=>$description];
            //var_dump(getRiskUserItem($projID,$ucID,$name));
            if(!empty(getRiskUserItem($projID,$ucID,$name))){
                header('Location: ?A=cost_benefits&A2=risks&projID='.$projID.'&ucID='.$ucID.'&isTaken=true');
            } else {
                insertRiskUser($projID,$ucID,$risks_infos);
                header('Location: ?A=cost_benefits&A2=risks&projID='.$projID.'&ucID='.$ucID);
            }
        } else {
            throw new Exception("There is no UC selected !");
        }
    } else {
        throw new Exception("There is no Project selected !");
    }
}

function delete_risk_user($idRisk){
    //var_dump(intval($idRisk));
    if(isset($_SESSION['projID'])){
        $projID = $_SESSION['projID'];
        if(isset($_SESSION['ucID'])){
            $ucID = $_SESSION['ucID'];
            deleteRiskUser(intval($idRisk));
            header('Location: ?A=cost_benefits&A2=risks&projID='.$projID.'&ucID='.$ucID);
        } else {
            throw new Exception("There is no UC selected !");
        }
    } else {
        throw new Exception("There is no Project selected !");
    }
}

function risks_selected($twig,$is_connected,$post=[]){
    if($post){
        if(isset($_SESSION['projID'])){
            $projID = $_SESSION['projID'];
            if(isset($_SESSION['ucID'])){
                $ucID = $_SESSION['ucID'];
                $selRisks = [];
                foreach ($post as $id => $value) {
                    array_push($selRisks,$id);
                }
                $selRisks_old = getListSelRisks($projID,$ucID);
                $selRisks_old_id = getKeys($selRisks_old);
                $selRisks_diff_rm = array_diff($selRisks_old_id,$selRisks);
                $selRisks_diff_add = array_diff($selRisks,$selRisks_old_id);
                //var_dump($selRisks_diff_rm);
                //var_dump($selRisks_diff_add);
                if(empty($selRisks_old)){
                    insertSelRisk($projID,$ucID,$selRisks);
                } else if (!empty($selRisks_old)) {
                    deleteSelRisk($projID,$ucID,$selRisks_diff_rm);
                    insertSelRisk($projID,$ucID,$selRisks_diff_add);
                }
                update_ModifDate_proj($projID);
                updateCB($projID,0);
                risks_input($twig,$is_connected,$projID,$ucID);
            } else {
                throw new Exception("There is no UC selected !");
            }
        } else {
            throw new Exception("There is no Project selected !");
        }
    } else {
        throw new Exception("No Risk item selected !");
    }
}

function risks_input($twig,$is_connected,$projID=0,$ucID=0){
    $user = getUser($_SESSION['username']);
    if($projID!=0 and $ucID!=0){
        if(getProjByID($projID,$user[0]) and getUCByID($ucID)){
            $proj = getProjByID($projID,$user[0]);
            $uc = getUCByID($ucID);
            $list_selRisks = getListSelRisks($projID,$ucID);
            //var_dump($list_selRisks);
            $list_risks_advice = getListRisksAdvice($ucID); 
            $list_sel_risks_advice = getListSelByType($list_selRisks,$list_risks_advice);
            //var_dump($list_sel_risks_advice);
            $list_risks_user = getListRiskUser($projID,$ucID);
            $compo = getCompoByUC($ucID);
            
            $nb_compo = 0;
            $selectedZones = getListSelZones($projID);
            foreach ($selectedZones as $key => $value) {
                if (!hasChildren($key,$selectedZones)) {
                    $nb_compo += getNbTotalCompoForSelectedZone($compo['id'], $key);
                }
                
            } 
            $nb_uc = getNbTotalUC($projID,$ucID);
            //var_dump($list_ratio);
            $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/input/cost_benefits_steps/risks_input.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project","selected"=>$proj[1],'part2'=>"Use Case",'selected2'=>$uc[1],'projID'=>$projID,'ucID'=>$ucID,"risks_advice"=>$list_risks_advice,"risks_user"=>$list_risks_user,"selRisks"=>$list_selRisks,'compo'=>$compo,'nb_compo'=>$nb_compo,'nb_uc'=>$nb_uc));
            prereq_CostBenefits();
        } else {
            header('Location: ?A=cost_benefits&A2=project');
        }
    } else {
        throw new Exception("There is no project or use case selected !");
    }
}

function risks_inputed($post){
    if($post){
        if(isset($_SESSION['projID'])){
            $projID = $_SESSION['projID'];
            if(isset($_SESSION['ucID'])){
                $ucID = $_SESSION['ucID'];
                $list = getListRiskFromPost($post);
                insertRiskInputed($projID,$ucID,$list);
                update_ModifDate_proj($projID);
                updateCB($projID,0);
                header('Location: ?A=cost_benefits&A2=summary&projID='.$projID.'&ucID='.$ucID);
            } else {
                throw new Exception("There is no UC selected !");
            }
        } else {
            throw new Exception("There is no Project selected !");
        }
    } else {
        throw new Exception("There is no data input !");
    }
}

function getListRiskFromPost($post){
    $list = [];
    foreach ($post as $key => $value) {
        $temp = explode('_',$key);
        //var_dump($temp);
        if($temp[0]=="impact"){
            if(array_key_exists($temp[1],$list)){
                $list[$temp[1]] += ['exp_impact'=>$value];
            } else {
                $list[$temp[1]] = ['exp_impact'=>$value];
            }
        } else if($temp[0]=="prob"){
            if(array_key_exists($temp[1],$list)){
                $list[$temp[1]] += ['prob'=>$value];
            } else {
                $list[$temp[1]] = ['prob'=>$value];
            }
        } 
    }
    return $list;
}

function delete_selection_risks($projID=0,$ucID=0){
    $user = getUser($_SESSION['username']);
    if($projID!=0 and $ucID!=0){
        if(getProjByID($projID,$user[0]) and getUCByID($ucID)){
            deleteAllSelRisks($projID,$ucID);
            header('Location: ?A=cost_benefits&A2=summary&projID='.$projID.'&ucID='.$ucID);
        } else {
            header('Location: ?A=cost_benefits&A2=project');
        }
    } else {
        throw new Exception("There is no project or use case selected !");
    }
}



// ---------------------------------------- SUMMARY ----------------------------------------

function summary($twig,$is_connected,$projID=0,$confirm=0){
    $user = getUser($_SESSION['username']);
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            if(isset($_SESSION['ucID'])){
                unset($_SESSION['ucID']);
            }
            $proj = getProjByID($projID,$user[0]);
            $list_measures = getListMeasures();
            $list_ucs = getListUCs();
            $selScope = getListSelScope($projID);
            $check = checkCBInputs($projID,$selScope);
            $list_checks = $check[0];
            $isValid = $check[1];
            if($confirm==1){
                updateCB($projID,1);
            }
            $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/input/cost_benefits_steps/summary.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project","selected"=>$proj[1],'projID'=>$projID,'meas'=>$list_measures,'ucs'=>$list_ucs,'selScope'=>$selScope,'list_checks'=>$list_checks,'isValid'=>$isValid,'confirm'=>$confirm));
            prereq_CostBenefits();
        } else {
            throw new Exception("This Project doesn't exist !");
        }
    } else {
        header('Location: ?A=cost_benefits&A2=use_case_cb');
    }
}

function checkCBInputs($projID,$scope){
    $list = [];
    $ret = true;
    foreach ($scope as $id_meas => $list_ucs) {
        foreach ($list_ucs as $ucID) {
            $capex = checkCapex($projID,$ucID);
            $implem = checkImplem($projID,$ucID);
            $opex = checkOpex($projID,$ucID);
            $revenues = checkRevenues($projID,$ucID);
            $cashreleasing = checkCashReleasing($projID,$ucID);
            $widercash = checkWiderCash($projID,$ucID);
            $quantifiable = checkQuantifiable($projID,$ucID);
            $noncash = checkNonCash($projID,$ucID);
            $risks = checkRisks($projID,$ucID);
            $list[$ucID] = ['capex'=>$capex,'implem'=>$implem,'opex'=>$opex,'revenues'=>$revenues,'cashreleasing'=>$cashreleasing,'widercash'=>$widercash,'quantifiable'=>$quantifiable,'noncash'=>$noncash,'risks'=>$risks];
            if(in_array(0,$list[$ucID])){
                $ret = false;
            }
        }
    }
    return [$list,$ret];
}


// ---------------------------------------- FILLING CHECKS ----------------------------------------
function checkCapex($projID,$ucID){
    $listSel = getListSelCapex($projID,$ucID);
    if(!empty($listSel)){
        echo "<script>checkProgress('capex');</script>";
        return 1;
    } else {
        return 2;
    }
}

function checkImplem($projID,$ucID){
    $listSel = getListSelImplem($projID,$ucID);
    if(!empty($listSel)){
        echo "<script>checkProgress('implem');</script>";
        return 1;
    } else {
        return 2;
    }
}

function checkOpex($projID,$ucID){
    $listSel = getListSelOpex($projID,$ucID);
    if(!empty($listSel)){
        echo "<script>checkProgress('opex');</script>";
        return 1;
    } else {
        return 2;
    }
}

function checkRevenues($projID,$ucID){
    $listSel = getListSelRevenues($projID,$ucID);
    if(!empty($listSel)){
        echo "<script>checkProgress('revenues');</script>";
        return 1;
    } else {
        return 2;
    }
}

function checkCashReleasing($projID,$ucID){
    $listSel = getListSelCashReleasing($projID,$ucID);
    if(!empty($listSel)){
        echo "<script>checkProgress('crb');</script>";
        return 1;
    } else {
        return 2;
    }
}

function checkWiderCash($projID,$ucID){
    $listSel = getListSelWiderCash($projID,$ucID);
    if(!empty($listSel)){
        echo "<script>checkProgress('wcb');</script>";
        return 1;
    } else {
        return 2;
    }
}

function checkQuantifiable($projID,$ucID){
    $listSel = getListSelQuantifiable($projID,$ucID);
    if(!empty($listSel)){
        echo "<script>checkProgress('quantif');</script>";
        return 1;
    } else {
        return 2;
    }
}

function checkNonCash($projID,$ucID){
    $listSel = getListSelNonCash($projID,$ucID);
    if(empty($listSel)){
        return 2;
    } else {
        foreach ($listSel as $key => $value) {
            if($value['exp_impact']==0){
                return 0;
            }
        }
        echo "<script>checkProgress('ncb');</script>";
        return 1;
    }
}

function checkRisks($projID,$ucID){
    $listSel = getListSelRisks($projID,$ucID);
    if(empty($listSel)){
        return 2;
    } else {
        foreach ($listSel as $key => $value) {
            if($value['exp_impact']==0){
                return 0;
            }
        }
        echo "<script>checkProgress('risks');</script>";
        return 1;
    }
}


// ---------------------------------------- CHECK PRE-REQ ----------------------------------------
function prereq_CostBenefits(){
    checkProgress();
    if(isset($_SESSION['projID'])){
        $projID = $_SESSION['projID'];
            echo "<script>prereq_CostBenefits1(true);</script>";
        if(isset($_SESSION['ucID'])){
            $ucID = $_SESSION['ucID'];
            $revSchedule = getRevenuesSchedule($projID,$ucID);
            $hasSchedule = !$revSchedule ? $revSchedule : true;
                echo "<script>prereq_CostBenefits2(true,".$hasSchedule.");</script>";
        }
    }
}

// ----------------------------------------- PROGRESS ---------------------------------------------
function checkProgress(){
    if(isset($_SESSION['projID'])){
        $projID = $_SESSION['projID'];
        echo "<script>checkProgress('project');</script>";
        if(isset($_SESSION['ucID'])){
            $ucID = $_SESSION['ucID'];
            echo "<script>checkProgress('uc');</script>";
            checkCapex($projID,$ucID);
            checkImplem($projID,$ucID);
            checkOpex($projID,$ucID);
            checkRevenues($projID,$ucID);
            checkCashReleasing($projID,$ucID);
            checkWiderCash($projID,$ucID);
            checkQuantifiable($projID,$ucID);
            checkNonCash($projID,$ucID);
            checkRisks($projID,$ucID);
    }
}
}