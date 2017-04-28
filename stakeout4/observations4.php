<?php
	require_once 'areTheyLoggedIn4.php';
?>

<!DOCTYPE html>
<html>
<head><meta name="viewport" content="user-scalable=no, width=device-width" />
<meta charset="UTF-8">
    <title>Observations</title>
    <script src="http://www.jotascript.com/js/jquery-214.js"></script>
    <script src="http://www.jotascript.com/js/jquery_play.js"></script>
    <link rel="stylesheet" type="text/css" href="http://www.jotascript.com/js/bootstrap/css/bootstrap.min.css">
    <script src="http://www.jotascript.com/js/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="http://www.jotascript.com/js/bootstrap/css/justified-nav.css">
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
                        <a class="navbar-brand" href="http://www.roxorsoxor.com/stakeout4/index4.php">Home</a>
                    </div>
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    	<ul class="nav navbar-nav">
                            <li><a href="http://www.roxorsoxor.com/stakeout4/cases4.php">Cases</a></li>
                            <li><a href="http://www.roxorsoxor.com/stakeout4/observations4.php">Observations</a></li>
                            <li><a href="http://www.roxorsoxor.com/stakeout4/gators4.php">Investigators</a></li>
						<li><a href="http://www.roxorsoxor.com/stakeout4/assignments4.php">Assignments</a></li>						
					</ul>

                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="logout_stakeout4.php">Logout</a></li>
                        </ul>

                    </div> <!-- /collapse -->                    
                </div> <!-- /container-fluid -->   
            </nav> <!-- /navbar -->

            <!-- main -->

	<div class="panel panel-default">

		<div class="panel-heading"><h4>Observations</h4></div>

			<div class="panel-body">

				<!-- Panel Content -->

                <a href="http://www.roxorsoxor.com/stakeout4/insert_observe5g.php" class="btn btn-primary">Add Observation</a>

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
		SELECT a.caseID, a.observation, a.pix, a.observeTime, c.caseName, c.status, a.username, b.forename, b.surname, b.status, a.action 
			FROM observations4 a
				INNER JOIN user_creds4 b
					ON a.username = b.username
				INNER JOIN cases4 c
					ON a.caseID = c.caseID
						WHERE b.status = 1 AND c.status = 1"; 				

    // Use variable with MySQL command to grab info from database
	$result = $connekt->query($query);

    // Start creating an HTML table and create header row
    echo "<table class='table table-striped table-hover'>";
    echo "<thead><tr><th>Case Name</th><th>View</th><th>Action</th><th>User</th><th>Observation</th><th>Photos</th><th>Time Stamp</th></tr></thead><tbody>";

    // Create a row in HTML table for each row from database
    while ($row = mysqli_fetch_array($result)) {

        echo "<tr>";
		echo "<td>" . $row["caseName"] . "</td>";
		echo "<td>View</td>";
		echo "<td>" . $row["action"] . "</td>";
		echo "<td>" . $row['forename'] . " " . $row['surname'] . "</td>";
        echo "<td>" . $row["observation"] . "</td>";
		echo "<td>" . $row["pix"] . "</td>";
        echo "<td>" . $row["observeTime"] . "</td>";
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

</body>
</html>