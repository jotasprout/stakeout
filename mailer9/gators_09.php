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
	echo "<script>console.log('" . $username . " is logged in.')</script>";
}

?>

<!DOCTYPE html>

<html>
<head>
<meta name="viewport" content="user-scalable=no, width=device-width" />
<meta charset="UTF-8">
<title>Investigators</title>
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
					<li><a href="//www.roxorsoxor.com/mailer9/assignments_09.php">Assignments</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="logout_09.php">Logout</a></li>
				</ul>
			</div>
			
			<!-- /collapse --> 
			
		</div>
		
		<!-- /container-fluid --> 
		
	</nav>
	
	<!-- /navbar --> 
	
	<!-- main -->
	
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4>Investigators</h4>
		</div>
		<div class="panel-body"> 
			
			<!-- Panel Content --> 
			
			<a href="insert_gator_09.php" class="btn btn-primary">Add Investigator</a>

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
    $query = "SELECT * FROM user_creds4";

	// Use variable with MySQL command to grab info from database
	$result = $connekt->query($query);

	// Start creating an HTML table and create header row
    echo "<table class='table table-striped table-hover'>";
    echo "<thead><tr><th>ID #</th><th>Manage</th><th>Status</th><th>First Name</th><th>Last Name</th><th>username</th><th>password</th><th>eMail</th></tr></thead><tbody>";

	// Create a row in HTML table for each row from database
    while ($row = mysqli_fetch_array($result)) {

		if ($row["status"] == 1) {
			$status = "active";
		}

		else {
			$status = "inactive";
		}

        echo "<tr>";
		echo "<td>" . $row["id"] . "</td>";
		echo "<td><a href='manage_gator_09.php?id=" . $row["id"] . "'>Manage</a></td>";
        echo "<td>" . $status . "</td>";
		echo "<td>" . $row["forename"] . "</td>";
        echo "<td>" . $row["surname"] . "</td>";
        echo "<td>" . $row["username"] . "</td>";
		echo "<td>" . "reset" . "</td>";
		echo "<td>" . $row["email"] . "</td>";
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

</body>
</html>
