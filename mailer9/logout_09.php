<?php

require_once 'class.gator.php';
areTheyLoggedIn();

$user = new USER();
$user->logout();

?>