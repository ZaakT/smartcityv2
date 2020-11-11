<?php
namespace general;
use general;

function prereq_navbar($side){
    echo "<script>prereq_navbar($side);</script>";
}

function project($twig,$is_connected, $nextPage, $sideBarName){
    $user = getUser($_SESSION['username']);
    $list_projects = getListProjects($user[0]);
    $sessionProj = isset($_SESSION['projID']) ? $_SESSION['projID'] : "None";
    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    foreach ($list_projects as $key => $proj) {
        $list_projects[$key][array_key_last($list_projects[$key])+1]= !empty(getProjetKeyDates($list_projects[$key]['id']));
        //$list_projects[$key][array_key_last($list_projects[$key])+1]= count(getConfirmedUseCases($user[0],$sessionProj))>0; // has a uc confirmed
        
    }
    getConfirmedUseCases($user[0],$sessionProj);
    echo $twig->render('/others/general_steps/project.twig',array('is_connected'=>$is_connected,'devises'=>$devises,
    'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projects'=>$list_projects, 
    'nextPage'=>$nextPage, 'sideBarName'=>$sideBarName,  'isTaken'=>(isset($_GET['isTaken']) && $_GET['isTaken']), "sessionProj"=>$sessionProj)); 
}

function create_proj($post, $sideBarName, $A2){
    $name = $post['name'];
    $description = isset($post['description']) ? $post['description'] : "";
    $user = getUser($_SESSION['username']);
    $idUser = $user[0];
    $projInfos = [$name,$description,$idUser];
    if(!empty(getProj($idUser,$name))){
        header('Location: ?A='.$sideBarName.'&A2='.$A2.'t&isTaken=true');
    } else {
        insertProj($projInfos);
        header('Location: ?A='.$sideBarName.'&A2='.$A2);
    }
}

function edit_proj($post, $sideBarName, $A2){
    var_dump($post);
    $name = $post['name'];
    $description = isset($post['description']) ? $post['description'] : "";
    $user = getUser($_SESSION['username']);
    $idUser = $user[0];
    $projID =  $post['projID'];

    $projInfos = [$name,$description,$projID];
    if(!empty(getProj($idUser,$name)) && getProj($idUser,$name)['id']=!$projID ){
        header('Location: ?A='.$sideBarName.'&A2='.$A2.'t&isTaken=true');
    } else {
        editProj($projInfos);
        header('Location: ?A='.$sideBarName.'&A2='.$A2);
    }
}

function duplicate_proj($post, $sideBarName, $A2){
    //Duplicate the project
    $user = getUser($_SESSION['username']);
    $idUser = $user[0];
    $projIDorigin = $post["projID"];
    $projOrigin = getProjByID($projIDorigin, $idUser);
    $oldName = $projOrigin['name'];
    $nbCopy = 0;
    $newName = $oldName." copy";
    while(!empty(getProj($idUser,$newName))){
        $nbCopy++;
        $newName = $oldName." copy ($nbCopy)";
    }
    
    insertProj([$newName,$projOrigin['description'], $idUser]);    
    $newProj = getProj($idUser,$newName);

    //We duplicate the project information
    copyProjInf($newProj["id"], $projOrigin);
    copyProfPerimeter($newProj["id"],$projIDorigin );
    
    //The project has duplicated, now we duplicate the scope 
    $listSelScopeOrigin = getListSelScope($projIDorigin);
    insertSelScope($newProj["id"],$listSelScopeOrigin);

    //Now, we duplicate the overlay schedule
    $keyDatesOrigin = getProjetKeyDates($projIDorigin);
    if(isset($keyDatesOrigin[0])){
        //We duplicate only if we find a schedule
        $keyDatesOrigin = $keyDatesOrigin[0];
        insertProjetKeyDates($newProj["id"], $keyDatesOrigin['start_date'], $keyDatesOrigin['duration'], $keyDatesOrigin['deploy_start_date'], $keyDatesOrigin['deploy_duration']);
    }

    //We duplicate the UCs schedules
    $listSelScopeNew= getListSelScope($newProj["id"]);
    foreach ($listSelScopeNew as $measID => $list_ucs) {
        foreach ($list_ucs as $ucID) {
            $scheduleDatesOrigin = getProjetSchedule($projIDorigin, $ucID);
            if($scheduleDatesOrigin){
                insertProjectSchedule($newProj["id"], $ucID, $scheduleDatesOrigin['deploy_start'], $scheduleDatesOrigin['deployment_duration'], 
                $scheduleDatesOrigin['uc_end'], $scheduleDatesOrigin['pricing_start'], $scheduleDatesOrigin['poc_duration']);
            }
        }
    }


    //We duplicate the UCs selection (inputed in the summary)
    $confirmedUseCasesOrigin = getConfirmedUseCases($user[0], $projIDorigin );
    foreach($confirmedUseCasesOrigin as $key=>$value){
        $key = explode("_", $key);
        insertNewUseCaseConfirmation($user[0], $newProj["id"], $key[1], $key[0]);
    }

    //Now ... we have to duplicate the UC's items ... It will not be easy
    duplicateXpexItems($projIDorigin,$newProj["id"]);







    header('Location: ?A='.$sideBarName.'&A2='.$A2);
}


