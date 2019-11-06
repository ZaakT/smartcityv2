<?php
// --------------------------------- CONNECT TO DATABASE ----------------------------------

function dbConnect()
{
    try{
    $db = new PDO('mysql:host=smartcityv2;dbname=dst_v2_db_updated;charset=utf8', 'root','', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        return $db;
    } catch(Exception $e){ 
        throw new Exception("access to the database impossible !");
    }
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
    $req = $db->prepare('SELECT id, username, is_admin, password,salt FROM user WHERE username = ?');
    $req->execute(array($username));
    $res =  $req->fetch();
    
    if(!empty($res)){
        $userName = $res['username'];
        $userID = intval($res['id']);
        $isAdmin = $res['is_admin']==1 ? true : false;
        $userPassword = $res['password'];
        $salt = $res['salt'];
        $user = [$userID,$userName,$userPassword,$isAdmin,$salt];
    } else {
        $user = [];
    }
    return $user;
}

function getListUsers(){
    $db = dbConnect();
    $req = $db->query('SELECT id, username, is_admin,creation_date FROM user ORDER BY username');
    $list = [];
    while ($row = $req->fetch()){
        array_push($list,$row);
    }
    return $list;
}

/* function userAlreadyExists($username){
    $db = dbConnect();
    $req = $db->prepare('SELECT * FROM user WHERE username=?');
    return $req->execute(array($username));
} */

function insertUser($user){
    $db = dbConnect();
    $req = $db->prepare('INSERT INTO user (username,salt,password,is_admin) VALUES (?,?,?,?)');
    return $req->execute(array($user[0],$user[1],$user[2],$user[3]));
}

function modifyUser($user){
    $db = dbConnect();
    $req = $db->prepare('UPDATE user
                        SET username = ?,
                            salt = ?,
                            password = ?
                        WHERE id = ?');
    return $req->execute(array($user[1],$user[2],$user[3],$user[0]));
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
    $req = $db->query('SELECT * FROM measure ORDER BY name');
    $list = [];
    while ($row = $req->fetch()){
        array_push($list,$row);
    }
    return $list;
}

function getListSelMeas($ucmID){
    $db = dbConnect();
    $req = $db->prepare('SELECT measure.id, name, description
                        FROM measure
                        INNER JOIN ucm_sel_measure
                        WHERE (ucm_sel_measure.id_meas = measure.id) AND (ucm_sel_measure.id_ucm = ?)');
    $req->execute(array($ucmID));
    $list = [];
    while ($row = $req->fetch()){
        array_push($list,$row);
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
    $req = $db->query('SELECT crit.id, crit.name, crit.description, critCat.id
                    FROM crit
                    INNER JOIN critCat
                    WHERE crit.id_cat = critCat.id
                    ORDER BY name');
    $list = [];
    while ($row = $req->fetch()){
        array_push($list,$row);
    }
    return $list;
}

function getListCritCat(){
    $db = dbConnect();
    $req = $db->query('SELECT id,name FROM critCat ORDER BY name');
    $list = [];
    while ($row = $req->fetch()){
        array_push($list,$row);
    }
    return $list;
}

function getListSelCrit($ucmID){
    $db = dbConnect();
    $req = $db->prepare('SELECT crit.id, name, description, crit.id_cat
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



// ---------------------------------------- GEOGRAPHY ----------------------------------------

function getListDLTs(){
    $db = dbConnect();
    $req = $db->query('SELECT id, name, description FROM dlt ORDER BY name');
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



// ---------------------------------------- USE CASES ----------------------------------------

function getUC($list_measID){
    $db = dbConnect();
    $req = $db->prepare('SELECT id,name FROM use_case WHERE id_meas = ? ORDER BY name');
    $list = [];
    foreach ($list_measID as $measID) {
        $req->execute(array($measID));
        while ($row = $req->fetch()){
            array_push($list,$row);
        }
    }
    //var_dump($list);
    return $list;
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
    $list = array_reverse($list,true);
    //var_dump($list);
    return $list;

}

function insertRates($ucmID,$list_per_uc){
    $db = dbConnect();
    $ret = false;
    $req = $db->prepare('INSERT INTO uc_vs_crit_input (id_ucm,id_uc,id_crit,rate) VALUES (?,?,?,?)');
    foreach ($list_per_uc as $idUC => $list_per_crit) {
        foreach($list_per_crit as $idCrit => $rate){
            $ret = $req->execute(array($ucmID,$idUC,$idCrit,$rate));
        }
    }
    if(!$ret){
        throw new Exception("All inputed rate not inserted");
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
    $req = $db->query('SELECT use_case.id, use_case.name, use_case.description, id_meas, measure.name
                        FROM use_case
                        INNER JOIN measure
                        WHERE use_case.id_meas = measure.id
                        ORDER BY measure.name,use_case.name');
    $list = [];
    while ($row = $req->fetch()){
        array_push($list,$row);
    }
    return $list;
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
    $req2 = $db->prepare("SELECT id_uc,use_case.id_meas
                            FROM proj_sel_usecase
                            INNER JOIN use_case
                            WHERE (id_proj = ?) AND (use_case.id = id_uc)");
    $req2->execute(array($projID));
    while ($row = $req2->fetch()){
        $id_uc = intval($row['id_uc']);
        $id_meas = intval($row['id_meas']);
        array_push($list[$id_meas],$id_uc);
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
    $db = dbConnect();
    $req = $db->prepare("DELETE proj_sel_measure.*,proj_sel_usecase.*
                            FROM proj_sel_measure
                            INNER JOIN proj_sel_usecase
                                WHERE (proj_sel_measure.id_proj = proj_sel_usecase.id_proj)
                                    AND (proj_sel_measure.id_proj=?)");
    return $req->execute(array($projID));
    
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

function getListSelZones(){
    $db = dbConnect();
    $req = $db->prepare("SELECT zone.id, zone.name, zone.type, zone.id_zone
                            FROM project_perimeter
                            INNER JOIN zone
                                WHERE zone.id = project_perimeter.id_zone
                            ORDER BY zone.name");
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