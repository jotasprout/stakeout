<?php
// PHP code in a more secure location
  require_once '../../../php/landfill.php'; // connects to db

// Connection test and feedback
  if (!$connekt)
  {
    die('Rats! Could not connect: ' . mysqli_error());
  }

//Uses PHP code to connect to database
  mysqli_select_db("jscript_stakeout", $connekt);

// Assigns form field content to columns in database
	$caseNum = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['caseNum']));
	$action = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['action']));
	$observation = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['observation']));

// Instructions for inserting form content into database
  $pushObserve = "
  INSERT INTO observations (
  	caseNum,
	action,
	observation
	)
  VALUES (
  	'$caseNum',
	'$action',
	'$observation'
	);";

// Uses the above instructions for inserting
// mysqli_query($pushObserve);
  
// Feedback of whether INSERT worked or not
  $retval = mysqli_query($pushObserve, $connekt);
  
  if(!$retval){
	  die('Crap. Could not record your observation: ' . mysqli_error());
  }
	
	echo "<h2>Your observation has been recorded.</h2>";
	echo "<p><a href=\"http://www.jotascript.com/rxrsxr/insertObserveBS.htm\">Record another observation</p>";
	
// When attempt is complete, connection closes
  mysqli_close($connekt);

?>