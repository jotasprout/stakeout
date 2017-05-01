<?php	
session_start();	
if (!isset($_SESSION['username'])) {		
    header("location:login_form5.php");	
} 
// NEW STUFF
require_once 'class.gator5.php';
$user_home = new USER();
if(!$user_home->is_logged_in()) {	
    $user_home->redirect('login_form5.php');
}

$stmt = $user_home->runQuery("SELECT * FROM user_creds4 WHERE id=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>