<?php

    session_start();

    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false) {
        header("Location: login.php"); # user goes to login screen if they aren't logged in
    }

    # if they are logged in, they see the content on this page below
?>

<!DOCTYPE html>
<html>
<head>
    <title>Observations</title>
    <script src="http://www.jotascript.com/js/jquery-214.js"></script>
    <script src="http://www.jotascript.com/js/jquery_play.js"></script>
    <link rel="stylesheet" type="text/css" href="http://www.jotascript.com/js/bootstrap/css/bootstrap.min.css">
    <script src="http://www.jotascript.com/js/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="http://www.jotascript.com/js/bootstrap/css/justified-nav.css">
    <LINK href="favicon.ico" rel="icon" type="image/x-icon">
    <LINK href="favicon.ico" rel="shortcut icon" type="image/x-icon">
    <LINK href="favicon.ico" rel="icon" type="image/ico">
</head>
<body>

	<div class="container">
            <div class="masthead">
                <a href="http://www.roxorsoxor.com/stakeout/index.php"><img src="stakeoutLogo.png" width="680" height="198"/></a>      
            </div> <!-- /masthead -->

            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="http://www.roxorsoxor.com/stakeout/index.php">Stakeout Home</a>
                    </div>
                    
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li><a href="http://www.roxorsoxor.com/stakeout/cases.php">Cases</a></li>
                            <li><a href="http://www.roxorsoxor.com/stakeout/observations.php">Observations</a></li>
                            <li><a href="http://www.roxorsoxor.com/stakeout/gators.php">Investigators</a></li>
                        </ul>

                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="http://www.roxorsoxor.com">RoxorSoxor.com</a></li>
                        </ul>
                    </div> <!-- /collapse -->                    
                    
                </div> <!-- /container-fluid -->   
            </nav> <!-- /navbar -->
            
            <!-- main -->

	<div class="panel panel-default">
		<div class="panel-heading"><h4>Observations</h4></div>
			<div class="panel-body">
				<!-- Panel Content -->
                <a href="insertCase.htm" class="btn btn-primary">Add Observation</a>
                <a href="logoutstakeout.php" class="btn">Logout</a>
<?php

// PHP code in a more secure location

    include("../../../php/landfill.php");

//Uses PHP code to connect to database

	mysql_select_db("jscript_stakeout", $connekt);

// Connection test and feedback

  if (!$connekt)

  {

    die('Rats! Could not connect: ' . mysql_error());

  }

// Create variable for query

    $query = "SELECT * FROM observations ORDER BY observations.observationTime ASC";

// Use variable with MySQL command to grab info from database

	$result = mysql_query($query);

// Start creating an HTML table and create header row

    echo "<table class='table table-striped table-hover'>";

    echo "<thead><tr><th>Case #</th><th>Manage</th><th>Observation</th><th>Time Stamp</th></tr></thead><tbody>";



 // Create a row in HTML table for each row from database

    while ($row = mysql_fetch_array($result)) {

        echo "<tr>";
		echo "<td>" . $row["caseNum"] . "</td>";
		echo "<td>Manage</td>";
        echo "<td>" . $row["observation"] . "</td>";
        echo "<td>" . $row["observationTime"] . "</td>";
        echo "</tr>";

    }

// Finish creating HTML table

    echo "</tbody></table>";

// When attempt is complete, connection closes

    mysql_close($connekt);

?>
			</div>
		</div>
	</div> <!-- /container -->

</body>

</html>