function delete_proj($idProj, $sideBarName, $A2){
    // var_dump($idProj);
    deleteProj($idProj);
    if($idProj==getProjID()){
        unset($_SESSION["projID"]);
    }
    header('Location: ?A='.$sideBarName.'&A2='.$A2);
}


function commonPage($twig,$is_connected, $nextPage, $sideBarName){
    $user = getUser($_SESSION['username']);
    $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
    
    echo $twig->render('/others/general_common.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[3], 'nextPage'=>$nextPage, 'sideBarName'=>$sideBarName));
}

function use_case_selection($twig,$is_connected, $nextPage, $sideBarName, $projID=0){
    $user = getUser($_SESSION['username']);
    if($projID!=0){
        if(isset($_SESSION['ucID'])){
            unset($_SESSION['ucID']);
        }
        if(getProjByID($projID,$user[0])){
            $proj = getProjByID($projID,$user[0]);
            $list_measures = getListMeasures();
            $list_ucs = getListUCs();
            if(isSup()){
                foreach ($list_ucs as $ucID => $data) {
                    $list_ucs[$ucID]["hasSchedule"]=hasSchedule($projID, $ucID);
                }
            }
            $selScope = getListSelScope($projID);
            //Suppression de project common car il ne peu être modifier que dans la partie project common
            if(isset($list_measures[0])){unset($list_measures[0]);}
            if(isset($list_ucs[-1])){unset($list_ucs[-1]);}
            if(isset($selScope[0])){unset($selScope[0]);}

            $list_cat = getListUCsCat();

            $devises = getListDevises();
            $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
            $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
                
            echo $twig->render('/others/general_steps/use_case_selection.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,
            'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1],'part'=>"Project",'projID'=>$projID,"selected"=>$proj[1],'selScope'=>$selScope,
            'ucs'=>$list_ucs,'measures'=>$list_measures, 'nextPage'=>$nextPage, 'sideBarName'=>$sideBarName, "list_cat"=>$list_cat));
            if($sideBarName=='input_project_common' or $sideBarName=='input_project_common_supplier'){
                prereq_ipc(0);
            }
        } else {
            header('Location: ?A='.$sideBarName);
        }
    } else {
        $devises = getListDevises();
    $selDevName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $devises[1]['name'];
    $selDevSym = isset($_SESSION['devise_symbol']) ? $_SESSION['devise_symbol'] :  $devises[1]['symbol'];
        
        echo $twig->render('/others/general_steps/use_case_selection.twig',array('is_connected'=>$is_connected,'devises'=>$devises,'selDevSym'=>$selDevSym,'selDevName'=>$selDevName,'is_admin'=>$user[2],'username'=>$user[1], 'nextPage'=>$nextPage, 'sideBarName'=>$sideBarName));
    }
} 


