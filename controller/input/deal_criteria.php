<?php

function deal_criteria($twig, $is_connected, $projID, $side, $sideBarName)
{ 

    $user = getUser($_SESSION['username']);
    $projDuration = getProjetKeyDates($_SESSION['projID'])[0]['duration'];
    $list_projects = getListProjects($user[0]);

    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    if ($projID != 0) {
        if (getProjByID($projID, $user[0])) {
            $proj = getProjByID($projID, $user[0]);
            $inputNogoTarget = getDealCriteriaInputNogoTarget($projID);
            echo $twig->render('/input/deal_criteria_steps/deal_criteria.twig', array('is_connected' => $is_connected, 
            'devises' => $devises, 'selDevSym' => $selDevSym, 'selDevName' => $selDevName, 'is_admin' => $user[2], 
            'username' => $user[1], 'part' => "Project", 'projID' => $projID, "selected" => $proj[1], 'projects' => $list_projects, 
            'input' => $inputNogoTarget, 'side' => $side, "sideBarName"=>$sideBarName, "projDuration"=>$projDuration));
            prereq_ipc(1);
            prereq_ipc_sup();
        }
    }
}

function deal_criteria_input_nogo_target($post = [], $side)
{
    //CREATE TABLE deal_criteria_input_nogo_target(id INT(11) PRIMARY KEY, societal_npv_nogo INT(11),societal_npv_target INT(11),societal_roi_nogo INT(11),societal_roi_target INT(11),societal_payback_nogo INT(11),societal_payback_target INT(11),npv_nogo INT(11),npv_target INT(11),roi_nogo INT(11),roi_target INT(11),payback_nogo INT(11),payback_target INT(11),risks_rating_nogo INT(11),risks_rating_target INT(11),noncash_rating_nogo INT(11),noncash_rating_target INT(11));

    if (isset($_SESSION['projID'])) {
        $projID = $_SESSION['projID'];

        //Customer BC SIDE
        if ($side == "" or $side == "customer") {
            if (isset($post['societal_npv_nogo']) && isset($post['societal_npv_target']) && isset($post['societal_roi_nogo']) && isset($post['societal_roi_target']) && isset($post['societal_payback_nogo']) && isset($post['societal_payback_target']) && isset($post['npv_nogo']) && isset($post['npv_target']) && isset($post['roi_nogo']) && isset($post['roi_target']) && isset($post['payback_nogo']) && isset($post['payback_target']) && isset($post['risks_rating_nogo']) && isset($post['risks_rating_target']) && isset($post['nqbr_nogo']) && isset($post['nqbr_target'])) {
                $societal_npv_nogo = floatval($post['societal_npv_nogo']);
                $societal_npv_target = floatval($post['societal_npv_target']);
                $societal_roi_nogo = floatval($post['societal_roi_nogo']);
                $societal_roi_target = floatval($post['societal_roi_target']);
                $societal_payback_nogo = floatval($post['societal_payback_nogo']);
                $societal_payback_target = floatval($post['societal_payback_target']);
                $npv_nogo = floatval($post['npv_nogo']);
                $npv_target = floatval($post['npv_target']);
                $roi_nogo = floatval($post['roi_nogo']);
                $roi_target = floatval($post['roi_target']);
                $payback_nogo = floatval($post['payback_nogo']);
                $payback_target = floatval($post['payback_target']);
                $rr_nogo = floatval($post['risks_rating_nogo']);
                $rr_target = floatval($post['risks_rating_target']);
                $nqbr_nogo = floatval($post['nqbr_nogo']);
                $nqbr_target = floatval($post['nqbr_target']);
                insertInputDealCriteria($societal_npv_nogo, $societal_npv_target, $societal_roi_nogo, $societal_roi_target, $societal_payback_nogo, $societal_payback_target, $npv_nogo, $npv_target, $roi_nogo, $roi_target, $payback_nogo, $payback_target, $rr_nogo, $rr_target, $nqbr_nogo, $nqbr_target, $projID);
                header('Location: ?A=input_project_common&A2=deal_criteria&projID='. $projID );
            } else {

                throw new Exception("There is an error with the input fields !");
            }
        } elseif ($side == "supplier") {
            //Supplier BC SIDE
            $checked = "";
            foreach ($post as $key => $value) {
                if(strpos($key, 'check') !== false){
                    $checked.=$key.'-';
                }
            }
                
            $npv_nogo = isset($post['npv_nogo']) ? floatval($post['npv_nogo']) : 0;
            $npv_target = isset($post['npv_target']) ? floatval($post['npv_target']) : 0;
            $roi_nogo = isset($post['roi_nogo']) ? floatval($post['roi_nogo']) : 0;
            $roi_target = isset($post['roi_target']) ? floatval($post['roi_target']) : 0;
            $payback_nogo = isset($post['payback_nogo']) ? floatval($post['payback_nogo']) : 0;
            $payback_target = isset($post['payback_target']) ? floatval($post['payback_target']) : 0;
            $operating_margin_target = isset($post['operating_margin_target']) ? floatval($post['operating_margin_target']) : 0;
            $operating_margin_nogo = isset($post['operating_margin_nogo']) ? floatval($post['operating_margin_nogo']) : 0;
            insertInputDealCriteriaSupplier($npv_nogo, $npv_target, $roi_nogo, $roi_target, $payback_nogo, $payback_target,$operating_margin_target,$operating_margin_nogo,$checked, $projID);
            header('Location: ?A=input_project_common_supplier&A2=deal_criteria&projID=' . $projID);
            
            //throw new Exception("Not yet implemented !");
        }
    } else {
        throw new Exception("There is no project selected !");
    }
}
