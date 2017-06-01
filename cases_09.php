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
<head>
<meta name="viewport" content="user-scalable=no, width=device-width" />
<meta charset="UTF-8">
<title>Cases</title>
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
		<div class="panel-heading">
			<h3 class="panel-title">Cases</h3>
		</div>
		<div class="panel-body"> 
			
			<!-- Panel Content --> 
			<?php
				if ($jefe == 1) {
					echo "<a href='https://www.roxorsoxor.com/stakeout/insert_case_09.php' class='btn btn-primary'>Add Case</a>";
				}
			?>

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
else {

	if ($jefe == 1) {
		// Admin sees all cases
		$query = "SELECT * FROM cases4 ORDER BY cases4.caseName ASC";
		$result = $connekt->query($query);
	}
	else {
		// Gators only see cases assigned to them
		$query = "
		SELECT a.caseID, c.caseName, c.status, a.username 
			FROM assignments4 a
				INNER JOIN cases4 c
					ON a.caseID = c.caseID
						WHERE a.username = '$username' AND c.status = 1";
		$result = $connekt->query($query);
	}
}
    
// Use variable with MySQL command to grab info from database
	// $result = $connekt->query($query);
// Start creating an HTML table and create header row
    echo "<table class='table table-striped table-hover'><thead><tr><th>Case Name</th></tr></thead><tbody>";
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
	</div>
</div>
<!-- /container -->
<script src='//roxorsoxor.com/stakeout/mobrules.js'></script></body>
</html>
