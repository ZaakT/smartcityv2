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

function getListCapexAdvice($ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT *
                            FROM capex_item_advice
                            INNER JOIN capex_uc
                                INNER JOIN capex_item
                                    WHERE capex_uc.id_uc = ?
                                        and capex_item.id = capex_uc.id_item
                                        and capex_item.id = capex_item_advice.id
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

function getListCapexUser($projID,$ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT capex_item.id,name,description
                            FROM capex_item_user
                            INNER JOIN capex_uc
                                INNER JOIN capex_item
                                    WHERE capex_uc.id_uc = ?
                                        and capex_item.id = capex_uc.id_item
                                        and capex_item_user.id_proj = ?
                                        and capex_item_user.id = capex_item.id
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

function getListSelCapex($projID,$ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT id_item,unit_cost,volume,period
                            FROM input_capex
                            INNER JOIN capex_item
                                WHERE  id_uc = ? and id_proj = ? and id_item = capex_item.id
                            ORDER BY capex_item.name
                            ");
    $req->execute(array($ucID,$projID));

    $list = [];
    while($row = $req->fetch()){
        $id_item = intval($row['id_item']);
        $unit_cost = floatval($row['unit_cost']);
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

function insertCapexUser($projID,$ucID,$capex_data){
    $db = dbConnect();
    $ret = false;
    $db->exec('DROP PROCEDURE IF EXISTS `add_capex`;');
    $db->exec(' CREATE PROCEDURE `add_capex`(
                            IN capex_name VARCHAR(255),
                            IN capex_desc VARCHAR(255),
                            IN idUC INT,
                            IN idProj INT
                            )
                            BEGIN
                                DECLARE itemID INT;
                                INSERT INTO capex_item (name,description)
                                    VALUES (capex_name,capex_desc);
                                SET itemID = LAST_INSERT_ID();
                                INSERT INTO capex_uc (id_item,id_uc)
                                    VALUES (itemID,idUC);
                                INSERT INTO capex_item_user (id,id_proj)
                                    VALUES (itemID,idProj);
                            END
                                ');
    $req = $db->prepare('CALL add_capex(?,?,?,?);');
    $ret = $req->execute(array($capex_data['name'],$capex_data['description'],$ucID,$projID));
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
        $val = $res ? intval($res['val']) : -1;
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
        $ret = $req->execute(array($data['volume'],$data['unit_cost'],$data['period'],$projID,$ucID,$id_item));
    }
    return $ret;
}

function getNbTotalCompo($compoID){
    $db = dbConnect();
    $req = $db->prepare("SELECT SUM(number) FROM comp_per_zone WHERE id_compo = ?");
    $req->execute(array($compoID));
    $res = intval($req->fetch()[0]);
    return number_format($res, 0, ',', ' ');
}

function getNbTotalUC($projID,$ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT SUM(nb_compo DIV nb_per_uc)
                            FROM volumes_input
                            WHERE id_proj = ?
                                and id_uc = ?");
    $req->execute(array($projID,$ucID));
    $res = intval($req->fetch()[0]);
    return number_format($res, 0, ',', ' ');
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

function getListImplemAdvice($ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT *
                            FROM implem_item_advice
                            INNER JOIN implem_uc
                                INNER JOIN implem_item
                                    WHERE implem_uc.id_uc = ?
                                        and implem_item.id = implem_uc.id_item
                                        and implem_item.id = implem_item_advice.id
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

function getListImplemUser($projID,$ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT implem_item.id,name,description
                            FROM implem_item_user
                            INNER JOIN implem_uc
                                INNER JOIN implem_item
                                    WHERE implem_uc.id_uc = ?
                                        and implem_item.id = implem_uc.id_item
                                        and implem_item_user.id_proj = ?
                                        and implem_item_user.id = implem_item.id
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
                                WHERE  id_uc = ? and id_proj = ? and id_item = implem_item.id
                            ORDER BY implem_item.name
                            ");
    $req->execute(array($ucID,$projID));

    $list = [];
    while($row = $req->fetch()){
        $id_item = intval($row['id_item']);
        $unit_cost = floatval($row['unit_cost']);
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

function insertImplemUser($projID,$ucID,$implem_data){
    $db = dbConnect();
    $ret = false;
    $db->exec('DROP PROCEDURE IF EXISTS `add_implem`;');
    $db->exec(' CREATE PROCEDURE `add_implem`(
                            IN implem_name VARCHAR(255),
                            IN implem_desc VARCHAR(255),
                            IN idUC INT,
                            IN idProj INT
                            )
                            BEGIN
                                DECLARE itemID INT;
                                INSERT INTO implem_item (name,description)
                                    VALUES (implem_name,implem_desc);
                                SET itemID = LAST_INSERT_ID();
                                INSERT INTO implem_uc (id_item,id_uc)
                                    VALUES (itemID,idUC);
                                INSERT INTO implem_item_user (id,id_proj)
                                    VALUES (itemID,idProj);
                            END
                                ');
    $req = $db->prepare('CALL add_implem(?,?,?,?);');
    $ret = $req->execute(array($implem_data['name'],$implem_data['description'],$ucID,$projID));
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
        $val = $res ? intval($res['val']) : -1;
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
        $ret = $req->execute(array($data['volume'],$data['unit_cost'],$projID,$ucID,$id_item));
    }
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

function getListOpexAdvice($ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT *
                            FROM opex_item_advice
                            INNER JOIN opex_uc
                                INNER JOIN opex_item
                                    WHERE opex_uc.id_uc = ?
                                        and opex_item.id = opex_uc.id_item
                                        and opex_item.id = opex_item_advice.id
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

function getListOpexUser($projID,$ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT opex_item.id,name,description
                            FROM opex_item_user
                            INNER JOIN opex_uc
                                INNER JOIN opex_item
                                    WHERE opex_uc.id_uc = ?
                                        and opex_item.id = opex_uc.id_item
                                        and opex_item_user.id_proj = ?
                                        and opex_item_user.id = opex_item.id
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
                                WHERE  id_uc = ? and id_proj = ? and id_item = opex_item.id
                            ORDER BY opex_item.name
                            ");
    $req->execute(array($ucID,$projID));

    $list = [];
    while($row = $req->fetch()){
        $id_item = intval($row['id_item']);
        $unit_cost = floatval($row['unit_cost']);
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

function insertOpexUser($projID,$ucID,$opex_data){
    $db = dbConnect();
    $ret = false;
    $db->exec('DROP PROCEDURE IF EXISTS `add_opex`;');
    $db->exec(' CREATE PROCEDURE `add_opex`(
                            IN opex_name VARCHAR(255),
                            IN opex_desc VARCHAR(255),
                            IN idUC INT,
                            IN idProj INT
                            )
                            BEGIN
                                DECLARE itemID INT;
                                INSERT INTO opex_item (name,description)
                                    VALUES (opex_name,opex_desc);
                                SET itemID = LAST_INSERT_ID();
                                INSERT INTO opex_uc (id_item,id_uc)
                                    VALUES (itemID,idUC);
                                INSERT INTO opex_item_user (id,id_proj)
                                    VALUES (itemID,idProj);
                            END
                                ');
    $req = $db->prepare('CALL add_opex(?,?,?,?);');
    $ret = $req->execute(array($opex_data['name'],$opex_data['description'],$ucID,$projID));
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
        $val = $res ? intval($res['val']) : -1;
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
        $ret = $req->execute(array($data['volume'],$data['unit_cost'],$data['anVarVol'],$data['anVarCost'],$projID,$ucID,$id_item));
    }
    return $ret;
}


// ---------------------------------------- REVENUES----------------------------------------

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
    //var_dump($list);
    return $list;

}

function getListSelRevenues($projID,$ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT id_item,revenues_per_unit,volume,annual_variation_volume,annual_variation_unitcost
                            FROM input_revenues
                            INNER JOIN revenues_item
                                WHERE  id_uc = ? and id_proj = ? and id_item = revenues_item.id
                            ORDER BY revenues_item.name
                            ");
    $req->execute(array($ucID,$projID));

    $list = [];
    while($row = $req->fetch()){
        $id_item = intval($row['id_item']);
        $unit_rev = floatval($row['revenues_per_unit']);
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
        $val = $res ? intval($res['val']) : -1;
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
        $ret = $req->execute(array($data['volume'],$data['unit_rev'],$data['anVarVol'],$data['anVarRev'],$projID,$ucID,$id_item));
    }
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
        $unit_cost = floatval($row['unit_cost']);
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
                                WHERE  id_uc = ? and id_proj = ? and id_item = cashreleasing_item.id
                            ORDER BY cashreleasing_item.name
                            ");
    $req->execute(array($ucID,$projID));

    $list = [];
    while($row = $req->fetch()){
        $id_item = intval($row['id_item']);
        $unit_cost = floatval($row['unit_cost']);
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
        $val = $res ? intval($res['val']) : -1;
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
        $ret = $req->execute(array($data['unit_indic'],$data['volume'],$data['unit_cost'],$data['vol_red'],$data['unit_cost_red'],$data['anVarVol'],$data['anVarCost'],$projID,$ucID,$id_item));

    }
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
        $unit_cost = floatval($row['unit_cost']);
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
                                WHERE  id_uc = ? and id_proj = ? and id_item = widercash_item.id
                            ORDER BY widercash_item.name
                            ");
    $req->execute(array($ucID,$projID));

    $list = [];
    while($row = $req->fetch()){
        $id_item = intval($row['id_item']);
        $unit_cost = floatval($row['unit_cost']);
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
        $val = $res ? intval($res['val']) : -1;
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
        $ret = $req->execute(array($data['unit_indic'],$data['volume'],$data['unit_cost'],$data['vol_red'],$data['unit_cost_red'],$data['anVarVol'],$data['anVarCost'],$projID,$ucID,$id_item));

    }
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
                                WHERE  id_uc = ? and id_proj = ? and id_item = noncash_item.id
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

function getListRiskAdvice($ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT *
                            FROM risk_item_advice
                            INNER JOIN risk_uc
                                INNER JOIN risk_item
                                    WHERE risk_uc.id_uc = ?
                                        and risk_item.id = risk_uc.id_item
                                        and risk_item.id = risk_item_advice.id
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

function getListSelRisk($projID,$ucID){
    $db = dbConnect();
    $req = $db->prepare("SELECT id_item,expected_impact,probability
                            FROM input_risk
                            INNER JOIN risk_item
                                WHERE  id_uc = ? and id_proj = ? and id_item = risk_item.id
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
