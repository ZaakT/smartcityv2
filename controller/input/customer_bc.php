<?php

require_once('model/model.php');

// -- Input Project Common
function prereq_ipc($nb){
    if(isset($_GET['A2'])){
        echo "<script>prereq_ipc($nb);</script>";
    }
}
function selectCashIn_Out($type){

    echo "<script>selectCashIn_Out('$type');</script>";

}
function prereq_ipc_sup(){
    if(isset($_GET['A2'])){
        echo "<script>prereq_ipc_sup();</script>";
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

function sideFilter($xpexList, $side, $type){
    $res = [];
    foreach ($xpexList as $xpexID => $xpex) {
        if(getXpexSide($xpexID, $type)==$type){
            $res[$xpexID]=$xpex;
        }
    }
    return $res;
}



function xpex_selection($twig,$is_connected,$projID, $_ucID, $sideBarName, $type="capex", $side,$isTaken=false){
    //Permet d'afficher la page de séléction des capex ou opex. Le paramètre "$type" permet de choisir si il s'agit d'opex ou de capex.
    //If ucID == 0 => we are locking ALL the UC of the project.
    //var_dump($_ucID);
    $user = getUser($_SESSION['username']);
    $proj = getProjByID($projID,$user[0]);
    $_SESSION['_ucID']= $_ucID;
    if($_ucID==-1){$_SESSION['ucID'] = $_ucID;}
    if($projID!=0){
        if(getProjByID($projID,$user[0])){
            $listUcID=getListUcID($_ucID, $projID);
            $listUcsName = getUcsName($listUcID);

            $listXpex = getListXpex($listUcID, $type, $projID, $side);
            $list_xpex_advice = $listXpex[0];
            $list_xpex_user = $listXpex[1];
            $list_selXpex = $listXpex[2]; 
            $list_xpex_advice_from_ntt = $listXpex[3];
            $list_xpex_advice_from_outside_ntt = $listXpex[4];
            $list_xpex_advice_internal = $listXpex[5];
            
            $list_xpex_user_from_ntt = $listXpex[6];
            $list_xpex_user_from_outside_ntt = $listXpex[7];
            $list_xpex_user_internal = $listXpex[8];
            $list_xpex_supplier = $listXpex[9]; 
            $list_selXpex = $listXpex[10];
            $list_sel_xpex_advice = $listXpex[11];
            $nb_uc = $listXpex[12];
            $list_ratio = $listXpex[13];
            $uc = $listXpex[14];
            $list_xpex_cat = $listXpex[16]; 
            $list_xpex_cat_from_supplier =  $listXpex[17];


            if(count($listUcID)!=1){
                $ucID = 0;
            }else{
                $ucID = $listUcID[0];
            }
            //var_dump($list_xpex_advice_from_ntt);
            //var_dump($list_xpex_user_from_ntt);
            //var_dump($list_xpex_user_from_outside_ntt);
            //var_dump($list_xpex_user_internal);
            /*var_dump($list_xpex_supplier);
            //var_dump($list_xpex_user_from_ntt);
            //var_dump($list_selXpex);*/
            //var_dump($list_selXpex);
            //var_dump($list_xpex_user_from_ntt);
            $devises = getListDevises();
            //var_dump($list_xpex_advice_from_ntt, $list_xpex_advice_from_outside_ntt, $list_xpex_advice_internal);
            $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
            $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
            //print_r($list_xpex_advice_from_outside_ntt);
            $ucPrint = $ucID != -1 ? getSolutionByUcID($ucID)['name']." / ".$uc[1] : $uc[1];
            echo $twig->render('/input/input_project_common_steps/xpex_selection.twig',array('is_connected'=>$is_connected,'devises'=>$devises,
            'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project","selected"=>$proj[1],
            'part2'=>"Use Case",'selected2'=>$ucPrint, 'projID'=>$projID, 'ucID'=>$ucID,
            "xpex_advice_from_ntt"=>$list_xpex_advice_from_ntt,"xpex_advice_from_outside_ntt"=>$list_xpex_advice_from_outside_ntt,"xpex_advice_internal"=>$list_xpex_advice_internal,
            "xpex_user_from_ntt"=>$list_xpex_user_from_ntt,"xpex_user_from_outside_ntt"=>$list_xpex_user_from_outside_ntt,"xpex_user_internal"=>$list_xpex_user_internal,"xpex_supplier"=>$list_xpex_supplier,
            'isTaken'=>$isTaken,'selXpex'=>$list_selXpex, 'type'=>$type, 'projID'=>$projID, "sideBarName"=>$sideBarName, "listUcID"=>$listUcID, 
            "listUcsName"=>$listUcsName, "xpexCategories"=>$list_xpex_cat, "list_xpex_cat_from_supplier"=>$list_xpex_cat_from_supplier ));
            prereq_ipc(1);
            prereq_CostBenefits();
            prereq_ipc_sup();
            /*if( $type=="deployment_costs" || $type=="opex" || $type=="capex"){
                selectCashIn_Out("out");
            }elseif($type=="equipment_revenues" || $type =="deployment_revenues" || $type =="operating_revenues"){
                selectCashIn_Out("in");
            }*/


        } else {
            throw new Exception("This Project doesn't exist !");
        }
    } else {
        header('Location: ?A=project_sdesign&A2=project');
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
                }elseif($type=="revenuesProtection"){
                    $selXpex_old = getListSelRevenuesProtection($projID,$ucID);
                }elseif($type=="revenues"){
                    $selXpex_old = getListSelRevenues($projID,$ucID);
                }elseif($type=="cashreleasing"){
                    $selXpex_old = getListSelCashReleasing($projID,$ucID);
                }elseif($type=="widercash"){
                    $selXpex_old = getListSelWiderCash($projID,$ucID);
                }elseif($type=="quantifiable"){
                    $selXpex_old = getListSelQuantifiable($projID,$ucID);
                }elseif($type=="noncash"){
                    $selXpex_old = getListSelNonCash($projID,$ucID);
                }elseif($type=="risks"){
                    $selXpex_old = getListSelRisks($projID,$ucID);
                }elseif($type=='equipment_revenues' ||$type=="deployment_revenues" || $type=="operating_revenues"){
                    $selXpex_old = getListSelSupplierRevenues($projID,$ucID, explode('_',$type)[0]);
                }

                if(empty($selXpex_old)){
                    if($type=="capex"){
                        insertSelCapex($projID,$ucID,$selXpex[$ucID]);
                    }elseif($type=="opex"){
                        insertSelOpex($projID,$ucID,$selXpex[$ucID]);
                    }elseif($type=="deployment_costs"){
                        insertSelImplem($projID,$ucID,$selXpex[$ucID]);
                    }elseif($type=="revenuesProtection"){
                        insertSelRevenuesProtection($projID,$ucID,$selXpex[$ucID]);
                    }elseif($type=="revenues"){
                        insertSelRevenues($projID,$ucID,$selXpex[$ucID]);
                    }elseif($type=="cashreleasing"){
                        insertSelCashReleasing($projID,$ucID,$selXpex[$ucID]);
                    }elseif($type=="widercash"){
                        insertSelWiderCash($projID,$ucID,$selXpex[$ucID]);
                    }elseif($type=="quantifiable"){
                        insertSelQuantifiable($projID,$ucID,$selXpex[$ucID]);
                    }elseif($type=="noncash"){
                        insertSelNonCash($projID,$ucID,$selXpex[$ucID]);
                    }elseif($type=="risks"){
                        insertSelRisk($projID,$ucID,$selXpex[$ucID]);
                    }elseif($type=='equipment_revenues' ||$type=="deployment_revenues" || $type=="operating_revenues"){
                        insertSelSupplierRevenues($projID,$ucID,$selXpex[$ucID], explode('_',$type)[0]);
                    }

                } elseif (!empty($selXpex_old)) {
                    $selXpexToKeep = [];
                    //var_dump($selXpex[$ucID]);
                    if(($side=="supplier"||$side=="customer")&&($type=="capex"||$type=="opex"||$type=="deployment_costs")){
                        foreach($selXpex_old as $xpexID=>$value){
                            if(getXpexSide($xpexID, $type)!=$side){
                                array_push($selXpexToKeep, $xpexID);
                            }
                        }
                    }elseif($type=='equipment_revenues' ||$type=="deployment_revenues" || $type=="operating_revenues"){
                        foreach($selXpex_old as $xpexID=>$value){
                            if(getSupplierRevenueType($xpexID)!=explode('_',$type)[0]){
                                array_push($selXpexToKeep, $xpexID);
                            }
                        }
                    }


                    $selXpex_old_id = getKeys($selXpex_old);
                    $selXpex_diff_rm = array_diff($selXpex_old_id,array_merge($selXpex[$ucID], $selXpexToKeep));
    
                    $selXpex_diff_add = array_diff($selXpex[$ucID],$selXpex_old_id);

                    if($type=="capex"){
                        deleteSelCapex($projID,$ucID,$selXpex_diff_rm);
                        insertSelCapex($projID,$ucID,$selXpex_diff_add);
                    }elseif($type=="opex"){
                        deleteSelOpex($projID,$ucID,$selXpex_diff_rm);
                        insertSelOpex($projID,$ucID,$selXpex_diff_add);
                    }elseif($type=="deployment_costs"){
                        deleteSelImplem($projID,$ucID,$selXpex_diff_rm);
                        insertSelImplem($projID,$ucID,$selXpex_diff_add);
                    }elseif($type=="revenuesProtection"){
                        deleteSelRevenuesProtection($projID,$ucID,$selXpex_diff_rm);
                        insertSelRevenuesProtection($projID,$ucID,$selXpex_diff_add);
                    }elseif($type=="revenues"){
                        deleteSelRevenues($projID,$ucID,$selXpex_diff_rm);
                        insertSelRevenues($projID,$ucID,$selXpex_diff_add);
                    }elseif($type=="cashreleasing"){
                        deleteSelCashReleasing($projID,$ucID,$selXpex_diff_rm);
                        insertSelCashReleasing($projID,$ucID,$selXpex_diff_add);
                    }elseif($type=="widercash"){
                        deleteSelWiderCash($projID,$ucID,$selXpex_diff_rm);
                        insertSelWiderCash($projID,$ucID,$selXpex_diff_add);
                    }elseif($type=="quantifiable"){
                        deleteSelQuantifiable($projID,$ucID,$selXpex_diff_rm);
                        insertSelQuantifiable($projID,$ucID,$selXpex_diff_add);
                    }elseif($type=="noncash"){
                        deleteSelNonCash($projID,$ucID,$selXpex_diff_rm);
                        insertSelNonCash($projID,$ucID,$selXpex_diff_add);
                    }elseif($type=="risks"){
                        deleteSelRisks($projID,$ucID,$selXpex_diff_rm);
                        insertSelRisk($projID,$ucID,$selXpex_diff_add);
                    }elseif($type=='equipment_revenues' ||$type=="deployment_revenues" || $type=="operating_revenues"){
                        deleteSelSupplierRevenues($projID,$ucID,$selXpex_diff_rm, explode('_',$type)[0]);
                        insertSelSupplierRevenues($projID,$ucID,$selXpex_diff_add, explode('_',$type)[0]);
                    }
                }else {
                    throw new Exception("1 Wrong type.");
                }
            }
            
            update_ModifDate_proj($projID);
            $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
            xpex_input($twig,$is_connected,$projID,$listUcID, $type, $sideBarName, $side);
            //updateCB($projID,0);
             
        } else {
            throw new Exception("There is no Project selected !");
        }
    } else {
        throw new Exception("No Xpex item selected !");
    }
}


