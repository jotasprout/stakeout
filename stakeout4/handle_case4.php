<?php

	// PHP code in a more secure location
  require_once '../../../php/landfill.php';

  $connekt = new mysqli($db_hostname, $db_username, $db_password, $db_database);

  if ($connekt->connect_error) die($connekt->connect_error);

// Assigns form field content to columns in database
	$caseNum = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['caseNum']));
	$caseName = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['caseName']));
	$startDate = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['startDate']));

// Instructions for inserting form content into database
  $pushCase = "
  INSERT INTO cases4 (
  	caseNum,
	caseName,
	startDate
	)
  VALUES (
  	'$caseNum',
	'$caseName',
	'$startDate'
	);";

// Uses the above instructions for inserting
//  mysqli_query($pushObserve);
  $retval = $connekt->query($pushCase);
  
// Feedback of whether INSERT worked or not
  
  if(!$retval){
	  die('Crap. Could not open your case: ' . mysql_error());
  }
	
	header("location:cases4.php");
	
// When attempt is complete, connection closes
  mysqli_close($connekt);

?>