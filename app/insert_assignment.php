<?php
session_start();
require_once 'class.gator.php';
require_once 'stylesAndSuch.php';
require_once 'navbar.php';
$user = new USER();

if(!$user->areTheyLoggedIn()) {
	$user->redirect('http://www.roxorsoxor.com/stakeout/login_form.php');
}
else {
	$jefe = $_SESSION['jefe'];
	if ($jefe == 1) {
		echo "<script>console.log('You are an admin.')</script>";
	} else {
		$user->redirect('index.php');
	}
	$username = $_SESSION['username'];
	echo "<script>console.log('" . $username . " is logged in.')</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Assign Investigator</title>
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
				<h3 class="panel-title">New Assignment</h3>
			</div>
			<div class="panel-body">

        <!-- This form uses code in handle_prez to insert input into the database -->
        <form class="form-horizontal" action="handle_assignment.php" method="post">
            <fieldset>
				<?php
					// PHP code in a more secure location
					include("../../secret_php/landfill.php");
					//Uses PHP code to connect to database
					$connekt = new mysqli($db_hostname, $db_username, $db_password, $db_database);
					// Connection test and feedback
					if (!$connekt){
						die('Rats! Could not connect: ' . mysqli_error());
					}
					// Create variable for query
					$query0 = "SELECT * FROM user_creds WHERE userStatus = 'Y'";
					// Create variable for MySQL command using query to grab active users from database
					$result0 = $connekt->query($query0);
					// Create Investigator Menu
					echo "<div class='form-group'>";
						echo "<label class='col-lg-2 control-label' for='assignedGator'>Investigator</label>";
						echo "<div class='col-lg-4'>";
							echo "<select class='form-control' name='assignedGator'>";
								echo "<option value=''>- Choose -</option>";
								while ($row0 = mysqli_fetch_array($result0)) {
									echo "<option value='" . $row0['username'] . "'>" . $row0['forename'] . " " . $row0['surname'] . "</option>";
								}
							echo "</select>";
						echo "</div>";
					echo "</div>";
					// Create variable for query
					$query = "SELECT * FROM cases WHERE status = 1";
					// Create variable for MySQL command using query to grab active users from database
					$result = $connekt->query($query);
					// Create Investigator Menu
					echo "<div class='form-group'>";
						echo "<label class='col-lg-2 control-label' for='assignedCase'>Case</label>";
						echo "<div class='col-lg-4'>";
							echo "<select class='form-control' name='assignedCase'>";
								echo "<option value=''>- Choose -</option>";
								while ($row = mysqli_fetch_array($result)) {
									echo "<option value='" . $row['caseID'] . "'>" . $row['caseName'] . "</option>";
								}
							echo "</select>";
						echo "</div>";
					echo "</div>";
					// echo "<script>console.log('Case Number " . $assignedCase . " is assigned to " . $username . "')</script>";
					// When attempt is complete, connection closes
					mysqli_close($connekt);
				?>
                <div class="form-group"> <!-- Last Row -->
                    <div class="col-lg-4 col-lg-offset-2">
                        <button class="btn btn-primary" type="submit" name="submit">Assign</button>
                    </div>
                </div><!-- /Last Row -->
            </fieldset>
        </form>

		</div> <!-- /panel-body -->
	</div> <!-- /panel-primary -->

	</div> <!-- /container -->
	<?php echo $scriptsAndSuch; ?>
</script>
</body>
</html>