function getListXpex($listUcID, $type, $projID, $side){
    $xepx_cat_supplier_to_customer = ["capex"=>"equipment_revenues", "opex"=>"operating_revenues", "deployment_costs"=>"deployment_revenues"];

    $nb_uc= [];
    $list_xpex_advice = []; 
    $list_xpex_user = [];   
    $list_selXpex = [];

    $list_xpex_advice_from_ntt = [];
    $list_xpex_advice_from_outside_ntt = [];
    $list_xpex_advice_internal = [];

    $list_xpex_user_from_ntt  = [];    
    $list_xpex_user_from_outside_ntt  = [];
    $list_xpex_user_internal  = [];

    $list_xpex_supplier = []; //Used only In cutomer side to show xpex equivalent to supplier revenues
    $list_xpex_cat = [];


    $list_selXpex = [];

    $list_sel_xpex_advice = [];

    $list_xpex_cat_from_supplier = [];
    foreach ($listUcID as $ucID) {
        $uc = getUCByID($ucID);
        $list_xpex_supplier[$ucID]=[];
        $list_xpex_cat[$ucID] = getListXpexCat($type, $ucID,$side);
        if($side == "customer" && isset($xepx_cat_supplier_to_customer[$type])){
            $list_xpex_cat_from_supplier[$ucID] = getListXpexCat($xepx_cat_supplier_to_customer[$type], $ucID,"supplier");
        }
        if($type=="capex"){
                
            $list_xpex_advice[$ucID] = getListCapexAdvice($ucID, "all", "projDev"); 
            $list_xpex_user[$ucID] = getListCapexUser($projID,$ucID, "all", $side);    

            $list_xpex_advice_from_ntt[$ucID] = getListCapexAdvice($ucID, "from_ntt", "projDev"); 
            $list_xpex_advice_from_outside_ntt[$ucID] = getListCapexAdvice($ucID, "from_outside_ntt", $side); 
            $list_xpex_advice_internal[$ucID] = getListCapexAdvice($ucID, "internal", $side); 

            $list_xpex_user_from_ntt[$ucID] = getListCapexUser($projID,$ucID, "from_ntt", $side);    
            $list_xpex_user_from_outside_ntt[$ucID] = getListCapexUser($projID,$ucID, "from_outside_ntt", $side); 
            $list_xpex_user_internal[$ucID] = getListCapexUser($projID,$ucID, "internal", $side); 

            $list_selXpex[$ucID] = getListSelCapex($projID,$ucID, $side); 

            if($side == "customer"){
                //We need here to select the revenues of the supplier and transform it in xpex
                $list_xpex_supplier[$ucID] = getListXpexSupplier($ucID, $projID, $list_selXpex[$ucID], $type);
            }


        }elseif($type=="opex"){
            $list_xpex_advice[$ucID] = getListOpexAdvice($ucID, "all", "projDev"); 
            $list_xpex_user[$ucID] = getListOpexUser($projID,$ucID, "all", $side);    

            $list_xpex_advice_from_ntt[$ucID] = getListOpexAdvice($ucID, "from_ntt", "projDev"); 
            $list_xpex_advice_from_outside_ntt[$ucID] = getListOpexAdvice($ucID, "from_outside_ntt", $side); 
            $list_xpex_advice_internal[$ucID] = getListOpexAdvice($ucID, "internal", $side); 

            $list_xpex_user_from_ntt[$ucID] = getListOpexUser($projID,$ucID, "from_ntt", $side);    
            $list_xpex_user_from_outside_ntt[$ucID] = getListOpexUser($projID,$ucID, "from_outside_ntt", $side); 
            $list_xpex_user_internal[$ucID] = getListOpexUser($projID,$ucID, "internal", $side); 

            $list_selXpex[$ucID] = getListSelOpex($projID,$ucID, $side); 

            if($side == "customer"){
                //We need here to select the revenues of the supplier and transform it in xpex
                $list_xpex_supplier[$ucID] = getListXpexSupplier($ucID, $projID, $list_selXpex[$ucID], $type);
            }
        }elseif($type=="deployment_costs"){
            $list_xpex_advice[$ucID] = getListImplemAdvice($ucID, "all", "projDev");
            $list_xpex_user[$ucID] = getListImplemUser($projID,$ucID, "all", $side);     
            
            $list_xpex_advice_from_ntt[$ucID] = getListImplemAdvice($ucID, "from_ntt", "projDev"); 
            $list_xpex_advice_from_outside_ntt[$ucID] = getListImplemAdvice($ucID, "from_outside_ntt", $side); 
            $list_xpex_advice_internal[$ucID] = getListImplemAdvice($ucID, "internal", $side); 

            $list_xpex_user_from_ntt[$ucID]  = getListImplemUser($projID,$ucID, "from_ntt", $side);    
            $list_xpex_user_from_outside_ntt[$ucID] = getListImplemUser($projID,$ucID, "from_outside_ntt", $side); 
            $list_xpex_user_internal[$ucID]  = getListImplemUser($projID,$ucID, "internal", $side); 
            
            $list_selXpex[$ucID] = getListSelImplem($projID,$ucID, $side); 
            if($side == "customer"){
                //We need here to select the revenues of the supplier and transform it in xpex
                $list_xpex_supplier[$ucID] = getListXpexSupplier($ucID, $projID, $list_selXpex[$ucID], $type);
            }
        }elseif($type=="equipment_revenues" || $type =="deployment_revenues" || $type =="operating_revenues"){
            
            $list_xpex_advice_from_outside_ntt[$ucID]  = [];
            $list_xpex_advice_internal[$ucID]  = [];

            $list_xpex_user_from_outside_ntt[$ucID]  = [];
            $list_xpex_user_internal[$ucID]  = [];

            $list_selXpex[$ucID]  = getListSelSupplierRevenues($projID,$ucID,  explode('_',$type)[0]); 

            $list_xpex_advice_from_ntt[$ucID]  = getListSupplierRevenuesAdvice($ucID, explode('_',$type)[0]); 
            $list_xpex_user_from_ntt[$ucID]  = getListSupplierRevenuesUser($ucID, $projID, explode('_',$type)[0]);  

            $list_xpex_advice[$ucID] = $list_xpex_advice_from_ntt[$ucID];
            
        }elseif($type=="revenues" || $type =="cashreleasing" || $type =="revenuesProtection" || $type =="widercash" || $type =="quantifiable" || $type =="noncash" || $type =="risks"){
            
            $list_xpex_advice_from_outside_ntt[$ucID]  = [];
            $list_xpex_advice_internal[$ucID]  = [];

            $list_xpex_user_from_outside_ntt[$ucID]  = [];
            $list_xpex_user_internal[$ucID]  = [];

            if($type=="revenues"){
                $list_selXpex[$ucID]  =getListSelRevenues($projID,$ucID);
                $list_xpex_advice_from_ntt[$ucID]  = getListRevenuesAdvice($ucID);
                $list_xpex_user_from_ntt[$ucID]  = getListRevenuesUser($projID,$ucID); 
            }elseif($type=="revenuesProtection"){
                $list_selXpex[$ucID]  = getListSelRevenuesProtection($projID,$ucID); 
                $list_xpex_advice_from_ntt[$ucID]  = getListRevenuesProtectionAdvice($ucID); 
                $list_xpex_user_from_ntt[$ucID]  = getListRevenuesProtectionUser($projID,$ucID);   
            }elseif($type=="cashreleasing"){
                $list_selXpex[$ucID]  = getListSelCashReleasing($projID,$ucID); 
                $list_xpex_advice_from_ntt[$ucID]  = getListCashReleasingAdvice($ucID); 
                $list_xpex_user_from_ntt[$ucID]  = getListCashReleasingUser($projID,$ucID);   
            }elseif($type=="widercash"){
                $list_selXpex[$ucID]  = getListSelWiderCash($projID,$ucID); 
                $list_xpex_advice_from_ntt[$ucID]  = getListWiderCashAdvice($ucID);   
                $list_xpex_user_from_ntt[$ucID]  = getListWiderCashUser($projID,$ucID);   
            }elseif($type=="quantifiable"){
                $list_selXpex[$ucID]  = getListSelQuantifiable($projID,$ucID);
                $list_xpex_advice_from_ntt[$ucID]  = getListQuantifiableAdvice($ucID);
                $list_xpex_user_from_ntt[$ucID]  = getListQuantifiableUser($projID,$ucID) ;
            }elseif($type=="noncash"){
                $list_selXpex[$ucID]  =getListSelNonCash($projID,$ucID);
                $list_xpex_advice_from_ntt[$ucID]  = getListNonCashAdvice($ucID); 
                $list_xpex_user_from_ntt[$ucID]  = getListNonCashUser($projID,$ucID); 
            }elseif($type=="risks"){
                $list_selXpex[$ucID]  = getListSelRisks($projID,$ucID);
                $list_xpex_advice_from_ntt[$ucID]  = getListRisksAdvice($ucID);
                $list_xpex_user_from_ntt[$ucID]  = getListRiskUser($projID,$ucID);
            }

            $list_xpex_advice[$ucID] = $list_xpex_advice_from_ntt[$ucID];
            
        }else{
            throw new Exception("2 Wrong type.");
        }

        //var_dump($list_selXpex);
        $list_sel_xpex_advice[$ucID] = getListSelByType($list_selXpex[$ucID],$list_xpex_advice[$ucID]);
        $compo = getCompoByUC($ucID);


        $nb_uc[$ucID] = getNbTotalUC($projID,$ucID);
            //var_dump($nb_uc);
        $list_ratio[$ucID] = getRatioCompoCapex($list_sel_xpex_advice[$ucID],$compo['id']);
            //var_dump($list_ratio);
    }
    return [$list_xpex_advice, $list_xpex_user, $list_selXpex, $list_xpex_advice_from_ntt, $list_xpex_advice_from_outside_ntt, 
    $list_xpex_advice_internal, $list_xpex_user_from_ntt, $list_xpex_user_from_outside_ntt, $list_xpex_user_internal, $list_xpex_supplier, 
    $list_selXpex, $list_sel_xpex_advice, $nb_uc, $list_ratio, $uc, $compo, $list_xpex_cat, $list_xpex_cat_from_supplier];
}


