<?php
	// PHP code in a more secure location
  require_once '../../../php/landfill.php';

  $connekt = new mysqli($db_hostname, $db_username, $db_password, $db_database);

  if ($connekt->connect_error) die($connekt->connect_error);

	// Assigns form field content to columns in database
	$caseNum = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['caseNum']));
	$action = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['action']));
	$observation = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['observation']));
	$pix = $_POST['pix'];
	$username = $_SESSION['username'];

	// Instructions for inserting form content into database
  $pushObserve = "
  INSERT INTO observations (
  	caseNum,
	action,
	observation,
	pix,
	username
	)
  VALUES (
  	'$caseNum',
	'$action',
	'$observation',
	'$pix',
	'$username'
	);";

	// Uses the above instructions for inserting
	// mysqli_query($pushObserve);
    $retval = $connekt->query($pushObserve);
	
	// Feedback of whether INSERT worked or not

  if(!$retval){
	  die('Crap. Could not record your observation: ' . mysqli_error());
  }
	
	echo "<h2>Your observation has been recorded.</h2>";
	echo "<p>Either <a href=\"http://www.roxorsoxor.com/stakeout4/observations4.php\">review observations</a> or <a href=\"http://www.roxorsoxor.com/stakeout4/insert_observe4.php\">Record another observation</p>";
	
	// When attempt is complete, connection closes
  mysqli_close($connekt);

?>