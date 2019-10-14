<?php

require_once('model/model.php');

// --- Financing / Funding
function funding($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/funding.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}

// ---- Financing / Funding Steps
function scenario($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/funding_steps/scenario.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}

function input($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/funding_steps/input.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}

function output($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/funding_steps/output.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}

function benef($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/funding_steps/benef.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}

function scen_comp($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/funding_steps/scen_comp.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}