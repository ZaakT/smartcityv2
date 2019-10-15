<?php

require __DIR__ . '/vendor/autoload.php';

foreach (glob("controller/*") as $dir){
    foreach (glob("$dir/*.php") as $filename){
        require($filename);
        //var_dump($filename);
    }
    foreach (glob("$dir/*") as $dir2){
        foreach (glob("$dir2/*.php") as $filename){
            require($filename);
            //var_dump($filename);
        }
    }
}
foreach (glob("controller/*.php") as $filename){
    require($filename);
    //var_dump($filename);
}

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/view');
$twig = new Environment($loader);

$is_connected = isConnected();

//stocker un token (clé aléatoire générée à la connexion) dans la table token et l'username en cookie
try{
    if(isset($_GET['A'])){
        if($is_connected){
            if($_GET['A']=='home'){
                home($twig,$is_connected);
            }
            elseif($_GET['A']=='logout'){
                logout($twig);
            }
            elseif($_GET['A']=='admin'){
                if(isset($_GET['A2'])){
                    if($_GET['A2']=='manage_db'){
                        manage_db($twig,$is_connected); 
                    } elseif($_GET['A2']=='manage_users'){
                        manage_users($twig,$is_connected); 
                    } elseif($_GET['A2']=='create_user'){
                        create_user($twig,$is_connected,$_POST);
                    } else {
                        header('Location: ?A=admin');
                    }
                } else {
                    admin($twig,$is_connected);
                }
            }
            elseif($_GET['A']=='profile'){
                profile($twig,$is_connected);    
            }
            elseif($_GET['A']=='project_dev'){
                project_dev($twig,$is_connected);    
            }
            elseif($_GET['A']=='project_design'){
                if(isset($_GET['A2'])){
                    if($_GET['A2']=="ucm"){
                        ucm($twig,$is_connected);
                    }
                    elseif($_GET['A2']=="criteria"){
                        criteria($twig,$is_connected);
                    }
                    elseif($_GET['A2']=="geography"){
                        geography($twig,$is_connected);
                    }
                    elseif($_GET['A2']=="use_case"){
                        use_case($twig,$is_connected);
                    }
                    elseif($_GET['A2']=="rating"){
                        rating($twig,$is_connected);
                    }
                    elseif($_GET['A2']=="scoring"){
                        scoring($twig,$is_connected);
                    }
                    elseif($_GET['A2']=="global_score"){
                        global_score($twig,$is_connected);
                    }
                    else {
                        header('Location: ?A='.$_GET['A']);
                    }
                } else {
                    project_design($twig,$is_connected);
                } 
            } elseif($_GET['A']=='project_scoping'){
                if(isset($_GET['A2'])){
                    if($_GET['A2']=="project"){
                        project($twig,$is_connected);
                    } elseif($_GET['A2']=="scope"){
                        scope($twig,$is_connected);
                    } elseif($_GET['A2']=="perimeter"){
                        perimeter($twig,$is_connected);
                    } elseif($_GET['A2']=="size"){
                        size($twig,$is_connected);
                    } elseif($_GET['A2']=="volumes"){
                        volumes($twig,$is_connected);
                    } elseif($_GET['A2']=="schedule"){
                        schedule($twig,$is_connected);
                    } elseif($_GET['A2']=="discount_rate"){
                        discount_rate($twig,$is_connected);
                    } else {
                        header('Location: ?A='.$_GET['A']);
                    }
                } else {
                    project_scoping($twig,$is_connected);
                }        
            } elseif($_GET['A']=='cost_benefits'){
                if(isset($_GET['A2'])){
                    if($_GET['A2']=="use_case_cb"){
                        use_case_cb($twig,$is_connected);
                    } elseif($_GET['A2']=="project"){
                        project_cb($twig,$is_connected);
                    } elseif($_GET['A2']=="capex"){
                        capex($twig,$is_connected);
                    } elseif($_GET['A2']=="implem"){
                        implem($twig,$is_connected);
                    } elseif($_GET['A2']=="opex"){
                        opex($twig,$is_connected);
                    } elseif($_GET['A2']=="revenues"){
                        revenues($twig,$is_connected);
                    } elseif($_GET['A2']=="cashreleasing"){
                        cashreleasing($twig,$is_connected);
                    } elseif($_GET['A2']=="widercash"){
                        widercash($twig,$is_connected);
                    } elseif($_GET['A2']=="noncash"){
                        noncash($twig,$is_connected);
                    } elseif($_GET['A2']=="risks"){
                        risks($twig,$is_connected);
                    } else {
                        header('Location: ?A='.$_GET['A']);
                    }
                } else {  
                    cost_benefits($twig,$is_connected);
                }        
            } elseif($_GET['A']=='financing'){     
                financing($twig,$is_connected);      
            } elseif($_GET['A']=='business_model'){
                business_model($twig,$is_connected);           
            } elseif($_GET['A']=='funding'){
                if(isset($_GET['A2'])){
                    if($_GET['A2']=="scenario"){
                        scenario($twig,$is_connected);
                    } elseif($_GET['A2']=="input"){
                        input($twig,$is_connected);
                    } elseif($_GET['A2']=="output"){
                        output($twig,$is_connected);
                    } elseif($_GET['A2']=="benef"){
                        benef($twig,$is_connected);
                    } elseif($_GET['A2']=="scen_comp"){
                        scen_comp($twig,$is_connected);
                    } else {
                        header('Location: ?A='.$_GET['A']);
                    }
                } else {  
                    funding($twig,$is_connected); 
                }            
            } elseif($_GET['A']=='dashboards'){
                 if(isset($_GET['A2'])){
                    if($_GET['A2']=="cost_benefits_out"){
                        cost_benefits_out($twig,$is_connected);
                    } elseif($_GET['A2']=="budget"){
                        budget($twig,$is_connected);
                    } elseif($_GET['A2']=="financing"){
                        financing_out($twig,$is_connected);
                    } elseif($_GET['A2']=="bankability"){
                        bankability($twig,$is_connected);
                    } else {
                        header('Location: ?A='.$_GET['A']);
                    }
                } else { 
                    dashboards($twig,$is_connected);
                }              
            } elseif($_GET['A']=='scenarios'){
                scenarios($twig,$is_connected);        
            } else {
                header('Location: ?A=home');
            }                  

        } else {
            if($_GET['A']=='login'){
                if(isset($_GET['A2'])){
                    if($_GET['A2']=='form'){
                        connexion($twig,$_POST);
                    } else {
                        header('Location: ?A=login');
                    }
                } else {
                    login($twig);
                }
            } else {
                header('Location: ?A=login');
            }
        }
    } else {
        if($is_connected){
            header('Location: ?A=home');
        } else {
            header('Location: ?A=login');
        }
    }

} catch(Exception $e) {
    $errorMessage = $e->getMessage();
    echo $twig->render('/others/error.twig',array('error'=>$errorMessage)); 
}