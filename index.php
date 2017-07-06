<?php

session_start();
require_once 'class.gator.php';
require_once 'stylesAndSuch.php';
require_once 'navbar.php';

$user = new USER();

if(!$user->areTheyLoggedIn()) {
	$user->redirect('https://www.roxorsoxor.com/stakeout/login_form.php');
}
else {
	$jefe = $_SESSION['jefe'];
	if ($jefe == 1) {
		echo "<script>console.log('You are an admin.')</script>";
	}	
	$username = $_SESSION['username'];
	$forename = $_SESSION['forename'];
	$email = $_SESSION['email'];
	echo "<script>console.log('" . $username . " is logged in.')</script>";
}

// PHP code in a more secure location
include("../../../php/landfill.php");

//Uses PHP code to connect to database
$connekt = new mysqli($db_hostname, $db_username, $db_password, $db_database);

// Connection test and feedback
if (!$connekt) {
	die('Rats! Could not connect: ' . mysqli_error());
  }

// Create variable for query
$query = "SELECT * FROM user_creds4 WHERE username = $username";

// Use variable with MySQL command to grab info from database
$result = $connekt->query($query);

?>

<!DOCTYPE html>

<html>
<head>
<meta name="viewport" content="user-scalable=no, width=device-width" />
<meta charset="UTF-8">
<title>Stakeout | Home</title>
<?php echo $stylesAndSuch; ?>
</head>

<body>
<div class="container">

<nav class='navbar navbar-default'>	
	<div id='header' class='container-fluid'>		
		<h1 class="hide"><a href="index.php">Stakeout</a></h1>

<?php 
	if ($jefe == 1) {
		echo $navbarJefe;
	}
	else {
		echo $navbarGator;
	}
?>
	
	</div> <!-- /container-fluid -->   
</nav> <!-- /navbar -->	
	
<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Home</h3>
  </div>
  <div class="panel-body">
    <p><strong>Email:</strong> <?php echo $email; ?></p>
	<p><strong>Username:</strong> <?php echo $username; ?></p>
	
<?php
  // PHP code in a more secure location
  include("../../../php/landfill.php");
  //Uses PHP code to connect to database
  $connekt = new mysqli($db_hostname, $db_username, $db_password, $db_database);
  // Connection test and feedback
  if (!$connekt)  {    
	die('Rats! Could not connect: ' . mysqli_error());  
  }
		
  // Create variable for query
  $query = "SELECT a.caseID, c.caseName, c.status, a.username	
	FROM assignments4 a, cases4 c			
			WHERE a.caseID = c.caseID AND c.status = 1 AND a.username = '$username'";				
		
  // Use variable with MySQL command to grab info from database
  $result = $connekt->query($query);
  // Start creating an HTML table and create header row
  echo "<table class='table table-striped table-hover'>";
  echo "<thead><tr><th>Assignments</th></tr></thead><tbody>";
  // Create a row in HTML table for each row from database 
  while ($row = mysqli_fetch_array($result)) {	 
	  echo "<tr>";	 

	  echo "<td><a href='manage_case.php?id=" . $row["caseID"] . "'>" . $row["caseName"] . "</a></td>";	 	 
	  echo "</tr>";
  }
  // Finish creating HTML table
  echo "</tbody></table>";
  // When attempt is complete, connection closes
  mysqli_close($connekt);
?>	

<p align="center"><a href="userGuide_beta_0-2.pdf">Download latest User Guide (PDF)</a></p>

  </div> <!-- /panel-body -->
</div>
	
</div> <!-- /container -->

<script src='//roxorsoxor.com/stakeout/mobrules.js'></script></body>
</html>