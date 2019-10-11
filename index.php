<?php

require __DIR__ . '/vendor/autoload.php';

foreach (glob("controller/*") as $dir){
    foreach (glob("$dir/*.php") as $filename){
        require($filename);
    }
}

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/view');
$twig = new Environment($loader);

$is_connected = true; //à déduire si login dans $_COOKIE
$id_user = 2;

//stocker un token (clé aléatoire générée à la connexion) dans la table token et l'username en cookie
try{
    if(isset($_GET['action'])){
        if($is_connected){
            if($_GET['action']=='home'){
                home($twig,$id_user);
            }
            elseif($_GET['action']=='logout'){
                logout($twig,$id_user);
            }
            elseif($_GET['action']=='admin'){
                admin($twig,$id_user);
            }
            elseif($_GET['action']=='profile'){
                profile($twig,$id_user);    
            }
            elseif($_GET['action']=='project_dev'){
                project_dev($twig,$id_user);    
            }
            elseif($_GET['action']=='project_design'){
                if(isset($_GET['action2'])){
                    if($_GET['action2']=="ucm"){
                        ucm($twig,$id_user);
                    }
                    elseif($_GET['action2']=="criteria"){
                        criteria($twig,$id_user);
                    }
                    elseif($_GET['action2']=="geography"){
                        geography($twig,$id_user);
                    }
                    elseif($_GET['action2']=="use_case"){
                        use_case($twig,$id_user);
                    }
                    elseif($_GET['action2']=="rating"){
                        rating($twig,$id_user);
                    }
                    elseif($_GET['action2']=="scoring"){
                        scoring($twig,$id_user);
                    }
                    elseif($_GET['action2']=="global_score"){
                        global_score($twig,$id_user);
                    }
                    else {
                        header('Location: ?action='.$_GET['action']);
                    }
                } else {
                    project_design($twig,$id_user);
                } 
            } elseif($_GET['action']=='project_scoping'){
                if(isset($_GET['action2'])){
                    if($_GET['action2']=="project"){
                        project($twig,$id_user);
                    } elseif($_GET['action2']=="scope"){
                        scope($twig,$id_user);
                    } elseif($_GET['action2']=="perimeter"){
                        perimeter($twig,$id_user);
                    } elseif($_GET['action2']=="size"){
                        size($twig,$id_user);
                    } elseif($_GET['action2']=="volumes"){
                        volumes($twig,$id_user);
                    } elseif($_GET['action2']=="schedule"){
                        schedule($twig,$id_user);
                    } elseif($_GET['action2']=="discount_rate"){
                        discount_rate($twig,$id_user);
                    } else {
                        header('Location: ?action='.$_GET['action']);
                    }
                } else {
                    project_scoping($twig,$id_user);
                }        
            } elseif($_GET['action']=='cost_benefits'){
                if(isset($_GET['action2'])){
                    if($_GET['action2']=="use_case_cb"){
                        use_case_cb($twig,$id_user);
                    } elseif($_GET['action2']=="project"){
                        project_cb($twig,$id_user);
                    } elseif($_GET['action2']=="capex"){
                        capex($twig,$id_user);
                    } elseif($_GET['action2']=="implem"){
                        implem($twig,$id_user);
                    } elseif($_GET['action2']=="opex"){
                        opex($twig,$id_user);
                    } elseif($_GET['action2']=="revenues"){
                        revenues($twig,$id_user);
                    } elseif($_GET['action2']=="cashreleasing"){
                        cashreleasing($twig,$id_user);
                    } elseif($_GET['action2']=="widercash"){
                        widercash($twig,$id_user);
                    } elseif($_GET['action2']=="noncash"){
                        noncash($twig,$id_user);
                    } elseif($_GET['action2']=="risks"){
                        risks($twig,$id_user);
                    } else {
                        header('Location: ?action='.$_GET['action']);
                    }
                } else {  
                    cost_benefits($twig,$id_user);
                }        
            } elseif($_GET['action']=='financing'){     
                financing($twig,$id_user);      
            } elseif($_GET['action']=='business_model'){
                business_model($twig,$id_user);           
            } elseif($_GET['action']=='funding'){
                if(isset($_GET['action2'])){
                    if($_GET['action2']=="scenario"){
                        scenario($twig,$id_user);
                    } elseif($_GET['action2']=="input"){
                        input($twig,$id_user);
                    } elseif($_GET['action2']=="output"){
                        output($twig,$id_user);
                    } elseif($_GET['action2']=="benef"){
                        benef($twig,$id_user);
                    } elseif($_GET['action2']=="scen_comp"){
                        scen_comp($twig,$id_user);
                    } else {
                        header('Location: ?action='.$_GET['action']);
                    }
                } else {  
                    funding($twig,$id_user); 
                }            
            } elseif($_GET['action']=='dashboards'){
                 if(isset($_GET['action2'])){
                    if($_GET['action2']=="cost_benefits_out"){
                        cost_benefits_out($twig,$id_user);
                    } elseif($_GET['action2']=="budget"){
                        budget($twig,$id_user);
                    } elseif($_GET['action2']=="financing"){
                        financing_out($twig,$id_user);
                    } elseif($_GET['action2']=="bankability"){
                        bankability($twig,$id_user);
                    } else {
                        header('Location: ?action='.$_GET['action']);
                    }
                } else { 
                    dashboards($twig,$id_user);
                }              
            } elseif($_GET['action']=='scenarios'){
                scenarios($twig,$id_user);        
            } else {
                header('Location: ?action=home');
            }                  

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
        } else {
            header('Location: ?action=login');
        }
    }

} catch(Exception $e) {
    $errorMessage = $e->getMessage();
    echo $twig->render('/others/error.twig',array('error'=>$errorMessage)); 
}