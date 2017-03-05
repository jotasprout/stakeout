<?php
// PHP code in a more secure location
  include("../../../php/landfill.php");

// Connection test and feedback
  if (!$connekt)
  {
    die('Rats! Could not connect: ' . mysql_error());
  }

//Uses PHP code to connect to database
  mysql_select_db("jscript_stakeout", $connekt);

// Assigns form field content to columns in database
	$caseNum = mysql_real_escape_string(htmlspecialchars($_POST['caseNum']));
	$caseName = mysql_real_escape_string(htmlspecialchars($_POST['caseName']));
	$startDate = mysql_real_escape_string(htmlspecialchars($_POST['startDate']));

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
//  mysql_query($pushObserve);
  
// Feedback of whether INSERT worked or not
  $retval = mysql_query($pushCase, $connekt);
  
  if(!$retval){
	  die('Crap. Could not open your case: ' . mysql_error());
  }
	
	echo "<h2>Case # INSERT NUMBER is now open.</h2>";
	echo "<p>Assign an investigator or <a href=\"http://www.roxorsoxor.com/stakeout/insertObserveBS.htm\">enter an observation</a>.</p>";
	
// When attempt is complete, connection closes
  mysql_close($connekt);

?>