<?php

session_start();
require_once 'class.gatorGoogle.php';
$user = new USER();

if(!$user->areTheyLoggedIn()) {
	$user->redirect('http://www.roxorsoxor.com/stakeout/login_form.php');
}

if($user->areTheyLoggedIn()!="") {
	$user->logout();	
	$user->redirect('http://www.roxorsoxor.com/stakeout/login_form.php');
}

?>