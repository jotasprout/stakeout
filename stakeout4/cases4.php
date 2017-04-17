<?php



	require_once 'areTheyLoggedIn4.php';



?>



<!DOCTYPE html>



<html>



<head>

<meta charset="UTF-8">



    <title>Cases</title>



    <script src="http://www.jotascript.com/js/jquery-214.js"></script>

    <script src="http://www.jotascript.com/js/jquery_play.js"></script>

    <link rel="stylesheet" type="text/css" href="http://www.jotascript.com/js/bootstrap/css/bootstrap.min.css">

    <script src="http://www.jotascript.com/js/bootstrap/js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="http://www.jotascript.com/js/bootstrap/css/justified-nav.css">



</head>



<body>



	<div class="container">



            <div class="masthead">



                <a href="http://www.roxorsoxor.com/stakeout4/index4.php"><img src="http://www.roxorsoxor.com/stakeout/stakeoutLogo.png" width="680" height="198"/></a>      



            </div> <!-- /masthead -->



            <nav class="navbar navbar-default">



                <div class="container-fluid">



                    <div class="navbar-header">



                        <a class="navbar-brand" href="http://www.roxorsoxor.com/stakeout4/index4.php">Home</a>



                    </div>               



                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">                        <ul class="nav navbar-nav">



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



            <!-- main -->



	<div class="panel panel-default">



		<div class="panel-heading"><h4>Cases</h4></div>



			<div class="panel-body">



				<!-- Panel Content -->



                <a href="insert_case4.php" class="btn btn-primary">Open Case</a>



                <a href="logout_stakeout4.php" class="btn">Logout</a>



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



    $query = "SELECT * FROM cases ORDER BY cases.startDate ASC";



// Use variable with MySQL command to grab info from database



	$result = $connekt->query($query);



// Start creating an HTML table and create header row



    echo "<table class='table table-striped table-hover'>";



    echo "<thead><tr><th>Case #</th><th>Manage</th><th>Case Name</th><th>Start Date</th><th>Status</th><th>End Date</th><th>Delivered</th></tr></thead><tbody>";





 // Create a row in HTML table for each row from database



    while ($row = mysqli_fetch_array($result)) {



        echo "<tr>";



		echo "<td>" . $row["caseNum"] . "</td>";



		echo "<td><a href='manage_case4.php?id=" . $row["id"] . "'>Manage</a></td>";



        echo "<td>" . $row["caseName"] . "</td>";



        echo "<td>" . $row["startDate"] . "</td>";



        echo "<td>" . $row["status"] . "</td>";



        echo "<td>" . $row["endDate"] . "</td>";



		echo "<td>" . $row["deliveryDate"] . "</td>";



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



