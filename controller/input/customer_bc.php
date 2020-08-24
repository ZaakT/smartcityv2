<?php

require_once('model/model.php');

// -- Input Project Common
function prereq_ipc($nb){
    if(isset($_GET['A2'])){
        echo "<script>prereq_ipc($nb);</script>";
    }
}


function xpex_selection($twig,$is_connected,$projID, $ucID, $type="capex",$isTaken=false){
    //Permet d'afficher la page de séléction des capex ou opex. Le paramètre "$type" permet de choisir si il s'agit d'opex ou de capex.
    $user = getUser($_SESSION['username']);
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            if($ucID!=0){
                if(getUCByID($ucID)){
                    $proj = getProjByID($projID,$user[0]);
                    $uc = getUCByID($ucID);
                    if($type=="capex"){
                        $list_xpex_advice = getListCapexAdvice($ucID); 
                        $list_xpex_user = getListCapexUser($projID,$ucID);    
                        $list_selXpex = getListSelCapex($projID,$ucID); 
                    }elseif($type=="opex"){
                        $list_xpex_advice = getListOpexAdvice($ucID); 
                        $list_xpex_user = getListOpexUser($projID,$ucID);    
                        $list_selXpex = getListSelOpex($projID,$ucID); 
                    }elseif($type=="deployment_costs"){
                        $list_xpex_advice = getListImplemAdvice($ucID);
                        $list_xpex_user = getListImplemUser($projID,$ucID);     
                        $list_selXpex = getListSelImplem($projID,$ucID); 
                    }else{
                        throw new Exception("Wrong type.");
                    }

                    $devises = getListDevises();
                    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
                    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
                    
                    echo $twig->render('/input/input_project_common_steps/xpex_selection.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project","selected"=>$proj[1],'part2'=>"Use Case",'selected2'=>$uc[1],'projID'=>$projID,'ucID'=>$ucID,"xpex_advice"=>$list_xpex_advice,"xpex_user"=>$list_xpex_user,'isTaken'=>$isTaken,'selXpex'=>$list_selXpex, 'type'=>$type, 'ucID'=>$ucID, 'projID'=>$projID));
                    prereq_ipc(1);
                } else {
                    throw new Exception("This Use Case doesn't exist !");
                }
            } else {
                header('Location: ?A=input_project_common&A2=use_case_selection');
            }
        } else {
            throw new Exception("This Project doesn't exist !");
        }
    } else {
        header('Location: ?A=input_project_common&A2=project_selection');
    }
}

function xpex_selected($twig,$is_connected,$post, $type){
    if($post){
        if(isset($_SESSION['projID'])){
            $projID = $_SESSION['projID'];
            if(isset($_SESSION['ucID'])){
                $ucID = $_SESSION['ucID'];
                $selXpex = [];
                foreach ($post as $id => $value) {
                    array_push($selXpex,$id);
                }
                if($type=="capex"){
                    $selXpex_old = getListSelCapex($projID,$ucID);
                }elseif($type=="opex"){
                    $selXpex_old = getListSelOpex($projID,$ucID);
                }elseif($type=="deployment_costs"){
                    $selXpex_old = getListSelImplem($projID,$ucID);
                }
                $selXpex_old_id = getKeys($selXpex_old);
                $selXpex_diff_rm = array_diff($selXpex_old_id,$selXpex);
                $selXpex_diff_add = array_diff($selXpex,$selXpex_old_id);
                if(empty($selXpex_old)){
                    if($type=="capex"){
                        insertSelCapex($projID,$ucID,$selXpex);
                    }elseif($type=="opex"){
                        insertSelOpex($projID,$ucID,$selXpex);
                    }elseif($type=="deployment_costs"){
                        insertSelImplem($projID,$ucID,$selXpex);
                    }
                } elseif (!empty($selXpex_old)) {
                    if($type=="capex"){
                        deleteSelCapex($projID,$ucID,$selXpex_diff_rm);
                        insertSelCapex($projID,$ucID,$selXpex_diff_add);
                    }elseif($type=="opex"){
                        deleteSelOpex($projID,$ucID,$selXpex_diff_rm);
                        insertSelOpex($projID,$ucID,$selXpex_diff_add);
                    }elseif($type=="deployment_costs"){
                        deleteSelImplem($projID,$ucID,$selXpex_diff_rm);
                        insertSelImplem($projID,$ucID,$selXpex_diff_add);
                    }
                }else {
                    throw new Exception("Wrong type.");
                }
                update_ModifDate_proj($projID);
                $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
                xpex_input($twig,$is_connected,$projID,$ucID, $type);
                updateCB($projID,0);
            } else {
                throw new Exception("There is no UC selected !");
            }
        } else {
            throw new Exception("There is no Project selected !");
        }
    } else {
        throw new Exception("No Xpex item selected !");
    }
}


