<?php

require_once('model/model.php');

// -- Financing
function financing($twig,$is_connected){
    $user = getUser($_SESSION['username']);
    echo $twig->render('/input/financing_in.twig',array('is_connected'=>$is_connected,'is_admin'=>$user[3]));
}
