<?php

require_once('model/model.php');

// -- Input Project Common



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
                    //prereq_CostBenefits();
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

