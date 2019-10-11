<?php

require_once('model/model.php');

// -- Financing
function financing($twig,$id_user){
    $user = getUser($id_user);
    echo $twig->render('/input/financing_in.twig',array('is_connected'=>true,'is_admin'=>$user[1]));
}