function xpex_input($twig,$is_connected,$projID=0,$ucID=0, $type="capex"){
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


                if($type=="capex"){
                    $list_xpex_advice = getListCapexAdvice($ucID); 
                    $list_xpex_user = getListCapexUser($projID,$ucID);    
                    $list_selXpex = getListSelCapex($projID,$ucID); 
                    
                }elseif($type=="opex"){
                    $list_xpex_advice = getListOpexAdvice($ucID); 
                    $list_xpex_user = getListOpexUser($projID,$ucID);    
                    $list_selXpex = getListSelOpex($projID,$ucID); 
                }elseif($type=="deployment_costs"){
                    $list_xpex_advice = getListImplemAdvice($ucID);
                    $list_xpex_user = getListImplemUser($projID,$ucID);     
                    $list_selXpex = getListSelImplem($projID,$ucID); 
                }else{
                    throw new Exception("Wrong type.");
                }
                $list_sel_xpex_advice = getListSelByType($list_selXpex,$list_xpex_advice);
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
                $list_ratio = getRatioCompoCapex($list_sel_xpex_advice,$compo['id']);
                     //var_dump($list_ratio);
                $devises = getListDevises();
                
                $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
                $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
                
                echo $twig->render('/input/input_project_common_steps/xpex_input.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project","selected"=>$proj[1],'part2'=>"Use Case",'selected2'=>$uc[1],'projID'=>$projID,'ucID'=>$ucID,"xpex_advice"=>$list_xpex_advice,"xpex_user"=>$list_xpex_user,"selXpex"=>$list_selXpex,'compo'=>$compo,'ratio'=>$list_ratio,'nb_compo'=>$nb_compo,'nb_uc'=>$nb_uc, 'type'=>$type));
                prereq_ipc(1);
            } else {
                header('Location: ?A=cost_benefits&A2=project');
            }
        } else {
            throw new Exception("There is no project or use case selected !");
        }
    }

function create_xpex($twig,$is_connected, $post,  $type) {
    if(isset($_SESSION['projID'])){
        $projID = $_SESSION['projID'];
        if(isset($_SESSION['ucID'])){
            $ucID = $_SESSION['ucID'];
            $name = $post['name'];
            $description = isset($post['description']) ? $post['description'] : "";
            $xpex_infos = ["name"=>$name,"description"=>$description];
            //var_dump(getCapexUserItem($projID,$ucID,$name));
            echo $name;
            if($name==''){
                throw new Exception("Incorrect name.");
            }
            if(!empty(getCapexUserItem($projID,$ucID,$name)) or !empty(getOpexUserItem($projID,$ucID,$name)) or !empty(getImplemUserItem($projID,$ucID,$name))){
                header('Location: ?A=input_project_common&A2=capex&projID='.$projID.'&ucID='.$ucID.'&isTaken=true');
            } else {
                if($type=="capex"){
                    insertCapexUser($projID,$ucID,$xpex_infos);
                }elseif($type=="opex"){
                    insertOpexUser($projID,$ucID,$xpex_infos);
                }elseif($type=='deployment_costs'){
                    insertImplemUser($projID,$ucID,$xpex_infos);
                }else{
                    throw new Exception("Wrong type !");
                }
                header('Location: ?A=input_project_common&A2='.$type.'&projID='.$projID.'&ucID='.$ucID);
            }
        } else {
            throw new Exception("There is no UC selected !");
        }
    } else {
        throw new Exception("There is no Project selected !");
    }
}

function delete_xpex_user($idXpex, $type){
    //var_dump(intval($idCapex));
    echo $idXpex;
    if(isset($_GET['projID'])){
        $projID = $_GET['projID'];
        if(isset($_GET['ucID'])){
            $ucID = $_GET['ucID'];
            if($type=="capex"){
                deleteCapexUser(intval($idXpex));
            }elseif($type=="opex"){
                deleteOpexUser(intval($idXpex));
            }elseif($type=='deployment_costs'){
                deleteImplemUser(intval($idXpex));
            }else{
                throw new Exception("Wrong type !");
            }
            header('Location: ?A=input_project_common&A2='.$type.'&projID='.$projID.'&ucID='.$ucID);
        } else {
            throw new Exception("There is no UC selected !");
        }
    } else {
        throw new Exception("There is no Project selected !");
    }
}