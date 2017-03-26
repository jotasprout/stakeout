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
  INSERT INTO cases (
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
  
// Feedback of whether INSERT worked or not
  $retval = mysqli_query($pushCase, $connekt);
  
  if(!$retval){
	  die('Crap. Could not open your case: ' . mysql_error());
  }
	
	echo "<h2>Case # INSERT NUMBER is now open.</h2>";
	echo "<p>Assign an investigator or <a href=\"http://www.roxorsoxor.com/stakeout4/insert_observe4.php\">enter an observation</a>.</p>";
	
// When attempt is complete, connection closes
  mysqli_close($connekt);

?>