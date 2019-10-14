<?php

require_once('model/model.php');

function logout($twig){
    setcookie('username',$_SESSION['username']);
    session_unset();
    header('Location: ?A=login');
}
