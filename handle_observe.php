<?php
// PHP code in a more secure location
  include("../../php/landfill.php");

// Connection test and feedback
  if (!$connekt)
  {
    die('Rats! Could not connect: ' . mysql_error());
  }

//Uses PHP code to connect to database
  mysql_select_db("jscript_stakeout", $connekt);

// Assigns form field content to columns in database
	$caseNum = mysql_real_escape_string(htmlspecialchars($_POST['caseNum']));
	$action = mysql_real_escape_string(htmlspecialchars($_POST['action']));
	$observation = mysql_real_escape_string(htmlspecialchars($_POST['observation']));

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
//  mysql_query($pushObserve);
  
// Feedback of whether INSERT worked or not
  $retval = mysql_query($pushObserve, $connekt);
  
  if(!$retval){
	  die('Crap. Could not record your observation: ' . mysql_error());
  }
	
	echo "<h2>Your observation has been recorded.</h2>";
	echo "<p><a href=\"http://www.jotascript.com/rxrsxr/insertObserveBS.htm\">Record another observation</p>";
	
// When attempt is complete, connection closes
  mysql_close($connekt);

?>