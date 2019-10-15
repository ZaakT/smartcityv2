<?php

function dbConnect()
{
    try{
    $db = new PDO('mysql:host=smartcityv2;dbname=dst_v2_db;charset=utf8', 'root', ''/*, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)*/);
        return $db;
    } catch(Exception $e){ 
        throw new Exception("access to the database impossible !");
    }
}

// Users
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
    $list_users = [];
    while ($row = $req->fetch()){
        array_push($list_users,$row);
    }
    return $list_users;
}

function userAlreadyExists($username){
    $db = dbConnect();
    $req = $db->prepare('SELECT * FROM user WHERE username=?');
    return $req->execute(array($username));
}

function insertUser($user){
    $db = dbConnect();
    $req = $db->prepare('INSERT INTO user (username,salt,password,is_admin,id_1,creation_date) VALUES (?,?,?,?,?,NOW())');
    return $req->execute(array($user[0],$user[1],$user[2],$user[3],$user[4]));
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

//UCM
function getUCM($idUser,$name){
    $db = dbConnect();
    $req = $db->prepare('SELECT id, name, description FROM uc_scenario WHERE id_1 = ? and name = ?');
    $req->execute(array($idUser,$name));
    $res =  $req->fetch();
    return $res;
}

function getListUCMS($idUser){
    $db = dbConnect();
    $req = $db->prepare('SELECT id, name, description FROM uc_scenario WHERE id_1 = ? ORDER BY id');
    $req->execute(array($idUser));
    $list_ucms = [];
    while ($row = $req->fetch()){
        array_push($list_ucms,$row);
    }
    return $list_ucms;
}

function insertUCM($ucm){
    $db = dbConnect();
    $req = $db->prepare('INSERT INTO uc_scenario (name,description,id_1) VALUES (?,?,?)');
    return $req->execute(array($ucm[0],$ucm[1],$ucm[2]));
}