<?php
	require_once 'areTheyLoggedIn4.php';
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <title>Assign Investigator</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="http://www.jotascript.com/js/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="http://www.jotascript.com/js/bootstrap/css/justified-nav.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
		<div class="masthead">
			<a href="http://www.roxorsoxor.com/stakeout4/index4.php">
				<img src="http://www.roxorsoxor.com/stakeout/stakeoutLogo.png" width="680" height="198"/>
			</a>      
		</div> <!-- /masthead -->

		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="http://www.roxorsoxor.com/stakeout4/index4.php">Stakeout Home</a>
				</div>
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li><a href="http://www.roxorsoxor.com/stakeout4/cases4.php">Cases</a></li>
						<li><a href="http://www.roxorsoxor.com/stakeout4/observations4.php">Observations</a></li>
						<li><a href="http://www.roxorsoxor.com/stakeout4/gators4.php">Investigators</a></li>
						<li><a href="http://www.roxorsoxor.com/stakeout4/assignments4.php">Assignments</a></li>						
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="http://www.roxorsoxor.com">RoxorSoxor.com</a></li>
					</ul>
				</div> <!-- /collapse -->                    
			</div> <!-- /container-fluid -->   
		</nav> <!-- /navbar -->

        <!-- This form uses code in handle_prez to insert input into the database -->
        <form class="form-horizontal" action="handle_assignment4.php" method="post">
           
            <fieldset>
            	<legend>Assign Investigator</legend>
                
				<?php

					// PHP code in a more secure location
					include("../../../php/landfill.php");

					//Uses PHP code to connect to database
					$connekt = new mysqli($db_hostname, $db_username, $db_password, $db_database);

					// Connection test and feedback
					if (!$connekt){
						die('Rats! Could not connect: ' . mysqli_error());
					}

					// Create variable for query
					$query0 = "SELECT * FROM user_creds WHERE status = 1";

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
									echo "<option value='" . $row['caseNum'] . "'>" . $row['caseName'] . "</option>";
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

		<footer class="footer">
			<p>&copy; RoxorSoxor 2017</p>
		</footer>

	</div> <!-- /container -->

</body>
</html>