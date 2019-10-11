<?php

require_once('model/model.php');

function logout($twig){
    echo $twig->render('/others/login.twig',array('is_connected'=>false)); 
}
