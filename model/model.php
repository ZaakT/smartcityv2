<?php
// --------------------------------- CONNECT TO DATABASE ----------------------------------

function dbConnect()
{
    try{
    $db = new PDO('mysql:host=smartcityv2;dbname=dst_v2_db_updated;charset=utf8', 'root','', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        return $db;
    } catch(Exception $e){ 
        throw new Exception("Access to the database impossible !");
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
    $req = $db->query('SELECT id,name,description FROM measure ORDER BY name');
    $list = [];
    while ($row = $req->fetch()){
        $id = intval($row['id']);
        $name = $row['name'];
        $description = $row['description'];
        $list[$id] = ['name'=>$name,'description'=>$description];
    }
    return $list;
}

function getListSelMeas($ucmID){
    $db = dbConnect();
    $req = $db->prepare('SELECT id_meas
                        FROM ucm_sel_measure
                        WHERE ucm_sel_measure.id_ucm = ?');
    $req->execute(array($ucmID));
    $list = [];
    while ($row = $req->fetch()){
        array_push($list,$row['id_meas']);
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

function getUCByID($ucID){
    $db = dbConnect();
    $req = $db->prepare('SELECT * FROM use_case WHERE id = ?');
    $req->execute(array($ucID));
    return $req->fetch();
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
        $id_uc = $row[0];
        $name = $row[1];
        $description = $row[2];
        $id_meas = $row[3];
        $name_meas = $row[4];
        $list[$id_uc] = ["name"=>$name,"description"=>$description,"id_meas"=>$id_meas,"name_meas"=>$name_meas];
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
        $val = number_format(round($row['number']),0,'.',' ');
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
    $req = $db->prepare("SELECT id_zone,id_uc,nb_compo,nb_per_uc
                            FROM volumes_input
                            WHERE id_proj = ?");
    $req->execute(array($projID));
    $list = [];
    while($row = $req->fetch()){
        $id_zone = intval($row['id_zone']);
        $id_uc = intval($row['id_uc']);
        $nb_compo = intval($row['nb_compo']);
        $nb_per_uc = intval($row['nb_per_uc']);
        if(array_key_exists($id_zone,$list)){
            if(array_key_exists($id_uc,$list[$id_zone])){
                $list[$id_zone][$id_uc] += ['nb_compo'=>$nb_compo,'nb_per_uc'=>$nb_per_uc];
            } else {
                $list[$id_zone] += [$id_uc=>['nb_compo'=>$nb_compo,'nb_per_uc'=>$nb_per_uc]];
            }
        } else {
            $list[$id_zone] = [$id_uc=>['nb_compo'=>$nb_compo,'nb_per_uc'=>$nb_per_uc]];
        }
    }
    //var_dump($list);
    return $list;
}


function insertSelVolumes($projID,$list){
    $db = dbConnect();
    $ret = false;
    $req = $db->prepare("INSERT INTO volumes_input
                            (id_proj,id_zone,id_uc,nb_compo,nb_per_uc)
                            VALUES (?,?,?,?,?)");
    foreach ($list as $id_zone => $list_ucs) {
        foreach ($list_ucs as $id_uc => $data) {
            $ret = $req->execute(array($projID,$id_zone,$id_uc,$data['nb_compo'],$data['nb_per_uc']));
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
        $startdate = date_create($row['start_date'])->format('m/Y');
        $date25 = date_create($row['25_rampup'])->format('m/Y');
        $date50 = date_create($row['50_rampup'])->format('m/Y');
        $date75 = date_create($row['75_rampup'])->format('m/Y');
        $date100 = date_create($row['100_rampup'])->format('m/Y');
        $enddate = date_create($row['end_date'])->format('m/Y');
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
