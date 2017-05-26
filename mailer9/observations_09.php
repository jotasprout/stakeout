<?php
session_start();
require_once 'class.gator.php';
require_once 'stylesAndSuch.php';
require_once 'navbar.php';
$user = new USER();

if(!$user->areTheyLoggedIn()) {
	$user->redirect('https://www.roxorsoxor.com/stakeout/login_form_09.php');
}
else {
	$jefe = $_SESSION['jefe'];
	if ($jefe == 1) {
		echo "<script>console.log('You are an admin.')</script>";
	}
	$username = $_SESSION['username'];
	echo "<script>console.log('" . $username . " is logged in.')</script>";
}

?>
<!DOCTYPE html>
<html>
<head><meta name="viewport" content="user-scalable=no, width=device-width" />
<meta charset="UTF-8">
    <title>Observations</title>
<?php echo $stylesAndSuch; ?>   
</head>
<body>
	<div class="container">
             
<nav class='navbar navbar-default'>	
	<div id='header' class='container-fluid'>		
		<h1 class="hide"><a href="index_09.php">Stakeout</a></h1>
		
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

            <!-- main -->
	<div class="panel panel-primary">
		<div class="panel-heading"><h3 class="panel-title">Observations</h3></div>
			<div class="panel-body">
				<!-- Panel Content -->
                <a href="//www.roxorsoxor.com/stakeout/insert_observe_09.php" class="btn btn-primary">Add Observation</a>
<?php
    // PHP code in a more secure location
    include("../../../php/landfill.php");
    //Uses PHP code to connect to database
	$connekt = new mysqli($db_hostname, $db_username, $db_password, $db_database);
    // Connection test and feedback
  if (!$connekt)
  {
    die('Rats! Could not connect: ' . mysqli_error());
  }
    // Create variable for query
	$query = "
		SELECT a.caseID, a.observeID, a.observation, a.pix, a.observeTime, c.caseName, c.status, a.username, b.forename, b.surname, b.status, a.action 
			FROM observations4 a
				INNER JOIN user_creds4 b
					ON a.username = b.username
				INNER JOIN cases4 c
					ON a.caseID = c.caseID
						WHERE b.status = 1 AND c.status = 1
						 ORDER BY observeTime ASC"; 				
    // Use variable with MySQL command to grab info from database
	$result = $connekt->query($query);
    // Start creating an HTML table and create header row
    echo "<table class='table table-striped table-hover'>";
    echo "<thead><tr><th>Case</th><th>Investigator</th><th>Observation</th><th>Date</th></tr></thead><tbody>";
    // Create a row in HTML table for each row from database
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>";
		echo "<td>" . $row["caseName"] . "</td>";
		echo "<td>" . $row['forename'] . " " . $row['surname'] . "</td>";
        echo "<td><a href='manage_observe_09.php?id=" . $row['observeID'] . "'>" . $row["observation"] . "</a></td>";
		
		$ourTime = new DateTime($row["observeTime"] ." UTC");
		$ourTime ->setTimezone(new DateTimeZone('America/New_York'));
		
        echo "<td>" . $formatted_date_long=date_format($ourTime, 'm-d-y') . "</td>";
        echo "</tr>";
    }
    // Finish creating HTML table
    echo "</tbody></table>";
    // When attempt is complete, connection closes
    mysqli_close($connekt);
?>
			</div>
		</div>
	</div> <!-- /container -->
<script src='//roxorsoxor.com/stakeout/mobrules.js'></script></body>
</html>