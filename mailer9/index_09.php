<?php

session_start();
require_once 'class.gator.php';
require_once 'stylesAndSuch.php';
if(!isset($_SESSION['username'])) {
	echo "<script>console.log('Nobody is logged in.')</script>";
	header("Location:login_form_09.php");
}
else {
	// $_SESSION['username'] = $userRow['username'];
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
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header"> <a class="navbar-brand" href="//www.roxorsoxor.com/mailer9/index_09.php">You</a> </div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="//www.roxorsoxor.com/mailer9/cases_09.php">Cases</a></li>
					<li><a href="//www.roxorsoxor.com/mailer9/observations_09.php">Observations</a></li>
					<li><a href="//www.roxorsoxor.com/mailer9/gators_09.php">Investigators</a></li>
					<li><a href="//www.roxorsoxor.com/mailer9/assignments_09.php">Assignments</a></li></ul>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="logout_09.php">Logout</a></li>
				</ul>
			</div>
			<!-- /collapse --> 
			
		</div>
		<!-- /container-fluid --> 
		
	</nav>
	<!-- /navbar -->
	
	<div class="jumbotron">
		<h1>Welcome, <?php echo $forename; ?>!</h1>
		<p class="lead">Your email is <?php echo $email; ?></P>
		<p class="lead">Your username is <?php echo $username; ?></P>
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
		  echo "<thead><tr><th>Assigned Cases</th></tr></thead><tbody>";
		  // Create a row in HTML table for each row from database 
		  while ($row = mysqli_fetch_array($result)) {	 
			  echo "<tr>";	 
	 
			  echo "<td><a href='manage_case_09.php?id=" . $row["caseID"] . "'>" . $row["caseName"] . "</a></td>";	 	 
			  echo "</tr>";
		  }
		  // Finish creating HTML table
		  echo "</tbody></table>";
		  // When attempt is complete, connection closes
		  mysqli_close($connekt);
		  ?>
	</div>
	<footer class="footer">
		<p>&copy; RoxorSoxor 2017</p>
	</footer>
</div>
<!-- /container -->

</body>
</html>