function xpex_input($twig,$is_connected,$projID=0,$listUcID, $type="capex", $sideBarName, $side){
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
                

                $listUcsName = getUcsName($listUcID);
                


                $devises = getListDevises();

                if(count($listUcID)>1){
                    $ucID = 0;
                }else{
                    $ucID = $listUcID[0];
                }

                $listXpex = getListXpex($listUcID, $type, $projID, $side);
                $list_xpex_advice = $listXpex[0];
                $list_xpex_user = $listXpex[1];
                $list_selXpex = $listXpex[2]; 
                $list_xpex_advice_from_ntt = $listXpex[3];
                $list_xpex_advice_from_outside_ntt = $listXpex[4];

                $list_xpex_advice_internal = $listXpex[5];
                $list_xpex_user_from_ntt = $listXpex[6];
                $list_xpex_user_from_outside_ntt = $listXpex[7];
                $list_xpex_user_internal = $listXpex[8];
                $list_xpex_supplier = $listXpex[9]; 
                $list_sel_xpex_advice = $listXpex[11];
                $nb_uc = $listXpex[12];
                $list_ratio = $listXpex[13];
                $uc = $listXpex[14];
                $compo = $listXpex[15];
                $list_xpex_cat = $listXpex[16];
                $list_xpex_cat_from_supplier = $listXpex[17];

                $list_limite_schedule = getProjetSchedule($projID, $ucID);  


                $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
                $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
                echo $twig->render('/input/input_project_common_steps/xpex_input.twig',array('is_connected'=>$is_connected,'devises'=>$devises,
                'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",
                "selected"=>$proj[1],'part2'=>"Use Case",'selected2'=>$uc[1],'projID'=>$projID,'ucID'=>$ucID,'selXpex'=>$list_selXpex, 
                "xpex_advice_from_ntt"=>$list_xpex_advice_from_ntt,"xpex_advice_from_outside_ntt"=>$list_xpex_advice_from_outside_ntt,"xpex_advice_internal"=>$list_xpex_advice_internal,
                "xpex_user_from_ntt"=>$list_xpex_user_from_ntt,"xpex_user_from_outside_ntt"=>$list_xpex_user_from_outside_ntt,"xpex_user_internal"=>$list_xpex_user_internal, "xpex_supplier"=>$list_xpex_supplier
                ,'compo'=>$compo,'ratio'=>$list_ratio,'nb_uc'=>$nb_uc, 'type'=>$type,  "sideBarName"=> $sideBarName, "listUcID"=>$listUcID, "listUcsName"=>$listUcsName, 
                "list_limite_schedule"=>$list_limite_schedule, "xpexCategories"=>$list_xpex_cat, "list_xpex_cat_from_supplier"=>$list_xpex_cat_from_supplier));
                prereq_ipc(1);
                prereq_CostBenefits();
                prereq_ipc_sup();
                if( $type=="deployment_costs" || $type=="opex" || $type=="capex"){
                    selectCashIn_Out("out");
                }elseif($type=="equipment_revenues" || $type =="deployment_revenues" || $type =="operating_revenues"){
                    selectCashIn_Out("in");
                }
            } else {
                header('Location: ?A=cost_benefits&A2=project');
            }
        } else {
            throw new Exception("There is no project or use case selected !");
        }
    }

