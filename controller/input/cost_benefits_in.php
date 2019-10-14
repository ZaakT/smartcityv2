
<?php

require_once('model/model.php');

// -- Cost Benefits
function cost_benefits($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/cost_benefits_in.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}



// --- Cost Benefits Steps
function use_case_cb($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/cost_benefits_steps/use_case.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}

function project_cb($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/cost_benefits_steps/project.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}

function capex($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/cost_benefits_steps/capex.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}

function implem($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/cost_benefits_steps/implem.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}

function opex($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/cost_benefits_steps/opex.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}

function revenues($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/cost_benefits_steps/revenues.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}

function cashreleasing($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/cost_benefits_steps/cashreleasing.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}

function widercash($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/cost_benefits_steps/widercash.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}

function noncash($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/cost_benefits_steps/noncash.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}

function risks($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/cost_benefits_steps/risks.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}