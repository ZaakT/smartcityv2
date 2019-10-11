
<?php

require_once('model/model.php');

// -- Cost Benefits
function cost_benefits($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/input/cost_benefits_in.twig',array('is_connected'=>true,'is_admin'=>$user[1]));
}



// --- Cost Benefits Steps
function use_case_cb($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/input/cost_benefits_steps/use_case.twig',array('is_connected'=>true,'is_admin'=>$user[1]));
}

function project_cb($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/input/cost_benefits_steps/project.twig',array('is_connected'=>true,'is_admin'=>$user[1]));
}

function capex($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/input/cost_benefits_steps/capex.twig',array('is_connected'=>true,'is_admin'=>$user[1]));
}

function implem($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/input/cost_benefits_steps/implem.twig',array('is_connected'=>true,'is_admin'=>$user[1]));
}

function opex($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/input/cost_benefits_steps/opex.twig',array('is_connected'=>true,'is_admin'=>$user[1]));
}

function revenues($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/input/cost_benefits_steps/revenues.twig',array('is_connected'=>true,'is_admin'=>$user[1]));
}

function cashreleasing($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/input/cost_benefits_steps/cashreleasing.twig',array('is_connected'=>true,'is_admin'=>$user[1]));
}

function widercash($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/input/cost_benefits_steps/widercash.twig',array('is_connected'=>true,'is_admin'=>$user[1]));
}

function noncash($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/input/cost_benefits_steps/noncash.twig',array('is_connected'=>true,'is_admin'=>$user[1]));
}

function risks($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/input/cost_benefits_steps/risks.twig',array('is_connected'=>true,'is_admin'=>$user[1]));
}