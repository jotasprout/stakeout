<?php

session_start();
require_once 'class.gator.php';
$user = new USER();

if(!$user->areTheyLoggedIn()) {
	$user->redirect('login_form_09.php');
}

if($user->areTheyLoggedIn()!="") {
	$user->logout();	
	$user->redirect('login_form_09.php');
}

?>