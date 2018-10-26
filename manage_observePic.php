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
    <title>Manage Asset</title>
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
		<div class="panel-heading"><h3 class="panel-title">Manage Asset</h3></div>
			<div class="panel-body">
				<!-- Panel Content -->
                
<?php
    // PHP code in a more secure location
    include("../../secret_php/landfill.php");
    //Uses PHP code to connect to database
	$connekt = new mysqli($db_hostname, $db_username, $db_password, $db_database);
    // Connection test and feedback
	// confirm id is valid and is numeric/larger than 0)
	if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0){
		// query db
		$id = $_GET['id'];
		
		// Create variable for query
		$query = "
			SELECT a.caseID, a.observeID, a.description, a.observeAsset, c.caseName 
				FROM observations a
					INNER JOIN cases c
						ON a.caseID = c.caseID
							WHERE a.observeID = '$id'"; 				
		// Use variable with MySQL command to grab info from database
		$result = $connekt->query($query)
		or die(mysqli_error($result));
		$row = mysqli_fetch_array($result);
		// check that the 'id' matches up with a row in the databse
		if($row){
			// if there's a match, display data from db
			echo "<div class='row'><strong>BREADCRUMBS GO HERE Case:</strong> " . $row["caseName"] . "</div>";

			echo "<div class='row'>";
			echo "<div class='col-md-3'><strong>Uploaded Asset:</strong></div>";
			echo "<div class='col-md-9'>";
			
			if($row["observeAsset"] == "") {
				echo "None";
			}
			else {
				echo "<img src='caseAssets/" . $row["observeAsset"] . "'>";
			}
			echo "</div></div>";
			
			echo "<div class='row'>";
			echo "<div class='col-md-3'><strong>Description:</strong></div>";
			echo "<div class='col-md-9'>" . $row["description"] . "</div>";
			echo "</div>";																		
		}
		else // if no match, display error
		{
			echo "<script>console.log('No results.')</script>";
		}
	}

	// When attempt is complete, connection closes
    mysqli_close($connekt);
	
?>
			</div>
		</div>
	</div> <!-- /container -->

<script src='https://www.roxorsoxor.com/stakeout/js/mobrules.js'></script></body>
</html>