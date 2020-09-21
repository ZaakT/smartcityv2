<?php

require_once('model/model.php');

// -- Input Project Common
function prereq_ipc($nb){
    if(isset($_GET['A2'])){
        echo "<script>prereq_ipc($nb);</script>";
    }
}

function getListUcID($_ucID, $projID){
    if($_ucID==0){
        $listUcID=[];
        $listUcs = getListSelScope($projID);
        
        foreach ($listUcs as  $meas) {
            
            foreach ($meas as $ucID) {
                array_push($listUcID, $ucID);
            }
        }
    }else{
        $listUcID=[$_ucID];
    }
    return $listUcID;
}

function getUcsName($listUcID){
    $listUcs=getListUCs();
    $listUcsName = [];
    foreach ($listUcID as $ucID) {
        $listUcsName[$ucID]=$listUcs[$ucID]['name'];
    }
    return $listUcsName;
}

function sideFilter($xpexList, $side){
    $res = [];
    foreach ($xpexList as $key => $xpex) {
        var_dump($xpex);
        if($xpex['side']==$side){
            $res[$key]=$xpex;
        }
    }
    return $res;
}

function xpex_selection($twig,$is_connected,$projID, $_ucID, $sideBarName, $type="capex", $side,$isTaken=false){
    //Permet d'afficher la page de séléction des capex ou opex. Le paramètre "$type" permet de choisir si il s'agit d'opex ou de capex.
    //If ucID == 0 => we are locking ALL the UC of the project.
    //var_dump($_ucID);
    $user = getUser($_SESSION['username']);
    $_SESSION['_ucID']= $_ucID;
    if($_ucID==-1){$_SESSION['ucID'] = $_ucID;}
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            $listUcID=getListUcID($_ucID, $projID);
            $listUcsName = getUcsName($listUcID);

            $list_xpex_advice_from_ntt = [];
            $list_xpex_advice_from_outside_ntt = [];
            $list_xpex_advice_internal = [];

            $list_xpex_user_from_ntt = [];    
            $list_xpex_user_from_outside_ntt = [];
            $list_xpex_user_internal = []; 

            $list_selXpex = []; 
            $proj = getProjByID($projID,$user[0]);
            foreach ($listUcID as $ucID) {
                if(getUCByID($ucID)){
                    $uc = getUCByID($ucID);
                    if($type=="capex"){
                        
                        $list_xpex_advice_from_ntt[$ucID] = getListCapexAdvice($ucID, "from_ntt", $side); 
                        $list_xpex_advice_from_outside_ntt[$ucID]  = getListCapexAdvice($ucID, "from_outside_ntt", $side); 
                        $list_xpex_advice_internal[$ucID]  = getListCapexAdvice($ucID, "internal", $side); 

                        $list_xpex_user_from_ntt[$ucID]   = getListCapexUser($projID,$ucID, "from_ntt", $side);  
                        $list_xpex_user_from_outside_ntt[$ucID]  = getListCapexUser($projID,$ucID, "from_outside_ntt", $side); 
                        $list_xpex_user_internal[$ucID]   = getListCapexUser($projID,$ucID, "internal", $side); 
 
                        $list_selXpex[$ucID] = getListSelCapex($projID,$ucID); 
                    }elseif($type=="opex"){
                        $list_xpex_advice_from_ntt[$ucID]  = getListOpexAdvice($ucID, "from_ntt", $side); 
                        $list_xpex_advice_from_outside_ntt[$ucID]  = getListOpexAdvice($ucID, "from_outside_ntt", $side); 
                        $list_xpex_advice_internal[$ucID]  = getListOpexAdvice($ucID, "internal", $side); 

                        $list_xpex_user_from_ntt[$ucID]   = getListOpexUser($projID,$ucID, "from_ntt", $side);    
                        $list_xpex_user_from_outside_ntt[$ucID]   = getListOpexUser($projID,$ucID, "from_outside_ntt", $side); 
                        $list_xpex_user_internal[$ucID]   = getListOpexUser($projID,$ucID, "internal", $side); 

                        $list_selXpex[$ucID]  = getListSelOpex($projID,$ucID); 
                    }elseif($type=="deployment_costs"){
                        $list_xpex_advice_from_ntt[$ucID]  = getListImplemAdvice($ucID, "from_ntt", $side); 
                        $list_xpex_advice_from_outside_ntt[$ucID]  = getListImplemAdvice($ucID, "from_outside_ntt", $side); 
                        $list_xpex_advice_internal[$ucID]  = getListImplemAdvice($ucID, "internal", $side); 

                        $list_xpex_user_from_ntt[$ucID]  = getListImplemUser($projID,$ucID, "from_ntt", $side);    
                        $list_xpex_user_from_outside_ntt[$ucID]   = getListImplemUser($projID,$ucID, "from_outside_ntt", $side); 
                        $list_xpex_user_internal[$ucID]  = getListImplemUser($projID,$ucID, "internal", $side); 
                        
                        $list_selXpex[$ucID]  = getListSelImplem($projID,$ucID); 
                    }else{
                        throw new Exception("Wrong type.");
                    }
                } else {
                    throw new Exception("This use case doesn't exist !");
                }
            }
            if(count($listUcID)!=1){
                $ucID = 0;
            }else{
                $ucID = $listUcID[0];
            }
            $devises = getListDevises();
            $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
            $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
            //print_r($list_xpex_advice_from_outside_ntt);
            echo $twig->render('/input/input_project_common_steps/xpex_selection.twig',array('is_connected'=>$is_connected,'devises'=>$devises,
            'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project","selected"=>$proj[1],
            'part2'=>"Use Case",'selected2'=>$uc[1], 'projID'=>$projID, 'ucID'=>$ucID,
            "xpex_advice_from_ntt"=>$list_xpex_advice_from_ntt,"xpex_advice_from_outside_ntt"=>$list_xpex_advice_from_outside_ntt,"xpex_advice_internal"=>$list_xpex_advice_internal,
            "xpex_user_from_ntt"=>$list_xpex_user_from_ntt,"xpex_user_from_outside_ntt"=>$list_xpex_user_from_outside_ntt,"xpex_user_internal"=>$list_xpex_user_internal,
            'isTaken'=>$isTaken,'selXpex'=>$list_selXpex, 'type'=>$type, 'projID'=>$projID, "sideBarName"=>$sideBarName, "listUcID"=>$listUcID, "listUcsName"=>$listUcsName ));
            prereq_ipc(1);
            prereq_CostBenefits();

        } else {
            throw new Exception("This Project doesn't exist !");
        }
    } else {
        header('Location: ?A=input_project_common&A2=project_selection');
    }
}