function create_xpex($twig,$is_connected, $post,  $type, $sideBarName, $side) {
    if($side != "supplier" && $side != "customer" && $side != "projDev" ){throw new Exception("Wrong side");}
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
        $origine = "from_ntt";
        if(isset($post['origine'])){
            $origine = $post['origine'];
        }else{
            if($side == "supplier"){
                $origine = "from_outside_ntt";
            }
        }
        $cat = $post['category'];
        $xpex_infos = ["name"=>$name,"description"=>$description, "cat"=>$cat];
        //echo $origine;

        //var_dump(getCapexUserItem($projID,$ucID,$name));
        if($name==''){
            throw new Exception("Incorrect name.");
        }
        if(!empty(getCapexUserItem($projID,$ucID,$name)) or !empty(getOpexUserItem($projID,$ucID,$name)) or !empty(getImplemUserItem($projID,$ucID,$name))){
            header('Location: ?A='.$sideBarName.'&A2='.$type.'&projID='.$projID.'&ucID='.$ucID.'&isTaken=true');
        } else {
            if($type=="capex"){
                insertCapexUser($projID,$ucID,$xpex_infos, $origine, $side);
            }elseif($type=="opex"){
                insertOpexUser($projID,$ucID,$xpex_infos, $origine, $side);
            }elseif($type=='deployment_costs'){
            insertImplemUser($projID,$ucID,$xpex_infos, $origine, $side);
            }elseif($type=='revenuesProtection'){
                insertRevenuesProtectionUser($projID,$ucID,$xpex_infos);
            }elseif($type=='equipment_revenues'){
                insertSupplierRevenueUser($projID,$ucID,$xpex_infos, "equipment");
            }elseif($type=='deployment_revenues'){
                insertSupplierRevenueUser($projID,$ucID,$xpex_infos, "deployment");
            }elseif($type=='operating_revenues'){
                insertSupplierRevenueUser($projID,$ucID,$xpex_infos, "operating");
            }elseif($type=='revenues'){
                insertRevenuesUser($projID,$ucID,$xpex_infos);
            }elseif($type=='cashreleasing'){
                insertCashReleasingUser($projID,$ucID,$xpex_infos);
            }elseif($type=='widercash'){
                insertWiderCashUser($projID,$ucID,$xpex_infos);
            }elseif($type=='quantifiable'){
                insertQuantifiableUser($projID,$ucID,$xpex_infos);
            }elseif($type=='noncash'){
                insertNonCashUser($projID,$ucID,$xpex_infos);
            }elseif($type=='risks'){
                insertRiskUser($projID,$ucID,$xpex_infos);
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
            }elseif($type=='revenuesProtection'){
                deleteRevenuesProtectionUser(intval($idXpex));
            }elseif($type=='equipment_revenues' ||$type=="deployment_revenues" || $type=="operating_revenues"){
                deleteSupplierRevenueUser(intval($idXpex));
            }elseif($type=='revenues'){
                deleteRevenuesUser(intval($idXpex));
            }elseif($type=='cashreleasing'){
                deleteCashReleasingUser(intval($idXpex));
            }elseif($type=='widercash'){
                deleteWiderCashUser(intval($idXpex));
            }elseif($type=='quantifiable'){
                deleteQuantifiableUser(intval($idXpex));
            }elseif($type=='noncash'){
                deleteNonCashUser(intval($idXpex));
            }elseif($type=='risks'){
                deleteRiskUser(intval($idXpex));
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
        //var_dump($post);
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
                foreach ($info[$ucID] as $key => $value) {
                    $temp = explode('_',$key);
                    $type=$_GET['A2'];
                    if($temp[0]=="vol"){
                        if(array_key_exists($temp[1],$list)){
                            $list[$temp[1]] += ['volume'=>$value];
                        } else {
                            $list[$temp[1]] = ['volume'=>$value];
                        }
                    } elseif($temp[0]=="unitCost"){
                        if(array_key_exists($temp[1],$list)){
                            $list[$temp[1]] += ['unit_cost'=>$value];
                        } else {
                            $list[$temp[1]] = ['unit_cost'=>$value];
                        }
                    } elseif($temp[0]=="period"){
                        if(array_key_exists($temp[1],$list)){
                            $list[$temp[1]] += ['period'=>$value];
                        } else {
                            $list[$temp[1]] = ['period'=>$value];
                        }
                    } elseif($temp[0]=="anVarVol"){
                        if(array_key_exists($temp[1],$list)){
                            $list[$temp[1]] += ['anVarVol'=>$value];
                        } else {
                            $list[$temp[1]] = ['anVarVol'=>$value];
                        }
                    } elseif($temp[0]=="anVarCost"){
                        if(array_key_exists($temp[1],$list)){
                            $list[$temp[1]] += ['anVarCost'=>$value];
                        } else {
                            $list[$temp[1]] = ['anVarCost'=>$value];
                        }
                    }elseif($temp[0]=="margin"){
                        if(array_key_exists($temp[1],$list)){
                            $list[$temp[1]] += ['margin'=>$value];
                        } else {
                            $list[$temp[1]] = ['margin'=>$value];
                        }
                    }elseif($temp[0]=="unit" ){
                        if(array_key_exists($temp[1],$list)){
                            $list[$temp[1]] += ['unit'=>$value];
                        } else {
                            $list[$temp[1]] = ['unit'=>$value];
                        }
                    }else if($temp[0]=="revenueStart"){
                        if(array_key_exists($temp[1],$list)){
                            $list[$temp[1]] += ['revenue_start_date'=>$value];
                        } else {
                            $list[$temp[1]] = ['revenue_start_date'=>$value];
                        }
                    }else if($temp[0]=="rampUpDurationt"){
                        if(array_key_exists($temp[1],$list)){
                            $list[$temp[1]] += ['ramp_up_duration'=>$value];
                        } else {
                            $list[$temp[1]] = ['ramp_up_duration'=>$value];
                        }
                    }else if($temp[0]=="guide"){
                        if(array_key_exists($temp[1],$list)){
                            $list[$temp[1]] += ['guide'=>$value];
                        } else {
                            $list[$temp[1]] = ['guide'=>$value];
                        }
                    } else if($temp[0]=="unitIndic"){
                        if(array_key_exists($temp[1],$list)){
                            $list[$temp[1]] += ['unit_indic'=>$value];
                        } else {
                            $list[$temp[1]] = ['unit_indic'=>$value];
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
                    }elseif($temp[0]=="impact"){
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
                    }else if($temp[0]=="anVarRev"){
                        if(array_key_exists($temp[1],$list)){
                            $list[$temp[1]] += ['anVarRev'=>$value];
                        } else {
                            $list[$temp[1]] = ['anVarRev'=>$value];
                        }
                    }else if($temp[0]=="currentRevenues"){
                        if(array_key_exists($temp[1],$list)){
                            $list[$temp[1]] += ['currentRevenues'=>$value];
                        } else {
                            $list[$temp[1]] = ['currentRevenues'=>$value];
                        }
                    }else if($temp[0]=="impact100"){
                        if(array_key_exists($temp[1],$list)){
                            $list[$temp[1]] += ['impact'=>$value];
                        } else {
                            $list[$temp[1]] = ['impact'=>$value];
                        }
                    } else if($temp[0]=="unitRev"){
                        if(array_key_exists($temp[1],$list)){
                            $list[$temp[1]] += ['unit_rev'=>$value];
                        } else {
                            $list[$temp[1]] = ['unit_rev'=>$value];
                        }
                    }else{
                        throw new Exception("Error ! :".$temp[0]);
                    }
                    if($type=='equipment_revenues' || $type=="deployment_revenues"){
                        $list[$temp[1]] += ['anVarVol'=>0, 'anVarCost'=>0];
                    }
                }

                if($type=="capex"){
                    insertCapexInputed($projID,$ucID,$list);
                }elseif($type=="opex"){
                    insertOpexInputed($projID,$ucID,$list);
                }elseif($type=="deployment_costs"){
                    insertImplemInputed($projID,$ucID,$list);
                }elseif($type=="revenuesProtection"){
                    insertRevenuesProtectionInputed($projID,$ucID,$list);
                }elseif($type=='equipment_revenues' ||$type=="deployment_revenues" || $type=="operating_revenues"){
                    //var_dump($list);
                    insertSupplierRevenuesInputed($projID,$ucID,$list);
                }elseif($type=='revenues'){
                    insertRevenuesInputed($projID,$ucID,$list);
                }elseif($type=='cashreleasing'){
                    insertCashReleasingInputed($projID,$ucID,$list);
                }elseif($type=='widercash'){
                    insertWiderCashInputed($projID,$ucID,$list);
                }elseif($type=='quantifiable'){
                    insertQuantifiableInputed($projID,$ucID,$list);
                }elseif($type=='noncash'){
                    insertNonCashInputed($projID,$ucID,$list);
                }elseif($type=='risks'){
                    insertRiskInputed($projID,$ucID,$list);
                }else{
                    throw new Exception("Wrong type !");
                }
            }
            update_ModifDate_proj($projID);
            
            if($sideBarName=="input_project_common" or $sideBarName=="input_project_common_supplier" or $sideBarName == "input_use_case_supplier"){
                header('Location: ?A='.$sideBarName.'&A2='.$type.'&projID='.$projID.'&ucID='.$ucID);
            }elseif($sideBarName=="input_use_case" or $sideBarName=="cost_benefits"){
            //$type=="revenues" || $type =="cashreleasing" || $type =="widercash" || $type =="quantifiable" || $type =="noncash" || $type =="risks"
                $next=["capex"=>"deployment_costs", 
                "deployment_costs"=>"opex",
                "opex"=>"revenues",
                "revenues"=>"revenuesProtection",
                "revenuesProtection"=>"cashreleasing",
                "cashreleasing"=>"widercash",
                "widercash"=>"quantifiable",
                "quantifiable"=>"noncash",
                "noncash"=>"risks",
                "risks"=>"summary"];
                header('Location: ?A='.$sideBarName.'&A2='.$next [$type].'&projID='.$projID.'&ucID='.$ucID);
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
            }elseif($type == "revenuesProtection"){
                deleteAllSelRevenuesProtection($projID,$ucID);
                header('Location: ?A='.$sideBarName.'&A2=revenuesProtection&projID='.$projID.'&ucID='.$ucID);
            }elseif($type == "revenues"){
                deleteAllSelRevenues($projID,$ucID);
                header('Location: ?A='.$sideBarName.'&A2=revenues&projID='.$projID.'&ucID='.$ucID);
            }elseif($type == "cashreleasing"){
                deleteAllSelCashReleasing($projID,$ucID);
                header('Location: ?A='.$sideBarName.'&A2=cashreleasing&projID='.$projID.'&ucID='.$ucID);
            }elseif($type == "widercash"){
                deleteAllSelWiderCash($projID,$ucID);
                header('Location: ?A='.$sideBarName.'&A2=widercash&projID='.$projID.'&ucID='.$ucID);
            }elseif($type == "quantifiable"){
                deleteAllSelQuantifiable($projID,$ucID);
                header('Location: ?A='.$sideBarName.'&A2=quantifiable&projID='.$projID.'&ucID='.$ucID);
            }elseif($type == "noncash"){
                deleteAllSdeleteAllSelNonCashelImplem($projID,$ucID);
                header('Location: ?A='.$sideBarName.'&A2=noncash&projID='.$projID.'&ucID='.$ucID);
            }elseif($type == "risks"){
                deleteAllSelRisks($projID,$ucID);
                header('Location: ?A='.$sideBarName.'&A2=risks&projID='.$projID.'&ucID='.$ucID);
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

function create_xpex_cat($twig,$is_connected, $post,  $type, $sideBarName,$side){
    $projID = getProjID();
    if($projID!=-1){
        $ucID = $post['ucID'];
        insertXpexcCat($ucID, $post['name'], $type, $side);
    }
    //$sol = getSolutionByUcID($ucID);
    header('Location: ?A='.$sideBarName.'&A2='.$type.'&projID='.$projID.'&ucID='.$ucID);
}
function delete_xpex_cat($twig,$is_connected, $post,  $type, $sideBarName,$side){

    $projID = getProjID();
    $ucID = $_GET['ucID'];

    if($projID!=-1){
        //var_dump($post);
        foreach ($post as $key => $value) {
            $catID = explode("_", $key)[1];
            deleteXpexCat($catID,  $type);
        }
    }
    header('Location: ?A='.$sideBarName.'&A2='.$type.'&projID='.$projID.'&ucID='.$ucID);
}