<?php

require __DIR__ . '/vendor/autoload.php';
require('controller/controller.php');

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/view');
$twig = new Environment($loader);

$is_connected = true; //à déduire si login dans $_COOKIE
$id_user = 1;

//stocker un token (clé aléatoire générée à la connexion) dans la table token et l'username en cookie

try{
    if(isset($_GET['action'])){
        if($is_connected){
            if($_GET['action']=='home'){
                home($twig,$id_user);
            } elseif($_GET['action']=='disconnect'){
                disconnect($twig,$id_user);
            } elseif($_GET['action']=='admin'){
                admin($twig,$id_user);
            } elseif($_GET['action']=='profile'){
                profile($twig,$id_user);    
            } elseif($_GET['action']=='project_dev'){
                project_dev($twig,$id_user);    
            } elseif($_GET['action']=='project_design'){
                project_design($twig,$id_user);    
            } elseif($_GET['action']=='project_scoping'){
                project_scoping($twig,$id_user);      
            } elseif($_GET['action']=='cost_benefits'){
                cost_benefits($twig,$id_user);        
            } elseif($_GET['action']=='financing'){
                financing($twig,$id_user);         
            } elseif($_GET['action']=='business_model'){
                business_model($twig,$id_user);           
            } elseif($_GET['action']=='funding'){
                funding($twig,$id_user);                
            } elseif($_GET['action']=='dashboards'){
                dashboards($twig,$id_user);              
            } elseif($_GET['action']=='scenarios'){
                scenarios($twig,$id_user);        
            } else {
                header('Location: ?action=home');
            }
            
           /*  if(isset($_GET['action2'])){
                if($_GET['action2']=="ucm"){
                    ucm($twig);
                } else {
                    header('Location: ?action='.$_GET['action']);
                }
            }  else {
                //header('Location: ?action='.$_GET['action']);
            } */

        } else {
            if($_GET['action']=='login'){
                login($twig);
            } else {
                header('Location: ?action=login');
            }
        }
    } else {
        if($is_connected){
            header('Location: ?action=home');
        } else{
            header('Location: ?action=login');
        }
    }

} catch(Exception $e) {
    $errorMessage = $e->getMessage();
    echo $twig->render('/others/error.twig',array('error'=>$errorMessage)); 
}