function xpex_selected($twig,$is_connected,$post, $type, $sideBarName, $side){
    if($post){
        if(isset($_SESSION['projID'])){
            $projID = $_SESSION['projID'];
            if(isset($_SESSION['_ucID'])){
                $_ucID = $_SESSION['_ucID'];
            }else{
                $_ucID = 0;
            }
            $listUcID=getListUcID($_ucID, $projID);

            $selXpex = [];
            
            foreach ($listUcID as $ucID){//initalization of $selXpex
                $selXpex[$ucID]=[];
            }
            foreach ($post as $id => $value) {
                $id=explode('_', $id);
                array_push($selXpex[$id[0]],$id[1]);
            }
            foreach ($listUcID as $ucID) {

                if($type=="capex"){
                    $selXpex_old = getListSelCapex($projID,$ucID);
                    
                }elseif($type=="opex"){
                    $selXpex_old = getListSelOpex($projID,$ucID);
                }elseif($type=="deployment_costs"){
                    $selXpex_old = getListSelImplem($projID,$ucID);
                }
                $selXpex_old_id = getKeys($selXpex_old);
                $selXpex_diff_rm = array_diff($selXpex_old_id,$selXpex[$ucID]);

                $selXpex_diff_add = array_diff($selXpex[$ucID],$selXpex_old_id);

                if(empty($selXpex_old)){
                    if($type=="capex"){
                        insertSelCapex($projID,$ucID,$selXpex[$ucID]);
                    }elseif($type=="opex"){
                        insertSelOpex($projID,$ucID,$selXpex[$ucID]);
                    }elseif($type=="deployment_costs"){
                        insertSelImplem($projID,$ucID,$selXpex[$ucID]);
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
            }
            
            update_ModifDate_proj($projID);
            $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
            xpex_input($twig,$is_connected,$projID,$listUcID, $type, $sideBarName);
            //updateCB($projID,0);
             
        } else {
            throw new Exception("There is no Project selected !");
        }
    } else {
        throw new Exception("No Xpex item selected !");
    }
}


function xpex_input($twig,$is_connected,$projID=0,$listUcID, $type="capex", $sideBarName){
    /* 
    INPUT:  ID du projet, et id du UC
    OUTPUT: capex_input.twig
    user = id, username, is_admin
    proj = name description discount_rate weight_bank weight_bank_soc creation_date modif_date id_user scoping cb
    uc = id name description id_meas id_cat
    list_selCapex = id_item,unit_cost,volume,period
    
    */
        $user = getUser($_SESSION['username']);
        if($projID!=0){
            if(getProjByID($projID,$user[0])){
                $proj = getProjByID($projID,$user[0]);
                
                $nb_uc= [];

                $listUcsName = getUcsName($listUcID);
                

                $list_xpex_advice = []; 
                $list_xpex_user = [];   
                $list_selXpex = [];

                $list_xpex_advice_from_ntt = [];
                $list_xpex_advice_from_outside_ntt = [];
                $list_xpex_advice_internal = [];

                $list_xpex_user_from_ntt  = [];    
                $list_xpex_user_from_outside_ntt  = [];
                $list_xpex_user_internal  = [];
            


                $list_selXpex = [];

                $list_sel_xpex_advice = [];
                foreach ($listUcID as $ucID) {
                    $uc = getUCByID($ucID);
                    if($type=="capex"){
                            
                        $list_xpex_advice[$ucID] = getListCapexAdvice($ucID); 
                        $list_xpex_user[$ucID] = getListCapexUser($projID,$ucID);    
                        $list_selXpex[$ucID] = getListSelCapex($projID,$ucID);

                        $list_xpex_advice_from_ntt[$ucID] = getListCapexAdvice($ucID, "from_ntt"); 
                        $list_xpex_advice_from_outside_ntt[$ucID] = getListCapexAdvice($ucID, "from_outside_ntt"); 
                        $list_xpex_advice_internal[$ucID] = getListCapexAdvice($ucID, "internal"); 

                        $list_xpex_user_from_ntt[$ucID] = getListCapexUser($projID,$ucID, "from_ntt");    
                        $list_xpex_user_from_outside_ntt[$ucID] = getListCapexUser($projID,$ucID, "from_outside_ntt"); 
                        $list_xpex_user_internal[$ucID] = getListCapexUser($projID,$ucID, "internal"); 

                        $list_selXpex[$ucID] = getListSelCapex($projID,$ucID); 
                    }elseif($type=="opex"){
                        $list_xpex_advice[$ucID] = getListOpexAdvice($ucID); 
                        $list_xpex_user[$ucID] = getListOpexUser($projID,$ucID);    
                        $list_selXpex[$ucID] = getListSelOpex($projID,$ucID); 

                        $list_xpex_advice_from_ntt[$ucID] = getListOpexAdvice($ucID, "from_ntt"); 
                        $list_xpex_advice_from_outside_ntt[$ucID] = getListOpexAdvice($ucID, "from_outside_ntt"); 
                        $list_xpex_advice_internal[$ucID] = getListOpexAdvice($ucID, "internal"); 

                        $list_xpex_user_from_ntt[$ucID] = getListOpexUser($projID,$ucID, "from_ntt");    
                        $list_xpex_user_from_outside_ntt[$ucID] = getListOpexUser($projID,$ucID, "from_outside_ntt"); 
                        $list_xpex_user_internal[$ucID] = getListOpexUser($projID,$ucID, "internal"); 

                        $list_selXpex[$ucID] = getListSelOpex($projID,$ucID); 
                    }elseif($type=="deployment_costs"){
                        $list_xpex_advice[$ucID] = getListImplemAdvice($ucID);
                        $list_xpex_user[$ucID] = getListImplemUser($projID,$ucID);     
                        $list_selXpex[$ucID] = getListSelImplem($projID,$ucID); 

                        $list_xpex_advice_from_ntt[$ucID] = getListImplemAdvice($ucID, "from_ntt"); 
                        $list_xpex_advice_from_outside_ntt[$ucID] = getListImplemAdvice($ucID, "from_outside_ntt"); 
                        $list_xpex_advice_internal[$ucID] = getListImplemAdvice($ucID, "internal"); 

                        $list_xpex_user_from_ntt[$ucID]  = getListImplemUser($projID,$ucID, "from_ntt");    
                        $list_xpex_user_from_outside_ntt[$ucID] = getListImplemUser($projID,$ucID, "from_outside_ntt"); 
                        $list_xpex_user_internal[$ucID]  = getListImplemUser($projID,$ucID, "internal"); 
                        
                        
                        $list_sel_xpex_advice[$ucID] = getListSelByType($list_selXpex[$ucID],$list_xpex_advice[$ucID]);
                    }else{
                        throw new Exception("Wrong type.");
                    }


                    $list_sel_xpex_advice[$ucID] = getListSelByType($list_selXpex[$ucID],$list_xpex_advice[$ucID]);
                    $compo = getCompoByUC($ucID);
        
   
        
                    $nb_uc[$ucID] = getNbTotalUC($projID,$ucID);
                        //var_dump($nb_uc);
                    $list_ratio[$ucID] = getRatioCompoCapex($list_sel_xpex_advice[$ucID],$compo['id']);
                        //var_dump($list_ratio);
                }
                $devises = getListDevises();

                if(count($listUcID)>1){
                    $ucID = 0;
                }else{
                    $ucID = $listUcID[0];
                }
               
                $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
                $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
                echo $twig->render('/input/input_project_common_steps/xpex_input.twig',array('is_connected'=>$is_connected,'devises'=>$devises,
                'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",
                "selected"=>$proj[1],'part2'=>"Use Case",'selected2'=>$uc[1],'projID'=>$projID,'ucID'=>$ucID,'selXpex'=>$list_selXpex, 
                "xpex_advice_from_ntt"=>$list_xpex_advice_from_ntt,"xpex_advice_from_outside_ntt"=>$list_xpex_advice_from_outside_ntt,"xpex_advice_internal"=>$list_xpex_advice_internal,
                "xpex_user_from_ntt"=>$list_xpex_user_from_ntt,"xpex_user_from_outside_ntt"=>$list_xpex_user_from_outside_ntt,"xpex_user_internal"=>$list_xpex_user_internal,
                'compo'=>$compo,'ratio'=>$list_ratio,'nb_uc'=>$nb_uc, 'type'=>$type,  "sideBarName"=> $sideBarName, "listUcID"=>$listUcID, "listUcsName"=>$listUcsName));
                prereq_ipc(1);
                prereq_CostBenefits();
            } else {
                header('Location: ?A=cost_benefits&A2=project');
            }
        } else {
            throw new Exception("There is no project or use case selected !");
        }
    }

function create_xpex($twig,$is_connected, $post,  $type, $sideBarName) {
    if(isset($_SESSION['projID'])){
        $projID = $_SESSION['projID'];
        if(isset($post['useCase'])){ //Input porject common
            $ucID = $post['useCase'];
        }
        elseif(isset($_SESSION['ucID'])){//When a Use Case has been selected in a menu
            $ucID = $_SESSION['ucID'];
        }else{
            throw new Exception("Please select a Use Case", 1);
        }
        $name = $post['name'];
        $description = isset($post['description']) ? $post['description'] : "";
        $origine = $post['origine'];
        $xpex_infos = ["name"=>$name,"description"=>$description];
        //echo $origine;

        //var_dump(getCapexUserItem($projID,$ucID,$name));
        if($name==''){
            throw new Exception("Incorrect name.");
        }
        if(!empty(getCapexUserItem($projID,$ucID,$name)) or !empty(getOpexUserItem($projID,$ucID,$name)) or !empty(getImplemUserItem($projID,$ucID,$name))){
            header('Location: ?A='.$sideBarName.'&A2='.$type.'&projID='.$projID.'&ucID='.$ucID.'&isTaken=true');
        } else {
            if($type=="capex"){
                insertCapexUser($projID,$ucID,$xpex_infos, $origine);
            }elseif($type=="opex"){
                insertOpexUser($projID,$ucID,$xpex_infos, $origine);
            }elseif($type=='deployment_costs'){
                insertImplemUser($projID,$ucID,$xpex_infos, $origine);
            }else{
                throw new Exception("Wrong type !");
            }
            header('Location: ?A='.$sideBarName.'&A2='.$type.'&projID='.$projID.'&ucID='.$ucID);
        }
        
    } else {
        throw new Exception("There is no Project selected !");
    }
}

function delete_xpex_user($idXpex, $type, $sideBarName){
    //var_dump(intval($idCapex));
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
            header('Location: ?A='.$sideBarName.'&A2='.$type.'&projID='.$projID.'&ucID='.$ucID);
        } else {
            throw new Exception("There is no UC selected !");
        }
    } else {
        throw new Exception("There is no Project selected !");
    }
}


