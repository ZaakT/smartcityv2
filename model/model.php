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

function getUser($idUser){
    $db = dbConnect();
    $user = $db->prepare('SELECT id, username, is_admin, password FROM user WHERE id = ?');
    $user->execute(array($idUser));
    $user =  $user->fetch();
    if(empty($user)){
        throw new Exception("no user received");
    }
    $userName = $user['username'];
    $userID = intval($user['id']);
    $isAdmin = $user['is_admin']==1 ? true : false;
    $userPassword = $user['password'];
    /*
    var_dump($userName);
    var_dump($userID);
    var_dump($isAdmin);*/
    if($userID!=$idUser){
        throw new Exception("userID incorrect");
    }
    return [$userName,$isAdmin,$userID,$userPassword];
}

function getUserCity($idUser){
    $db = dbConnect();
    $city = $db->prepare('SELECT city.name FROM user, city WHERE user.id = ? ');
    $city->execute(array($idUser));
    $city = $city->fetch();
    if(empty($city)){
        throw new Exception("no city received");
    }
    //var_dump($city);
    return $city['name'];
}