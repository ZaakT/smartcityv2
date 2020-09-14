<?php
// --------------------------------- CONNECT TO DATABASE ----------------------------------

function dbConnect()
{
    try{
    $db = new PDO('mysql:host=smartcityv2;dbname=dst_v2_db_updated;charset=utf8', 'root','', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        return $db;
    } catch(Exception $e){ 
        try {
            $db = new PDO('mysql:host=mysql_v2_test;dbname=smartcity_v2_db;charset=utf8;port=3306', 'root','root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
                return $db;
        } catch (Exception $e2) {
            throw new Exception("Access to the database impossible ! : 
            \n1 - ".$e->getMessage()."
            \n2 - ".$e2->getMessage() );
        }
    }
}

// ---------------------------------------- DEVISES ----------------------------------------

function getListDevises(){
    $db = dbConnect();
    $req = $db->prepare('SELECT id, name, symbol, rateToGBP FROM devise ORDER BY id');
    $req->execute();
    $list = [];
    while ($row = $req->fetch()){
        $id = intval($row['id']);
        $rateToGBP = floatval($row['rateToGBP']);
        $name = $row['name'];
        $symbol = $row['symbol'];
        $list[$id] = ['name'=>$name,'symbol'=>$symbol,'rateToGBP'=>$rateToGBP];
    }
    $list = !empty($list) ? $list : [1=>['name'=>'GBP','symbol'=>'£','rateToGBP'=>1]];
    return $list;
}

function convertDevToGBP($val){
    $listDev = getListDevises();
    $devName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $listDev[1]['name'];
    if(!empty($devName)){
        if($devName == "GBP" || !isset($_SESSION['devise_id'])){
            return $val;
        } else {
            $idDev = $_SESSION['devise_id'];
            $rateToGBP = $listDev[$idDev]['rateToGBP'];
            $newVal = $rateToGBP != 0 ? $val * $rateToGBP : 0;
            $res = number_format($newVal,2,'.','');
            //var_dump($res);
            return $res;
        }
    } else {
        throw new Exception("There is no devise selected");
    }
}

function convertGBPToDev($val){
    $listDev = getListDevises();
    $devName = isset($_SESSION['devise_name']) ? $_SESSION['devise_name'] : $listDev[1]['name'];
    if(!empty($devName)){
        if($devName == "GBP" || !isset($_SESSION['devise_id'])){
            return $val;
        } else {
            $idDev = $_SESSION['devise_id'];
            $rateToGBP = $listDev[$idDev]['rateToGBP'];
            $newVal = $rateToGBP != 0 ? $val / $rateToGBP : 0;
            $res = number_format($newVal,2,'.','');
            //var_dump($res);
            return $res;
        }
    } else {
        throw new Exception("There is no devise selected");
    }
}

function changeExchangeRate($id,$newrate){
    $db = dbConnect();
    $req = $db->prepare('UPDATE devise SET rateToGBP = ? WHERE id = ?');
    return $req->execute(array($newrate, $id));
}


// ---------------------------------------- USERS ----------------------------------------

function getUserCity($idUser){
    $db = dbConnect();
    $req = $db->prepare('SELECT city.name FROM user, city WHERE user.id = ? ');
    $req->execute(array($idUser));
    $res = $req->fetch();
    if(empty($res)){
        throw new Exception("no city received");
    }
    //var_dump($city);
    return $res['name'];
}

function getUserByUsername($username){
    $db = dbConnect();
    $req = $db->prepare('SELECT id, password FROM user WHERE username = ? ');
    $req->execute(array($username));
    $res = $req->fetch();
    return $res;
}

function getUser($username){
    $db = dbConnect();
    $req = $db->prepare('SELECT id, username, is_admin, password,salt,profile FROM user WHERE username = ?');
    $req->execute(array($username));
    $res =  $req->fetch();
    
    if(!empty($res)){
        $userName = $res['username'];
        $userID = intval($res['id']);
        $isAdmin = $res['is_admin']==1 ? true : false;
        $userPassword = $res['password'];
        $salt = $res['salt'];
        $profile=$res["profile"];
        $user = [$userID,$userName,$userPassword,$isAdmin,$salt,$profile];
    } else {
        $user = [];
    }
    return $user;
}

function getListUsers(){
    $db = dbConnect();
    $req = $db->prepare('SELECT id, username, is_admin,creation_date,profile FROM user ORDER BY username');
    $req->execute();
    $list = [];
    while ($row = $req->fetch()){
        array_push($list,$row);
    }
    return $list;
}

function insertUser($user){
    /*$db = dbConnect();
    $req = $db->prepare('INSERT INTO user (username,salt,password,is_admin) VALUES (?,?,?,?)');
    return $req->execute(array($user[0],$user[1],$user[2],$user[3]));*/

    $nameMeasure = "Project Management ".$user[0];
    $description = "";
    $db = dbConnect();
    $ret = false;
    $db->exec('DROP PROCEDURE IF EXISTS `insert_user`;');
    $db->exec(' CREATE PROCEDURE `insert_user`(
                            IN username VARCHAR(255),
                            IN salt VARCHAR(255),
                            IN password VARCHAR(255),
                            IN nameMeasure VARCHAR(255),
                            IN description VARCHAR(255),
                            IN is_admin INT,
                            IN profile ENUM("d","s") #Project Developper or Supplier
                            )
                            BEGIN
                                DECLARE userID INT;
                                INSERT INTO user (username,salt,password,is_admin,profile)
                                    VALUES (username,salt,password,is_admin,profile);
                                SET userID = LAST_INSERT_ID();
                                INSERT INTO measure (name,description,user)
                                    VALUES (nameMeasure,description,userID);
                            END
                                ');
    $req = $db->prepare('CALL insert_user(?,?,?,?,?,?,?);');
    $ret = $req->execute(array($user[0],$user[1],$user[2],$nameMeasure, $description,$user[3],$user[4]));
    return $ret;
}

function modifyUser($user){
    $db = dbConnect();
    $req = $db->prepare('UPDATE user
                        SET username = ?,
                            salt = ?,
                            password = ?
                        WHERE id = ?');
    return $req->execute(array($user[1],$user[2],$user[3],$user[0],$user[4]));
}

function deleteUser($userID){
    $db = dbConnect();
    $req = $db->prepare('DELETE FROM user WHERE id = ?');
    return $req->execute(array($userID));
}





//  ---------------------------------------- USE CASES MENU ----------------------------------------

function getUCMByID($id,$idUser){
    $db = dbConnect();
    $req = $db->prepare('SELECT * FROM use_cases_menu WHERE id = ? and id_user = ?');
    $req->execute(array($id,$idUser));
    $res = $req->fetch();
    return $res;
}

function getUCM($idUser,$name){ //in order to test if the name is already taken or not
    $db = dbConnect();
    $req = $db->prepare('SELECT * FROM use_cases_menu WHERE id_user = ? and name = ?');
    $req->execute(array($idUser,$name));
    $res =  $req->fetch();
    return $res;
}

function getListUCMS($idUser){
    $db = dbConnect();
    $req = $db->prepare('SELECT * FROM use_cases_menu WHERE id_user = ? ORDER BY id');
    $req->execute(array($idUser));
    $list = [];
    while ($row = $req->fetch()){
        array_push($list,$row);
    }
    return $list;
}

function insertUCM($ucm){
    $db = dbConnect();
    $req = $db->prepare('INSERT INTO use_cases_menu (name,description,id_user) VALUES (?,?,?)');
    return $req->execute(array($ucm[0],$ucm[1],$ucm[2]));
}

function deleteUCM($id){
    $db = dbConnect();
    $req = $db->prepare('DELETE FROM use_cases_menu WHERE id = ?');
    return $req->execute(array($id));
}

function update_ModifDate_ucm($ucmID){
    $db = dbConnect();
    $req = $db->prepare('UPDATE use_cases_menu SET modif_date = CURRENT_TIMESTAMP WHERE id = ?');
    return $req->execute(array($ucmID));
}


// ---------------------------------------- MEASURES ----------------------------------------

function getListMeasures(){
    $db = dbConnect();
    $req = $db->prepare('SELECT id,name,description,user FROM measure ORDER BY name');
    $req->execute();
    $list = [];
    while ($row = $req->fetch()){
        $id = intval($row['id']);
        $name = $row['name'];
        $description = $row['description'];
        $user = $row['user'];
        $list[$id] = ['name'=>$name,'description'=>$description,'user'=>$user];
    }
    return $list;
}

function getMeasure($measName){
    $db = dbConnect();
    $req = $db->prepare('SELECT id, name, description
                            FROM measure
                            WHERE name = ?');
    $req->execute(array($measName));
    $res =  $req->fetch();
    
    if(!empty($res)){
        $name = $res['name'];
        $description = $res['description'];
        $measID = intval($res['id']);
        
        $measure = [$measID,$name,$description];
    } else {
        $measure = [];
    }
    return $measure;
}


function insertMeasure($measure){
    $db = dbConnect();
    $req = $db->prepare('INSERT INTO measure (name,description,user) VALUES (?,?,?)');
    return $req->execute(array($measure[0],$measure[1],$measure[2]));
}

function deleteMeasure($measID){
    $db = dbConnect();
    $req = $db->prepare('DELETE FROM measure WHERE id = ?');
    return $req->execute(array($measID));
}

function getListSelMeas($ucmID){
    $db = dbConnect();
    $req = $db->prepare('SELECT id_meas
                        FROM ucm_sel_measure
                        WHERE ucm_sel_measure.id_ucm = ?');
    $req->execute(array($ucmID));
    $list = [];
    while ($row = $req->fetch()){
        array_push($list,intval($row['id_meas']));
    }
    return $list;
}

function insertSelMeas($ucmID,$list){
    $db = dbConnect();
    $ret = false;
    foreach ($list as $measID) {
        $req = $db->prepare('INSERT INTO ucm_sel_measure (id_ucm,id_meas) VALUES (?,?)');
        $ret = $req->execute(array($ucmID,$measID));
    }
    if(!$ret){
        throw new Exception("Selected Measures not inserted");
    }
    return $ret;
}

function deleteSelMeas($ucmID){
    $db = dbConnect();
    $req = $db->prepare('DELETE FROM ucm_sel_measure WHERE id_ucm = ?');
    return $req->execute(array($ucmID));
}

function getNbUCsMeas($listMeas){
    $db = dbConnect();
    $req = $db->prepare('SELECT count(id) as nbUC FROM use_case WHERE id_meas = ?');
    $list = [];
    foreach ($listMeas as $measID => $meas){
        $req->execute(array($measID));
        $res = $req->fetch();
        $list[$measID] = intval($res['nbUC']);
    }
    return $list;
}



// ---------------------------------------- CRITERIA ----------------------------------------
function getCatByCrit($idCrit){
    $db = dbConnect();
    $req = $db->prepare('SELECT id_cat FROM crit WHERE id = ?');
    $req->execute(array($idCrit));
    $res = $req->fetch();
    return intval($res['id_cat']);
}

function getListCrit(){
    $db = dbConnect();
    $req = $db->prepare('SELECT crit.id, crit.name, crit.description, crit.scoring_guidance, critCat.id as id_cat
                    FROM crit
                    INNER JOIN critCat
                    WHERE crit.id_cat = critCat.id
                    ORDER BY name');
    $req->execute();
    $list = [];
    while ($row = $req->fetch()){
        $id = intval($row['id']);
        $name = $row['name'];
        $description = $row['description'];
        $id_cat = intval($row['id_cat']);
        $scoring_guidance = $row['scoring_guidance'];
        //var_dump($row['scoring_guidance'], $scoring_guidance);
        array_push($list,['id'=>$id,'description'=>$description,'name'=>$name,'id_cat'=>$id_cat,'scoring_guidance'=>$scoring_guidance]);
    }
    return $list;
}

function getListCritCat(){
    $db = dbConnect();
    $req = $db->prepare('SELECT id,name FROM critCat ORDER BY name');
    $req->execute();
    $list = [];
    while ($row = $req->fetch()){
        array_push($list,$row);
    }
    return $list;
}

function getListSelCrit($ucmID){
    $db = dbConnect();
    $req = $db->prepare('SELECT crit.id, name, description, crit.scoring_guidance, crit.id_cat
                        FROM crit
                        INNER JOIN ucm_sel_crit
                        WHERE (ucm_sel_crit.id_crit = crit.id)
                            AND (ucm_sel_crit.id_ucm = ?)
                        ORDER BY name');
    $req->execute(array($ucmID));
    $list = [];
    while ($row = $req->fetch()){
        array_push($list,$row);
    }
    return $list;
}

function getListSelCritCat($ucmID){
    $db = dbConnect();
    $req = $db->prepare('SELECT critCat.id, name
                        FROM critCat
                        INNER JOIN ucm_sel_critcat
                        WHERE (ucm_sel_critcat.id_critCat = critCat.id)
                            AND (ucm_sel_critcat.id_ucm = ?)
                        ORDER BY name');
    $req->execute(array($ucmID));
    $list = [];
    while ($row = $req->fetch()){
        array_push($list,$row);
    }
    return $list;
}

function insertSelCrit($ucmID,$list){
    $db = dbConnect();
    $ret = false;
    foreach ($list as $critID) {
        $req = $db->prepare('INSERT INTO ucm_sel_crit (id_ucm,id_crit) VALUES (?,?)');
        $ret = $req->execute(array($ucmID,$critID));
    }
    if(!$ret){
        throw new Exception("Selected Criteria not inserted");
    }
    return $ret;
}

function insertSelCritCat($ucmID,$list){
    $db = dbConnect();
    $ret = false;
    foreach ($list as $critCatID) {
        $req = $db->prepare('INSERT INTO ucm_sel_critcat (id_critCat,id_ucm) VALUES (?,?)');
        $ret = $req->execute(array($critCatID,$ucmID));
    }
    if(!$ret){
        throw new Exception("Selected Criteria Category not inserted");
    }
    return $ret;
}

function deleteSelCrit($ucmID){
    $db = dbConnect();
    $req = $db->prepare('DELETE FROM ucm_sel_crit WHERE id_ucm = ?');
    return $req->execute(array($ucmID));
}

function deleteSelCritCat($ucmID){
    $db = dbConnect();
    $req = $db->prepare('DELETE FROM ucm_sel_critcat WHERE id_ucm = ?');
    return $req->execute(array($ucmID));
}

function getNbsCritCat($listCat){
    $db = dbConnect();
    $req = $db->prepare('SELECT count(id) as nbCrit FROM crit WHERE id_cat = ?');
    $list = [];
    foreach ($listCat as $cat){
        $req->execute(array($cat['id']));
        $res = $req->fetch();
        $list[$cat['id']] = intval($res['nbCrit']);
    }
    return $list;
}

function getCritCat($nameCat){
    $db = dbConnect();
    $req = $db->prepare('SELECT *
                        FROM critCat
                        WHERE name = ?');
    $req->execute(array($nameCat));
    return $req->fetch();
}

function insertCritCat($category){
    $db = dbConnect();
    $req = $db->prepare('INSERT INTO critCat (name) VALUES (?)');
    return $req->execute(array($category[0]));
}

function deleteCritCat($catID){
    $db = dbConnect();
    $req = $db->prepare('DELETE FROM critCat WHERE id = ?');
    return $req->execute(array($catID));
}

function getCritByNameAndCat($critName,$catID){
    $db = dbConnect();
    $req = $db->prepare('SELECT * FROM crit WHERE name = ? and id_cat = ?');
    $req->execute(array($critName,$catID));
    return $req->fetch();
}

function insertCrit($crit){
    $db = dbConnect();
    $req = $db->prepare('INSERT INTO crit
                            (name,description,scoring_guidance,id_cat)
                            VALUES (?,?,?,?)');
    return $req->execute(array($crit[0],$crit[1],$crit[2],$crit[3]));
}

function deleteCrit($critID){
    $db = dbConnect();
    $req = $db->prepare('DELETE FROM crit WHERE id = ?');
    return $req->execute(array($critID));
}



// ---------------------------------------- GEOGRAPHY ----------------------------------------

function getListDLTs(){
    $db = dbConnect();
    $req = $db->prepare('SELECT id, name, description FROM dlt ORDER BY name');
    $req->execute();
    $list = [];
    while ($row = $req->fetch()){
        array_push($list,$row);
    }
    return $list;
}

function getListSelDLTs($ucmID){
    $db = dbConnect();
    $req = $db->prepare('SELECT dlt.id, name, description
                        FROM dlt
                        INNER JOIN ucm_sel_dlt
                        WHERE (ucm_sel_dlt.id_dlt = dlt.id)
                                AND (ucm_sel_dlt.id_ucm = ?)
                        ORDER BY name');
    $req->execute(array($ucmID));
    $list = [];
    while ($row = $req->fetch()){
        array_push($list,$row);
    }
    return $list;
}

function insertSelDLTs($ucmID,$list){
    $db = dbConnect();
    $ret = false;
    foreach ($list as $idDLT) {
        $req = $db->prepare('INSERT INTO ucm_sel_dlt (id_ucm,id_dlt) VALUES (?,?)');
        $ret = $req->execute(array($ucmID,$idDLT));
    }
    if(!$ret){
        throw new Exception("Selected District Location Type not inserted");
    }
    return $ret;
}

function deleteSelDLTs($ucmID){
    $db = dbConnect();
    $req = $db->prepare('DELETE FROM ucm_sel_dlt WHERE id_ucm = ?');
    return $req->execute(array($ucmID));
}

function getDLTByName($nameDLT){
    $db = dbConnect();
    $req = $db->prepare('SELECT * FROM dlt WHERE name = ?');
    $req->execute(array($nameDLT));
    return $req->fetch();
}

function insertDLT($infosDLT){
    $db = dbConnect();
    $req = $db->prepare('INSERT INTO dlt (name,description) VALUES (?,?)');
    return $req->execute(array($infosDLT[0],$infosDLT[1]));
}

function deleteDLT($idDLT){
    $db = dbConnect();
    $req = $db->prepare('DELETE FROM dlt WHERE id = ?');
    return $req->execute(array($idDLT));
}

function insertZone($infosZone){
    $db = dbConnect();
    $req = $db->prepare('INSERT INTO zone (name,type,id_zone) VALUES (?,?,?)');
    return $req->execute(array($infosZone[0],$infosZone[1],$infosZone[2]));
}

function deleteZone($idZone){
    $db = dbConnect();
    $req = $db->prepare('DELETE FROM zone WHERE id = ?');
    return $req->execute(array($idZone));
}



// ---------------------------------------- USE CASES ----------------------------------------

function getUC($list_measID){
    $db = dbConnect();
    $req = $db->prepare('SELECT id,name FROM use_case WHERE id_meas = ? ORDER BY name');
    $list = [];
    foreach ($list_measID as $measID) {
        $req->execute(array($measID));
        while ($row = $req->fetch()){
            $uc = [intval($row['id']),$row['name'],'id'=>intval($row['id']),'name'=>$row['name']];
            array_push($list,$uc);
        }
    }
    return $list;
}

function getUCByID($ucID){
    $db = dbConnect();
    $req = $db->prepare('SELECT * FROM use_case WHERE id = ?');
    $req->execute(array($ucID));
    return $req->fetch();
}

function getUCByNameAndMeasAndCat($ucName,$measID,$catID){
    $db = dbConnect();
    $req = $db->prepare('SELECT * FROM use_case WHERE name = ? and id_meas = ? and id_cat = ?');
    $req->execute(array($ucName,$measID,$catID));
    return $req->fetch();
}

function insertUseCase($usecase){
    $db = dbConnect();
    $req = $db->prepare('INSERT INTO use_case
                            (name,description,id_meas,id_cat)
                            VALUES (?,?,?,?)');
    return $req->execute(array($usecase[0],$usecase[1],$usecase[2],$usecase[3]));
}

function deleteUseCase($ucID){
    $db = dbConnect();
    $req = $db->prepare('DELETE FROM use_case WHERE id = ?');
    return $req->execute(array($ucID));
}

function getListSelUC($ucmID){
    $db = dbConnect();
    $req = $db->prepare('SELECT use_case.id, use_case.name, use_case.description, measure.name
                            FROM use_case
                                INNER JOIN ucm_sel_uc
                                INNER JOIN measure
                                    WHERE (ucm_sel_uc.id_uc = use_case.id)
                                        AND (ucm_sel_uc.id_ucm = ?) 
                                        AND (use_case.id_meas = measure.id)
                                ORDER BY measure.name, use_case.name');
    $req->execute(array($ucmID));
    $list = [];
    while ($row = $req->fetch()){
        array_push($list,$row);
    }
    //var_dump($list);
    return $list;
}

function insertSelUC($ucmID,$list){
    $db = dbConnect();
    $ret = false;
    foreach ($list as $idUC) {
        $req = $db->prepare('INSERT INTO ucm_sel_uc (id_ucm,id_uc) VALUES (?,?)');
        $ret = $req->execute(array($ucmID,$idUC));
    }
    if(!$ret){
        throw new Exception("Selected Use Cases not inserted");
    }
    return $ret;
}

function deleteSelUC($ucmID){
    $db = dbConnect();
    $req = $db->prepare('DELETE FROM ucm_sel_uc WHERE id_ucm = ?');
    return $req->execute(array($ucmID));
}

function getGuidCrit($ucs,$criteria){
    $db = dbConnect();
    $req = $db->prepare('SELECT pertinence, range_min, range_max
                        FROM uc_vs_crit
                        WHERE (uc_vs_crit.id_uc = ?)
                        AND (uc_vs_crit.id_crit = ?)');
    $list = [];
    foreach ($ucs as $uc) {
        $temp = [];
        foreach ($criteria as $crit) {
            $req->execute(array($uc[0],$crit[0]));
            while ($row = $req->fetch()){
                $pert = $row['pertinence'];
                $min = $row['range_min'];
                $max = $row['range_max'];
                $temp[$crit[0]]=[$pert,$min,$max];
            }
        }
        //var_dump($temp);
        $list[$uc[0]]=$temp;
    }
    //var_dump($list);
    return $list;                    
}

function getPertDLT($ucs,$DLTs){
    $db = dbConnect();
    $req = $db->prepare('SELECT pertinence
                        FROM uc_vs_dlt
                        WHERE (uc_vs_dlt.id_uc = ?)
                        AND (uc_vs_dlt.id_dlt = ?)');
    $list = [];
    foreach ($ucs as $uc) {
        $temp = [];
        foreach ($DLTs as $DLT) {
            $req->execute(array($uc[0],$DLT[0]));
            while ($row = $req->fetch()){
                $pert = $row['pertinence'];
                $temp[$DLT[0]]=$pert;
            }
        }
        //var_dump($temp);
        $list[$uc[0]]=$temp;
    }
    //var_dump($list);
    return $list;                    
}

// ---------------------------------------- RATING ----------------------------------------
function getListInputedRates($ucmID){
    $db = dbConnect();
    $req = $db->prepare('SELECT * FROM uc_vs_crit_input WHERE id_ucm = ?');
    $req->execute(array($ucmID));
    $list = [];
    while ($row = $req->fetch()){
        $idUC = $row['id_uc'];
        $idCrit = $row['id_crit'];
        $rate = $row['rate'];
        if(array_key_exists($idUC,$list)){
            $list[$idUC]=[$idCrit=>intval($rate)]+$list[$idUC];
        }
        else {
            $list[$idUC]=[$idCrit=>intval($rate)];
        }
    }
    //var_dump($orderUC,$orderCrit);
    //$list = array_reverse($list,true);
    //var_dump($list);
    return $list;

}

function insertRates($ucmID,$list_per_uc){
    $db = dbConnect();
    $ret = false;
    $req = $db->prepare('INSERT INTO uc_vs_crit_input (id_ucm,id_uc,id_crit,rate) VALUES (?,?,?,?)');
    foreach ($list_per_uc as $idUC => $list_per_crit) {
        //var_dump($list_per_crit);
        foreach ($list_per_crit as $idCrit => $rate) {
            $ret = $req->execute(array($ucmID,$idUC,$idCrit,$rate));
        }
    }
    if(!$ret){
        throw new Exception("All input rate not inserted");
    }
    return $ret;
}

function deleteRates($ucmID){
    $db = dbConnect();
    $req = $db->prepare('DELETE FROM uc_vs_crit_input WHERE id_ucm = ?');
    return $req->execute(array($ucmID));
}


// ---------------------------------------- GLOBAL SCORE ----------------------------------------

function insertCritCatWeights($ucmID,$list){
    $db = dbConnect();
    $ret = false;
    $req = $db->prepare('UPDATE ucm_sel_critcat
                            SET weight = ?
                            WHERE ucm_sel_critcat.id_critCat = ? AND ucm_sel_critcat.id_ucm = ?
                            ');
    foreach ($list as $idCritCat => $weight) {
        $ret = $req->execute(array($weight,$idCritCat,$ucmID));
    }
    if(!$ret){
        throw new Exception("All weights not inserted");
    }
    return $ret;
}

function getListWeights($ucmID){
    $db = dbConnect();
    $req = $db->prepare('SELECT id_critCat,weight FROM ucm_sel_critcat WHERE ucm_sel_critcat.id_ucm = ?');
    $req->execute(array($ucmID));
    $list = [];
    while ($row = $req->fetch()){
        $idCritCat = $row['id_critCat'];
        $weight = $row['weight'];
        $list[$idCritCat] = intval($weight);
        }
    //var_dump($list);
    return $list;
}







// ---------------------------------------- PROJECT ----------------------------------------



function getProjByID($id,$idUser){
    $db = dbConnect();
    $req = $db->prepare('SELECT * FROM project WHERE id = ? and id_user = ?');
    $req->execute(array($id,$idUser));
    $res = $req->fetch();
    return $res;
}

function getProj($idUser,$name){ //in order to test if the name is already taken or not
    $db = dbConnect();
    $req = $db->prepare('SELECT * FROM project WHERE id_user = ? and name = ?');
    $req->execute(array($idUser,$name));
    $res =  $req->fetch();
    return $res;
}

function getListProjects($idUser){
    $db = dbConnect();
    $req = $db->prepare('SELECT * FROM project WHERE id_user = ? ORDER BY id');
    $req->execute(array($idUser));
    $list = [];
    while ($row = $req->fetch()){
        array_push($list,$row);
    }
    return $list;
}

function insertProj($proj){
    $db = dbConnect();
    $req = $db->prepare('INSERT INTO project (name,description,id_user) VALUES (?,?,?)');
    return $req->execute(array($proj[0],$proj[1],$proj[2]));
}

function deleteProj($id){
    $db = dbConnect();
    $req = $db->prepare('DELETE FROM project WHERE id = ?');
    return $req->execute(array($id));
}

function update_ModifDate_proj($projID){
    $db = dbConnect();
    $req = $db->prepare('UPDATE project SET modif_date = CURRENT_TIMESTAMP WHERE id = ?');
    return $req->execute(array($projID));
}


function getListUCs(){
    $db = dbConnect();
    $req = $db->prepare('SELECT use_case.id, use_case.name, use_case.description, id_meas, measure.name, id_cat, use_case_cat.name
                        FROM use_case
                        INNER JOIN measure
                            INNER JOIN use_case_cat
                                WHERE use_case.id_meas = measure.id
                                and use_case.id_cat = use_case_cat.id
                        ORDER BY measure.name,use_case_cat.name,use_case.name');
    $req->execute();
    $list = [];
    while ($row = $req->fetch()){
        $id_uc = intval($row[0]);
        $name = $row[1];
        $description = $row[2];
        $id_meas = intval($row[3]);
        $name_meas = $row[4];
        $id_cat = intval($row[5]);
        $name_cat = $row[6];
        $list[$id_uc] = ["name"=>$name,"description"=>$description,"id_meas"=>$id_meas,"name_meas"=>$name_meas,"id_cat"=>$id_cat,"name_cat"=>$name_cat];
    }
    return $list;
}
function getListUCsCat(){
    $db = dbConnect();
    $req = $db->prepare('SELECT id, name, description
                        FROM use_case_cat
                        ORDER BY name');
    $req->execute();
    $list = [];
    while ($row = $req->fetch()){
        $id = intval($row['id']);
        $name = $row['name'];
        $description = $row['description'];
        $list[$id] = ["name"=>$name,"description"=>$description];
    }
    return $list;
}

function getUCsCat($nameCat){
    $db = dbConnect();
    $req = $db->prepare('SELECT *
                        FROM use_case_cat
                        WHERE name = ?');
    $req->execute(array($nameCat));
    return $req->fetch();
}

function getNbUCsCat($listCat){
    $db = dbConnect();
    $req = $db->prepare('SELECT count(id) as nbUC FROM use_case WHERE id_cat = ?');
    $list = [];
    foreach ($listCat as $catID => $cat){
        $req->execute(array($catID));
        $res = $req->fetch();
        $list[$catID] = intval($res['nbUC']);
    }
    return $list;
}

function insertUCCat($category){
    $db = dbConnect();
    $req = $db->prepare('INSERT INTO use_case_cat (name,description) VALUES (?,?)');
    return $req->execute(array($category[0],$category[1]));
}

function deleteUCCat($catID){
    $db = dbConnect();
    $req = $db->prepare('DELETE FROM use_case_cat WHERE id = ?');
    return $req->execute(array($catID));
}

function updateScoping($projID,$val){
    $db = dbConnect();
    $req = $db->prepare('UPDATE project SET scoping=? WHERE id = ?');
    return $req->execute(array($val,$projID));
}

function updateCB($projID,$val){
    $db = dbConnect();
    $req = $db->prepare('UPDATE project SET cb = ? WHERE id = ?');
    return $req->execute(array($val,$projID));
}

// ---------------------------------------- SCOPE ----------------------------------------

function getListSelScope($projID){
    $db = dbConnect();
    $req1 = $db->prepare("SELECT id_meas
                            FROM proj_sel_measure
                            WHERE id_proj = ?");
    $req1->execute(array($projID));
    $list = [];
    while ($row = $req1->fetch()){
        $id_meas = intval($row['id_meas']);
        $list[$id_meas] = [];
    }
    //var_dump($list);
    $req2 = $db->prepare("SELECT proj_sel_usecase.id_uc,use_case.id_meas
                            FROM proj_sel_usecase
                            INNER JOIN use_case
                            WHERE (id_proj = ?) AND (use_case.id = proj_sel_usecase.id_uc)");
    $req2->execute(array($projID));
    while ($row = $req2->fetch()){
        $id_uc = intval($row['id_uc']);
        $id_meas = intval($row['id_meas']);
        array_unshift($list[$id_meas],$id_uc);
    }
    //var_dump($list);
    return $list;
}

function insertSelScope($projID,$list){
    $db = dbConnect();
    $ret = false;
    $req1 = $db->prepare("INSERT INTO proj_sel_measure
                            (id_proj,id_meas)
                            VALUES (?,?)");
    $req2 = $db->prepare("INSERT INTO proj_sel_usecase
                            (id_proj,id_uc)
                            VALUES (?,?)");
    foreach ($list as $id_meas => $listUC) {
        if(!empty($listUC)){
            $ret = $req1->execute(array($projID,$id_meas));
            foreach ($listUC as $key => $id_uc) {
                $ret = $req2->execute(array($projID,$id_uc));
            }
        }
    }
    return $ret;
}

function deleteSelScope($projID){
    $ret = false;
    $db = dbConnect();
    $req = $db->prepare("DELETE proj_sel_measure.*,proj_sel_usecase.*
                            FROM proj_sel_measure
                            INNER JOIN proj_sel_usecase
                                WHERE (proj_sel_measure.id_proj = proj_sel_usecase.id_proj)
                                    AND (proj_sel_measure.id_proj=?)");
    $ret = $req->execute(array($projID));
    return $ret;
    
}

// ---------------------------------------- PERIMETER ----------------------------------------

function getListZones(){
    $db = dbConnect();
    $req = $db->prepare("SELECT * FROM zone ORDER BY name");
    $req->execute();
    $list = [];
    while($row = $req->fetch()){
        $id_zone = intval($row['id']);
        $name = $row['name'];
        $type = $row['type'];
        $id_parent = intval($row['id_zone']);
        $list[$id_zone]=["name"=>$name,"type"=>$type,"parent"=>$id_parent];
    }
    //var_dump($list);
    return $list;
}

function getListSelZones($projID){
    $db = dbConnect();
    $req = $db->prepare("SELECT zone.id, zone.name, zone.type, zone.id_zone
                            FROM project_perimeter
                            INNER JOIN zone
                                WHERE zone.id = project_perimeter.id_zone
                                    AND project_perimeter.id_proj = ?
                            ORDER BY zone.name");
    $req->execute(array($projID));
    $list = [];
    while($row = $req->fetch()){
        $id_zone = intval($row['id']);
        $name = $row['name'];
        $type = $row['type'];
        $id_parent = intval($row['id_zone']);
        $list[$id_zone]=["name"=>$name,"type"=>$type,"parent"=>$id_parent];
    }
    //var_dump($list);
    return $list;
}

function insertSelZones($projID,$list){
    $db = dbConnect();
    $ret = false;
    $req1 = $db->prepare("INSERT INTO project_perimeter
                            (id_proj,id_zone)
                            VALUES (?,?)");
    foreach ($list as $id_zone) {
        $ret = $req1->execute(array($projID,$id_zone));
    }
    return $ret;
}

function deleteSelZones($projID){
    $db = dbConnect();
    $req = $db->prepare("DELETE FROM project_perimeter WHERE id_proj=?");
    return $req->execute(array($projID));
}


// ---------------------------------------- SIZE ----------------------------------------

function getListMag(){
    $db = dbConnect();
    $req = $db->prepare('SELECT * FROM magnitude ORDER BY range_min');
    $req->execute();
    $list = [];
    while($row = $req->fetch()){
        $id = intval($row['id']);
        $name = $row['name'];
        $range_min = intval($row['range_min']);
        $range_max = intval($row['range_max']);
        $list[$id]=["name"=>$name,"range_min"=>$range_min,"range_max"=>$range_max];
    }
    //var_dump($list);
    return $list;   
}


function getListSelSizes($projID){
    $db = dbConnect();
    $req = $db->prepare("SELECT id_zone,id_uc,id_mag
                            FROM project_size
                            WHERE id_proj = ?");
    $req->execute(array($projID));
    $list = [];
    while($row = $req->fetch()){
        $id_zone = intval($row['id_zone']);
        $id_uc = intval($row['id_uc']);
        $id_mag = intval($row['id_mag']);
        if(array_key_exists($id_zone,$list)){
            $list[$id_zone] += [$id_uc=>$id_mag];
        } else {
            $list[$id_zone] = [$id_uc=>$id_mag];
        }
    }
    //var_dump($list);
    return $list;
}

function insertSelSizes($projID,$list){
    $db = dbConnect();
    $ret = false;
    $req = $db->prepare("INSERT INTO project_size
                            (id_proj,id_zone,id_uc,id_mag)
                            VALUES (?,?,?,?)");
    foreach ($list as $id_zone => $list_ucs) {
        foreach ($list_ucs as $id_uc => $id_mag) {
            $ret = $req->execute(array($projID,$id_zone,$id_uc,$id_mag));
        }
    }
    return $ret;
}

function deleteSelSizes($projID){
    $db = dbConnect();
    $req = $db->prepare("DELETE FROM project_size WHERE id_proj=?");
    return $req->execute(array($projID));
}


// ---------------------------------------- SIZE ----------------------------------------

function getComponents(){
    $db = dbConnect();
    $req = $db->prepare('SELECT * FROM component ORDER BY name');
    $req->execute();
    $list = [];
    while($row = $req->fetch()){
        $id = intval($row['id']);
        $name = $row['name'];
        $id_meas = intval($row['id_meas']);
        $list[$id]=["name"=>$name,"id_meas"=>$id_meas];
    }
    //var_dump($list);
    return $list;
}

function getNbCompoPerZone(){
    $db = dbConnect();
    $req = $db->prepare('SELECT id_compo,id_zone,number FROM comp_per_zone');
    $req->execute();
    $list = [];
    while($row = $req->fetch()){
        $id_compo = intval($row['id_compo']);
        $val = intval($row['number']);//number_format(round($row['number']),0,'.',' ');
        $id_zone = intval($row['id_zone']);
        if(array_key_exists($id_compo,$list)){
            $list[$id_compo]+=[$id_zone=>$val];
        } else {
            $list[$id_compo]=[$id_zone=>$val];
        }
    }
    //var_dump($list);
    return $list;
}

function getRatio(){
    $db = dbConnect();
    $req = $db->prepare('SELECT id_compo,id_uc,val FROM ratio_comp_per_uc');
    $req->execute();
    $list = [];
    while($row = $req->fetch()){
        $id_compo = intval($row['id_compo']);
        $val = number_format(round($row['val']),0,'.',' ');
        $id_uc = intval($row['id_uc']);
        if(array_key_exists($id_compo,$list)){
            $list[$id_compo]+=[$id_uc=>$val];
        } else {
            $list[$id_compo]=[$id_uc=>$val];
        }
    }
    //var_dump($list);
    return $list;
}


// ---------------------------------------- VOLUMES ----------------------------------------

function getListSelVolumes($projID){
    $db = dbConnect();
    $req = $db->prepare("SELECT id_zone,id_uc,nb_compo,nb_per_uc,nb_tot_uc
                            FROM volumes_input
                            WHERE id_proj = ?");
    $req->execute(array($projID));
    $list = [];
    while($row = $req->fetch()){
        $id_zone = intval($row['id_zone']);
        $id_uc = intval($row['id_uc']);
        $nb_compo = intval($row['nb_compo']);
        $nb_per_uc = intval($row['nb_per_uc']);
        $nb_tot_uc = intval($row['nb_tot_uc']);
        if(array_key_exists($id_zone,$list)){
            if(array_key_exists($id_uc,$list[$id_zone])){
                $list[$id_zone][$id_uc] += ['nb_compo'=>$nb_compo,'nb_per_uc'=>$nb_per_uc, 'nb_tot_uc'=>$nb_tot_uc];
            } else {
                $list[$id_zone] += [$id_uc=>['nb_compo'=>$nb_compo,'nb_per_uc'=>$nb_per_uc, 'nb_tot_uc'=>$nb_tot_uc]];
            }
        } else {
            $list[$id_zone] = [$id_uc=>['nb_compo'=>$nb_compo,'nb_per_uc'=>$nb_per_uc, 'nb_tot_uc'=>$nb_tot_uc]];
        }
    }
    //var_dump($list);
    return $list;
}


function insertSelVolumes($projID,$list){
    $db = dbConnect();
    $ret = false;
    $req = $db->prepare("INSERT INTO volumes_input
                            (id_proj,id_zone,id_uc,nb_tot_uc)
                            VALUES (?,?,?,?)");
    foreach ($list as $id_zone => $list_ucs) {
        foreach ($list_ucs as $id_uc => $data) {
            $ret = $req->execute(array($projID,$id_zone,$id_uc,$data['nb_compo']));
        }
    }
    return $ret;
}

function deleteSelVolumes($projID){
    $db = dbConnect();
    $req = $db->prepare("DELETE FROM volumes_input WHERE id_proj=?");
    return $req->execute(array($projID));
}


// ---------------------------------------- SCHEDULE ----------------------------------------

function getListSelDates($projID){
    $db = dbConnect();
    $req_implem = $db->prepare("SELECT * FROM implem_schedule WHERE id_proj = ?");
    $req_implem->execute(array($projID));
    $req_opex = $db->prepare("SELECT * FROM opex_schedule WHERE id_proj = ?");
    $req_opex->execute(array($projID));
    $req_revenue = $db->prepare("SELECT * FROM revenue_schedule WHERE id_proj = ?");
    $req_revenue->execute(array($projID));

    $list = [];

    while($row = $req_implem->fetch()){
        $id_uc = intval($row['id_uc']);
        $startdate = date_create($row['start_date'])->format('m/Y');
        $date25 = date_create($row['25_completion'])->format('m/Y');
        $date50 = date_create($row['50_completion'])->format('m/Y');
        $date75 = date_create($row['75_completion'])->format('m/Y');
        $date100 = date_create($row['100_completion'])->format('m/Y');
        if(array_key_exists('implem',$list)){
            $list['implem'][$id_uc] = [
                'startdate'=>$startdate,
                '25date'=>$date25,
                '50date'=>$date50,
                '75date'=>$date75,
                '100date'=>$date100,
                ];
        } else {
            $list['implem'] = [ $id_uc => [
                                'startdate'=>$startdate,
                                '25date'=>$date25,
                                '50date'=>$date50,
                                '75date'=>$date75,
                                '100date'=>$date100,
            ]];
        }
    }
    while($row = $req_opex->fetch()){
        $id_uc = intval($row['id_uc']);
        $startdate = date_create($row['start_date'])->format('m/Y');
        $date25 = date_create($row['25_rampup'])->format('m/Y');
        $date50 = date_create($row['50_rampup'])->format('m/Y');
        $date75 = date_create($row['75_rampup'])->format('m/Y');
        $date100 = date_create($row['100_rampup'])->format('m/Y');
        $enddate = date_create($row['end_date'])->format('m/Y');
        if(array_key_exists('opex',$list)){
            $list['opex'][$id_uc] = [
                                'startdate'=>$startdate,
                                '25date'=>$date25,
                                '50date'=>$date50,
                                '75date'=>$date75,
                                '100date'=>$date100,
                                'enddate'=>$enddate,
            ];
        } else {
                $list['opex'] = [$id_uc => [
                'startdate'=>$startdate,
                '25date'=>$date25,
                '50date'=>$date50,
                '75date'=>$date75,
                '100date'=>$date100,
                'enddate'=>$enddate,
            ]];
        }
    }
    while($row = $req_revenue->fetch()){
        $id_uc = intval($row['id_uc']);
        $startdate = $row['start_date'] ? date_create($row['start_date'])->format('m/Y') : null;
        $date25 = $row['25_rampup'] ? date_create($row['25_rampup'])->format('m/Y') : null;
        $date50 = $row['50_rampup'] ? date_create($row['50_rampup'])->format('m/Y') : null;
        $date75 = $row['75_rampup'] ? date_create($row['75_rampup'])->format('m/Y') : null;
        $date100 = $row['100_rampup'] ? date_create($row['100_rampup'])->format('m/Y') : null;
        $enddate = $row['end_date'] ? date_create($row['end_date'])->format('m/Y') : null;
        if(array_key_exists('revenues',$list)){
            $list['revenues'][$id_uc] = [
                                'startdate'=>$startdate,
                                '25date'=>$date25,
                                '50date'=>$date50,
                                '75date'=>$date75,
                                '100date'=>$date100,
                                'enddate'=>$enddate,
            ];
        } else {
            $list['revenues'] = [$id_uc => [
                                'startdate'=>$startdate,
                                '25date'=>$date25,
                                '50date'=>$date50,
                                '75date'=>$date75,
                                '100date'=>$date100,
                                'enddate'=>$enddate,
            ]];
        }
    }
    //var_dump($list);
    return $list;
}

function insertSelDates($projID,$list){
    $db = dbConnect();
    $ret = false;
    $req_implem = $db->prepare("INSERT INTO implem_schedule
                            (id_proj,id_uc,start_date,25_completion,50_completion,75_completion,100_completion)
                            VALUES (?,?,?,?,?,?,?)");
    $req_opex = $db->prepare("INSERT INTO opex_schedule
                            (id_proj,id_uc,start_date,25_rampup,50_rampup,75_rampup,100_rampup,end_date)
                            VALUES (?,?,?,?,?,?,?,?)");
    $req_revenue = $db->prepare("INSERT INTO revenue_schedule
                            (id_proj,id_uc,start_date,25_rampup,50_rampup,75_rampup,100_rampup,end_date)
                            VALUES (?,?,?,?,?,?,?,?)");
    foreach ($list['implem'] as $id_uc => $data) {
        $ret = $req_implem->execute(array($projID,$id_uc,$data['startdate'],$data['25date'],$data['50date'],$data['75date'],$data['100date']));
    }
    foreach ($list['opex'] as $id_uc => $data) {
        $ret = $req_opex->execute(array($projID,$id_uc,$data['startdate'],$data['25date'],$data['50date'],$data['75date'],$data['100date'],$data['enddate']));
    }
    foreach ($list['revenues'] as $id_uc => $data) {
        $ret = $req_revenue->execute(array($projID,$id_uc,$data['startdate'],$data['25date'],$data['50date'],$data['75date'],$data['100date'],$data['enddate']));
    }
    return $ret;
}


function deleteSelDates($projID){
    $db = dbConnect();
    $req_implem = $db->prepare("DELETE FROM implem_schedule WHERE id_proj=?");
    $req_opex = $db->prepare("DELETE FROM opex_schedule WHERE id_proj=?");
    $req_revenue = $db->prepare("DELETE FROM revenue_schedule WHERE id_proj=?");
    return $req_implem->execute(array($projID))&&$req_opex->execute(array($projID))&&$req_revenue->execute(array($projID));
}


// ---------------------------------------- DISCOUNT RATE ----------------------------------------

function getListSelDiscountRate($projID){
    $db = dbConnect();
    $req = $db->prepare("SELECT discount_rate FROM project WHERE id = ?");
    $req->execute(array($projID));
    $res = $req->fetch();
    return floatval($res['discount_rate']);
}

function insertSelDiscountRate($projID,$val){
    $db = dbConnect();
    $ret = false;
    $req = $db->prepare("UPDATE project
                            SET discount_rate = ?
                            WHERE id = ?");
    $ret = $req->execute(array($val,$projID));
    return $ret;
}








// ---------------------------------------- CAPEX----------------------------------------

function getCapexUserItem($projID,$ucID,$name){
    $db = dbConnect();
    $req = $db->prepare("SELECT *
                            FROM capex_item_user
                            INNER JOIN capex_uc
                                INNER JOIN capex_item
                                    WHERE capex_item_user.id_proj = ?
                                        and capex_item.id = capex_item_user.id
                                        and capex_uc.id_uc = ?
                                        and capex_item.name = ?
                        ");
    $req->execute(array($projID,$ucID,$name));
    return $req->fetchAll();
}

function getListCapexAdvice($ucID, $origine = "all"){
/* 
CAPEX_ITEM_ADVICE
id int(11)            id of the advice
unit varchar(255)     ex: per lamppost
source text 
range_min int(11) 
range_max

CAPEX_UC
id_item int(11) PK 
id_uc int(11) PK

CAPEX_ITEM_ADVICE
id int(11) AI PK 
name varchar(255) 
description text
*/
    $db = dbConnect();
    $origine_selection = "";

    if($origine=="from_ntt"){
        $origine_selection = "and capex_item.origine = 'from_ntt'";
    }elseif($origine == "from_outside_ntt"){
        $origine_selection = "and capex_item.origine = 'from_outside_ntt'";
    }elseif($origine == "internal"){
               $origine_selection = "and capex_item.origine = 'internal'";
    }

    $req = $db->prepare("SELECT *
                            FROM capex_item_advice
                            INNER JOIN capex_uc
                                INNER JOIN capex_item
                                    WHERE capex_uc.id_uc = ?
                                        and capex_item.id = capex_uc.id_item
                                        and capex_item.id = capex_item_advice.id
                                        $origine_selection
                            ORDER BY name
                            ");
    $req->execute(array($ucID));

    $list = [];
    while($row = $req->fetch()){
        $id_item = intval($row['id']);
        $name = $row['name'];
        $description = $row['description'];
        $unit = $row['unit'];
        $source = $row['source'];
        $range_min = intval($row['range_min']);
        $range_max = intval($row['range_max']);
        if(array_key_exists($id_item,$list)){
            $list[$id_item] += ['name'=>$name,'description'=>$description,'unit'=>$unit,'source'=>$source,'range_min'=>$range_min,'range_max'=>$range_max];
        } else {
            $list[$id_item] = ['name'=>$name,'description'=>$description,'unit'=>$unit,'source'=>$source,'range_min'=>$range_min,'range_max'=>$range_max];
        }
    }
    //var_dump($list);
    return $list;
}

function getListCapexItems($ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT DISTINCT capex_item.id,name,description,unit,source,range_min,range_max
                            FROM capex_item
                            LEFT JOIN capex_item_advice
                                ON capex_item.id = capex_item_advice.id
                            LEFT JOIN capex_uc
                                ON capex_item.id = capex_uc.id_item
                                    
                            WHERE capex_uc.id_uc = ?
                            ORDER BY name
                            ");
    $req->execute(array($ucID));

    $list = [];
    while($row = $req->fetch()){
        $id_item = intval($row['id']);
        $name = $row['name'];
        $description = $row['description'];
        $unit = $row['unit'];
        $source = $row['source'];
        $range_min = intval($row['range_min']);
        $range_max = intval($row['range_max']);
        if(array_key_exists($id_item,$list)){
            $list[$id_item] += ['name'=>$name,'description'=>$description,'unit'=>$unit,'source'=>$source,'range_min'=>$range_min,'range_max'=>$range_max];
        } else {
            $list[$id_item] = ['name'=>$name,'description'=>$description,'unit'=>$unit,'source'=>$source,'range_min'=>$range_min,'range_max'=>$range_max];
        }
    }
    //var_dump($list);
    return $list;
}

function getListCapexUser($projID,$ucID, $origine = "all"){
    $db = dbConnect();
    $origine_selection = "";

    if($origine=="from_ntt"){
        $origine_selection = "and capex_item.origine = 'from_ntt'";
    }elseif($origine == "from_outside_ntt"){
        $origine_selection = "and capex_item.origine = 'from_outside_ntt'";
    }elseif($origine == "internal"){
               $origine_selection = "and capex_item.origine = 'internal'";
    }

    $req = $db->prepare("SELECT capex_item.id,name,description
                            FROM capex_item_user
                            INNER JOIN capex_uc
                                INNER JOIN capex_item
                                    WHERE capex_uc.id_uc = ?
                                        and capex_item.id = capex_uc.id_item
                                        and capex_item_user.id_proj = ?
                                        and capex_item_user.id = capex_item.id
                                        $origine_selection
                            ORDER BY name
                            ");
    $req->execute(array($ucID,$projID));

    $list = [];
    while($row = $req->fetch()){
        $id_item = intval($row['id']);
        $name = $row['name'];
        $description = $row['description'];
        if(array_key_exists($id_item,$list)){
            $list[$id_item] += ['name'=>$name,'description'=>$description];
        } else {
            $list[$id_item] = ['name'=>$name,'description'=>$description];
        }
    }
    return $list;
}

function getListSelCapex($projID,$ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT id_item,unit_cost,volume,period
                            FROM input_capex
                            INNER JOIN capex_item
                                WHERE  input_capex.id_uc = ? and id_proj = ? and id_item = capex_item.id
                            ORDER BY capex_item.name
                            ");
    $req->execute(array($ucID,$projID));

    $list = [];
    while($row = $req->fetch()){
        $id_item = intval($row['id_item']);
        $unit_cost = convertGBPToDev(floatval($row['unit_cost']));
        $volume = intval($row['volume']);
        $period = intval($row['period']);
        if(array_key_exists($id_item,$list)){
            $list[$id_item] += ['unit_cost'=>$unit_cost,'volume'=>$volume,'period'=>$period];
        } else {
            $list[$id_item] = ['unit_cost'=>$unit_cost,'volume'=>$volume,'period'=>$period];
        }
    }
    //var_dump($list);
    return $list;
}


function insertCapexUser($projID,$ucID,$capex_data, $origine="NULL"){
    $db = dbConnect();
    $ret = false;
    $db->exec('DROP PROCEDURE IF EXISTS `add_capex`;');
    $db->exec(' CREATE PROCEDURE `add_capex`(
                            IN capex_name VARCHAR(255),
                            IN capex_desc VARCHAR(255),
                            IN idUC INT,
                            IN idProj INT,
                            IN origine VARCHAR(255)
                            )
                            BEGIN
                                DECLARE itemID INT;
                                INSERT INTO capex_item (name,description, origine)
                                    VALUES (capex_name,capex_desc, origine);
                                SET itemID = LAST_INSERT_ID();
                                INSERT INTO capex_uc (id_item,id_uc)
                                    VALUES (itemID,idUC);
                                INSERT INTO capex_item_user (id,id_proj)
                                    VALUES (itemID,idProj);
                            END
                                ');
    $req = $db->prepare('CALL add_capex(?,?,?,?, ?);');
    $ret = $req->execute(array($capex_data['name'],$capex_data['description'],$ucID,$projID, $origine));
    return $ret;
}

function deleteCapexUser($idCapex){
    $db = dbConnect();
    $req = $db->prepare('DELETE FROM capex_item WHERE id = ?');
    return $req->execute(array($idCapex));
}

function insertSelCapex($projID,$ucID,$list){
    $db = dbConnect();
    $ret = false;
    $req = $db->prepare("INSERT INTO input_capex
                            (id_item,id_proj,id_uc)
                            VALUES (?,?,?)");
    foreach ($list as $id_item) {
        $ret = $req->execute(array($id_item,$projID,$ucID));
    }
    return $ret;
}

function deleteSelCapex($projID,$ucID,$list){
    $ret = false;
    $db = dbConnect();
    $req = $db->prepare("DELETE FROM input_capex WHERE id_proj = ? and id_uc = ? and id_item = ?");
    foreach ($list as $id_item) {
        $ret = $req->execute(array($projID,$ucID,$id_item));
    }
    return $ret;
}

function getCompoByUC($ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT component.id,component.name
                            FROM component
                            INNER JOIN use_case
                                WHERE component.id_meas = use_case.id_meas
                                    and component.id = use_case.id");
    $req->execute(array($ucID));
    $res = $req->fetch();
    if($res){
        $id_compo = intval($res['id']);
        $name = $res['name'];
        return ["id"=>$id_compo,"name"=>$name];
    } else {
        return [];
    }
}

function getRatioCompoCapex($list_item,$compoID){
    $db = dbConnect();
    $req = $db->prepare("SELECT val FROM ratio_comp_capex WHERE id_compo = ? and id_item = ?");
    
    $list = [];
    foreach ($list_item as $id_item) {
        $req->execute(array($compoID,$id_item));
        $res = $req->fetch();
        $val = $res ? floatval($res['val']) : -1;
        if(array_key_exists($id_item,$list)){
            $list[$id_item] += ['val'=>$val];
        } else {
            $list[$id_item] = ['val'=>$val];
        }
    }
    //var_dump($list);
    return $list;
}

function insertCapexInputed($projID,$ucID,$list){
    $db = dbConnect();
    $ret = false;
    $req = $db->prepare("UPDATE input_capex
                            SET volume = ?,
                                unit_cost = ?,
                                period = ?
                            WHERE id_proj = ? and id_uc = ? and id_item = ?");
    foreach ($list as $id_item => $data) {
        $ret = $req->execute(array($data['volume'],convertDevToGBP($data['unit_cost']),$data['period'],$projID,$ucID,$id_item));
    }
    return $ret;
}

function getNbTotalCompoForAllZones($compoID){
    $db = dbConnect();
    $req = $db->prepare("SELECT SUM(number) FROM comp_per_zone WHERE id_compo = ?");
    $req->execute(array($compoID));
    $res = intval($req->fetch()[0]);
    return number_format($res, 0, ',', ' ');
}

function getNbTotalCompoForSelectedZone($compoID, $zoneID){
    $db = dbConnect();
    $req = $db->prepare("SELECT number FROM comp_per_zone WHERE id_compo = ? and id_zone = ?");
    $req->execute(array($compoID,$zoneID));
    $res = intval($req->fetch()[0]);
    return $res;
}

function getNbTotalUC($projID,$ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT SUM(nb_tot_uc)
                            FROM volumes_input
                            WHERE id_proj = ?
                                and id_uc = ?");
    $req->execute(array($projID,$ucID));
    $res = intval($req->fetch()[0]);
    return $res;
}

function deleteAllSelCapex($projID,$ucID){
    $ret = false;
    $db = dbConnect();
    $req = $db->prepare("DELETE FROM input_capex WHERE id_proj = ? and id_uc = ?");
    $ret = $req->execute(array($projID,$ucID));
    return $ret;
}




// ---------------------------------------- IMPLEM----------------------------------------

function getImplemUserItem($projID,$ucID,$name){
    $db = dbConnect();
    $req = $db->prepare("SELECT *
                            FROM implem_item_user
                            INNER JOIN implem_uc
                                INNER JOIN implem_item
                                    WHERE implem_item_user.id_proj = ?
                                        and implem_item.id = implem_item_user.id
                                        and implem_uc.id_uc = ?
                                        and implem_item.name = ?
                        ");
    $req->execute(array($projID,$ucID,$name));
    return $req->fetchAll();
}

function getListImplemAdvice($ucID, $origine = "all"){
    $db = dbConnect();
    $origine_selection = "";

    if($origine=="from_ntt"){
        $origine_selection = "and implem_item.origine = 'from_ntt'";
    }elseif($origine == "from_outside_ntt"){
        $origine_selection = "and implem_item.origine = 'from_outside_ntt'";
    }elseif($origine == "internal"){
               $origine_selection = "and implem_item.origine = 'internal'";
    }

    
    $req = $db->prepare("SELECT *
                            FROM implem_item_advice
                            INNER JOIN implem_uc
                                INNER JOIN implem_item
                                    WHERE implem_uc.id_uc = ?
                                        and implem_item.id = implem_uc.id_item
                                        and implem_item.id = implem_item_advice.id
                                        $origine_selection
                            ORDER BY name
                            ");
    $req->execute(array($ucID));

    $list = [];
    while($row = $req->fetch()){
        $id_item = intval($row['id']);
        $name = $row['name'];
        $description = $row['description'];
        $unit = $row['unit'];
        $source = $row['source'];
        $range_min = intval($row['range_min']);
        $range_max = intval($row['range_max']);
        if(array_key_exists($id_item,$list)){
            $list[$id_item] += ['name'=>$name,'description'=>$description,'unit'=>$unit,'source'=>$source,'range_min'=>$range_min,'range_max'=>$range_max];
        } else {
            $list[$id_item] = ['name'=>$name,'description'=>$description,'unit'=>$unit,'source'=>$source,'range_min'=>$range_min,'range_max'=>$range_max];
        }
    }
    //var_dump($list);
    return $list;
}

function getListImplemItems($ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT DISTINCT implem_item.id,name,description,unit,source,range_min,range_max
                            FROM implem_item
                            LEFT JOIN implem_item_advice
                                ON implem_item.id = implem_item_advice.id
                            LEFT JOIN implem_uc
                                ON implem_item.id = implem_uc.id_item
                                    
                            WHERE implem_uc.id_uc = ?
                            ORDER BY name
                            ");
    $req->execute(array($ucID));

    $list = [];
    while($row = $req->fetch()){
        $id_item = intval($row['id']);
        $name = $row['name'];
        $description = $row['description'];
        $unit = $row['unit'];
        $source = $row['source'];
        $range_min = intval($row['range_min']);
        $range_max = intval($row['range_max']);
        if(array_key_exists($id_item,$list)){
            $list[$id_item] += ['name'=>$name,'description'=>$description,'unit'=>$unit,'source'=>$source,'range_min'=>$range_min,'range_max'=>$range_max];
        } else {
            $list[$id_item] = ['name'=>$name,'description'=>$description,'unit'=>$unit,'source'=>$source,'range_min'=>$range_min,'range_max'=>$range_max];
        }
    }
    //var_dump($list);
    return $list;
}

function getListImplemUser($projID,$ucID,  $origine = "all"){
    $db = dbConnect();
    $origine_selection = "";


    if($origine=="from_ntt"){
        $origine_selection = "and implem_item.origine = 'from_ntt'";
    }elseif($origine == "from_outside_ntt"){
        $origine_selection = "and implem_item.origine = 'from_outside_ntt'";
    }elseif($origine == "internal"){
               $origine_selection = "and implem_item.origine = 'internal'";
    }

    $req = $db->prepare("SELECT implem_item.id,name,description
                            FROM implem_item_user
                            INNER JOIN implem_uc
                                INNER JOIN implem_item
                                    WHERE implem_uc.id_uc = ?
                                        and implem_item.id = implem_uc.id_item
                                        and implem_item_user.id_proj = ?
                                        and implem_item_user.id = implem_item.id
                                        $origine_selection
                            ORDER BY name
                            ");
    $req->execute(array($ucID,$projID));

    $list = [];
    while($row = $req->fetch()){
        $id_item = intval($row['id']);
        $name = $row['name'];
        $description = $row['description'];
        if(array_key_exists($id_item,$list)){
            $list[$id_item] += ['name'=>$name,'description'=>$description];
        } else {
            $list[$id_item] = ['name'=>$name,'description'=>$description];
        }
    }
    //var_dump($list);
    return $list;

}

function getListSelImplem($projID,$ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT id_item,unit_cost,volume
                            FROM input_implem
                            INNER JOIN implem_item
                                WHERE  input_implem.id_uc = ? and id_proj = ? and id_item = implem_item.id
                            ORDER BY implem_item.name
                            ");
    $req->execute(array($ucID,$projID));

    $list = [];
    while($row = $req->fetch()){
        $id_item = intval($row['id_item']);
        $unit_cost = convertGBPToDev(floatval($row['unit_cost']));
        $volume = intval($row['volume']);
        if(array_key_exists($id_item,$list)){
            $list[$id_item] += ['unit_cost'=>$unit_cost,'volume'=>$volume];
        } else {
            $list[$id_item] = ['unit_cost'=>$unit_cost,'volume'=>$volume];
        }
    }
    //var_dump($list);
    return $list;
}

function insertImplemUser($projID,$ucID,$implem_data, $origine="NULL"){
    $db = dbConnect();
    $ret = false;
    $db->exec('DROP PROCEDURE IF EXISTS `add_implem`;');
    $db->exec(' CREATE PROCEDURE `add_implem`(
                            IN implem_name VARCHAR(255),
                            IN implem_desc VARCHAR(255),
                            IN idUC INT,
                            IN idProj INT,
                            IN origine VARCHAR(255)
                            )
                            BEGIN
                                DECLARE itemID INT;
                                INSERT INTO implem_item (name,description, origine)
                                    VALUES (implem_name,implem_desc, origine);
                                SET itemID = LAST_INSERT_ID();
                                INSERT INTO implem_uc (id_item,id_uc)
                                    VALUES (itemID,idUC);
                                INSERT INTO implem_item_user (id,id_proj)
                                    VALUES (itemID,idProj);
                            END
                                ');
    $req = $db->prepare('CALL add_implem(?,?,?,?,?);');
    $ret = $req->execute(array($implem_data['name'],$implem_data['description'],$ucID,$projID,$origine));
    return $ret;
}

function deleteImplemUser($idImplem){
    $db = dbConnect();
    $req = $db->prepare('DELETE FROM implem_item WHERE id = ?');
    return $req->execute(array($idImplem));
}

function insertSelImplem($projID,$ucID,$list){
    $db = dbConnect();
    $ret = false;
    $req = $db->prepare("INSERT INTO input_implem
                            (id_item,id_proj,id_uc)
                            VALUES (?,?,?)");
    foreach ($list as $id_item) {
        $ret = $req->execute(array($id_item,$projID,$ucID));
    }
    return $ret;
}

function deleteSelImplem($projID,$ucID,$list){
    $ret = false;
    $db = dbConnect();
    $req = $db->prepare("DELETE FROM input_implem WHERE id_proj = ? and id_uc = ? and id_item = ?");
    foreach ($list as $id_item) {
        $ret = $req->execute(array($projID,$ucID,$id_item));
    }
    return $ret;
}

function getRatioCompoImplem($list_item,$compoID){
    $db = dbConnect();
    $req = $db->prepare("SELECT val FROM ratio_comp_implem WHERE id_compo = ? and id_item = ?");
    
    $list = [];
    foreach ($list_item as $id_item) {
        $req->execute(array($compoID,$id_item));
        $res = $req->fetch();
        $val = $res ? floatval($res['val']) : -1;
        if(array_key_exists($id_item,$list)){
            $list[$id_item] += ['val'=>$val];
        } else {
            $list[$id_item] = ['val'=>$val];
        }
    }
    //var_dump($list);
    return $list;
}

function insertImplemInputed($projID,$ucID,$list){
    $db = dbConnect();
    $ret = false;
    $req = $db->prepare("UPDATE input_implem
                            SET volume = ?,
                                unit_cost = ?
                            WHERE id_proj = ? and id_uc = ? and id_item = ?");
    foreach ($list as $id_item => $data) {
        $ret = $req->execute(array($data['volume'],convertDevToGBP($data['unit_cost']),$projID,$ucID,$id_item));
    }
    return $ret;
}

function deleteAllSelImplem($projID,$ucID){
    $ret = false;
    $db = dbConnect();
    $req = $db->prepare("DELETE FROM input_implem WHERE id_proj = ? and id_uc = ?");
    $ret = $req->execute(array($projID,$ucID));
    return $ret;
}


// ---------------------------------------- OPEX----------------------------------------

function getOpexUserItem($projID,$ucID,$name){
    $db = dbConnect();
    $req = $db->prepare("SELECT *
                            FROM opex_item_user
                            INNER JOIN opex_uc
                                INNER JOIN opex_item
                                    WHERE opex_item_user.id_proj = ?
                                        and opex_item.id = opex_item_user.id
                                        and opex_uc.id_uc = ?
                                        and opex_item.name = ?
                        ");
    $req->execute(array($projID,$ucID,$name));
    return $req->fetchAll();
}

function getListOpexAdvice($ucID, $origine = "all"){
    $db = dbConnect();
    $origine_selection = "";

    if($origine=="from_ntt"){
        $origine_selection = "and opex_item.origine = 'from_ntt'";
    }elseif($origine == "from_outside_ntt"){
        $origine_selection = "and opex_item.origine = 'from_outside_ntt'";
    }elseif($origine == "internal"){
               $origine_selection = "and opex_item.origine = 'internal'";
    }

    $req = $db->prepare("SELECT *
                            FROM opex_item_advice
                            INNER JOIN opex_uc
                                INNER JOIN opex_item
                                    WHERE opex_uc.id_uc = ?
                                        and opex_item.id = opex_uc.id_item
                                        and opex_item.id = opex_item_advice.id
                                        $origine_selection
                            ORDER BY name
                            ");
    $req->execute(array($ucID));

    $list = [];
    while($row = $req->fetch()){
        $id_item = intval($row['id']);
        $name = $row['name'];
        $description = $row['description'];
        $unit = $row['unit'];
        $source = $row['source'];
        $range_min = intval($row['range_min']);
        $range_max = intval($row['range_max']);
        if(array_key_exists($id_item,$list)){
            $list[$id_item] += ['name'=>$name,'description'=>$description,'unit'=>$unit,'source'=>$source,'range_min'=>$range_min,'range_max'=>$range_max];
        } else {
            $list[$id_item] = ['name'=>$name,'description'=>$description,'unit'=>$unit,'source'=>$source,'range_min'=>$range_min,'range_max'=>$range_max];
        }
    }
    //var_dump($list);
    return $list;
}

function getListOpexItems($ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT DISTINCT opex_item.id,name,description,unit,source,range_min,range_max
                            FROM opex_item
                            LEFT JOIN opex_item_advice
                                ON opex_item.id = opex_item_advice.id
                            LEFT JOIN opex_uc
                                ON opex_item.id = opex_uc.id_item
                                    
                            WHERE opex_uc.id_uc = ?
                            ORDER BY name
                            ");
    $req->execute(array($ucID));

    $list = [];
    while($row = $req->fetch()){
        $id_item = intval($row['id']);
        $name = $row['name'];
        $description = $row['description'];
        $unit = $row['unit'];
        $source = $row['source'];
        $range_min = intval($row['range_min']);
        $range_max = intval($row['range_max']);
        if(array_key_exists($id_item,$list)){
            $list[$id_item] += ['name'=>$name,'description'=>$description,'unit'=>$unit,'source'=>$source,'range_min'=>$range_min,'range_max'=>$range_max];
        } else {
            $list[$id_item] = ['name'=>$name,'description'=>$description,'unit'=>$unit,'source'=>$source,'range_min'=>$range_min,'range_max'=>$range_max];
        }
    }
    //var_dump($list);
    return $list;
}

function getListOpexUser($projID,$ucID, $origine = "all"){
    $db = dbConnect();
    $origine_selection = "";

    if($origine=="from_ntt"){
        $origine_selection = "and opex_item.origine = 'from_ntt'";
    }elseif($origine == "from_outside_ntt"){
        $origine_selection = "and opex_item.origine = 'from_outside_ntt'";
    }elseif($origine == "internal"){
               $origine_selection = "and opex_item.origine = 'internal'";
    }


    $req = $db->prepare("SELECT opex_item.id,name,description
                            FROM opex_item_user
                            INNER JOIN opex_uc
                                INNER JOIN opex_item
                                    WHERE opex_uc.id_uc = ?
                                        and opex_item.id = opex_uc.id_item
                                        and opex_item_user.id_proj = ?
                                        and opex_item_user.id = opex_item.id
                                        $origine_selection
                            ORDER BY name
                            ");
    $req->execute(array($ucID,$projID));

    $list = [];
    while($row = $req->fetch()){
        $id_item = intval($row['id']);
        $name = $row['name'];
        $description = $row['description'];
        if(array_key_exists($id_item,$list)){
            $list[$id_item] += ['name'=>$name,'description'=>$description];
        } else {
            $list[$id_item] = ['name'=>$name,'description'=>$description];
        }
    }
    //var_dump($list);
    return $list;

}

function getListSelOpex($projID,$ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT id_item,unit_cost,volume,annual_variation_volume,annual_variation_unitcost
                            FROM input_opex
                            INNER JOIN opex_item
                                WHERE  input_opex.id_uc = ? and id_proj = ? and id_item = opex_item.id
                            ORDER BY opex_item.name
                            ");
    $req->execute(array($ucID,$projID));

    $list = [];
    while($row = $req->fetch()){
        $id_item = intval($row['id_item']);
        $unit_cost = convertGBPToDev(floatval($row['unit_cost']));
        $volume = intval($row['volume']);
        $anVarVol = floatval($row['annual_variation_volume']);
        $anVarCost = floatval($row['annual_variation_unitcost']);
        if(array_key_exists($id_item,$list)){
            $list[$id_item] += ['unit_cost'=>$unit_cost,'volume'=>$volume,'anVarVol'=>$anVarVol,'anVarCost'=>$anVarCost];
        } else {
            $list[$id_item] = ['unit_cost'=>$unit_cost,'volume'=>$volume,'anVarVol'=>$anVarVol,'anVarCost'=>$anVarCost];
        }
    }
    //var_dump($list);
    return $list;
}


function insertOpexUser($projID,$ucID,$opex_data, $origine="NULL"){
    $db = dbConnect();
    $ret = false;
    $db->exec('DROP PROCEDURE IF EXISTS `add_opex`;');
    $db->exec(' CREATE PROCEDURE `add_opex`(
                            IN opex_name VARCHAR(255),
                            IN opex_desc VARCHAR(255),
                            IN idUC INT,
                            IN idProj INT,
                            IN origine VARCHAR(255)
                            )
                            BEGIN
                                DECLARE itemID INT;
                                INSERT INTO opex_item (name,description, origine)
                                    VALUES (opex_name,opex_desc, origine);
                                SET itemID = LAST_INSERT_ID();
                                INSERT INTO opex_uc (id_item,id_uc)
                                    VALUES (itemID,idUC);
                                INSERT INTO opex_item_user (id,id_proj)
                                    VALUES (itemID,idProj);
                            END
                                ');
    //var_dump($projID,$ucID,$opex_data);
    $req = $db->prepare('CALL add_opex(?,?,?,?, ?);');
    $ret = $req->execute(array($opex_data['name'],$opex_data['description'],$ucID,$projID, $origine));
    return $ret;
}

function deleteOpexUser($idOpex){
    $db = dbConnect();
    $req = $db->prepare('DELETE FROM opex_item WHERE id = ?');
    return $req->execute(array($idOpex));
}

function insertSelOpex($projID,$ucID,$list){
    $db = dbConnect();
    $ret = false;
    $req = $db->prepare("INSERT INTO input_opex
                            (id_item,id_proj,id_uc)
                            VALUES (?,?,?)");
    foreach ($list as $id_item) {
        $ret = $req->execute(array($id_item,$projID,$ucID));
    }
    return $ret;
}

function deleteSelOpex($projID,$ucID,$list){
    $ret = false;
    $db = dbConnect();
    $req = $db->prepare("DELETE FROM input_opex WHERE id_proj = ? and id_uc = ? and id_item = ?");
    foreach ($list as $id_item) {
        $ret = $req->execute(array($projID,$ucID,$id_item));
    }
    return $ret;
}

function getRatioCompoOpex($list_item,$compoID){
    $db = dbConnect();
    $req = $db->prepare("SELECT val FROM ratio_comp_opex WHERE id_compo = ? and id_item = ?");
    
    $list = [];
    foreach ($list_item as $id_item) {
        $req->execute(array($compoID,$id_item));
        $res = $req->fetch();
        $val = $res ? floatval($res['val']) : -1;
        if(array_key_exists($id_item,$list)){
            $list[$id_item] += ['val'=>$val];
        } else {
            $list[$id_item] = ['val'=>$val];
        }
    }
    //var_dump($list);
    return $list;
}

function insertOpexInputed($projID,$ucID,$list){
    $db = dbConnect();
    $ret = false;
    $req = $db->prepare("UPDATE input_opex
                            SET volume = ?,
                                unit_cost = ?,
                                annual_variation_volume = ?,
                                annual_variation_unitcost = ?
                            WHERE id_proj = ? and id_uc = ? and id_item = ?");
    foreach ($list as $id_item => $data) {
        $ret = $req->execute(array($data['volume'],convertDevToGBP($data['unit_cost']),$data['anVarVol'],$data['anVarCost'],$projID,$ucID,$id_item));
    }
    return $ret;
}

function deleteAllSelOpex($projID,$ucID){
    $ret = false;
    $db = dbConnect();
    $req = $db->prepare("DELETE FROM input_opex WHERE id_proj = ? and id_uc = ?");
    $ret = $req->execute(array($projID,$ucID));
    return $ret;
}

// ------------------------------------ PROJECR KEY DATES (COMMON SCHEDULE) ------------------
function getProjetKeyDates($projID) {
    $db = dbConnect();
    $req = $db->prepare("SELECT * FROM project_dates WHERE id_project = ?");
    $req->execute(array($projID));
    return $req->fetchAll();
}

function insertProjetKeyDates($projID, $startDate, $duration, $deployStartDate, $deployDuration) {
    $db = dbConnect();
    $ret = false;
    $req = $db->prepare("INSERT INTO project_dates
                            (id_project, start_date, duration, deploy_start_date, deploy_duration)
                            VALUES (?,?,?,?,?)");
    $ret = $req->execute(array($projID, $startDate, $duration, $deployStartDate, $deployDuration));
    
    return $ret;
}


// ---------------------------------------- REVENUES----------------------------------------

function getEquipmentRevenues($projID,$ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT * FROM equipment_revenues");
    $req->execute(array($projID,$ucID));
    return $req->fetchAll();
}

function createEquipmentRevenue($projID, $ucID, $name, $cost_per_unit, $nb_units) {
    $db = dbConnect();
    $ret = false;
    $req = $db->prepare("INSERT INTO equipment_revenues
                            (name, price_per_unit, nb_units)
                            VALUES (?,?,?)");
    $ret = $req->execute(array($name, $cost_per_unit, $nb_units));
    
    return $ret;
}

function getRevenuesUserItem($projID,$ucID,$name){
    $db = dbConnect();
    $req = $db->prepare("SELECT *
                            FROM revenues_item_user
                            INNER JOIN revenues_uc
                                INNER JOIN revenues_item
                                    WHERE revenues_item_user.id_proj = ?
                                        and revenues_item.id = revenues_item_user.id
                                        and revenues_uc.id_uc = ?
                                        and revenues_item.name = ?
                        ");
    $req->execute(array($projID,$ucID,$name));
    return $req->fetchAll();
}

function getListRevenuesAdvice($ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT *
                            FROM revenues_item_advice
                            INNER JOIN revenues_uc
                                INNER JOIN revenues_item
                                    WHERE revenues_uc.id_uc = ?
                                        and revenues_item.id = revenues_uc.id_item
                                        and revenues_item.id = revenues_item_advice.id
                            ORDER BY name
                            ");
    $req->execute(array($ucID));

    $list = [];
    while($row = $req->fetch()){
        $id_item = intval($row['id']);
        $name = $row['name'];
        $description = $row['description'];
        $unit = $row['unit'];
        $source = $row['source'];
        $range_min = intval($row['range_min']);
        $range_max = intval($row['range_max']);
        if(array_key_exists($id_item,$list)){
            $list[$id_item] += ['name'=>$name,'description'=>$description,'unit'=>$unit,'source'=>$source,'range_min'=>$range_min,'range_max'=>$range_max];
        } else {
            $list[$id_item] = ['name'=>$name,'description'=>$description,'unit'=>$unit,'source'=>$source,'range_min'=>$range_min,'range_max'=>$range_max];
        }
    }
    //var_dump($list);
    return $list;
}

function getListRevenuesItems($ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT DISTINCT revenues_item.id,name,description,unit,source,range_min,range_max
                            FROM revenues_item
                            LEFT JOIN revenues_item_advice
                                ON revenues_item.id = revenues_item_advice.id
                            LEFT JOIN revenues_uc
                                ON revenues_item.id = revenues_uc.id_item
                                    
                            WHERE revenues_uc.id_uc = ?
                            ORDER BY name
                            ");
    $req->execute(array($ucID));

    $list = [];
    while($row = $req->fetch()){
        $id_item = intval($row['id']);
        $name = $row['name'];
        $description = $row['description'];
        $unit = $row['unit'];
        $source = $row['source'];
        $range_min = intval($row['range_min']);
        $range_max = intval($row['range_max']);
        if(array_key_exists($id_item,$list)){
            $list[$id_item] += ['name'=>$name,'description'=>$description,'unit'=>$unit,'source'=>$source,'range_min'=>$range_min,'range_max'=>$range_max];
        } else {
            $list[$id_item] = ['name'=>$name,'description'=>$description,'unit'=>$unit,'source'=>$source,'range_min'=>$range_min,'range_max'=>$range_max];
        }
    }
    return $list;
}

function getListRevenuesUser($projID,$ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT revenues_item.id,name,description
                            FROM revenues_item_user
                            INNER JOIN revenues_uc
                                INNER JOIN revenues_item
                                    WHERE revenues_uc.id_uc = ?
                                        and revenues_item.id = revenues_uc.id_item
                                        and revenues_item_user.id_proj = ?
                                        and revenues_item_user.id = revenues_item.id
                            ORDER BY name
                            ");
    $req->execute(array($ucID,$projID));

    $list = [];
    while($row = $req->fetch()){
        $id_item = intval($row['id']);
        $name = $row['name'];
        $description = $row['description'];
        if(array_key_exists($id_item,$list)){
            $list[$id_item] += ['name'=>$name,'description'=>$description];
        } else {
            $list[$id_item] = ['name'=>$name,'description'=>$description];
        }
    }
    return $list;

}

function getListSelRevenues($projID,$ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT id_item,revenues_per_unit,volume,annual_variation_volume,annual_variation_unitcost
                            FROM input_revenues
                            INNER JOIN revenues_item
                                WHERE  input_revenues.id_uc = ? and id_proj = ? and id_item = revenues_item.id
                            ORDER BY revenues_item.name
                            ");
    $req->execute(array($ucID,$projID));

    $list = [];
    while($row = $req->fetch()){
        $id_item = intval($row['id_item']);
        $unit_rev = convertGBPToDev(floatval($row['revenues_per_unit']));
        $volume = intval($row['volume']);
        $anVarVol = floatval($row['annual_variation_volume']);
        $anVarRev = floatval($row['annual_variation_unitcost']);
        if(array_key_exists($id_item,$list)){
            $list[$id_item] += ['unit_rev'=>$unit_rev,'volume'=>$volume,'anVarVol'=>$anVarVol,'anVarRev'=>$anVarRev];
        } else {
            $list[$id_item] = ['unit_rev'=>$unit_rev,'volume'=>$volume,'anVarVol'=>$anVarVol,'anVarRev'=>$anVarRev];
        }
    }
    //var_dump($list);
    return $list;
}

function insertRevenuesUser($projID,$ucID,$revenues_data){
    $db = dbConnect();
    $ret = false;
    $db->exec('DROP PROCEDURE IF EXISTS `add_revenues`;');
    $db->exec(' CREATE PROCEDURE `add_revenues`(
                            IN revenues_name VARCHAR(255),
                            IN revenues_desc VARCHAR(255),
                            IN idUC INT,
                            IN idProj INT
                            )
                            BEGIN
                                DECLARE itemID INT;
                                INSERT INTO revenues_item (name,description)
                                    VALUES (revenues_name,revenues_desc);
                                SET itemID = LAST_INSERT_ID();
                                INSERT INTO revenues_uc (id_item,id_uc)
                                    VALUES (itemID,idUC);
                                INSERT INTO revenues_item_user (id,id_proj)
                                    VALUES (itemID,idProj);
                            END
                                ');
    $req = $db->prepare('CALL add_revenues(?,?,?,?);');
    $ret = $req->execute(array($revenues_data['name'],$revenues_data['description'],$ucID,$projID));
    return $ret;
}

function deleteRevenuesUser($idRevenues){
    $db = dbConnect();
    $req = $db->prepare('DELETE FROM revenues_item WHERE id = ?');
    return $req->execute(array($idRevenues));
}

function insertSelRevenues($projID,$ucID,$list){
    $db = dbConnect();
    $ret = false;
    $req = $db->prepare("INSERT INTO input_revenues
                            (id_item,id_proj,id_uc)
                            VALUES (?,?,?)");
    foreach ($list as $id_item) {
        $ret = $req->execute(array($id_item,$projID,$ucID));
    }
    return $ret;
}

function deleteSelRevenues($projID,$ucID,$list){
    $ret = false;
    $db = dbConnect();
    $req = $db->prepare("DELETE FROM input_revenues WHERE id_proj = ? and id_uc = ? and id_item = ?");
    foreach ($list as $id_item) {
        $ret = $req->execute(array($projID,$ucID,$id_item));
    }
    return $ret;
}

function getRatioCompoRevenues($list_item,$compoID){
    $db = dbConnect();
    $req = $db->prepare("SELECT val FROM ratio_comp_revenues WHERE id_compo = ? and id_item = ?");
    
    $list = [];
    foreach ($list_item as $id_item) {
        $req->execute(array($compoID,$id_item));
        $res = $req->fetch();
        $val = $res ? floatval($res['val']) : -1;
        if(array_key_exists($id_item,$list)){
            $list[$id_item] += ['val'=>$val];
        } else {
            $list[$id_item] = ['val'=>$val];
        }
    }
    //var_dump($list);
    return $list;
}

function insertRevenuesInputed($projID,$ucID,$list){
    $db = dbConnect();
    $ret = false;
    $req = $db->prepare("UPDATE input_revenues
                            SET volume = ?,
                                revenues_per_unit = ?,
                                annual_variation_volume = ?,
                                annual_variation_unitcost = ?
                            WHERE id_proj = ? and id_uc = ? and id_item = ?");
    foreach ($list as $id_item => $data) {
        $ret = $req->execute(array($data['volume'],convertDevToGBP($data['unit_rev']),$data['anVarVol'],$data['anVarRev'],$projID,$ucID,$id_item));
    }
    return $ret;
}

function getRevenuesSchedule($projID,$ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT * FROM revenue_schedule WHERE id_proj = ? and id_uc = ?");
    $req->execute(array($projID,$ucID));
    $res = $req->fetch();
    return $res;
}

function deleteAllSelRevenues($projID,$ucID){
    $ret = false;
    $db = dbConnect();
    $req = $db->prepare("DELETE FROM input_revenues WHERE id_proj = ? and id_uc = ?");
    $ret = $req->execute(array($projID,$ucID));
    return $ret;
}



// ---------------------------------------- CASHRELEASING----------------------------------------

function getCashReleasingUserItem($projID,$ucID,$name){
    $db = dbConnect();
    $req = $db->prepare("SELECT *
                            FROM cashreleasing_item_user
                            INNER JOIN cashreleasing_uc
                                INNER JOIN cashreleasing_item
                                    WHERE cashreleasing_item_user.id_proj = ?
                                        and cashreleasing_item.id = cashreleasing_item_user.id
                                        and cashreleasing_uc.id_uc = ?
                                        and cashreleasing_item.name = ?
                        ");
    $req->execute(array($projID,$ucID,$name));
    return $req->fetchAll();
}

function getListCashReleasingAdvice($ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT *
                            FROM cashreleasing_item_advice
                            INNER JOIN cashreleasing_uc
                                INNER JOIN cashreleasing_item
                                    WHERE cashreleasing_uc.id_uc = ?
                                        and cashreleasing_item.id = cashreleasing_uc.id_item
                                        and cashreleasing_item.id = cashreleasing_item_advice.id
                            ORDER BY name
                            ");
    $req->execute(array($ucID));

    $list = [];
    while($row = $req->fetch()){
        $id_item = intval($row['id']);
        $name = $row['name'];
        $description = $row['description'];
        $unit = $row['unit'];
        $source = $row['source'];
        $range_min_red_nb = floatval($row['range_min_red_nb']);
        $range_max_red_nb = floatval($row['range_max_red_nb']);
        $range_min_red_cost = floatval($row['range_min_red_cost']);
        $range_max_red_cost = floatval($row['range_max_red_cost']);
        $unit_cost = convertGBPToDev(floatval($row['unit_cost']));
        if(array_key_exists($id_item,$list)){
            $list[$id_item] += ['name'=>$name,'description'=>$description,'unit'=>$unit,'source'=>$source,'range_min_red_nb'=>$range_min_red_nb,'range_max_red_nb'=>$range_max_red_nb,'range_min_red_cost'=>$range_min_red_cost,'range_max_red_cost'=>$range_max_red_cost];
        } else {
            $list[$id_item] = ['name'=>$name,'description'=>$description,'unit'=>$unit,'unit_cost'=>$unit_cost,'source'=>$source,'range_min_red_nb'=>$range_min_red_nb,'range_max_red_nb'=>$range_max_red_nb,'range_min_red_cost'=>$range_min_red_cost,'range_max_red_cost'=>$range_max_red_cost];
        }
    }
    //var_dump($list);
    return $list;
}

function getListCashreleasingItems($ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT DISTINCT cashreleasing_item.id,name,description,unit,source,range_min_red_nb,range_max_red_nb,range_min_red_cost,range_max_red_cost,unit_cost
                            FROM cashreleasing_item
                            LEFT JOIN cashreleasing_item_advice
                                ON cashreleasing_item.id = cashreleasing_item_advice.id
                            LEFT JOIN cashreleasing_uc
                                ON cashreleasing_item.id = cashreleasing_uc.id_item
                                    
                            WHERE cashreleasing_uc.id_uc = ?
                            ORDER BY name
                            ");
    $req->execute(array($ucID));

    $list = [];
    while($row = $req->fetch()){
        $id_item = intval($row['id']);
        $name = $row['name'];
        $description = $row['description'];
        $unit = $row['unit'];
        $source = $row['source'];
        $range_min_red_nb = floatval($row['range_min_red_nb']);
        $range_max_red_nb = floatval($row['range_max_red_nb']);
        $range_min_red_cost = floatval($row['range_min_red_cost']);
        $range_max_red_cost = floatval($row['range_max_red_cost']);
        $unit_cost = convertGBPToDev(floatval($row['unit_cost']));
        if(array_key_exists($id_item,$list)){
            $list[$id_item] += ['name'=>$name,'description'=>$description,'unit'=>$unit,'source'=>$source,'range_min_red_nb'=>$range_min_red_nb,'range_max_red_nb'=>$range_max_red_nb,'range_min_red_cost'=>$range_min_red_cost,'range_max_red_cost'=>$range_max_red_cost];
        } else {
            $list[$id_item] = ['name'=>$name,'description'=>$description,'unit'=>$unit,'unit_cost'=>$unit_cost,'source'=>$source,'range_min_red_nb'=>$range_min_red_nb,'range_max_red_nb'=>$range_max_red_nb,'range_min_red_cost'=>$range_min_red_cost,'range_max_red_cost'=>$range_max_red_cost];
        }
    }
    //var_dump($list);
    return $list;
}

function getListCashReleasingUser($projID,$ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT cashreleasing_item.id,name,description
                            FROM cashreleasing_item_user
                            INNER JOIN cashreleasing_uc
                                INNER JOIN cashreleasing_item
                                    WHERE cashreleasing_uc.id_uc = ?
                                        and cashreleasing_item.id = cashreleasing_uc.id_item
                                        and cashreleasing_item_user.id_proj = ?
                                        and cashreleasing_item_user.id = cashreleasing_item.id
                            ORDER BY name
                            ");
    $req->execute(array($ucID,$projID));

    $list = [];
    while($row = $req->fetch()){
        $id_item = intval($row['id']);
        $name = $row['name'];
        $description = $row['description'];
        if(array_key_exists($id_item,$list)){
            $list[$id_item] += ['name'=>$name,'description'=>$description];
        } else {
            $list[$id_item] = ['name'=>$name,'description'=>$description];
        }
    }
    //var_dump($list);
    return $list;

}

function getListSelCashReleasing($projID,$ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT id_item,unit_indicator,volume,unit_cost,volume_reduc,unit_cost_reduc,annual_var_volume,annual_var_unit_cost
                            FROM input_cashreleasing
                            INNER JOIN cashreleasing_item
                                WHERE  input_cashreleasing.id_uc = ? and id_proj = ? and id_item = cashreleasing_item.id
                            ORDER BY cashreleasing_item.name
                            ");
    $req->execute(array($ucID,$projID));

    $list = [];
    while($row = $req->fetch()){
        $id_item = intval($row['id_item']);
        $unit_cost = convertGBPToDev(floatval($row['unit_cost']));
        $unit_indic = $row['unit_indicator'];
        $volume = intval($row['volume']);
        $vol_red = floatval($row['volume_reduc']);
        $unit_cost_red = floatval($row['unit_cost_reduc']);
        $anVarVol = floatval($row['annual_var_volume']);
        $anVarCost = floatval($row['annual_var_unit_cost']);
        if(array_key_exists($id_item,$list)){
            $list[$id_item] += ['unit_indic'=>$unit_indic,'volume'=>$volume,'unit_cost'=>$unit_cost,'vol_red'=>$vol_red,'unit_cost_red'=>$unit_cost_red,'anVarVol'=>$anVarVol,'anVarCost'=>$anVarCost];
        } else {
            $list[$id_item] = ['unit_indic'=>$unit_indic,'volume'=>$volume,'unit_cost'=>$unit_cost,'vol_red'=>$vol_red,'unit_cost_red'=>$unit_cost_red,'anVarVol'=>$anVarCost,'anVarCost'=>$anVarCost];
        }
    }
    //var_dump($list);
    return $list;
}

function insertCashReleasingUser($projID,$ucID,$cashreleasing_data){
    $db = dbConnect();
    $ret = false;
    $db->exec('DROP PROCEDURE IF EXISTS `add_cashreleasing`;');
    $db->exec(' CREATE PROCEDURE `add_cashreleasing`(
                            IN cashreleasing_name VARCHAR(255),
                            IN cashreleasing_desc VARCHAR(255),
                            IN idUC INT,
                            IN idProj INT
                            )
                            BEGIN
                                DECLARE itemID INT;
                                INSERT INTO cashreleasing_item (name,description)
                                    VALUES (cashreleasing_name,cashreleasing_desc);
                                SET itemID = LAST_INSERT_ID();
                                INSERT INTO cashreleasing_uc (id_item,id_uc)
                                    VALUES (itemID,idUC);
                                INSERT INTO cashreleasing_item_user (id,id_proj)
                                    VALUES (itemID,idProj);
                            END
                                ');
    $req = $db->prepare('CALL add_cashreleasing(?,?,?,?);');
    $ret = $req->execute(array($cashreleasing_data['name'],$cashreleasing_data['description'],$ucID,$projID));
    return $ret;
}

function deleteCashReleasingUser($idCashReleasing){
    $db = dbConnect();
    $req = $db->prepare('DELETE FROM cashreleasing_item WHERE id = ?');
    return $req->execute(array($idCashReleasing));
}

function insertSelCashReleasing($projID,$ucID,$list){
    $db = dbConnect();
    $ret = false;
    $req = $db->prepare("INSERT INTO input_cashreleasing
                            (id_item,id_proj,id_uc)
                            VALUES (?,?,?)");
    foreach ($list as $id_item) {
        $ret = $req->execute(array($id_item,$projID,$ucID));
    }
    return $ret;
}

function deleteSelCashReleasing($projID,$ucID,$list){
    $ret = false;
    $db = dbConnect();
    $req = $db->prepare("DELETE FROM input_cashreleasing WHERE id_proj = ? and id_uc = ? and id_item = ?");
    foreach ($list as $id_item) {
        $ret = $req->execute(array($projID,$ucID,$id_item));
    }
    return $ret;
}

function getRatioCompoCashReleasing($list_item,$compoID){
    $db = dbConnect();
    $req = $db->prepare("SELECT val FROM ratio_comp_cashreleasing WHERE id_compo = ? and id_item = ?");
    
    $list = [];
    foreach ($list_item as $id_item) {
        $req->execute(array($compoID,$id_item));
        $res = $req->fetch();
        $val = $res ? floatval($res['val']) : -1;
        if(array_key_exists($id_item,$list)){
            $list[$id_item] += ['val'=>$val];
        } else {
            $list[$id_item] = ['val'=>$val];
        }
    }
    //var_dump($list);
    return $list;
}

function insertCashReleasingInputed($projID,$ucID,$list){
    $db = dbConnect();
    $ret = false;
    $req = $db->prepare("UPDATE input_cashreleasing
                            SET unit_indicator = ?,
                            volume = ?,
                            unit_cost = ?,
                            volume_reduc = ?,
                            unit_cost_reduc = ?,
                            annual_var_volume = ?,
                            annual_var_unit_cost = ?
                            WHERE id_proj = ? and id_uc = ? and id_item = ?");
    foreach ($list as $id_item => $data) {
        $ret = $req->execute(array($data['unit_indic'],$data['volume'],convertDevToGBP($data['unit_cost']),$data['vol_red'],$data['unit_cost_red'],$data['anVarVol'],$data['anVarCost'],$projID,$ucID,$id_item));

    }
    return $ret;
}

function deleteAllSelCashReleasing($projID,$ucID){
    $ret = false;
    $db = dbConnect();
    $req = $db->prepare("DELETE FROM input_cashreleasing WHERE id_proj = ? and id_uc = ?");
    $ret = $req->execute(array($projID,$ucID));
    return $ret;
}




// ---------------------------------------- WIDER CASH----------------------------------------

function getWiderCashUserItem($projID,$ucID,$name){
    $db = dbConnect();
    $req = $db->prepare("SELECT *
                            FROM widercash_item_user
                            INNER JOIN widercash_uc
                                INNER JOIN widercash_item
                                    WHERE widercash_item_user.id_proj = ?
                                        and widercash_item.id = widercash_item_user.id
                                        and widercash_uc.id_uc = ?
                                        and widercash_item.name = ?
                        ");
    $req->execute(array($projID,$ucID,$name));
    return $req->fetchAll();
}

function getListWiderCashAdvice($ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT *
                            FROM widercash_item_advice
                            INNER JOIN widercash_uc
                                INNER JOIN widercash_item
                                    WHERE widercash_uc.id_uc = ?
                                        and widercash_item.id = widercash_uc.id_item
                                        and widercash_item.id = widercash_item_advice.id
                            ORDER BY name
                            ");
    $req->execute(array($ucID));

    $list = [];
    while($row = $req->fetch()){
        $id_item = intval($row['id']);
        $name = $row['name'];
        $description = $row['description'];
        $unit = $row['unit'];
        $source = $row['source'];
        $range_min_red_nb = floatval($row['range_min_red_nb']);
        $range_max_red_nb = floatval($row['range_max_red_nb']);
        $range_min_red_cost = floatval($row['range_min_red_cost']);
        $range_max_red_cost = floatval($row['range_max_red_cost']);
        $unit_cost = convertGBPToDev(floatval($row['unit_cost']));
        if(array_key_exists($id_item,$list)){
            $list[$id_item] += ['name'=>$name,'description'=>$description,'unit'=>$unit,'source'=>$source,'range_min_red_nb'=>$range_min_red_nb,'range_max_red_nb'=>$range_max_red_nb,'range_min_red_cost'=>$range_min_red_cost,'range_max_red_cost'=>$range_max_red_cost];
        } else {
            $list[$id_item] = ['name'=>$name,'description'=>$description,'unit'=>$unit,'unit_cost'=>$unit_cost,'source'=>$source,'range_min_red_nb'=>$range_min_red_nb,'range_max_red_nb'=>$range_max_red_nb,'range_min_red_cost'=>$range_min_red_cost,'range_max_red_cost'=>$range_max_red_cost];
        }
    }
    //var_dump($list);
    return $list;
}

function getListWidercashItems($ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT DISTINCT widercash_item.id,name,description,unit,source,range_min_red_nb,range_max_red_nb,range_min_red_cost,range_max_red_cost,unit_cost
                            FROM widercash_item
                            LEFT JOIN widercash_item_advice
                                ON widercash_item.id = widercash_item_advice.id
                            LEFT JOIN widercash_uc
                                ON widercash_item.id = widercash_uc.id_item
                                    
                            WHERE widercash_uc.id_uc = ?
                            ORDER BY name
                            ");
    $req->execute(array($ucID));

    $list = [];
    while($row = $req->fetch()){
        $id_item = intval($row['id']);
        $name = $row['name'];
        $description = $row['description'];
        $unit = $row['unit'];
        $source = $row['source'];
        $range_min_red_nb = floatval($row['range_min_red_nb']);
        $range_max_red_nb = floatval($row['range_max_red_nb']);
        $range_min_red_cost = floatval($row['range_min_red_cost']);
        $range_max_red_cost = floatval($row['range_max_red_cost']);
        $unit_cost = convertGBPToDev(floatval($row['unit_cost']));
        if(array_key_exists($id_item,$list)){
            $list[$id_item] += ['name'=>$name,'description'=>$description,'unit'=>$unit,'source'=>$source,'range_min_red_nb'=>$range_min_red_nb,'range_max_red_nb'=>$range_max_red_nb,'range_min_red_cost'=>$range_min_red_cost,'range_max_red_cost'=>$range_max_red_cost];
        } else {
            $list[$id_item] = ['name'=>$name,'description'=>$description,'unit'=>$unit,'unit_cost'=>$unit_cost,'source'=>$source,'range_min_red_nb'=>$range_min_red_nb,'range_max_red_nb'=>$range_max_red_nb,'range_min_red_cost'=>$range_min_red_cost,'range_max_red_cost'=>$range_max_red_cost];
        }
    }
    //var_dump($list);
    return $list;
}

function getListWiderCashUser($projID,$ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT widercash_item.id,name,description
                            FROM widercash_item_user
                            INNER JOIN widercash_uc
                                INNER JOIN widercash_item
                                    WHERE widercash_uc.id_uc = ?
                                        and widercash_item.id = widercash_uc.id_item
                                        and widercash_item_user.id_proj = ?
                                        and widercash_item_user.id = widercash_item.id
                            ORDER BY name
                            ");
    $req->execute(array($ucID,$projID));

    $list = [];
    while($row = $req->fetch()){
        $id_item = intval($row['id']);
        $name = $row['name'];
        $description = $row['description'];
        if(array_key_exists($id_item,$list)){
            $list[$id_item] += ['name'=>$name,'description'=>$description];
        } else {
            $list[$id_item] = ['name'=>$name,'description'=>$description];
        }
    }
    //var_dump($list);
    return $list;

}

function getListSelWiderCash($projID,$ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT id_item,unit_indicator,volume,unit_cost,volume_reduc,unit_cost_reduc,annual_var_volume,annual_var_unit_cost
                            FROM input_widercash
                            INNER JOIN widercash_item
                                WHERE  input_widercash.id_uc = ? and id_proj = ? and id_item = widercash_item.id
                            ORDER BY widercash_item.name
                            ");
    $req->execute(array($ucID,$projID));

    $list = [];
    while($row = $req->fetch()){
        $id_item = intval($row['id_item']);
        $unit_cost = convertGBPToDev(floatval($row['unit_cost']));
        $unit_indic = $row['unit_indicator'];
        $volume = intval($row['volume']);
        $vol_red = floatval($row['volume_reduc']);
        $unit_cost_red = floatval($row['unit_cost_reduc']);
        $anVarVol = floatval($row['annual_var_volume']);
        $anVarCost = floatval($row['annual_var_unit_cost']);
        if(array_key_exists($id_item,$list)){
            $list[$id_item] += ['unit_indic'=>$unit_indic,'volume'=>$volume,'unit_cost'=>$unit_cost,'vol_red'=>$vol_red,'unit_cost_red'=>$unit_cost_red,'anVarVol'=>$anVarVol,'anVarCost'=>$anVarCost];
        } else {
            $list[$id_item] = ['unit_indic'=>$unit_indic,'volume'=>$volume,'unit_cost'=>$unit_cost,'vol_red'=>$vol_red,'unit_cost_red'=>$unit_cost_red,'anVarVol'=>$anVarVol,'anVarCost'=>$anVarCost];
        }
    }
    //var_dump($list);
    return $list;
}

function insertWiderCashUser($projID,$ucID,$widercash_data){
    $db = dbConnect();
    $ret = false;
    $db->exec('DROP PROCEDURE IF EXISTS `add_widercash`;');
    $db->exec(' CREATE PROCEDURE `add_widercash`(
                            IN widercash_name VARCHAR(255),
                            IN widercash_desc VARCHAR(255),
                            IN idUC INT,
                            IN idProj INT
                            )
                            BEGIN
                                DECLARE itemID INT;
                                INSERT INTO widercash_item (name,description)
                                    VALUES (widercash_name,widercash_desc);
                                SET itemID = LAST_INSERT_ID();
                                INSERT INTO widercash_uc (id_item,id_uc)
                                    VALUES (itemID,idUC);
                                INSERT INTO widercash_item_user (id,id_proj)
                                    VALUES (itemID,idProj);
                            END
                                ');
    $req = $db->prepare('CALL add_widercash(?,?,?,?);');
    $ret = $req->execute(array($widercash_data['name'],$widercash_data['description'],$ucID,$projID));
    return $ret;
}

function deleteWiderCashUser($idWiderCash){
    $db = dbConnect();
    $req = $db->prepare('DELETE FROM widercash_item WHERE id = ?');
    return $req->execute(array($idWiderCash));
}

function insertSelWiderCash($projID,$ucID,$list){
    $db = dbConnect();
    $ret = false;
    $req = $db->prepare("INSERT INTO input_widercash
                            (id_item,id_proj,id_uc)
                            VALUES (?,?,?)");
    foreach ($list as $id_item) {
        $ret = $req->execute(array($id_item,$projID,$ucID));
    }
    return $ret;
}

function deleteSelWiderCash($projID,$ucID,$list){
    $ret = false;
    $db = dbConnect();
    $req = $db->prepare("DELETE FROM input_widercash WHERE id_proj = ? and id_uc = ? and id_item = ?");
    foreach ($list as $id_item) {
        $ret = $req->execute(array($projID,$ucID,$id_item));
    }
    return $ret;
}

function getRatioCompoWiderCash($list_item,$compoID){
    $db = dbConnect();
    $req = $db->prepare("SELECT val FROM ratio_comp_widercash WHERE id_compo = ? and id_item = ?");
    
    $list = [];
    foreach ($list_item as $id_item) {
        $req->execute(array($compoID,$id_item));
        $res = $req->fetch();
        $val = $res ? floatval($res['val']) : -1;
        if(array_key_exists($id_item,$list)){
            $list[$id_item] += ['val'=>$val];
        } else {
            $list[$id_item] = ['val'=>$val];
        }
    }
    //var_dump($list);
    return $list;
}

function insertWiderCashInputed($projID,$ucID,$list){
    $db = dbConnect();
    $ret = false;
    $req = $db->prepare("UPDATE input_widercash
                            SET unit_indicator = ?,
                            volume = ?,
                            unit_cost = ?,
                            volume_reduc = ?,
                            unit_cost_reduc = ?,
                            annual_var_volume = ?,
                            annual_var_unit_cost = ?
                            WHERE id_proj = ? and id_uc = ? and id_item = ?");
    foreach ($list as $id_item => $data) {
        $ret = $req->execute(array($data['unit_indic'],$data['volume'],convertDevToGBP($data['unit_cost']),$data['vol_red'],$data['unit_cost_red'],$data['anVarVol'],$data['anVarCost'],$projID,$ucID,$id_item));

    }
    return $ret;
}

function deleteAllSelWiderCash($projID,$ucID){
    $ret = false;
    $db = dbConnect();
    $req = $db->prepare("DELETE FROM input_widercash WHERE id_proj = ? and id_uc = ?");
    $ret = $req->execute(array($projID,$ucID));
    return $ret;
}


// ---------------------------------------- QUANTIFIABLE NON MONETIZABLE BENEFITS ----------------------------------------

function getQuantifiableUserItem($projID,$ucID,$name){
    $db = dbConnect();
    $req = $db->prepare("SELECT *
                            FROM quantifiable_item_user
                            INNER JOIN quantifiable_uc
                                INNER JOIN quantifiable_item
                                    WHERE quantifiable_item_user.id_proj = ?
                                        and quantifiable_item.id = quantifiable_item_user.id
                                        and quantifiable_uc.id_uc = ?
                                        and quantifiable_item.name = ?
                        ");
    $req->execute(array($projID,$ucID,$name));
    return $req->fetchAll();
}

function getListQuantifiableAdvice($ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT *
                            FROM quantifiable_item_advice
                            INNER JOIN quantifiable_uc
                                INNER JOIN quantifiable_item
                                    WHERE quantifiable_uc.id_uc = ?
                                        and quantifiable_item.id = quantifiable_uc.id_item
                                        and quantifiable_item.id = quantifiable_item_advice.id
                            ORDER BY name
                            ");
    $req->execute(array($ucID));

    $list = [];
    while($row = $req->fetch()){
        $id_item = intval($row['id']);
        $name = $row['name'];
        $description = $row['description'];
        $unit = $row['unit'];
        $source = $row['source'];
        $range_min_red_nb = floatval($row['range_min_red_nb']);
        $range_max_red_nb = floatval($row['range_max_red_nb']);
        if(array_key_exists($id_item,$list)){
            $list[$id_item] += ['name'=>$name,'description'=>$description,'unit'=>$unit,'source'=>$source,'range_min_red_nb'=>$range_min_red_nb,'range_max_red_nb'=>$range_max_red_nb];
        } else {
            $list[$id_item] = ['name'=>$name,'description'=>$description,'unit'=>$unit,'source'=>$source,'range_min_red_nb'=>$range_min_red_nb,'range_max_red_nb'=>$range_max_red_nb];
        }
    }
    //var_dump($list);
    return $list;
}

function getListQuantifiableItems($ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT DISTINCT quantifiable_item.id,name,description,unit,source,range_min_red_nb,range_max_red_nb
                            FROM quantifiable_item
                            LEFT JOIN quantifiable_item_advice
                                ON quantifiable_item.id = quantifiable_item_advice.id
                            LEFT JOIN quantifiable_uc
                                ON quantifiable_item.id = quantifiable_uc.id_item
                                    
                            WHERE quantifiable_uc.id_uc = ?
                            ORDER BY name
                            ");
    $req->execute(array($ucID));

    $list = [];
    while($row = $req->fetch()){
        $id_item = intval($row['id']);
        $name = $row['name'];
        $description = $row['description'];
        $unit = $row['unit'];
        $source = $row['source'];
        $range_min_red_nb = floatval($row['range_min_red_nb']);
        $range_max_red_nb = floatval($row['range_max_red_nb']);
        if(array_key_exists($id_item,$list)){
            $list[$id_item] += ['name'=>$name,'description'=>$description,'unit'=>$unit,'source'=>$source,'range_min_red_nb'=>$range_min_red_nb,'range_max_red_nb'=>$range_max_red_nb];
        } else {
            $list[$id_item] = ['name'=>$name,'description'=>$description,'unit'=>$unit,'source'=>$source,'range_min_red_nb'=>$range_min_red_nb,'range_max_red_nb'=>$range_max_red_nb];
        }
    }
    //var_dump($list);
    return $list;
}

function getListQuantifiableUser($projID,$ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT quantifiable_item.id,name,description
                            FROM quantifiable_item_user
                            INNER JOIN quantifiable_uc
                                INNER JOIN quantifiable_item
                                    WHERE quantifiable_uc.id_uc = ?
                                        and quantifiable_item.id = quantifiable_uc.id_item
                                        and quantifiable_item_user.id_proj = ?
                                        and quantifiable_item_user.id = quantifiable_item.id
                            ORDER BY name
                            ");
    $req->execute(array($ucID,$projID));

    $list = [];
    while($row = $req->fetch()){
        $id_item = intval($row['id']);
        $name = $row['name'];
        $description = $row['description'];
        if(array_key_exists($id_item,$list)){
            $list[$id_item] += ['name'=>$name,'description'=>$description];
        } else {
            $list[$id_item] = ['name'=>$name,'description'=>$description];
        }
    }
    //var_dump($list);
    return $list;

}

function getListSelQuantifiable($projID,$ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT id_item,unit_indicator,volume,volume_reduc,annual_var_volume
                            FROM input_quantifiable
                            INNER JOIN quantifiable_item
                                WHERE  input_quantifiable.id_uc = ? and id_proj = ? and id_item = quantifiable_item.id
                            ORDER BY quantifiable_item.name
                            ");
    $req->execute(array($ucID,$projID));

    $list = [];
    while($row = $req->fetch()){
        $id_item = intval($row['id_item']);
        $unit_indic = $row['unit_indicator'];
        $volume = intval($row['volume']);
        $vol_red = floatval($row['volume_reduc']);
        $anVarVol = floatval($row['annual_var_volume']);
        if(array_key_exists($id_item,$list)){
            $list[$id_item] += ['unit_indic'=>$unit_indic,'volume'=>$volume,'vol_red'=>$vol_red,'anVarVol'=>$anVarVol];
        } else {
            $list[$id_item] = ['unit_indic'=>$unit_indic,'volume'=>$volume,'vol_red'=>$vol_red, 'anVarVol'=>$anVarVol];
        }
    }
    //var_dump($list);
    return $list;
}

function insertQuantifiableUser($projID,$ucID,$quantifiable_data){
    $db = dbConnect();
    $ret = false;
    $db->exec('DROP PROCEDURE IF EXISTS `add_quantifiable`;');
    $db->exec(' CREATE PROCEDURE `add_quantifiable`(
                            IN quantifiable_name VARCHAR(255),
                            IN quantifiable_desc VARCHAR(255),
                            IN idUC INT,
                            IN idProj INT
                            )
                            BEGIN
                                DECLARE itemID INT;
                                INSERT INTO quantifiable_item (name,description)
                                    VALUES (quantifiable_name,quantifiable_desc);
                                SET itemID = LAST_INSERT_ID();
                                INSERT INTO quantifiable_uc (id_item,id_uc)
                                    VALUES (itemID,idUC);
                                INSERT INTO quantifiable_item_user (id,id_proj)
                                    VALUES (itemID,idProj);
                            END
                                ');
    $req = $db->prepare('CALL add_quantifiable(?,?,?,?);');
    $ret = $req->execute(array($quantifiable_data['name'],$quantifiable_data['description'],$ucID,$projID));
    return $ret;
}

function deleteQuantifiableUser($idQuantifiable){
    $db = dbConnect();
    $req = $db->prepare('DELETE FROM quantifiable_item WHERE id = ?');
    return $req->execute(array($idQuantifiable));
}

function insertSelQuantifiable($projID,$ucID,$list){
    $db = dbConnect();
    $ret = false;
    $req = $db->prepare("INSERT INTO input_quantifiable
                            (id_item,id_proj,id_uc)
                            VALUES (?,?,?)");
    foreach ($list as $id_item) {
        $ret = $req->execute(array($id_item,$projID,$ucID));
    }
    return $ret;
}

function deleteSelQuantifiable($projID,$ucID,$list){
    $ret = false;
    $db = dbConnect();
    $req = $db->prepare("DELETE FROM input_quantifiable WHERE id_proj = ? and id_uc = ? and id_item = ?");
    foreach ($list as $id_item) {
        $ret = $req->execute(array($projID,$ucID,$id_item));
    }
    return $ret;
}


function insertQuantifiableInputed($projID,$ucID,$list){
    $db = dbConnect();
    $ret = false;
    $req = $db->prepare("UPDATE input_quantifiable
                            SET unit_indicator = ?,
                            volume = ?,
                            volume_reduc = ?,
                            annual_var_volume = ?
                            WHERE id_proj = ? and id_uc = ? and id_item = ?");
    foreach ($list as $id_item => $data) {
        $ret = $req->execute(array($data['unit_indic'],$data['volume'],$data['vol_red'],$data['anVarVol'],$projID,$ucID,$id_item));

    }
    return $ret;
}

function deleteAllSelQuantifiable($projID,$ucID){
    $ret = false;
    $db = dbConnect();
    $req = $db->prepare("DELETE FROM input_quantifiable WHERE id_proj = ? and id_uc = ?");
    $ret = $req->execute(array($projID,$ucID));
    return $ret;
}

// ---------------------------------------- NON CASH----------------------------------------

function getNonCashUserItem($projID,$ucID,$name){
    $db = dbConnect();
    $req = $db->prepare("SELECT *
                            FROM noncash_item_user
                            INNER JOIN noncash_uc
                                INNER JOIN noncash_item
                                    WHERE noncash_item_user.id_proj = ?
                                        and noncash_item.id = noncash_item_user.id
                                        and noncash_uc.id_uc = ?
                                        and noncash_item.name = ?
                        ");
    $req->execute(array($projID,$ucID,$name));
    return $req->fetchAll();
}

function getListNonCashAdvice($ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT *
                            FROM noncash_item_advice
                            INNER JOIN noncash_uc
                                INNER JOIN noncash_item
                                    WHERE noncash_uc.id_uc = ?
                                        and noncash_item.id = noncash_uc.id_item
                                        and noncash_item.id = noncash_item_advice.id
                            ORDER BY name
                            ");
    $req->execute(array($ucID));

    $list = [];
    while($row = $req->fetch()){
        $id_item = intval($row['id']);
        $name = $row['name'];
        $description = $row['description'];
        $sources = $row['sources'];
        if(array_key_exists($id_item,$list)){
            $list[$id_item] += ['name'=>$name,'description'=>$description,'sources'=>$sources];
        } else {
            $list[$id_item] = ['name'=>$name,'description'=>$description,'sources'=>$sources];
        }
    }
    //var_dump($list);
    return $list;
}


function getListNoncashItems($ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT DISTINCT noncash_item.id,name,description
                            FROM noncash_item
                            LEFT JOIN noncash_item_advice
                                ON noncash_item.id = noncash_item_advice.id
                            LEFT JOIN noncash_uc
                                ON noncash_item.id = noncash_uc.id_item
                                    
                            WHERE noncash_uc.id_uc = ?
                            ORDER BY name
                            ");
    $req->execute(array($ucID));

    $list = [];
    while($row = $req->fetch()){
        $id_item = intval($row['id']);
        $name = $row['name'];
        $description = $row['description'];
        if(array_key_exists($id_item,$list)){
            $list[$id_item] += ['name'=>$name,'description'=>$description];
        } else {
            $list[$id_item] = ['name'=>$name,'description'=>$description];
        }
    }
    //var_dump($list);
    return $list;
}

function getListNonCashUser($projID,$ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT noncash_item.id,name,description
                            FROM noncash_item_user
                            INNER JOIN noncash_uc
                                INNER JOIN noncash_item
                                    WHERE noncash_uc.id_uc = ?
                                        and noncash_item.id = noncash_uc.id_item
                                        and noncash_item_user.id_proj = ?
                                        and noncash_item_user.id = noncash_item.id
                            ORDER BY name
                            ");
    $req->execute(array($ucID,$projID));

    $list = [];
    while($row = $req->fetch()){
        $id_item = intval($row['id']);
        $name = $row['name'];
        $description = $row['description'];
        if(array_key_exists($id_item,$list)){
            $list[$id_item] += ['name'=>$name,'description'=>$description];
        } else {
            $list[$id_item] = ['name'=>$name,'description'=>$description];
        }
    }
    //var_dump($list);
    return $list;

}

function getListSelNonCash($projID,$ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT id_item,expected_impact,probability
                            FROM input_noncash
                            INNER JOIN noncash_item
                                WHERE  input_noncash.id_uc = ? and id_proj = ? and id_item = noncash_item.id
                            ORDER BY noncash_item.name
                            ");
    $req->execute(array($ucID,$projID));

    $list = [];
    while($row = $req->fetch()){
        $id_item = intval($row['id_item']);
        $exp_impact = intval($row['expected_impact']);
        $prob = floatval($row['probability']);
        if(array_key_exists($id_item,$list)){
            $list[$id_item] += ['exp_impact'=>$exp_impact,'prob'=>$prob];
        } else {
            $list[$id_item] = ['exp_impact'=>$exp_impact,'prob'=>$prob];
        }
    }
    //var_dump($list);
    return $list;
}

function insertNonCashUser($projID,$ucID,$noncash_data){
    $db = dbConnect();
    $ret = false;
    $db->exec('DROP PROCEDURE IF EXISTS `add_noncash`;');
    $db->exec(' CREATE PROCEDURE `add_noncash`(
                            IN noncash_name VARCHAR(255),
                            IN noncash_desc VARCHAR(255),
                            IN idUC INT,
                            IN idProj INT
                            )
                            BEGIN
                                DECLARE itemID INT;
                                INSERT INTO noncash_item (name,description)
                                    VALUES (noncash_name,noncash_desc);
                                SET itemID = LAST_INSERT_ID();
                                INSERT INTO noncash_uc (id_item,id_uc)
                                    VALUES (itemID,idUC);
                                INSERT INTO noncash_item_user (id,id_proj)
                                    VALUES (itemID,idProj);
                            END
                                ');
    $req = $db->prepare('CALL add_noncash(?,?,?,?);');
    $ret = $req->execute(array($noncash_data['name'],$noncash_data['description'],$ucID,$projID));
    return $ret;
}

function deleteNonCashUser($idNonCash){
    $db = dbConnect();
    $req = $db->prepare('DELETE FROM noncash_item WHERE id = ?');
    return $req->execute(array($idNonCash));
}

function insertSelNonCash($projID,$ucID,$list){
    $db = dbConnect();
    $ret = false;
    $req = $db->prepare("INSERT INTO input_noncash
                            (id_item,id_proj,id_uc)
                            VALUES (?,?,?)");
    foreach ($list as $id_item) {
        $ret = $req->execute(array($id_item,$projID,$ucID));
    }
    return $ret;
}

function deleteSelNonCash($projID,$ucID,$list){
    $ret = false;
    $db = dbConnect();
    $req = $db->prepare("DELETE FROM input_noncash WHERE id_proj = ? and id_uc = ? and id_item = ?");
    foreach ($list as $id_item) {
        $ret = $req->execute(array($projID,$ucID,$id_item));
    }
    return $ret;
}

function deleteAllSelNonCash($projID,$ucID){
    $ret = false;
    $db = dbConnect();
    $req = $db->prepare("DELETE FROM input_noncash WHERE id_proj = ? and id_uc = ?");
    $ret = $req->execute(array($projID,$ucID));
    return $ret;
}

function insertNonCashInputed($projID,$ucID,$list){
    $db = dbConnect();
    $ret = false;
    $req = $db->prepare("UPDATE input_noncash
                            SET expected_impact = ?,
                            probability = ?
                            WHERE id_proj = ? and id_uc = ? and id_item = ?");
    foreach ($list as $id_item => $data) {
        $ret = $req->execute(array($data['exp_impact'],$data['prob'],$projID,$ucID,$id_item));

    }
    return $ret;
}



// ---------------------------------------- RISKS----------------------------------------

function getRiskUserItem($projID,$ucID,$name){
    $db = dbConnect();
    $req = $db->prepare("SELECT *
                            FROM risk_item_user
                            INNER JOIN risk_uc
                                INNER JOIN risk_item
                                    WHERE risk_item_user.id_proj = ?
                                        and risk_item.id = risk_item_user.id
                                        and risk_uc.id_uc = ?
                                        and risk_item.name = ?
                        ");
    $req->execute(array($projID,$ucID,$name));
    return $req->fetchAll();
}

function getListRisksAdvice($ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT DISTINCT *
                            FROM risk_item_advice
                            INNER JOIN risk_uc
                                INNER JOIN risk_item
                                    WHERE risk_uc.id_uc = ?
                                        and risk_item.id = risk_uc.id_item
                                        and risk_item.id = risk_item_advice.id
                            ");
    $req->execute(array($ucID));

    $list = [];
    while($row = $req->fetch()){
        $id_item = intval($row['id']);
        $name = $row['name'];
        $description = $row['description'];
        $sources = $row['sources'];
        if(array_key_exists($id_item,$list)){
            $list[$id_item] += ['name'=>$name,'description'=>$description,'sources'=>$sources];
        } else {
            $list[$id_item] = ['name'=>$name,'description'=>$description,'sources'=>$sources];
        }
    }
    //var_dump($list);
    return $list;
}

function getListRisksItems($ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT DISTINCT risk_item.id,risk_item.name,risk_item.description
                            FROM risk_item
                            LEFT JOIN risk_item_advice
                                ON risk_item.id = risk_item_advice.id
                            LEFT JOIN risk_uc
                                ON risk_item.id = risk_uc.id_item
                                    
                            WHERE risk_uc.id_uc = ?
                            ORDER BY name
                            ");
    $req->execute(array($ucID));

    $list = [];
    while($row = $req->fetch()){
        $id_item = intval($row['id']);
        $name = $row['name'];
        $description = $row['description'];
        if(array_key_exists($id_item,$list)){
            $list[$id_item] += ['name'=>$name,'description'=>$description];
        } else {
            $list[$id_item] = ['name'=>$name,'description'=>$description];
        }
    }
    //var_dump($list);
    return $list;
}

function getListRiskUser($projID,$ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT risk_item.id,name,description
                            FROM risk_item_user
                            INNER JOIN risk_uc
                                INNER JOIN risk_item
                                    WHERE risk_uc.id_uc = ?
                                        and risk_item.id = risk_uc.id_item
                                        and risk_item_user.id_proj = ?
                                        and risk_item_user.id = risk_item.id
                            ORDER BY name
                            ");
    $req->execute(array($ucID,$projID));

    $list = [];
    while($row = $req->fetch()){
        $id_item = intval($row['id']);
        $name = $row['name'];
        $description = $row['description'];
        if(array_key_exists($id_item,$list)){
            $list[$id_item] += ['name'=>$name,'description'=>$description];
        } else {
            $list[$id_item] = ['name'=>$name,'description'=>$description];
        }
    }
    //var_dump($list);
    return $list;

}

function getListSelRisks($projID,$ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT id_item,expected_impact,probability
                            FROM input_risk
                            INNER JOIN risk_item
                                WHERE  input_risk.id_uc = ? and id_proj = ? and id_item = risk_item.id
                            ORDER BY risk_item.name
                            ");
    $req->execute(array($ucID,$projID));

    $list = [];
    while($row = $req->fetch()){
        $id_item = intval($row['id_item']);
        $exp_impact = intval($row['expected_impact']);
        $prob = floatval($row['probability']);
        if(array_key_exists($id_item,$list)){
            $list[$id_item] += ['exp_impact'=>$exp_impact,'prob'=>$prob];
        } else {
            $list[$id_item] = ['exp_impact'=>$exp_impact,'prob'=>$prob];
        }
    }
    //var_dump($list);
    return $list;
}

function insertRiskUser($projID,$ucID,$risk_data){
    $db = dbConnect();
    $ret = false;
    $db->exec('DROP PROCEDURE IF EXISTS `add_risk`;');
    $db->exec(' CREATE PROCEDURE `add_risk`(
                            IN risk_name VARCHAR(255),
                            IN risk_desc VARCHAR(255),
                            IN idUC INT,
                            IN idProj INT
                            )
                            BEGIN
                                DECLARE itemID INT;
                                INSERT INTO risk_item (name,description)
                                    VALUES (risk_name,risk_desc);
                                SET itemID = LAST_INSERT_ID();
                                INSERT INTO risk_uc (id_item,id_uc)
                                    VALUES (itemID,idUC);
                                INSERT INTO risk_item_user (id,id_proj)
                                    VALUES (itemID,idProj);
                            END
                                ');
    $req = $db->prepare('CALL add_risk(?,?,?,?);');
    $ret = $req->execute(array($risk_data['name'],$risk_data['description'],$ucID,$projID));
    return $ret;
}

function deleteRiskUser($idRisk){
    $db = dbConnect();
    $req = $db->prepare('DELETE FROM risk_item WHERE id = ?');
    return $req->execute(array($idRisk));
}

function insertSelRisk($projID,$ucID,$list){
    $db = dbConnect();
    $ret = false;
    $req = $db->prepare("INSERT INTO input_risk
                            (id_item,id_proj,id_uc)
                            VALUES (?,?,?)");
    foreach ($list as $id_item) {
        $ret = $req->execute(array($id_item,$projID,$ucID));
    }
    return $ret;
}

function deleteSelRisk($projID,$ucID,$list){
    $ret = false;
    $db = dbConnect();
    $req = $db->prepare("DELETE FROM input_risk WHERE id_proj = ? and id_uc = ? and id_item = ?");
    foreach ($list as $id_item) {
        $ret = $req->execute(array($projID,$ucID,$id_item));
    }
    return $ret;
}

function deleteAllSelRisks($projID,$ucID){
    $ret = false;
    $db = dbConnect();
    $req = $db->prepare("DELETE FROM input_risk WHERE id_proj = ? and id_uc = ?");
    $ret = $req->execute(array($projID,$ucID));
    return $ret;
}

function insertRiskInputed($projID,$ucID,$list){
    $db = dbConnect();
    $ret = false;
    $req = $db->prepare("UPDATE input_risk
                            SET expected_impact = ?,
                            probability = ?
                            WHERE id_proj = ? and id_uc = ? and id_item = ?");
    foreach ($list as $id_item => $data) {
        $ret = $req->execute(array($data['exp_impact'],$data['prob'],$projID,$ucID,$id_item));

    }
    return $ret;
}












// ---------------------------------------- FINANCING SCENARIO----------------------------------------

function getListScenarios($userID){
    $db = dbConnect();
    $req = $db->prepare('SELECT financing_scenario.id,financing_scenario.name,financing_scenario.description,input_invest,input_op,financing_scenario.creation_date,financing_scenario.modif_date,id_proj
                            FROM financing_scenario
                            INNER JOIN project
                                WHERE financing_scenario.id_proj = project.id and project.id_user = ?
                            ORDER BY financing_scenario.name');
    $req->execute(array($userID));
    $list = [];
    while ($row = $req->fetch()){
        $id = intval($row['id']);
        $name = $row['name'];
        $description = $row['description'];
        $input_invest = convertGBPToDev(floatval($row['input_invest']));
        $input_op = convertGBPToDev(floatval($row['input_op']));
        $creation_date = $row['creation_date'];
        $modif_date = $row['modif_date'];
        $id_proj = intval($row['id_proj']);
        $list[$id] = ['name'=>$name,'description'=>$description,'input_invest'=>$input_invest,'input_op'=>$input_op,'creation_date'=>$creation_date,'modif_date'=>$modif_date,'id_proj'=>$id_proj];
    }
    //var_dump($list);
    return $list;
}

function getListScenariosByProj($projID){
    $db = dbConnect();
    $req = $db->prepare('SELECT financing_scenario.id,financing_scenario.name,financing_scenario.description,input_invest,input_op,financing_scenario.creation_date,financing_scenario.modif_date,id_proj
                            FROM financing_scenario
                            WHERE financing_scenario.id_proj = ?
                            ORDER BY financing_scenario.name');
    $req->execute(array($projID));
    $list = [];
    while ($row = $req->fetch()){
        $id = intval($row['id']);
        $name = $row['name'];
        $description = $row['description'];
        $input_invest = convertGBPToDev(floatval($row['input_invest']));
        $input_op = convertGBPToDev(floatval($row['input_op']));
        $creation_date = $row['creation_date'];
        $modif_date = $row['modif_date'];
        $id_proj = intval($row['id_proj']);
        $list[$id] = ['name'=>$name,'description'=>$description,'input_invest'=>$input_invest,'input_op'=>$input_op,'creation_date'=>$creation_date,'modif_date'=>$modif_date,'id_proj'=>$id_proj];
    }
    //var_dump($list);
    return $list;
}


function getListProjects2($idUser){
    $db = dbConnect();
    $req = $db->prepare('SELECT * FROM project WHERE id_user = ? ORDER BY id');
    $req->execute(array($idUser));
    $list = [];
    while ($row = $req->fetch()){
        //var_dump($row);
        $id = intval($row['id']);
        $name = $row['name'];
        $description = $row['description'];
        $discount_rate = floatval($row['discount_rate']);
        $weight_bank = floatval($row['weight_bank']);
        $weight_bank_soc = floatval($row['weight_bank_soc']);
        $creation_date = $row['creation_date'];
        $modif_date = $row['modif_date'];
        $id_user = intval($row['id_user']);
        $scoping = intval($row['scoping']);
        $cb = intval($row['cb']);
        $list[$id] = ['name'=>$name,'description'=>$description,'discount_rate'=>$discount_rate,'weight_bank'=>$weight_bank,'weight_bank_soc'=>$weight_bank_soc,'creation_date'=>$creation_date,'modif_date'=>$modif_date,'id_user'=>$id_user,'scoping'=>$scoping,'cb'=>$cb];
    }
    return $list;
}

function insertScen($scen){
    $db = dbConnect();
    $req = $db->prepare('INSERT INTO financing_scenario (name,description,id_proj) VALUES (?,?,?)');
    return $req->execute(array($scen[0],$scen[1],$scen[2]));
}

function deleteScen($id){
    $db = dbConnect();
    $req = $db->prepare('DELETE FROM financing_scenario WHERE id = ?');
    return $req->execute(array($id));
}

function update_ModifDate_scen($scenID){
    $db = dbConnect();
    $req = $db->prepare('UPDATE financing_scenario SET modif_date = CURRENT_TIMESTAMP WHERE id = ?');
    return $req->execute(array($scenID));
}

function getScen($userID,$name){
    $db = dbConnect();
    $req = $db->prepare('SELECT *
                            FROM financing_scenario
                            INNER JOIN project
                                WHERE project.id = financing_scenario.id_proj
                                    and project.id_user = ? and financing_scenario.name = ? ');
    $req->execute(array($userID,$name));
    $res = $req->fetch();
    //var_dump($res);
    return $res;
}

function getScenByID($scenID){
    $db = dbConnect();
    $req = $db->prepare('SELECT *
                            FROM financing_scenario
                            WHERE id = ? ');
    $req->execute(array($scenID));
    $res = $req->fetch();
    $id = intval($res['id']);
    $name = $res['name'];
    $description = $res['description'];
    $input_invest = convertGBPToDev(floatval($res['input_invest']));
    $input_op = convertGBPToDev(floatval($res['input_op']));
    $creation_date = $res['creation_date'];
    $modif_date = $res['modif_date'];
    $id_proj = intval($res['id_proj']);
    $scen = ['id'=>$id,'name'=>$name,'description'=>$description,'input_invest'=>$input_invest,'input_op'=>$input_op,'creation_date'=>$creation_date,'modif_date'=>$modif_date,'id_proj'=>$id_proj];
    
    //var_dump($scen);
    return $scen;
}

function insertInputScenario($op,$invest,$scenID){
    $db = dbConnect();
    $req = $db->prepare('UPDATE financing_scenario SET input_op = ?, input_invest = ? WHERE id = ?');
    return $req->execute(array(convertDevToGBP($op),convertDevToGBP($invest),$scenID));
}

function getFundingTarget($scenID){
    $db = dbConnect();
    $req = $db->prepare('SELECT input_op+input_invest as funding_target
                            FROM financing_scenario
                            WHERE id = ?');
    $req->execute(array($scenID));
    return convertGBPToDev(floatval($req->fetch()['funding_target']));
}




// ---------------------------------------- DASHBOARDS ----------------------------------------

function getTotCapexFromProj($projID){
    $db = dbConnect();
    $req = $db->prepare('SELECT SUM(volume*unit_cost) AS tot
                            FROM input_capex
                            WHERE id_proj = ?');
    $req->execute(array($projID));
    $res = $req->fetch()['tot'];
    $tot = floatval($res);
    return convertGBPToDev($tot);
}

function getTotCapexByUC($projID,$ucID){
    $db = dbConnect();
    $req = $db->prepare('SELECT SUM(volume*unit_cost) AS tot
                            FROM input_capex
                            WHERE id_proj = ? and id_uc = ?');
    $req->execute(array($projID,$ucID));
    $res = $req->fetch()['tot'];
    $tot = floatval($res);
    return convertGBPToDev($tot);
}

function getTotXpexByUCAndOrigine($projID,$ucID, $xpex, $origine){
    //not valable for opex
    if($xpex!="capex" and $xpex!="implem"){
        throw new Exception("Wrong xpex (this function is not valable for opex) ! ");
    }
    if($origine!="from_ntt" and $origine!="from_outside_ntt" and $origine!="internal"){
        throw new Exception("Wrong origine !");
    }
    if($origine=="internal" and $xpex=="capex" ){
        throw new Exception ("Capex can't be internal.");
    }
    $db = dbConnect();
    $req = $db->prepare('SELECT SUM(volume*unit_cost) AS tot
                            FROM input_'.$xpex.' 
                            JOIN '.$xpex.'_item 
                            ON id_item=id
                            WHERE id_proj = ? and id_uc = ? and origine = ?');
    $req->execute(array($projID,$ucID, $origine));
    $res = $req->fetch()['tot'];
    $tot = floatval($res);
    return convertGBPToDev($tot);
}

function getCapexAmort($projID,$ucID){
    $db = dbConnect();
    $req = $db->prepare('SELECT id_item,period
                            FROM input_capex
                            WHERE id_proj = ? and id_uc = ?');
    $req->execute(array($projID,$ucID));
    $list = [];
    while($res = $req->fetch()){
        $id_item = intval($res['id_item']);
        $period = intval($res['period']);
        $list[$id_item] = $period;
    }
    return $list;
}

function getTotImplemFromProj($projID){
    $db = dbConnect();
    $req = $db->prepare('SELECT SUM(volume*unit_cost) AS tot
                            FROM input_implem
                            WHERE id_proj = ?');
    $req->execute(array($projID));
    $res = $req->fetch()['tot'];
    $tot = floatval($res);
    return convertGBPToDev($tot);
}

function getTotImplemByUC($projID,$ucID){
    $db = dbConnect();
    $req = $db->prepare('SELECT SUM(volume*unit_cost) AS tot
                            FROM input_implem
                            WHERE id_proj = ? and id_uc = ?');
    $req->execute(array($projID,$ucID));
    $res = $req->fetch()['tot'];
    $tot = floatval($res);
    return convertGBPToDev($tot);
}

function getNbUC($projID,$ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT nb_tot_uc, id_zone
                            FROM volumes_input
                            WHERE id_proj = ? and id_uc = ?");
    $req->execute(array($projID,$ucID));
    $list = [];
    while($row=$req->fetch()){
        $id_zone = intval($row['id_zone']);
        $nb_uc = intval($row['nb_tot_uc']);
        $list[$id_zone] = $nb_uc;
    }
    return $list;
}

function getOpexValuesOrigine($projID,$ucID, $origine){
    $db = dbConnect();
    $req = $db->prepare('SELECT volume*unit_cost AS cost, annual_variation_volume as an_var_vol,                                    annual_variation_unitcost as an_var_unitcost, id_item
                            FROM input_opex
                            JOIN opex_item
                            ON id = id_item
                            WHERE id_proj = ? and id_uc = ? and origine = ?');
    $req->execute(array($projID,$ucID, $origine));
    $list = [];
    while($res = $req->fetch()){
        $id_item = intval($res['id_item']);
        $an_var_vol = floatval($res['an_var_vol']);
        $rate1 = pow(1+($an_var_vol/100),1/12);
        $an_var_unitcost = floatval($res['an_var_unitcost']);
        $rate2 = pow(1+($an_var_unitcost/100),1/12);
        $cost = convertGBPToDev(floatval($res['cost']));

        $list[$id_item] = ['cost'=>$cost,'an_var_vol'=>$rate1,'an_var_unitcost'=>$rate2];
    }
    //var_dump($list);
    return $list;
}
function getOpexValues($projID,$ucID){
    $db = dbConnect();
    $req = $db->prepare('SELECT volume*unit_cost AS cost, annual_variation_volume as an_var_vol,                                    annual_variation_unitcost as an_var_unitcost, id_item
                            FROM input_opex
                            WHERE id_proj = ? and id_uc = ?');
    $req->execute(array($projID,$ucID));
    $list = [];
    while($res = $req->fetch()){
        $id_item = intval($res['id_item']);
        $an_var_vol = floatval($res['an_var_vol']);
        $rate1 = pow(1+($an_var_vol/100),1/12);
        $an_var_unitcost = floatval($res['an_var_unitcost']);
        $rate2 = pow(1+($an_var_unitcost/100),1/12);
        $cost = convertGBPToDev(floatval($res['cost']));

        $list[$id_item] = ['cost'=>$cost,'an_var_vol'=>$rate1,'an_var_unitcost'=>$rate2];
    }
    //var_dump($list);
    return $list;
}

function getRevenuesValues($projID,$ucID){
    $db = dbConnect();
    $req = $db->prepare('SELECT volume*revenues_per_unit AS revenues,
                            annual_variation_volume as an_var_vol,                        
                            annual_variation_unitcost as an_var_unitcost,
                            id_item
                            FROM input_revenues
                            WHERE id_proj = ? and id_uc = ?');
    $req->execute(array($projID,$ucID));
    $list = [];
    while($res = $req->fetch()){
        $id_item = intval($res['id_item']);

        $an_var_vol = floatval($res['an_var_vol']);
        $rate1 = pow(1+($an_var_vol/100),1/12);

        $an_var_unitcost = floatval($res['an_var_unitcost']);
        $rate2 = pow(1+($an_var_unitcost/100),1/12);

        $revenues = convertGBPToDev(floatval($res['revenues']));

        $list[$id_item] = ['revenues'=>$revenues,'an_var_vol'=>$rate1,'an_var_unitcost'=>$rate2];
    }
    //var_dump($list);
    return $list;
}

function getCashReleasingValues($projID,$ucID){
    $db = dbConnect();
    $req = $db->prepare('SELECT volume*unit_cost AS baseline,
                            (volume*(1-volume_reduc/100))*(unit_cost*(1-unit_cost_reduc/100)) as target,
                            annual_var_volume as an_var_vol,                        
                            annual_var_unit_cost as an_var_unitcost,
                            id_item
                            FROM input_cashreleasing
                            WHERE id_proj = ? and id_uc = ?');
    $req->execute(array($projID,$ucID));
    $list = [];
    while($res = $req->fetch()){
        $id_item = intval($res['id_item']);

        $an_var_vol = floatval($res['an_var_vol']);
        $rate1 = pow(1+($an_var_vol/100),1/12);

        $an_var_unitcost = floatval($res['an_var_unitcost']);
        $rate2 = pow(1+($an_var_unitcost/100),1/12);

        $baseline = convertGBPToDev(floatval($res['baseline']));
        $target = convertGBPToDev(floatval($res['target']));

        $list[$id_item] = ['baseline'=>$baseline,'target'=>$target,'an_var_vol'=>$rate1,'an_var_unitcost'=>$rate2];
    }
    //var_dump($list);
    return $list;
}

function getBaselineCRB($projID,$ucID){
    $db = dbConnect();
    $req = $db->prepare('SELECT SUM(volume*unit_cost) as baseline
                            FROM input_cashreleasing
                            WHERE id_proj = ? and id_uc = ?');
    $req->execute(array($projID,$ucID));
    return convertGBPToDev(floatval($req->fetch()['baseline']));
}

function getWiderCashValues($projID,$ucID){
    $db = dbConnect();
    $req = $db->prepare('SELECT volume*unit_cost AS baseline,
                            (volume*(1-volume_reduc/100))*(unit_cost*(1-unit_cost_reduc/100)) as target,
                            annual_var_volume as an_var_vol,                        
                            annual_var_unit_cost as an_var_unitcost,
                            id_item
                            FROM input_widercash
                            WHERE id_proj = ? and id_uc = ?');
    $req->execute(array($projID,$ucID));
    $list = [];
    while($res = $req->fetch()){
        $id_item = intval($res['id_item']);

        $an_var_vol = floatval($res['an_var_vol']);
        $rate1 = pow(1+($an_var_vol/100),1/12);

        $an_var_unitcost = floatval($res['an_var_unitcost']);
        $rate2 = pow(1+($an_var_unitcost/100),1/12);

        $baseline = convertGBPToDev(floatval($res['baseline']));
        $target = convertGBPToDev(floatval($res['target']));

        $list[$id_item] = ['baseline'=>$baseline,'target'=>$target,'an_var_vol'=>$rate1,'an_var_unitcost'=>$rate2];
    }
    return $list;
}

function getNonCashRating($projID,$ucID){
    $db = dbConnect();
    $req = $db->prepare('SELECT SUM(expected_impact*probability/100) as tot,
                            COUNT(id_item) as nb
                            FROM input_noncash
                            WHERE id_proj = ? and id_uc = ?');
    $req->execute(array($projID,$ucID));
    $res = $req->fetch();
    //var_dump($res);
    $tot = floatval($res['tot']);
    $nb = intval($res['nb']);
    $rating = $nb!=0 ? $tot/$nb : -1;
    //var_dump($rating);
    return $rating;
}

function getRisksRating($projID,$ucID){
    $db = dbConnect();
    $req = $db->prepare('SELECT SUM(expected_impact*probability/100) as tot,
                            COUNT(id_item) as nb
                            FROM input_risk
                            WHERE id_proj = ? and id_uc = ?');
    $req->execute(array($projID,$ucID));
    $res = $req->fetch();
    //var_dump($res);
    $tot = floatval($res['tot']);
    $nb = intval($res['nb']);
    $rating = $nb!=0 ? $tot/$nb : -1;
    return $rating;
}


function getListVolumesPerUC($projID,$ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT SUM(nb_compo/nb_per_uc) as volumeCalculated, SUM(nb_tot_uc) as volumeDirectInput
                            FROM volumes_input
                            WHERE id_proj = ? and id_uc = ?");
    $req->execute(array($projID,$ucID));
    $res = $req->fetch();
    if ($res['volumeDirectInput']) {
        return intval($res['volumeDirectInput']);
    } else {
        return intval($res['volumeCalculated']);
    }
    
}


// ---------------------------------------- FUNDING SOURCES ----------------------------------------

function getListFundingSourcesCat(){
    $db = dbConnect();
    $req = $db->prepare('SELECT id,name
                            FROM funding_sources_category');
    $req->execute();
    $list = [];
    while($res = $req->fetch()){
        $id = intval($res['id']);
        $name = $res['name'];
        $list[$id] = ['name'=>$name];
    }
    //var_dump($list);
    return $list;
}

function getListFundingSources(){
    $db = dbConnect();
    $req = $db->prepare('SELECT id,name,id_cat,hasEntities,id_type
                            FROM funding_source');
    $req->execute();
    $list = [];
    while($res = $req->fetch()){
        $id = intval($res['id']);
        $name = $res['name'];
        $id_cat = intval($res['id_cat']);
        $hasEntities = intval($res['hasEntities']);
        $id_type = intval($res['id_type']); // 1 = others - 2 = loans and bonds
        $list[$id] = ['name'=>$name,'id_cat'=>$id_cat,'hasEntities'=>$hasEntities,'id_type'=>$id_type];
    }
    //var_dump($list);
    return $list;
}

function getFundingSourceByID($sourceID){
    $db = dbConnect();
    $req = $db->prepare('SELECT id,name,id_cat,hasEntities,id_type
                            FROM funding_source
                            WHERE id=?');
    $req->execute(array($sourceID));
    $res = $req->fetch();
    $id = intval($res['id']);
    $name = $res['name'];
    $id_cat = intval($res['id_cat']);
    $hasEntities = intval($res['hasEntities']);
    $id_type = intval($res['id_type']); // 1 = others - 2 = loans and bonds
    $FS = ['id'=>$id,'name'=>$name,'id_cat'=>$id_cat,'hasEntities'=>$hasEntities,'id_type'=>$id_type];
    return $FS;
}

function getListSelFS($scenID){
    $db = dbConnect();
    $req = $db->prepare('SELECT id_source,share,start_date,maturity_date,interest
                            FROM sel_funding_source
                            WHERE id_finScen = ?');
    $req->execute(array($scenID));
    $list = [];
    while($res = $req->fetch()){
        $id_source = intval($res['id_source']);
        $share = floatval($res['share']);
        $interest = floatval($res['interest']);
        $start_date = $res['start_date'] ? date_create($res['start_date'])->format('m/Y') : null;
        $maturity_date = $res['maturity_date'] ? date_create($res['maturity_date'])->format('m/Y') : null;
        $list[$id_source] = ['share'=>$share,'interest'=>$interest,'start_date'=>$start_date,'maturity_date'=>$maturity_date];
    }
    return $list;
}

function insertSelFS($scenID,$selFS){
    $db = dbConnect();
    $ret = true;
    $req = $db->prepare('INSERT INTO sel_funding_source (id_finScen,id_source,share) VALUES (?,?,?)');
    foreach($selFS as $sourceID => $share){
        $ret = $req->execute(array($scenID,$sourceID,$share));
    }
    return $ret;
}

function deleteSelFS($selFS){
    $db = dbConnect();
    $req = $db->prepare('DELETE FROM sel_funding_source WHERE id_source = ?');
    $ret = true;
    foreach($selFS as $sourceID => $share){
        $ret = $req->execute(array($sourceID));
    }
    return $ret;
}

function updateFundingSourceOthers($scenID,$sourceID,$infos){
    $db = dbConnect();
    $req = $db->prepare('UPDATE sel_funding_source
                            SET start_date = ?
                            WHERE id_source = ? and id_finScen = ?');
    return $req->execute(Array($infos['date'],$sourceID,$scenID));
}

function updateFundingSourceLB($scenID,$sourceID,$infos){
    $db = dbConnect();
    $req = $db->prepare('UPDATE sel_funding_source
                            SET start_date = ?,
                                maturity_date = ?,
                                interest = ?
                            WHERE id_source = ? and id_finScen = ?');
    return $req->execute(Array($infos['startdate'],$infos['maturitydate'],$infos['interest'],$sourceID,$scenID));
}

function insertInputBankability($npv_nogo,$npv_target,$roi_nogo,$roi_target,$payback_nogo,$payback_target,$rr_nogo,$rr_target,$nqbr_nogo,$nqbr_target,$projID){
    $db = dbConnect();
    $req = $db->prepare('REPLACE INTO bankability_input_nogo_target (id, npv_nogo, npv_target, roi_nogo, roi_target, payback_nogo, payback_target, risks_rating_nogo, risks_rating_target, noncash_rating_nogo, noncash_rating_target) VALUES (?,?,?,?,?,?,?,?,?,?,?)');
    return $req->execute(Array($projID,$npv_nogo,$npv_target,$roi_nogo,$roi_target,$payback_nogo,$payback_target,$rr_nogo,$rr_target,$nqbr_nogo,$nqbr_target));
}
function insertInputDealCriteria($societal_npv_nogo,$societal_npv_target,$societal_roi_nogo,$societal_roi_target,$societal_payback_nogo,$societal_payback_target, $npv_nogo,$npv_target,$roi_nogo,$roi_target,$payback_nogo,$payback_target,$rr_nogo,$rr_target,$nqbr_nogo,$nqbr_target,$projID){
    $db = dbConnect();
    $req = $db->prepare('REPLACE INTO deal_criteria_input_nogo_target (id, societal_npv_nogo, societal_npv_target, societal_roi_nogo, societal_roi_target, societal_payback_nogo, societal_payback_target,npv_nogo, npv_target, roi_nogo, roi_target, payback_nogo, payback_target, risks_rating_nogo, risks_rating_target, nqbr_nogo, nqbr_target) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
    return $req->execute(Array($projID,$societal_npv_nogo,$societal_npv_target,$societal_roi_nogo,$societal_roi_target,$societal_payback_nogo,$societal_payback_target,$npv_nogo,$npv_target,$roi_nogo,$roi_target,$payback_nogo,$payback_target,$rr_nogo,$rr_target,$nqbr_nogo,$nqbr_target));
}
function getDealCriteriaInputNogoTarget($projID, $filtre = ""){
    $db = dbConnect();
    $req = $db->prepare('SELECT * FROM deal_criteria_input_nogo_target WHERE id = ?');
    $req->execute(Array($projID));
    $list=[];
    while($row = $req->fetch()){
        $societal_npv_nogo = floatval($row['societal_npv_nogo']);
        $societal_npv_target = floatval($row['societal_npv_target']);
        $societal_roi_nogo = floatval($row['societal_roi_nogo']);
        $societal_roi_target = floatval($row['societal_roi_target']);
        $societal_payback_nogo = floatval($row['societal_payback_nogo']);
        $societal_payback_target = floatval($row['societal_payback_target']);
        $npv_nogo = floatval($row['npv_nogo']);
        $npv_target = floatval($row['npv_target']);
        $roi_nogo = floatval($row['roi_nogo']);
        $roi_target = floatval($row['roi_target']);
        $payback_nogo = floatval($row['payback_nogo']);
        $payback_target = floatval($row['payback_target']);
        $rr_nogo = floatval($row['risks_rating_nogo']);
        $rr_target = floatval($row['risks_rating_target']);
        $nqbr_nogo = floatval($row['nqbr_nogo']);
        $nqbr_target = floatval($row['nqbr_target']);
    
        if($filtre=="nogo"){
            $list = ['societal_npv_nogo'=>$societal_npv_nogo,  'societal_roi_nogo'=>$societal_roi_nogo,  'societal_payback_nogo'=>$payback_nogo, 'npv_nogo'=>$npv_nogo,  'roi_nogo'=>$roi_nogo,  'payback_nogo'=>$payback_nogo,  'rr_nogo'=>$rr_nogo,  'nqbr_nogo'=>$nqbr_nogo];
        }elseif($filtre=="target"){
            $list = ['societal_npv_target'=>$societal_npv_target,  'societal_roi_target'=>$societal_roi_target,  'societal_payback_target'=>$payback_target, 'npv_target'=>$npv_target,  'roi_target'=>$roi_target,  'payback_target'=>$payback_target,  'rr_target'=>$rr_target,  'nqbr_target'=>$nqbr_target];
        }elseif($filtre==""){
            $list = ['societal_npv_nogo'=>$societal_npv_nogo, 'societal_npv_target'=>$societal_npv_target, 'societal_roi_nogo'=>$societal_roi_nogo, 'societal_roi_target'=>$roi_target, 'societal_payback_nogo'=>$payback_nogo, 'societal_payback_target'=>$societal_payback_target,'npv_nogo'=>$npv_nogo, 'npv_target'=>$npv_target, 'roi_nogo'=>$roi_nogo, 'roi_target'=>$roi_target, 'payback_nogo'=>$payback_nogo, 'payback_target'=>$payback_target, 'rr_nogo'=>$rr_nogo, 'rr_target'=>$rr_target, 'nqbr_nogo'=>$nqbr_nogo, 'nqbr_target'=>$nqbr_target];
        }
    }
    return $list;
}
function getBankabilitInputNogoTarget($projID){
    $db = dbConnect();
    $req = $db->prepare('SELECT * FROM bankability_input_nogo_target WHERE id = ?');
    $req->execute(Array($projID));
    $list=[];
    while($row = $req->fetch()){
        $npv_nogo = floatval($row['npv_nogo']);
        $npv_target = floatval($row['npv_target']);
        $roi_nogo = floatval($row['roi_nogo']);
        $roi_target = floatval($row['roi_target']);
        $payback_nogo = floatval($row['payback_nogo']);
        $payback_target = floatval($row['payback_target']);
        $rr_nogo = floatval($row['risks_rating_nogo']);
        $rr_target = floatval($row['risks_rating_target']);
        $nqbr_nogo = floatval($row['noncash_rating_nogo']);
        $nqbr_target = floatval($row['noncash_rating_target']);
    $list = ['npv_nogo'=>$npv_nogo, 'npv_target'=>$npv_target, 'roi_nogo'=>$roi_nogo, 'roi_target'=>$roi_target, 'payback_nogo'=>$payback_nogo, 'payback_target'=>$payback_target, 'rr_nogo'=>$rr_nogo, 'rr_target'=>$rr_target, 'nqbr_nogo'=>$nqbr_nogo, 'nqbr_target'=>$nqbr_target];
    }
    return $list;
}



// ---------------------------------------- ENTITY ----------------------------------------

function getListLoansAndBonds($scenID){
    $db = dbConnect();
    $req = $db->prepare('SELECT entity.id,entity.id_source,name,description,start_date,share,maturity_date,interest
                            FROM entity
                                INNER JOIN loans_and_bonds
                                    WHERE loans_and_bonds.id = entity.id
                                        AND entity.id_finScen = ?
                            ORDER BY name
                                ');
    $req->execute(array($scenID));
    $list = [];
    while($row = $req->fetch()){
        $id = intval($row['id']);
        $id_source = intval($row['id_source']);
        $name = $row['name'];
        $description = $row['description'];
        $start_date = $row['start_date'] ? date_create($row['start_date'])->format('m/Y') : null;
        $share = floatval($row['share']);
        $interest = floatval($row['interest']);
        $maturity_date = $row['maturity_date'] ? date_create($row['maturity_date'])->format('m/Y') : null;
        if(array_key_exists($id_source,$list)){
            $list[$id_source][$id] = ['name'=>$name,'description'=>$description,'start_date'=>$start_date,'share'=>$share,'interest'=>$interest,'maturity_date'=>$maturity_date];
        } else {
            $list[$id_source] = [$id=>['name'=>$name,'description'=>$description,'start_date'=>$start_date,'share'=>$share,'interest'=>$interest,'maturity_date'=>$maturity_date]];
        }
    }
    //var_dump($list);
    return $list;
}

function getListOthers($scenID){
    $db = dbConnect();
    $req = $db->prepare('SELECT entity.id,entity.id_source,name,description,start_date,share
                            FROM entity
                                    INNER JOIN others
                                        WHERE others.id = entity.id
                                            AND entity.id_finScen = ?
                            ORDER BY name
                                ');
    $req->execute(array($scenID));
    $list = [];
    while($row = $req->fetch()){
        $id = intval($row['id']);
        $id_source = intval($row['id_source']);
        $name = $row['name'];
        $description = $row['description'];
        $start_date = $row['start_date'] ? date_create($row['start_date'])->format('m/Y') : null;
        $share = floatval($row['share']);
        if(array_key_exists($id_source,$list)){
            $list[$id_source][$id] = ['name'=>$name,'description'=>$description,'start_date'=>$start_date,'share'=>$share];
        } else {
            $list[$id_source] = [$id=>['name'=>$name,'description'=>$description,'start_date'=>$start_date,'share'=>$share]];
        }
    }
    //var_dump($list);
    return $list;
}

function insertLoansAndBonds($scenID,$sourceID,$name,$desc){
    $db = dbConnect();
    $ret = false;
    $db->exec('DROP PROCEDURE IF EXISTS `add_entity`;');
    $db->exec(' CREATE PROCEDURE `add_entity`(
                            IN entity_name VARCHAR(255),
                            IN entity_desc VARCHAR(255),
                            IN idSource INT,
                            IN idScen INT
                            )
                            BEGIN
                                DECLARE itemID INT;
                                INSERT INTO entity (name,description,id_source,id_finScen)
                                    VALUES (entity_name,entity_desc,idSource,idScen);
                                SET itemID = LAST_INSERT_ID();
                                INSERT INTO loans_and_bonds (id)
                                    VALUES (itemID);
                            END
                                ');
    $req = $db->prepare('CALL add_entity(?,?,?,?);');
    $ret = $req->execute(array($name,$desc,$sourceID,$scenID));
    return $ret;
}

function insertOthers($scenID,$sourceID,$name,$desc){
    $db = dbConnect();
    $ret = false;
    $db->exec('DROP PROCEDURE IF EXISTS `add_entity`;');
    $db->exec(' CREATE PROCEDURE `add_entity`(
                            IN entity_name VARCHAR(255),
                            IN entity_desc VARCHAR(255),
                            IN idSource INT,
                            IN idScen INT
                            )
                            BEGIN
                                DECLARE itemID INT;
                                INSERT INTO entity (name,description,id_source,id_finScen)
                                    VALUES (entity_name,entity_desc,idSource,idScen);
                                SET itemID = LAST_INSERT_ID();
                                INSERT INTO others (id)
                                    VALUES (itemID);
                            END
                                ');
    $req = $db->prepare('CALL add_entity(?,?,?,?);');
    $ret = $req->execute(array($name,$desc,$sourceID,$scenID));
    return $ret;
}

function deleteEntity($entityID){
    $db = dbConnect();
    $req = $db->prepare('DELETE FROM entity WHERE id = ?'); //not need to delete from children table because of "ON DELETE CASCADE"
    return $req->execute(array($entityID));
}


function updateEntityOthers($entityID,$infos){
    $db = dbConnect();
    $req = $db->prepare('UPDATE entity
                            SET start_date = ?,
                                share = ?
                            WHERE id = ?');
    return $req->execute(Array($infos['date'],$infos['share'],$entityID));
}

function updateEntityLB($entityID,$infos){
    $db = dbConnect();

    $req1 = $db->prepare('UPDATE entity
                            SET start_date = ?,
                                share = ?
                            WHERE id = ?');
    $ret1 = $req1->execute(Array($infos['startdate'],$infos['share'],$entityID));

    $req2 = $db->prepare('UPDATE loans_and_bonds
                            SET maturity_date = ?,
                                interest = ?
                            WHERE id = ?');
    $ret2 = $req2->execute(Array($infos['maturitydate'],$infos['interest'],$entityID));
    
    return $ret1 && $ret2;
}


// ---------------------------------------- BENEF. ----------------------------------------

function getListBenef($scenID){
    $db = dbConnect();
    $req = $db->prepare('SELECT id,name, share
                            FROM beneficiary
                            WHERE id_finScen = ?');
    $req->execute(array($scenID));
    $list =[];
    while ($row = $req->fetch()){
        $id = intval($row['id']);
        $name = $row['name'];
        $share = floatval($row['share']);
        $list[$id] = ['name'=>$name,'share'=>$share];
    }
    return $list;
}

function insertBenef($scenID,$infos){ //only insert name
    $db = dbConnect();
    $req = $db->prepare('INSERT INTO beneficiary
                            (id_finScen,name) VALUES (?,?)
                            ');
    return $req->execute(array($scenID,$infos['name']));
}

function updateBenef($benefID,$infos){ //only update share
    $db = dbConnect();
    $req = $db->prepare('UPDATE beneficiary
                            SET share = ?
                            WHERE id = ?');
    return $req->execute(array($infos['share'],$benefID));
}

function deleteBenef($benefID){
    $db = dbConnect();
    $req = $db->prepare('DELETE FROM beneficiary
                            WHERE id = ?
                            ');
    return $req->execute(array($benefID));
}


// ------------------------------------- BUSINESS MODEL -------------------------------------

function getListInvestCap(){
    $db = dbConnect();
    $req = $db->prepare('SELECT id,name,description FROM invest_capacity ORDER BY id');
    $list = [];
    $req->execute();
    while ($row = $req->fetch()){
        $id = intval($row['id']);
        $name = $row['name'];
        $description = $row['description'];
        $list[$id] = ['name'=>$name,'description'=>$description];
    }
    return $list;
}
function getListPaybackConst(){
    $db = dbConnect();
    $req = $db->prepare('SELECT id,name,description FROM payback_constraints ORDER BY id');
    $list = [];
    $req->execute();
    while ($row = $req->fetch()){
        $id = intval($row['id']);
        $name = $row['name'];
        $description = $row['description'];
        $list[$id] = ['name'=>$name,'description'=>$description];
    }
    return $list;
}
function getListBusinessModelPref(){
    $db = dbConnect();
    $req = $db->prepare('SELECT id,name,description FROM business_model_pref ORDER BY id');
    $list = [];
    $req->execute();
    while ($row = $req->fetch()){
        $id = intval($row['id']);
        $name = $row['name'];
        $description = $row['description'];
        $list[$id] = ['name'=>$name,'description'=>$description];
    }
    return $list;
}

function getListBMReco(){
    $db = dbConnect();
    $req = $db->prepare('SELECT id,name FROM business_model_reco');
    $list = [];
    $req->execute();
    while ($row = $req->fetch()){
        $id = intval($row['id']);
        $name = $row['name'];
        $list[$id] = ['name'=>$name];
    }
    return $list;
}

function getBMReco($id_investcap,$id_payconst,$id_bmpref){
    $db = dbConnect();
    $req = $db->prepare('SELECT in_house,PPP,outsourced
                            FROM matrix_bm_1
                            WHERE id_investcap = ?
                                AND id_payconst = ?
                                AND id_bmpref = ?');
    
    $req->execute(array($id_investcap,$id_payconst,$id_bmpref));
    $res = $req->fetch();
    $in_house = intval($res['in_house']);
    $PPP = intval($res['PPP']);
    $outsourced = intval($res['outsourced']);
    $list = [$in_house =>1,$PPP =>2,$outsourced =>3]; //please check the id of BMReco in the DB
    ksort($list);
    return $list;
}

function getSelBM($projID){
    $db = dbConnect();
    $req = $db->prepare('SELECT id_investcap,id_payconst,id_bmpref
                            FROM business_model
                            WHERE id_proj = ?');
    
    $req->execute(array($projID));
    $res = $req->fetch();
    $id_investcap = intval($res['id_investcap']);
    $id_payconst = intval($res['id_payconst']);
    $id_bmpref = intval($res['id_bmpref']);
    $list = ["id_investcap" => $id_investcap,"id_payconst" => $id_payconst,"id_bmpref" => $id_bmpref];
    return $list;
    
}

function insertSelBM($projID,$id_investcap,$id_payconst,$id_bmpref){
    $db = dbConnect();
    $req = $db->prepare('INSERT INTO business_model
                            (id_proj,id_investcap,id_payconst,id_bmpref)
                            VALUES (?,?,?,?)
                            ');
    return $req->execute(array($projID,$id_investcap,$id_payconst,$id_bmpref));
}

function deleteSelBM($projID){
    $db = dbConnect();
    $req = $db->prepare('DELETE FROM business_model
                            WHERE id_proj = ?
                            ');
    return $req->execute(array($projID));
}

function getListBMBank(){
    $db = dbConnect();
    $req = $db->prepare('SELECT id,name,description FROM bm_bankability');
    $list = [];
    $req->execute();
    while ($row = $req->fetch()){
        $id = intval($row['id']);
        $name = $row['name'];
        $description = $row['description'];
        $list[$id] = ['name'=>$name,'description'=>$description];
    }
    return $list;
}

function getListBMSocBank(){
    $db = dbConnect();
    $req = $db->prepare('SELECT id,name,description FROM bm_soc_bankability');
    $list = [];
    $req->execute();
    while ($row = $req->fetch()){
        $id = intval($row['id']);
        $name = $row['name'];
        $description = $row['description'];
        $list[$id] = ['name'=>$name,'description'=>$description];
    }
    return $list;
}

function getFundingOpt($id_bm,$id_investcap,$id_bank,$id_socbank){
    $db = dbConnect();
    $req = $db->prepare('SELECT city,grants,eq_investors,impact_investors,bank_debt,green_debt,suppliers,alternative
                            FROM matrix_bm_2
                            WHERE id_bm = ?
                                AND id_investcap = ?
                                AND id_bank = ?
                                AND id_socbank = ?');
    
    $req->execute(array($id_bm,$id_investcap,$id_bank,$id_socbank));
    $res = $req->fetch();

    $city = intval($res['city']);
    $grants = intval($res['grants']);
    $eq_investors = intval($res['eq_investors']);
    $impact_investors = intval($res['impact_investors']);
    $bank_debt = intval($res['bank_debt']);
    $green_debt = intval($res['green_debt']);
    $suppliers = intval($res['suppliers']);
    $alternative = intval($res['alternative']);

    $list = ['City'=>$city,'Grants'=>$grants,'Equity investors'=>$eq_investors,'Impact Investors'=>$impact_investors,'Bank Debt'=>$bank_debt,'Green Debt'=>$green_debt,'Suppliers'=>$suppliers,'Alternative'=>$alternative];
    arsort($list);
    return $list;
}

// ------------------------------------- MANAGE DATABASE -------------------------------------

function getAllItem1Advice($catItem){
    //
    $db = dbConnect();

    switch ($catItem) {
        case "capex":
            $req = $db->prepare("SELECT * FROM capex_item_advice INNER JOIN capex_item
                                        WHERE capex_item.id = capex_item_advice.id ORDER BY name");
            $req->execute();
        break;

        case "opex":
            $req = $db->prepare("SELECT * FROM opex_item_advice INNER JOIN opex_item
                                        WHERE opex_item.id = opex_item_advice.id ORDER BY name");
            $req->execute();
        break;

        case "implem":
            $req = $db->prepare("SELECT * FROM implem_item_advice INNER JOIN implem_item
                                        WHERE implem_item.id = implem_item_advice.id ORDER BY name");
            $req->execute();
        break;

        case "revenues":
            $req = $db->prepare("SELECT * FROM revenues_item_advice INNER JOIN revenues_item
                                        WHERE revenues_item.id = revenues_item_advice.id ORDER BY name");
            $req->execute();
        break;
    }
          
    $list = [];
    
    while($row = $req->fetch()){
        $id_item = intval($row['id']);
        $name = $row['name'];
        $description = $row['description'];
        $unit = $row['unit'];
        $source = $row['source'];
        $range_min = intval($row['range_min']);
        $range_max = intval($row['range_max']);
        if(array_key_exists($id_item,$list)){
            $list[$id_item] += ['name'=>$name,'description'=>$description,'unit'=>$unit,'source'=>$source,'range_min'=>$range_min,'range_max'=>$range_max];
        } else {
            $list[$id_item] = ['name'=>$name,'description'=>$description,'unit'=>$unit,'source'=>$source,'range_min'=>$range_min,'range_max'=>$range_max];
        }
    }
    //var_dump($list);
    return $list;
}

function getAllItem2Advice($catItem){
    $db = dbConnect();

    switch ($catItem) {
        case "cashreleasing":
            $req = $db->prepare("SELECT * FROM cashreleasing_item_advice INNER JOIN cashreleasing_item
                                        WHERE cashreleasing_item.id = cashreleasing_item_advice.id ORDER BY name");
            $req->execute();
        break;

        case "widercash":
            $req = $db->prepare("SELECT * FROM widercash_item_advice INNER JOIN widercash_item
                                        WHERE widercash_item.id = widercash_item_advice.id ORDER BY name");
            $req->execute();
        break;      
       
    }

    $list = [];
    while($row = $req->fetch()){
        $id_item = intval($row['id']);
        $name = $row['name'];
        $description = $row['description'];
        $unit = $row['unit'];
        $source = $row['source'];
        $range_min_red_nb = intval($row['range_min_red_nb']);
        $range_max_red_nb = intval($row['range_max_red_nb']);
        $range_min_red_cost = intval($row['range_min_red_cost']);
        $range_max_red_cost = intval($row['range_max_red_cost']);
        if(array_key_exists($id_item,$list)){
            $list[$id_item] += ['name'=>$name,'description'=>$description,'unit'=>$unit,'source'=>$source,'range_min_red_nb'=>$range_min_red_nb,'range_max_red_nb'=>$range_max_red_nb,'range_min_red_cost'=>$range_min_red_cost,'range_max_red_cost'=>$range_max_red_cost];
        } else {
            $list[$id_item] = ['name'=>$name,'description'=>$description,'unit'=>$unit,'source'=>$source,'range_min_red_nb'=>$range_min_red_nb,'range_max_red_nb'=>$range_max_red_nb,'range_min_red_cost'=>$range_min_red_cost,'range_max_red_cost'=>$range_max_red_cost];
        }
    }
    //var_dump($list);
    return $list;
}

function getAllItem3Advice($catItem){
    $db = dbConnect();

    switch ($catItem) {
        case "noncash":
            $req = $db->prepare("SELECT * FROM noncash_item_advice INNER JOIN noncash_item
                                        WHERE noncash_item.id = noncash_item_advice.id ORDER BY name");
            $req->execute();
        break;

        case "risks":
            $req = $db->prepare("SELECT * FROM risks_item_advice INNER JOIN risks_item
                                        WHERE risks_item.id = risks_item_advice.id ORDER BY name");
            $req->execute();
        break;  
    }


    $list = [];
    while($row = $req->fetch()){
        $id_item = intval($row['id']);
        $name = $row['name'];
        $description = $row['description'];
        if(array_key_exists($id_item,$list)){
            $list[$id_item] += ['name'=>$name,'description'=>$description];
        } else {
            $list[$id_item] = ['name'=>$name,'description'=>$description];
        }
    }
    //var_dump($list);
    return $list;
}

function getItemByNameAndCat($itemName,$catItem){ 
    //récupère tous les item d'une catégorie qui ont le nom passé en paramètre
    $db = dbConnect();
    //var_dump($itemName);
    if ($catItem == 'capex'){
        $req = $db->prepare('SELECT * FROM capex_item WHERE name = ?');
        $req->execute(array($itemName));
    } else if ($catItem == 'implem'){
        $req = $db->prepare('SELECT * FROM implem_item WHERE name = ?');
        $req->execute(array($itemName));
    } else if ($catItem == 'opex'){
        $req = $db->prepare('SELECT * FROM opex_item WHERE name = ?');
        $req->execute(array($itemName));
    } else if ($catItem == 'revenues'){
        $req = $db->prepare('SELECT * FROM revenues_item WHERE name = ?');
        $req->execute(array($itemName));
    } else if ($catItem == 'cashreleasing'){
        $req = $db->prepare('SELECT * FROM cashreleasing_item WHERE name = ?');
        $req->execute(array($itemName));
    } else if ($catItem == 'widercash'){
        $req = $db->prepare('SELECT * FROM widercash_item WHERE name = ?');
        $req->execute(array($itemName));
    } else if ($catItem == 'quantifiable'){
        $req = $db->prepare('SELECT * FROM quantifiable_item WHERE name = ?');
        $req->execute(array($itemName));
    } else if ($catItem == 'noncash'){
        $req = $db->prepare('SELECT * FROM noncash_item WHERE name = ?');
        $req->execute(array($itemName));
    } else if ($catItem == 'risks'){
        $req = $db->prepare('SELECT * FROM risks_item WHERE name = ?');
        $req->execute(array($itemName));
    }
    
    return $req->fetch();
}

function insertItem($item,$catItem){
    //insère un item et sa guidance dans la db
    //var_dump($item, $catItem);
    $db = dbConnect();

    $ret = false;

    switch($catItem)
    {
        case 'capex':
            $db->exec('DROP PROCEDURE IF EXISTS `add_capex`;');
            $db->exec(' CREATE PROCEDURE `add_capex`(
                                    IN capex_name VARCHAR(255),
                                    IN capex_desc VARCHAR(255),
                                    IN idUC INT,
                                    IN unit VARCHAR(255),
                                    IN source VARCHAR(255),
                                    IN range_min INT,
                                    IN range_max INT
                                    )
                                    BEGIN
                                        DECLARE itemID INT;
                                        INSERT INTO capex_item (name,description)
                                            VALUES (capex_name,capex_desc);
                                        SET itemID = LAST_INSERT_ID();
                                        INSERT INTO capex_uc (id_item,id_uc)
                                            VALUES (itemID,idUC);
                                        INSERT INTO capex_item_advice (id,unit,source,range_min,range_max)
                                            VALUES (itemID,unit,source,range_min,range_max);
                                    END
                                        ');
            $req = $db->prepare('CALL add_capex(?,?,?,?,?,?,?);');
            $ret = $req->execute(array($item[0],$item[1],$item[6],$item[2],$item[3],intval($item[4]),intval($item[5])));
        
            return $ret;
            break;

        case 'implem':
            $db->exec('DROP PROCEDURE IF EXISTS `add_implem`;');
            $db->exec(' CREATE PROCEDURE `add_implem`(
                                    IN implem_name VARCHAR(255),
                                    IN implem_desc VARCHAR(255),
                                    IN idUC INT,
                                    IN unit VARCHAR(255),
                                    IN source VARCHAR(255),
                                    IN range_min INT,
                                    IN range_max INT
                                    )
                                    BEGIN
                                        DECLARE itemID INT;
                                        INSERT INTO implem_item (name,description)
                                            VALUES (implem_name,implem_desc);
                                        SET itemID = LAST_INSERT_ID();
                                        INSERT INTO implem_uc (id_item,id_uc)
                                            VALUES (itemID,idUC);
                                        INSERT INTO implem_item_advice (id,unit,source,range_min,range_max)
                                            VALUES (itemID,unit,source,range_min,range_max);
                                    END
                                        ');
            $req = $db->prepare('CALL add_implem(?,?,?,?,?,?,?);');
            $ret = $req->execute(array($item[0],$item[1],$item[6],$item[2],$item[3],intval($item[4]),intval($item[5])));
        
            return $ret;
            break;

        case 'opex':
            $db->exec('DROP PROCEDURE IF EXISTS `add_opex`;');
            $db->exec(' CREATE PROCEDURE `add_opex`(
                                    IN opex_name VARCHAR(255),
                                    IN opex_desc VARCHAR(255),
                                    IN idUC INT,
                                    IN unit VARCHAR(255),
                                    IN source VARCHAR(255),
                                    IN range_min INT,
                                    IN range_max INT
                                    )
                                    BEGIN
                                        DECLARE itemID INT;
                                        INSERT INTO opex_item (name,description)
                                            VALUES (opex_name,opex_desc);
                                        SET itemID = LAST_INSERT_ID();
                                        INSERT INTO opex_uc (id_item,id_uc)
                                            VALUES (itemID,idUC);
                                        INSERT INTO opex_item_advice (id,unit,source,range_min,range_max)
                                            VALUES (itemID,unit,source,range_min,range_max);
                                    END
                                        ');
            $req = $db->prepare('CALL add_opex(?,?,?,?,?,?,?);');
            $ret = $req->execute(array($item[0],$item[1],$item[6],$item[2],$item[3],intval($item[4]),intval($item[5])));
        
            return $ret;
            break;

        case 'revenues':
            $db->exec('DROP PROCEDURE IF EXISTS `add_revenues`;');
            $db->exec(' CREATE PROCEDURE `add_revenues`(
                                    IN revenues_name VARCHAR(255),
                                    IN revenues_desc VARCHAR(255),
                                    IN idUC INT,
                                    IN unit VARCHAR(255),
                                    IN source VARCHAR(255),
                                    IN range_min INT,
                                    IN range_max INT
                                    )
                                    BEGIN
                                        DECLARE itemID INT;
                                        INSERT INTO revenues_item (name,description)
                                            VALUES (revenues_name,revenues_desc);
                                        SET itemID = LAST_INSERT_ID();
                                        INSERT INTO revenues_uc (id_item,id_uc)
                                            VALUES (itemID,idUC);
                                        INSERT INTO revenues_item_advice (id,unit,source,range_min,range_max)
                                            VALUES (itemID,unit,source,range_min,range_max);
                                    END
                                        ');
            $req = $db->prepare('CALL add_revenues(?,?,?,?,?,?,?);');
            $ret = $req->execute(array($item[0],$item[1],$item[6],$item[2],$item[3],intval($item[4]),intval($item[5])));
        
            return $ret;
            break;

            case 'cashreleasing':
                $db->exec('DROP PROCEDURE IF EXISTS `add_cashreleasing`;');
                $db->exec(' CREATE PROCEDURE `add_cashreleasing`(
                                        IN cashreleasing_name VARCHAR(255),
                                        IN cashreleasing_desc VARCHAR(255),
                                        IN unit VARCHAR(255),
                                        IN source VARCHAR(255),
                                        IN unit_cost INT,
                                        IN min_red_nb INT,
                                        IN max_red_nb INT,
                                        IN min_red_cost INt,
                                        IN max_red_cost INT,
                                        IN idUC INT
                                        )
                                        BEGIN
                                            DECLARE itemID INT;
                                            INSERT INTO cashreleasing_item (name,description)
                                                VALUES (cashreleasing_name,cashreleasing_desc);
                                            SET itemID = LAST_INSERT_ID();
                                            INSERT INTO cashreleasing_uc (id_item,id_uc)
                                                VALUES (itemID,idUC);
                                            INSERT INTO widercash_item_advice (id,unit,source,unit_cost,range_min_red_nb,range_max_red_nb,range_min_red_cost,range_max_red_cost)
                                                VALUES (itemID,unit,source,unit_cost,min_red_nb,max_red_nb,min_red_cost,max_red_cost);
                                        END
                                            ');
                $req = $db->prepare('CALL add_cashreleasing(?,?,?,?,?,?,?,?,?,?);');
                $ret = $req->execute(array($item[0],$item[1],$item[2],$item[3],intval($item[4]),intval($item[5]),intval($item[6]),intval($item[7]),intval($item[8]),intval($item[9])));
            
                return $ret;
                break;

                case 'widercash':
                    $db->exec('DROP PROCEDURE IF EXISTS `add_widercash`;');
                    $db->exec(' CREATE PROCEDURE `add_widercash`(
                                            IN widercash_name VARCHAR(255),
                                            IN widercash_desc VARCHAR(255),
                                            IN unit VARCHAR(255),
                                            IN source VARCHAR(255),
                                            IN unit_cost INT,
                                            IN min_red_nb INT,
                                            IN max_red_nb INT,
                                            IN min_red_cost INt,
                                            IN max_red_cost INT,
                                            IN idUC INT
                                            )
                                            BEGIN
                                                DECLARE itemID INT;
                                                INSERT INTO widercash_item (name,description)
                                                    VALUES (widercash_name,widercash_desc);
                                                SET itemID = LAST_INSERT_ID();
                                                INSERT INTO widercash_uc (id_item,id_uc)
                                                    VALUES (itemID,idUC);
                                                INSERT INTO widercash_item_advice (id,unit,source,unit_cost,range_min_red_nb,range_max_red_nb,range_min_red_cost,range_max_red_cost)
                                                    VALUES (itemID,unit,source,unit_cost,min_red_nb,max_red_nb,min_red_cost,max_red_cost);
                                            END
                                                ');
                    $req = $db->prepare('CALL add_widercash(?,?,?,?,?,?,?,?,?,?);');
                    $ret = $req->execute(array($item[0],$item[1],$item[2],$item[3],intval($item[4]),intval($item[5]),intval($item[6]),intval($item[7]),intval($item[8]),intval($item[9])));
                
                    return $ret;
                    break;

                    case 'quantifiable':
                        $db->exec('DROP PROCEDURE IF EXISTS `add_quantifiable`;');
                        $db->exec(' CREATE PROCEDURE `add_quantifiable`(
                                                IN quantifiable_name VARCHAR(255),
                                                IN quantifiable_desc VARCHAR(255),
                                                IN unit VARCHAR(255),
                                                IN source VARCHAR(255),
                                                IN min_red_nb INT,
                                                IN max_red_nb INT,
                                                IN idUC INT
                                                )
                                                BEGIN
                                                    DECLARE itemID INT;
                                                    INSERT INTO quantifiable_item (name,description)
                                                        VALUES (quantifiable_name,quantifiable_desc);
                                                    SET itemID = LAST_INSERT_ID();
                                                    INSERT INTO quantifiable_uc (id_item,id_uc)
                                                        VALUES (itemID,idUC);
                                                    INSERT INTO quantifiable_item_advice (id,unit,source,range_min_red_nb,range_max_red_nb)
                                                        VALUES (itemID,unit,source,min_red_nb,max_red_nb);
                                                END
                                                    ');
                        $req = $db->prepare('CALL add_quantifiable(?,?,?,?,?,?,?);');
                        $ret = $req->execute(array($item[0],$item[1],$item[2],$item[3],intval($item[4]),intval($item[5]),intval($item[6])));
                    
                        return $ret;
                        break;

                    case 'noncash':
                        $db->exec('DROP PROCEDURE IF EXISTS `add_noncash`;');
                        $db->exec(' CREATE PROCEDURE `add_noncash`(
                                                IN noncash_name VARCHAR(255),
                                                IN noncash_desc VARCHAR(255),
                                                IN idUC INT
                                                )
                                                BEGIN
                                                    DECLARE itemID INT;
                                                    INSERT INTO noncash_item (name,description) 
                                                            VALUES (noncash_name,noncash_desc);
                                                    SET itemID = LAST_INSERT_ID();
                                                    INSERT INTO noncash_uc (id_item,id_uc) VALUES (itemID,idUC);
                                                END
                                                    ');
                        $req = $db->prepare('CALL add_noncash(?,?,?);');
                        $ret = $req->execute(array($item[0],$item[1],intval($item[2])));
                    
                        return $ret;
                        break;

                        case 'risks':
                            $db->exec('DROP PROCEDURE IF EXISTS `add_risks`;');
                            $db->exec(' CREATE PROCEDURE `add_risks`(
                                                    IN risks_name VARCHAR(255),
                                                    IN risks_desc VARCHAR(255),
                                                    IN idUC INT
                                                    )
                                                    BEGIN
                                                        DECLARE itemID INT;
                                                        INSERT INTO risks_item (name,description) 
                                                                VALUES (risks_name,risks_desc);
                                                        SET itemID = LAST_INSERT_ID();
                                                        INSERT INTO risks_uc (id_item,id_uc) VALUES (itemID,idUC);
                                                    END
                                                        ');
                            $req = $db->prepare('CALL add_risks(?,?,?);');
                            $ret = $req->execute(array($item[0],$item[1],intval($item[2])));
                        
                            return $ret;
                            break;
    }

    
}

function deleteItem($catItem,$itemID) {
    $db = dbConnect();

    switch ($catItem) {
        case "capex":
            $req = $db->prepare('DELETE FROM capex_item WHERE id = ?');
            return $req->execute(array($itemID));

            $req = $db->prepare('DELETE FROM capex_item_advice WHERE id = ?');
            return $req->execute(array($itemID));

            $req = $db->prepare('DELETE FROM capex_uc WHERE id_item = ?');
            return $req->execute(array($itemID));
        break;

        case "implem":
            $req = $db->prepare('DELETE FROM implem_item WHERE id = ?');
            return $req->execute(array($itemID));

            $req = $db->prepare('DELETE FROM implem_item_advice WHERE id = ?');
            return $req->execute(array($itemID));

            $req = $db->prepare('DELETE FROM implem_uc WHERE id_item = ?');
            return $req->execute(array($itemID));
        break;

        case "opex":
            $req = $db->prepare('DELETE FROM opex_item WHERE id = ?');
            return $req->execute(array($itemID));

            $req = $db->prepare('DELETE FROM opex_item_advice WHERE id = ?');
            return $req->execute(array($itemID));

            $req = $db->prepare('DELETE FROM opex_uc WHERE id_item = ?');
            return $req->execute(array($itemID));
        break;

        case "revenues":
            $req = $db->prepare('DELETE FROM revenues_item WHERE id = ?');
            return $req->execute(array($itemID));

            $req = $db->prepare('DELETE FROM revenues_item_advice WHERE id = ?');
            return $req->execute(array($itemID));

            $req = $db->prepare('DELETE FROM revenues_uc WHERE id_item = ?');
            return $req->execute(array($itemID));
        break;

        case "cashreleasing":
            $req = $db->prepare('DELETE FROM cashreleasing_item WHERE id = ?');
            return $req->execute(array($itemID));

            $req = $db->prepare('DELETE FROM cashreleasing_item_advice WHERE id = ?');
            return $req->execute(array($itemID));

            $req = $db->prepare('DELETE FROM cashreleasing_uc WHERE id_item = ?');
            return $req->execute(array($itemID));
        break;

        case "widercash":
            $req = $db->prepare('DELETE FROM widercash_item WHERE id = ?');
            return $req->execute(array($itemID));

            $req = $db->prepare('DELETE FROM widercash_item_advice WHERE id = ?');
            return $req->execute(array($itemID));

            $req = $db->prepare('DELETE FROM widercash_uc WHERE id_item = ?');
            return $req->execute(array($itemID));
        break;

        case "quantifiable":
            $req = $db->prepare('DELETE FROM quantifiable_item WHERE id = ?');
            return $req->execute(array($itemID));

            $req = $db->prepare('DELETE FROM quantifiable_item_advice WHERE id = ?');
            return $req->execute(array($itemID));

            $req = $db->prepare('DELETE FROM quantifiable_uc WHERE id_item = ?');
            return $req->execute(array($itemID));
        break;

        case "noncash":
            $req = $db->prepare('DELETE FROM noncash_item WHERE id = ?');
            return $req->execute(array($itemID));

            $req = $db->prepare('DELETE FROM noncash_item_advice WHERE id = ?');
            return $req->execute(array($itemID));

            $req = $db->prepare('DELETE FROM noncash_uc WHERE id_item = ?');
            return $req->execute(array($itemID));
        break;

        case "risks":
            $req = $db->prepare('DELETE FROM risks_item WHERE id = ?');
            return $req->execute(array($itemID));

            $req = $db->prepare('DELETE FROM risks_item_advice WHERE id = ?');
            return $req->execute(array($itemID));

            $req = $db->prepare('DELETE FROM risks_uc WHERE id_item = ?');
            return $req->execute(array($itemID));
        break;
    } 
}