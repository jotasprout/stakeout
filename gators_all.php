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
	echo "<script>console.log('" . $username . " is logged in.')</script>";
}

?>

<!DOCTYPE html>

<html>
<head>
	<title>Investigators</title>
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
	
	<!-- main -->
	
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Investigators</h3>
		</div>
		<div class="panel-body"> 
			
			<!-- Panel Content --> 
			
			<a href="insert_gator.php" class="btn btn-primary">Add Investigator</a>
			<a href='https://www.roxorsoxor.com/stakeout/gators.php' class='btn btn-primary active' aria-pressed='true'>Show All</a>


<?php

	// PHP code in a more secure location
    include("../../../php/landfill.php");

	//Uses PHP code to connect to database
	$connekt = new mysqli($db_hostname, $db_username, $db_password, $db_database);

	// Connection test and feedback
	if (!$connekt) {
		die('Rats! Could not connect: ' . mysqli_error());
	  }

	// Create variable for query
    $query = "SELECT * FROM user_creds4 ORDER BY surname ASC";

	// Use variable with MySQL command to grab info from database
	$result = $connekt->query($query);

	// Start creating an HTML table and create header row
    echo "<table class='table table-striped table-hover'>";
    echo "<thead><tr><th>Name</th><th>Username</th><th>eMail</th><th>Status</th></tr></thead><tbody>";

	// Create a row in HTML table for each row from database
    while ($row = mysqli_fetch_array($result)) {

		if ($row["userStatus"] == "Y") {
			$status = "Active";
		}

		else {
			$status = "Inactive";
		}

        echo "<tr>";
		echo "<td><a href='manage_gator.php?id=" . $row["id"] . "'>" . $row['forename'] . " " . $row['surname'] . "</a></td>";
        echo "<td>" . $row["username"] . "</td>";
		echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $status . "</td>";		
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
