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
    $req = $db->prepare('SELECT id, username, is_admin, password FROM user WHERE username = ?');
    $req->execute(array($username));
    $res =  $req->fetch();
    if(!empty($res)){
        $userName = $res['username'];
        $userID = intval($res['id']);
        $isAdmin = $res['is_admin']==1 ? true : false;
        $userPassword = $res['password'];
    }
    return [$userID,$userName,$userPassword,$isAdmin];
}

function getListUsers(){
    $db = dbConnect();
    $req = $db->query('SELECT id, username, is_admin FROM user');
    $list_users = [];
    //var_dump($list_users);
    while ($row = $req->fetch()){
        array_push($list_users,$row);
        //var_dump($list_users);
    }
    return $list_users;
}