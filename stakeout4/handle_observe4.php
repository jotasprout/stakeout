<?php
	// PHP code in a more secure location
  require_once '../../../php/landfill.php';

  $connekt = new mysqli($db_hostname, $db_username, $db_password, $db_database);

  if ($connekt->connect_error) die($connekt->connect_error);

	// Assigns form field content to columns in database
	$caseNum = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['assignedCase']));
	$action = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['action']));
	$observation = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['observation']));
	$pix = $_POST['pix'];
	$username = $_POST['username'];
	$lat  = $_POST['txtlat'];
	$lng = $_POST['txtlng'];	

	// Instructions for inserting form content into database
  $pushObserve = "
  INSERT INTO observations4 (
  	caseNum,
	action,
	observation,
	lat,
	lng,
	pix,
	username
	)
  VALUES (
  	'$caseNum',
	'$action',
	'$observation',
	'$lat',
	'$lng',
	'$pix',
	'$username'
	);";

	// Uses the above instructions for inserting
    $retval = $connekt->query($pushObserve);
	
	// Feedback of whether INSERT worked or not.
 	if(!$retval){
		die('Crap. Could not record your observation: ' . mysqli_error());
	}

	header("location:observations4.php");

	// When attempt is complete, connection closes
	mysqli_close($connekt);

?>