function xpex_inputed($post, $sideBarName, $type){
    if($post){
        if(isset($_SESSION['projID'])){
            $projID = $_SESSION['projID'];
            if(isset($post['useCase'])){ //Input porject common
                $_ucID = $post['useCase'];
            }
            elseif(isset($_SESSION['_ucID'])){//When a Use Case has been selected in a menu
                $_ucID = $_SESSION['_ucID'];
            }else{
                throw new Exception("Please select a Use Case", 1);
            }
            $info= [];
            $listUcID=getListUcID($_ucID, $projID);
            foreach ($listUcID as $ucID){//initalization of $selXpex
                $info[$ucID]=[];
            }
            foreach ($post as $id => $value) {
                $id=explode('_', $id);
                $info[$id[2]]["$id[0]_$id[1]"]=$value;
            }
            
            foreach ($listUcID as $ucID) {
                $list = [];
                echo "<br> info[$ucID] :";print_r($info[$ucID]);
                foreach ($info[$ucID] as $key => $value) {
                    $temp = explode('_',$key);
                    $type=$_GET['A2'];
                    if($temp[0]=="vol"){
                        if(array_key_exists($temp[1],$list)){
                            $list[$temp[1]] += ['volume'=>$value];
                        } else {
                            $list[$temp[1]] = ['volume'=>$value];
                        }
                    } else if($temp[0]=="unitCost"){
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
                    }else{
                        throw new Exception("Error !");
                    }
                }

                if($type=="capex"){
                    insertCapexInputed($projID,$ucID,$list);
                }elseif($type=="opex"){
                    insertOpexInputed($projID,$ucID,$list);
                }elseif($type=="deployment_costs"){
                    insertImplemInputed($projID,$ucID,$list);
                }else{
                    throw new Exception("Wrong type !");
                }
            }
            update_ModifDate_proj($projID);
            if($sideBarName=="input_project_common" or $sideBarName=="input_project_common_supplier"){
                header('Location: ?A='.$sideBarName.'&A2='.$type.'&projID='.$projID.'&ucID='.$ucID);
            }elseif($sideBarName=="input_use_case" or $sideBarName=="cost_benefits"){
                if ($type == "capex"){
                    header('Location: ?A='.$sideBarName.'&A2=deployment_costs&projID='.$projID.'&ucID='.$ucID); 
                }
                elseif($type == "deployment_costs"){
                    header('Location: ?A='.$sideBarName.'&A2=opex&projID='.$projID.'&ucID='.$ucID); 
                }elseif($type == "opex"){
                    header('Location: ?A='.$sideBarName.'&A2=revenues&projID='.$projID.'&ucID='.$ucID); 
                }
            }

                
                

        } else {
            throw new Exception("There is no Project selected !");
        }
    } else {
        throw new Exception("There is no data input !");
    }
}


function delete_selection_xpex($projID=0,$ucID=0, $type, $sideBarName){
    $user = getUser($_SESSION['username']);
    if($projID!=0 and $ucID!=0){
        if(getProjByID($projID,$user[0]) and getUCByID($ucID)){
            if($type == "capex"){
                deleteAllSelCapex($projID,$ucID);
                header('Location: ?A='.$sideBarName.'&A2=deployment_costs&projID='.$projID.'&ucID='.$ucID);
            }elseif($type == "opex"){
                deleteAllSelOpex($projID,$ucID);
                header('Location: ?A='.$sideBarName.'&A2=revenues&projID='.$projID.'&ucID='.$ucID);
            }elseif($type == "deployment_costs"){
                deleteAllSelImplem($projID,$ucID);
                header('Location: ?A='.$sideBarName.'&A2=opex&projID='.$projID.'&ucID='.$ucID);
            }else{
                throw new Exception("Wrong type !");
            }
        } else {
            header('Location: ?A='.$sideBarName.'&A2=project');
        }
    } else {
        throw new Exception("There is no project or use case selected !");
    }
}