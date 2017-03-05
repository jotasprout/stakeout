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
	$firstName = mysql_real_escape_string(htmlspecialchars($_POST['firstName']));
	$lastName = mysql_real_escape_string(htmlspecialchars($_POST['lastName']));
	$username = mysql_real_escape_string(htmlspecialchars($_POST['gatorname']));
	$password = mysql_real_escape_string(htmlspecialchars($_POST['gatoreagle']));

// Instructions for inserting form content into database
  $pushGator = "
  INSERT INTO user_creds (
  	firstName,
	lastName,
	gatorname,
	gatoreagle
	)
  VALUES (
  	'$firstName',
	'$lastName',
	'$username',
	'$password'
	);";

// Uses the above instructions for inserting
// What is this? It was commented out.
// Also check pushObserve to make sure it isn't commented out where it shouldn't be
mysql_query($pushGator);
  
// Feedback of whether INSERT worked or not
  $retval = mysql_query($pushGator, $connekt);
  
  if(!$retval){
	  die('Nuts. Could not add an investigator: ' . mysql_error());
  }
	
	echo "<h2>You've added an investigator and their name should appear here with maybe a log in link.</h2>";
	echo "<p>Assign this investigator or <a href=\"http://www.roxorsoxor.com/stakeout/insert_gator.htm\">add another investigator</a>.</p>";
	
// When attempt is complete, connection closes
  mysql_close($connekt);

?>